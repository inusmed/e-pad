<?php namespace Modules\Konfigurasi\Repositories\SKPD;

/*----------------------------------------------------------------------------------------------------
* Project : e-PAD Kab Karo
*
* Author : Andriyanto <admin@indonusamedia.co.id>
* Logic Satker SKPD Repository
*
* Version: 1.0.0
* Latest update: Desember 26, 2019
*
*----------------------------------------------------------------------------------------------------*/

use DataTables;
use Illuminate\Support\Facades\Session;
use Modules\Konfigurasi\Entities\SKPD\Satker;

class SatkerRepository
{
    /**
     * @var mixed
     */
    protected $model;

    /**
     * @param Satker $satker
     */
    public function __construct(Satker $satker)
    {
        $this->model = $satker;
    }

    /**
     * Datatable Tarif Omzet
     * @param array data
     * 
     * @return Datatable
     */
    public function datatable($company_id, $urusan_id, $bidang_id)
    {
        /* inquery all data order by id desc */
        $data     = $this->model->where([
            'company_id'    => $company_id,
            'urusan_id'     => $urusan_id,
            'bidang_id'     => $bidang_id
        ])->get();
        
        if($data->count() > 0)
        {
            /* push data to pendapatan */
            foreach($data as $dt) {
                $satker[] = [
                    'company_id'   => $dt->company_id,
                    'urusan_id'    => $dt->urusan_id,
                    'urusan_nama'  => strtoupper($dt->fkurusan['nama']),
                    'bidang_id'    => $dt->bidang_id,
                    'bidang_nama'  => strtoupper($dt->fkbidang['nama']),
                    'kode'         => $dt->urusan_id.'.'.$dt->bidang_id.'.'.$dt->id,
                    'nama'         => strtoupper($dt->nama),
                    'id'           => $dt->id,
                    'status'       => $dt->status,
                    'status_nama'  => ( $dt['status'] ) ? 'Aktif' : 'Blok'
                ];
            }

            /* set datatable provider */
            return DataTables::of($satker)->make(true);
        }

        /* return data not found */
        return response()->json([
            'status' => 'false',
            'message'=> 'Data tidak ditemukan, silahkan tambah satuan kerja terlebih dahulu'
        ], 522);
    }

    public function getBy($company_id, $urusan_id, $bidang_id, $id)
    {
        return $this->model->where([
            'company_id'    => $company_id,
            'urusan_id'     => $urusan_id,
            'bidang_id'     => $bidang_id,
            'id'            => $id
        ])->first();
    }
}