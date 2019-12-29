<?php namespace Modules\Pengaturan\Entities\Referensi;

use Illuminate\Database\Eloquent\Model as Eloquent;

class RefJenisPenetapanPajak extends Eloquent
{
    public $incrementing = true;

    protected $fillable = [
        'id',
        'company_id',
        'nama',
        'status'
    ];

    protected $table = 'reff_jenis_penetapan_pajak';
}