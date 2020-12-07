<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelBooking extends Model
{
    protected $table = 'TBTransaksi';
    protected $fillable = [
        'u_id',
        'i_id',
        'email',
        'merk',
        'gambar',
        'tanggaltransaksi',
        'bank_company',
        'user_price',
        'status',
        'opsistatus'
    ];
}
