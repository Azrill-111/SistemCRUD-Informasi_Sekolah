<?php

namespace App\Http\Requests;

/**
 * Aturan validasi saat memperbarui informasi sama dengan saat membuat,
 * sehingga cukup mewarisi StoreInformasiRequest.
 */
class UpdateInformasiRequest extends StoreInformasiRequest
{
    //
}
