<?php namespace Modules\Pengaturan\Entities\JenisPendapatan;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Pendapatan extends Eloquent
{
    public $incrementing = false;

    protected $table = 'pendapatan_pajak';
    
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
        'uuid',
        'kode',
        'kode_akun',
        'nama',
        'nama',
        'status'
    ];

    public function fkreffkategori()
    {
        return $this->hasOne('Modules\Pengaturan\Entities\Referensi\RefKategoriPajak', 'id', 'kategori_pajak_id')
            ->where('company_id', $this->company_id);
    }

    public function fkreffpajak()
    {
        return $this->hasOne('Modules\Pengaturan\Entities\Referensi\RefPajak', 'id', 'reff_pajak_id')
            ->where('company_id', $this->company_id);
    }

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
            ->where('subrekening_id', $this->subrekening_id);
    }

    public function fkMetapendapatan()
    {
        return $this->hasOne('Modules\Pengaturan\Entities\JenisPendapatan\PendapatanMeta', 'kode_akun', 'kode_akun')
            ->where('company_id', $this->company_id)
            ->where('kategori_pajak_id', $this->kategori_pajak_id)
            ->where('reff_pajak_id', $this->reff_pajak_id)
            ->where('grup_id', $this->grup_id)
            ->where('kategori_id', $this->kategori_id)
            ->where('subkategori_id', $this->subkategori_id)
            ->where('rekening_id', $this->rekening_id)
            ->where('id', $this->id);
    }
}