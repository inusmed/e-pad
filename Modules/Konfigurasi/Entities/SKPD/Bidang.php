<?php namespace Modules\Konfigurasi\Entities\SKPD;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Bidang extends Eloquent
{
    public $incrementing = false;

    protected $fillable = [
        'company_id',
        'urusan_id',
        'id',
        'nama',
        'status'
    ];

    protected $table = 'satker_adm_bidang';

    public function fkurusan()
    {
        return $this->hasOne('Modules\Konfigurasi\Entities\SKPD\Urusan', 'id', 'urusan_id')
            ->where('company_id', $this->company_id);
    }
}