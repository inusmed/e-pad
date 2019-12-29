<?php namespace Modules\Pengaturan\Repositories\MataAnggaran;

/*----------------------------------------------------------------------------------------------------
* Project : e-PAD Kab Karo
*
* Author : Andriyanto <admin@indonusamedia.co.id>
* Logic Sub Rekening Akun Entities
*
* Version: 1.0.0
* Latest update: Desember 26, 2019
*
*----------------------------------------------------------------------------------------------------*/

use DataTables;
use Illuminate\Support\Facades\Session;
use Modules\Pengaturan\Entities\MataAnggaran\SubRekening;

class SubRekeningRepository
{
    /**
     * @var mixed
     */
    protected $model;

    /**
     * @param Invoice $invoice
     */
    public function __construct(SubRekening $subrekening)
    {
        $this->model = $subrekening;
    }

    public function datatable($company_id, $grup_id, $kategori_id, $subkategori_id)
    {
        $data     = $this->model->where([
            'company_id'    => $company_id,
            'grup_id'       => $grup_id,
            'kategori_id'   => $kategori_id,
            'subkategori_id'=> $subkategori_id
        ])->orderBy('id', 'asc')->get();

        if($data->count() > 0)
        {
            foreach($data as $dt) {
                $subrekening[] = [
                    'company_id' => $dt['company_id'],
                    'kategori_pajak_id' => $dt['kategori_pajak_id'],
                    'grup_id'    => $dt['grup_id'],
                    'grup_nama'  => $dt['grup_id']. '.'.$dt->fkgrup['nama'],
                    'kategori_id'=> $dt['kategori_id'],
                    'kategori_nama' => $dt['grup_id']. '.'.$dt['kategori_id']. '.'.$dt->fkkategori['nama'],
                    'subkategori_id'   => $dt['subkategori_id'],
                    'subkategori_nama' => $dt['grup_id']. '.'.$dt['kategori_id']. '.'.$dt['subkategori_id']. '.'.$dt->fksubkategori['nama'],
                    'id'         => $dt['id'],
                    'uuid'       => $dt['uuid'],
                    'subrekening_nama' => $dt['nama'],
                    'kodeAkun'   => $dt['grup_id'].'.'.$dt['kategori_id'].'.'.$dt['subkategori_id'].'.'.$dt['id'],
                    'status'     => $dt['status'],
                    'status_nama'=> ( $dt['status'] ) ? 'Aktif' : 'Blok'
                ];
            }

            return DataTables::of($subrekening)->make(true);
        }

        return response()->json([
            'status'    => false,
            'message'   => 'data tidak ditemukan'
        ], 522);
    }

    public function store($data)
    {
        $store = $this->model->create($data);
        
        if($store) 
            return true;

        return false;
    }

    public function getByUuid($company_id, $pajak_id, $grup_id, $kategori_id, $subkategori, $uuid)
    {
        $data   = $this->model->where([
            'company_id'  => $company_id,
            'kategori_pajak_id' => $pajak_id,
            'grup_id'     => $grup_id,
            'kategori_id' => $kategori_id,
            'subkategori_id' => $subkategori,
            'uuid'        => $uuid
        ])->first();

        if( !is_null($data))
        {
            return
                response()->json(array(
                    'status'    => true,
                    'data'      => [
                        'id'    => $data['id'],
                        'uuid'  => $data['uuid'],
                        'company_id' => $data['company_id'],
                        'grup_id'    => $data['grup_id'],
                        'grop_nama'  => $data['grup_id']. '.'.$data->fkgrup['nama'],
                        'kategori_id' => $data['kategori_id'],
                        'kategori_nama' => $data['grup_id'].'.'.$data['kategori_id']. '.'.$data->fkkategori['nama'],
                        'subkategori_nama' => $data['grup_id'].'.'.$data['kategori_id'].'.'.$data['subkategori_id']. '.'.$data->fksubkategori['nama'],
                        'subrekening_nama' => $data['nama'],
                        'kodeAkun'   => $data['grup_id'].'.'.$data['kategori_id'].'.'.$data['subkategori_id'].'.'.$data['id'],
                        'status'     => ($data['status']) ? 'Aktif' : 'Blok',
                        'status_id'  => ($data['status']),
                        'kategori_pajak' => $data['kategori_pajak_id'],
                        'created_at' => date('d M Y h:m:i', strtotime($data['created_at'])),
                        'updated_at' => date('d M Y h:m:i', strtotime($data['updated_at'])),
                    ]
                ), 200);
        }

        return response()->json([
            'status'    => false,
            'message'   => 'data tidak ditemukan'
        ], 500);
    }

    public function getBy($data)
    {
        return $this->model->where($data)->get();
    }

    public function updated($key, $data)
    {
        return $this->model->where($key)
                    ->update($data);
    }

    public function deleteBy($data)
    {
        $destroy = $this->model->where($data)->delete();

        if($destroy)
            return true;

        return false;
    }

    public function lists($company_id, $grup_id, $kategori_id, $subkategori_id)
    {
        $data   = $this->model->where([
            'company_id'    => $company_id,
            'grup_id'       => $grup_id,
            'kategori_id'   => $kategori_id,
            'subkategori_id'=> $subkategori_id
        ])->orderBy('id', 'asc')->get();

        $response[0] = [
            'id'    => 0,
            'name'  => 'Pilih Sub Rekening Akun' 
        ];
        
        foreach($data as $key => $value)
        {
            $response[] = array(
                'id'     => $value->id,
                'name'   => $value->id.' -- '.$value->nama
            );
        }

        return response()->json($response);
    }
}