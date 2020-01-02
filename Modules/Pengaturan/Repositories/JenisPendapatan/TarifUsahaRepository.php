<?php namespace Modules\Pengaturan\Repositories\JenisPendapatan;

/*----------------------------------------------------------------------------------------------------
* Project : e-PAD Kab Karo
*
* Author : Andriyanto <admin@indonusamedia.co.id>
* Logic Tarif Usaha Repository
*
* Version: 1.0.0
* Latest update: Desember 26, 2019
*
*----------------------------------------------------------------------------------------------------*/

use DataTables;
use Illuminate\Support\Facades\Session;
use Modules\Pengaturan\Entities\Tarif\TarifUsaha;

class TarifUsahaRepository
{
    /**
     * @var mixed
     */
    protected $model;

    /**
     * @param TarifUsaha $tarifOmzet
     */
    public function __construct(TarifUsaha $tarifUsaha)
    {
        $this->model = $tarifUsaha;
    }

    /**
     * Datatable Tarif Omzet
     * @param array data
     * 
     * @return Datatable
     */
    public function datatable(array $data)
    {
        /* inquery all data order by id desc */
        $data     = $this->model->where($data)->orderBy('nama', 'asc')->orderBy('tarif_group_id', 'asc')->get();
        
        if($data->count() > 0)
        {
            /* push data to pendapatan */
            foreach($data as $dt) {
                $tarifUsaha[] = [
                    'company_id'      => $dt->company_id,
                    'kategori_pajak'  => $dt->kategori_pajak_id,
                    'reff_pajak'      => $dt->reff_pajak_id,
                    'grup_id'         => $dt->grup_id,
                    'kategori_id'     => $dt->kategori_id,
                    'subkategori_id'  => $dt->subkategori_id,
                    'subrekening_id'  => $dt->subrekening_id,
                    'rekening_id'     => $dt->rekening_id,
                    'pendapatan_id'   => $dt->pendapatan_id,
                    'id'              => $dt->id,
                    'uuid'            => $dt->uuid,
                    'nama'            => $dt['nama'],
                    'periode'         => $dt->fkperiodetarif['nama'],
                    'tarif'           => number_format($dt->nilai, 0, ',', '.'),
                    'persentase'      => $dt['persentase'].'%',
                    'keterangan'      => $dt['keterangan'],
                    'status'          => ($dt['status'] == 0) ? 'Blok' : 'Aktif'
                ];
            }

            /* set datatable provider */
            return DataTables::of($tarifUsaha)->make(true);
        }

        /* return data not found */
        return response()->json([
            'status' => 'false',
            'message'=> 'Data tidak ditemukan, silahkan tambah data tarif usaha terlebih dahulu'
        ], 522);
    }

    /**
     * Insert Data Tarif Omzet
     * @param arrray $data
     * 
     * @return boolean
     */
    public function store(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Get Data Tarif Omzet
     * @param arrray $data
     * 
     * @return array
     */
    public function get(array $data)
    {
        return $this->model->where($data)->orderBy('created_at', 'desc')->first();
    }

    /**
     * Get Data By Uuid
     * @param arrray $data
     * 
     * @return array
     */
    public function getByUuid($company_id, $uuid)
    {
        return $this->model->where([
            ['company_id', '=', $company_id],
            ['uuid', '=', $uuid]
        ])->first();
    }

    /**
     * Update data
     * @param arrray $key
     * @param array $data
     * 
     * @return boolean
     */
    public function updated($key, $data)
    {
        return $this->model->where($key)->update($data);
    }

    /**
     * Delete Data
     * @param array $data
     * 
     * @return boolean
     */
    public function deleteBy($data)
    {
        return $this->model->where($data)->delete();
    }
}