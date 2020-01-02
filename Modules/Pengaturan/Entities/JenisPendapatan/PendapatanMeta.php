<?php namespace Modules\Pengaturan\Entities\JenisPendapatan;

use Illuminate\Database\Eloquent\Model as Eloquent;

class PendapatanMeta extends Eloquent
{
    public $incrementing = false;

    protected $table = 'pendapatan_pajak_metadata';
    
    protected $fillable = [
        'company_id',
        'kategori_pajak_id',
        'reff_pajak_id',
        'grup_id',
        'kategori_id',
        'subkategori_id',
        'subrekening_id',
        'rekening_id',
        'id',
        'reff_jenis_pajak_id',
        'reff_pelaporan_id',
        'reff_metode_hitung_id',
        'reff_penetapan_pajak_id',
        'jatuh_tempo',
        'persentase',
        'kode_akun',
        'kode_akun_denda'
    ];

    public function fkgrup()
    {
        return $this->hasOne('Modules\Pengaturan\Entities\MataAnggaran\Grup', 'id', 'grup_id')
            ->where('company_id', $this->company_id);
    }

    public function fkkategori()
    {
        return $this->hasOne('Modules\Pengaturan\Entities\MataAnggaran\Kategori', 'id', 'kategori_id')
            ->where('company_id', $this->company_id)
            ->where('grup_id', $this->grup_id);
    }

    public function fksubkategori()
    {
        return $this->hasOne('Modules\Pengaturan\Entities\MataAnggaran\SubKategori', 'id', 'subkategori_id')
            ->where('company_id', $this->company_id)
            ->where('grup_id', $this->grup_id)
            ->where('kategori_id', $this->kategori_id);
    }

    public function fksubrekening()
    {
        return $this->hasOne('Modules\Pengaturan\Entities\MataAnggaran\SubRekening', 'id', 'subrekening_id')
            ->where('company_id', $this->company_id)
            ->where('grup_id', $this->grup_id)
            ->where('kategori_id', $this->kategori_id)
            ->where('subkategori_id', $this->subkategori_id);
    }

    public function fkrekening()
    {
        return $this->hasOne('Modules\Pengaturan\Entities\MataAnggaran\Rekening', 'id', 'rekening_id')
            ->where('company_id', $this->company_id)
            ->where('grup_id', $this->grup_id)
            ->where('kategori_id', $this->kategori_id)
            ->where('subkategori_id', $this->subkategori_id)
            ->where('rekening_id', $this->rekening_id);
    }

    public function fkReffpajak()
    {
        return $this->hasOne('Modules\Pengaturan\Entities\Referensi\RefJenisPajak', 'id', 'reff_jenis_pajak_id')
            ->where('company_id', $this->company_id);
    }

    public function fkReffMetodeHitung()
    {
        return $this->hasOne('Modules\Pengaturan\Entities\Referensi\RefMetodeHitungPajak', 'id', 'reff_metode_hitung_id')
            ->where('company_id', $this->company_id);
    }

    public function fkJenisPelaporan()
    {
        return $this->hasOne('Modules\Pengaturan\Entities\Referensi\RefJenisPelaporanPajak', 'id', 'reff_pelaporan_id')
            ->where('company_id', $this->company_id);
    }

    public function fkJenisPenetapan()
    {
        return $this->hasOne('Modules\Pengaturan\Entities\Referensi\RefJenisPenetapanPajak', 'id', 'reff_penetapan_pajak_id')
            ->where('company_id', $this->company_id);
    }
}