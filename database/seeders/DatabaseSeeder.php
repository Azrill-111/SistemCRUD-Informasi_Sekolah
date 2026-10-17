<?php

namespace Database\Seeders;

use App\Models\Informasi;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Akun default
        |--------------------------------------------------------------------------
        | Admin : admin@sekolah.test  / password
        | User  : user@sekolah.test   / password
        */
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sekolah.test',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
        ]);

        User::create([
            'name' => 'Siswa Contoh',
            'email' => 'user@sekolah.test',
            'password' => Hash::make('password'),
            'role' => User::ROLE_USER,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Data informasi awal
        |--------------------------------------------------------------------------
        */
        $informasis = [
            [
                'title' => 'Jadwal Ujian Tengah Semester Ganjil',
                'content' => "Ujian Tengah Semester (UTS) ganjil akan dilaksanakan pada tanggal 20 sampai 25 Oktober 2026.\n\n"
                    .'Seluruh siswa diwajibkan hadir paling lambat pukul 07.00 WIB dengan mengenakan seragam lengkap. '
                    ."Kartu ujian dapat diambil di ruang tata usaha mulai H-3 sebelum pelaksanaan ujian.\n\n"
                    .'Materi yang diujikan mencakup seluruh pertemuan dari awal semester. Silakan menghubungi wali kelas '
                    .'masing-masing apabila terdapat pertanyaan.',
            ],
            [
                'title' => 'Penerimaan Peserta Didik Baru Tahun Ajaran 2027/2028',
                'content' => 'Pendaftaran Penerimaan Peserta Didik Baru (PPDB) tahun ajaran 2027/2028 dibuka secara online '
                    ."mulai 1 November 2026 hingga 15 Desember 2026.\n\n"
                    .'Berkas yang perlu disiapkan antara lain: fotokopi ijazah, akta kelahiran, kartu keluarga, '
                    ."dan pas foto ukuran 3x4 sebanyak dua lembar.\n\n"
                    .'Informasi lebih lanjut dapat dilihat pada halaman PPDB atau menghubungi panitia penerimaan '
                    .'di nomor telepon sekolah pada jam kerja.',
            ],
            [
                'title' => 'Kegiatan Ekstrakurikuler Semester Ini',
                'content' => "Kegiatan ekstrakurikuler resmi dimulai kembali pada minggu kedua semester ini.\n\n"
                    .'Pilihan ekstrakurikuler yang tersedia: Pramuka, Palang Merah Remaja, Basket, Futsal, Paskibra, '
                    ."Paduan Suara, dan Karya Ilmiah Remaja.\n\n"
                    .'Pendaftaran dilakukan melalui wali kelas. Setiap siswa diperbolehkan mengikuti maksimal dua '
                    .'kegiatan ekstrakurikuler agar tidak mengganggu kegiatan belajar mengajar.',
            ],
        ];

        foreach ($informasis as $informasi) {
            Informasi::create($informasi);
        }
    }
}
