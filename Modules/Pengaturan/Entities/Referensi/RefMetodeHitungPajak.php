<?php namespace Modules\Pengaturan\Entities\Referensi;

use Illuminate\Database\Eloquent\Model as Eloquent;

class RefMetodeHitungPajak extends Eloquent
{
    public $incrementing = true;

    protected $fillable = [
        'id',
        'company_id',
        'nama',
        'status'
    ];

    protected $table = 'reff_metode_hitung_pajak';
}