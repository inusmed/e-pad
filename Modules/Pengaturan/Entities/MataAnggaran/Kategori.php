<?php namespace Modules\Pengaturan\Entities\MataAnggaran;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Kategori extends Eloquent
{
    public $incrementing = false;

    protected $fillable = [
        'company_id',
        'grup_id',
        'id',
        'uuid',
        'nama',
        'status'
    ];

    protected $table = 'akun_kategori';

    public function fkgrup()
    {
        return $this->hasOne('Modules\Pengaturan\Entities\MataAnggaran\Grup', 'id', 'grup_id')
            ->where('company_id', $this->company_id);
    }
}