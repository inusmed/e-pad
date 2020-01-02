<?php namespace Modules\Konfigurasi\Entities\SKPD;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Satker extends Eloquent
{
    public $incrementing = false;

    protected $fillable = [
        'company_id',
        'urusan_id',
        'bidang_id',
        'id',
        'nama',
        'status'
    ];

    protected $table = 'satuan_adm_kerja';

    public function fkurusan()
    {
        return $this->hasOne('Modules\Konfigurasi\Entities\SKPD\Urusan', 'id', 'urusan_id')
            ->where('company_id', $this->company_id)
            ->where('id', $this->urusan_id);
    }

    public function fkbidang()
    {
        return $this->hasOne('Modules\Konfigurasi\Entities\SKPD\Bidang', 'id', 'bidang_id')
            ->where('company_id', $this->company_id)
            ->where('urusan_id', $this->urusan_id)
            ->where('id', $this->bidang_id);
    }
}