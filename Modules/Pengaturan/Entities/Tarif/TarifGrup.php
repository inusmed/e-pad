<?php namespace Modules\Pengaturan\Entities\Tarif;

use Illuminate\Database\Eloquent\Model as Eloquent;

class TarifGrup extends Eloquent
{
    public $incrementing = true;

    protected $fillable = [
        'id',
        'company_id',
        'nama',
        'status'
    ];

    protected $table = 'tarif_group';
}