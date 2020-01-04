<?php namespace Modules\Konfigurasi\Entities\SKPD;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Pegawai extends Eloquent
{
    public $incrementing = false;

    protected $fillable = [
        'company_id',
        'urusan_id',
        'bidang_id',
        'satker_id',
        'uuid',
        'nip',
        'nama',
        'userid',
        'jabatan',
        'status'
    ];

    protected $table = 'kepegawaian';
}