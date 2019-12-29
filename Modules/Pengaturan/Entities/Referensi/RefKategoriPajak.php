<?php namespace Modules\Pengaturan\Entities\Referensi;

use Illuminate\Database\Eloquent\Model as Eloquent;

class RefKategoriPajak extends Eloquent
{
    public $incrementing = true;

    protected $fillable = [
        'id',
        'company_id',
        'nama',
        'status'
    ];

    protected $table = 'reff_kategori_pajak';
}