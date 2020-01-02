<?php namespace Modules\Konfigurasi\Repositories\SKPD;

/*----------------------------------------------------------------------------------------------------
* Project : e-PAD Kab Karo
*
* Author : Andriyanto <admin@indonusamedia.co.id>
* Logic Bidang SKPD Repository
*
* Version: 1.0.0
* Latest update: Desember 26, 2019
*
*----------------------------------------------------------------------------------------------------*/

use DataTables;
use Illuminate\Support\Facades\Session;
use Modules\Konfigurasi\Entities\SKPD\Bidang;

class BidangRepository
{
    /**
     * @var mixed
     */
    protected $model;

    /**
     * @param Bidang $tarifOmzet
     */
    public function __construct(Bidang $bidang)
    {
        $this->model = $bidang;
    }

    /**
     * Datatable Tarif Omzet
     * @param array data
     * 
     * @return Datatable
     */
    public function datatable()
    {
        /* inquery all data order by id desc */
        $data     = $this->model->get();
        
        if($data->count() > 0)
        {
            /* push data to pendapatan */
            foreach($data as $dt) {
                $bidang[] = [
                    'company_id'   => $dt->company_id,
                    'urusan_id'    => $dt->urusan_id,
                    'urusan_nama'  => strtoupper($dt->fkurusan['nama']),
                    'kode'         => $dt->urusan_id.'.'.$dt->id,
                    'nama'         => strtoupper($dt->nama),
                    'id'           => $dt->id,
                    'status'       => $dt->status,
                    'status_nama'  => ( $dt['status'] ) ? 'Aktif' : 'Blok'
                ];
            }

            /* set datatable provider */
            return DataTables::of($bidang)->make(true);
        }

        /* return data not found */
        return response()->json([
            'status' => 'false',
            'message'=> 'Data tidak ditemukan, silahkan tambah data bidang terlebih dahulu'
        ], 522);
    }

    public function getBy($company_id, $urusan_id, $bidang_id)
    {
        return $this->model->where([
            'company_id'    => $company_id,
            'urusan_id'     => $urusan_id,
            'id'            => $bidang_id
        ])->first();
    }
}