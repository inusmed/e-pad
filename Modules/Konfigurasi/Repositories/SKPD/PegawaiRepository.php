<?php namespace Modules\Konfigurasi\Repositories\SKPD;

/*----------------------------------------------------------------------------------------------------
* Project : e-PAD Kab Karo
*
* Author : Andriyanto <admin@indonusamedia.co.id>
* Logic Pegawai Repository
*
* Version: 1.0.0
* Latest update: Desember 26, 2019
*
*----------------------------------------------------------------------------------------------------*/

use DataTables;
use Illuminate\Support\Facades\Session;
use Modules\Konfigurasi\Entities\SKPD\Pegawai;

class PegawaiRepository
{
    /**
     * @var mixed
     */
    protected $model;

    /**
     * @param Bidang $tarifOmzet
     */
    public function __construct(Pegawai $pegawai)
    {
        $this->model = $pegawai;
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
        $data     = $this->model->orderBy('created_at')->get();
        
        if($data->count() > 0)
        {
            /* push data to pendapatan */
            foreach($data as $dt) {
                $pegawai[] = [
                    'company_id'   => $dt->company_id,
                    'urusan_id'    => $dt->urusan_id,
                    'nama_urusan'  => '',
                    'bidang_id'    => '',
                    'nama_bidang'  => '',
                    'satker_id'    => '',
                    'nama_satker'  => '',
                    'nip'          => $dt->nip,
                    'nama'         => $dt->nama,
                    'jabatan'      => $dt->jabatan,
                    'userid'       => $dt->userid,
                    'status'       => $dt->status,
                    'status_nama'  => ( $dt['status'] ) ? 'Aktif' : 'Blok'
                ];
            }

            /* set datatable provider */
            return DataTables::of($pegawai)->make(true);
        }

        /* return data not found */
        return response()->json([
            'status' => 'false',
            'message'=> 'Data tidak ditemukan, silahkan tambah data bidang terlebih dahulu'
        ], 522);
    }
}