<?php namespace Modules\Pengaturan\Repositories\JenisPendapatan;

/*----------------------------------------------------------------------------------------------------
* Project : e-PAD Kab Karo
*
* Author : Andriyanto <admin@indonusamedia.co.id>
* Logic Jenis Pendapatan Repository
*
* Version: 1.0.0
* Latest update: Desember 26, 2019
*
*----------------------------------------------------------------------------------------------------*/

use DataTables;
use Illuminate\Support\Facades\Session;
use Modules\Pengaturan\Entities\MataAnggaran\Rekening;
use Modules\Pengaturan\Entities\JenisPendapatan\Pendapatan;

class GrupPendapatanRepository
{
    /**
     * @var mixed
     */
    protected $model;

    /**
     * @param Invoice $invoice
     */
    public function __construct(Pendapatan $pendapatan)
    {
        $this->model = $pendapatan;
    }

    /**
     * Datatable Data Pendapatan
     * @param Pendapatan $pendapatan
     * 
     * @return Datatable
     */
    public function datatable()
    {
        /* inquery all data order by id desc */
        $data     = $this->model->where('status', 1)->orderBy('id', 'asc')->get();

        if($data->count() > 0)
        {
            /* push data to pendapatan */
            foreach($data as $dt) {
                if($dt->fkMetapendapatan->fkReffpajak['id'] == 2 )
                {
                    $pendapatan[] = [
                        'reffpajak'  => $dt->fkreffpajak['nama'],
                        'jenispajak' => $dt->fkMetapendapatan->fkReffpajak['nama'],
                        'metodeHitung' => $dt->fkMetapendapatan->fkReffMetodeHitung['nama'],
                        'kode_pendapatan' => $dt['grup_id'].'.'.$dt['kategori_id'].'.'.$dt['subkategori_id'].'.'.$dt['subrekening_id'].'.'.$dt['rekening_id'].'.'.$dt['kode'],
                        'nama_pendapatan' => $dt['nama'],
                        'status'     => $dt['status'],
                        'status_name'=> ( $dt['status'] ) ? 'Aktif' : 'Blok'
                    ];
                }
            }

            /* set datatable provider */
            return DataTables::of($pendapatan)->make(true);
        }

        /* data tidak ditemukan */
        return response()->json([
            'status'    => false,
            'message'   => 'data tidak ditemukan'
        ], 522);
    }

}