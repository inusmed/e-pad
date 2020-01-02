<?php namespace Modules\Pengaturan\Entities\Tarif;

use Illuminate\Database\Eloquent\Model as Eloquent;

class TarifUsaha extends Eloquent
{
    public $incrementing = true;

    protected $fillable = [
        'company_id',
        'kategori_pajak_id',
        'reff_pajak_id',
        'grup_id',
        'kategori_id',
        'subkategori_id',
        'subrekening_id',
        'rekening_id',
        'pendapatan_id',
        'id',
        'kode_akun',
        'uuid',
        'nama',
        'reff_periode_tarif_id',
        'tarif_group_id',
        'satuan',
        'nilai',
        'persentase',
        'nilai',
        'keterangan',
        'status'
    ];

    protected $table = 'tarif_omzet';

    public function fktarifrup()
    {
        return $this->hasOne('Modules\Pengaturan\Entities\Tarif\TarifGrup', 'id', 'tarif_group_id')
            ->where('company_id', $this->company_id);
    }

    public function fkperiodetarif()
    {
        return $this->hasOne('Modules\Pengaturan\Entities\Referensi\ReffPeriodeTarif', 'id', 'reff_periode_tarif_id')
            ->where('company_id', $this->company_id);
    }

    public function fkpendapatan()
    {
        return $this->hasOne('Modules\Pengaturan\Entities\JenisPendapatan\Pendapatan', 'id', 'pendapatan_id')
            ->where('company_id', $this->company_id)
            ->where('kategori_pajak_id', $this->kategori_pajak_id)
            ->where('reff_pajak_id', $this->reff_pajak_id)
            ->where('grup_id', $this->grup_id)
            ->where('kategori_id', $this->kategori_id)
            ->where('subkategori_id', $this->subkategori_id)
            ->where('subrekening_id', $this->subrekening_id)
            ->where('rekening_id', $this->rekening_id)
            ->where('id', $this->pendapatan_id);
    }
}