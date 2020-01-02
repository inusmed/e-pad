<?php namespace Modules\Konfigurasi\Entities\SKPD;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Urusan extends Eloquent
{
    public $incrementing = false;

    protected $fillable = [
        'company_id',
        'id',
        'nama',
        'status'
    ];

    protected $table = 'satker_adm_urusan';
}