<?php namespace Modules\Pengaturan\Entities\MataAnggaran;

use Illuminate\Database\Eloquent\Model as Eloquent;

class SubRekening extends Eloquent
{
    public $incrementing = false;

    protected $table = 'akun_subrekening';
    
    protected $fillable = [
        'company_id',
        'kategori_pajak_id',
        'grup_id',
        'kategori_id',
        'subkategori_id',
        'id',
        'uuid',
        'nama',
        'status'
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
}