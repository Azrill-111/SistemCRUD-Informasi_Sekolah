<?php

namespace Tests\Feature;

use App\Models\Informasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SistemInformasiTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create([
            'email' => 'admin@sekolah.test',
            'password' => 'password',
            'role' => User::ROLE_ADMIN,
        ]);
    }

    private function siswa(): User
    {
        return User::factory()->create([
            'email' => 'user@sekolah.test',
            'password' => 'password',
            'role' => User::ROLE_USER,
        ]);
    }

    public function test_tamu_diarahkan_ke_halaman_login(): void
    {
        $this->get('/')->assertRedirect(route('login'));
        $this->get(route('informasi.index'))->assertRedirect(route('login'));
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    public function test_login_admin_diarahkan_ke_dashboard(): void
    {
        $this->admin();

        $this->post(route('login.attempt'), [
            'email' => 'admin@sekolah.test',
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticated();
    }

    public function test_admin_tetap_diarahkan_ke_dashboard_walau_tadi_membuka_halaman_user(): void
    {
        $this->admin();

        // Tamu sempat membuka halaman user, lalu login sebagai admin.
        $this->get(route('informasi.index'))->assertRedirect(route('login'));

        $this->post(route('login.attempt'), [
            'email' => 'admin@sekolah.test',
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));
    }

    public function test_login_user_diarahkan_ke_halaman_informasi(): void
    {
        $this->siswa();

        $this->post(route('login.attempt'), [
            'email' => 'user@sekolah.test',
            'password' => 'password',
        ])->assertRedirect(route('informasi.index'));

        $this->assertAuthenticated();
    }

    public function test_password_salah_menghasilkan_pesan_kesalahan(): void
    {
        $this->admin();

        $this->from(route('login'))->post(route('login.attempt'), [
            'email' => 'admin@sekolah.test',
            'password' => 'password-salah',
        ])->assertRedirect(route('login'))->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_admin_dapat_membuka_dashboard(): void
    {
        $this->actingAs($this->admin())
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Admin');
    }

    public function test_user_tidak_bisa_mengakses_halaman_admin(): void
    {
        $informasi = Informasi::create(['title' => 'Pengumuman', 'content' => 'Isi pengumuman resmi sekolah.']);

        $siswa = $this->siswa();

        $this->actingAs($siswa)->get(route('admin.dashboard'))->assertForbidden();
        $this->actingAs($siswa)->get(route('admin.informasi.index'))->assertForbidden();
        $this->actingAs($siswa)->get(route('admin.informasi.create'))->assertForbidden();
        $this->actingAs($siswa)->get(route('admin.informasi.edit', $informasi))->assertForbidden();
        $this->actingAs($siswa)->post(route('admin.informasi.store'), [
            'title' => 'Curang',
            'content' => 'Mencoba menambah data tanpa hak akses.',
        ])->assertForbidden();
        $this->actingAs($siswa)->delete(route('admin.informasi.destroy', $informasi))->assertForbidden();

        $this->assertDatabaseHas('informasis', ['title' => 'Pengumuman']);
    }

    public function test_admin_dapat_menambah_informasi(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())
            ->post(route('admin.informasi.store'), [
                'title' => 'Jadwal Ujian Akhir',
                'content' => 'Ujian akhir semester akan dilaksanakan mulai pekan depan.',
                'image' => UploadedFile::fake()->image('pengumuman.jpg'),
            ])
            ->assertRedirect(route('admin.informasi.index'))
            ->assertSessionHas('success');

        $informasi = Informasi::firstWhere('title', 'Jadwal Ujian Akhir');

        $this->assertNotNull($informasi);
        $this->assertNotNull($informasi->image);
        Storage::disk('public')->assertExists($informasi->image);
    }

    public function test_validasi_input_informasi_berjalan(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.informasi.store'), ['title' => '', 'content' => 'pendek'])
            ->assertSessionHasErrors(['title', 'content']);

        $this->assertDatabaseCount('informasis', 0);
    }

    public function test_admin_dapat_mengubah_informasi(): void
    {
        $informasi = Informasi::create(['title' => 'Judul Lama', 'content' => 'Isi lama dari informasi sekolah.']);

        $this->actingAs($this->admin())
            ->put(route('admin.informasi.update', $informasi), [
                'title' => 'Judul Baru',
                'content' => 'Isi baru dari informasi sekolah ini.',
            ])
            ->assertRedirect(route('admin.informasi.index'));

        $this->assertDatabaseHas('informasis', ['id' => $informasi->id, 'title' => 'Judul Baru']);
    }

    public function test_data_yang_dihapus_admin_hilang_dari_halaman_user(): void
    {
        $informasi = Informasi::create(['title' => 'Informasi Sementara', 'content' => 'Isi informasi sementara.']);

        $siswa = $this->siswa();

        $this->actingAs($siswa)
            ->get(route('informasi.index'))
            ->assertOk()
            ->assertSee('Informasi Sementara');

        $this->actingAs($siswa)
            ->get(route('informasi.show', $informasi))
            ->assertOk()
            ->assertSee('Informasi Sementara');

        $this->actingAs($this->admin())
            ->delete(route('admin.informasi.destroy', $informasi))
            ->assertRedirect(route('admin.informasi.index'));

        $this->assertDatabaseMissing('informasis', ['id' => $informasi->id]);

        // Halaman daftar tidak lagi memuat tautan ke informasi yang sudah dihapus.
        $this->actingAs($siswa)
            ->get(route('informasi.index'))
            ->assertOk()
            ->assertDontSee(route('informasi.show', $informasi))
            ->assertSee('Belum ada informasi');

        $this->actingAs($siswa)
            ->get(route('informasi.show', $informasi))
            ->assertNotFound();
    }

    public function test_halaman_user_menampilkan_data_dari_database(): void
    {
        $user = $this->siswa();

        Informasi::create(['title' => 'Bebas Pustaka', 'content' => 'Program bebas pustaka dibuka minggu ini.']);

        $this->actingAs($user)
            ->get(route('informasi.index'))
            ->assertOk()
            ->assertSee('Bebas Pustaka');
    }
}
