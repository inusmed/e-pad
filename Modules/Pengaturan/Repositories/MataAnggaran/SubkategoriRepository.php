<?php namespace Modules\Pengaturan\Repositories\MataAnggaran;

/*----------------------------------------------------------------------------------------------------
* Project : e-PAD Kab Karo
*
* Author : Andriyanto <admin@indonusamedia.co.id>
* Logic Sub Kategori Akun Entities
*
* Version: 1.0.0
* Latest update: Desember 26, 2019
*
*----------------------------------------------------------------------------------------------------*/

use DataTables;
use Illuminate\Support\Facades\Session;
use Modules\Pengaturan\Entities\MataAnggaran\SubKategori;

class SubkategoriRepository
{
    /**
     * @var mixed
     */
    protected $model;

    /**
     * @param Invoice $invoice
     */
    public function __construct(SubKategori $subkategori)
    {
        $this->model = $subkategori;
    }

    public function datatable($company_id, $grup_id, $kategori_id)
    {
        $data     = $this->model->where([
            'company_id'    => $company_id,
            'grup_id'       => $grup_id,
            'kategori_id'   => $kategori_id
        ])->orderBy('id', 'asc')->get();

        if($data->count() > 0)
        {
            foreach($data as $dt) {
                $subkategori[] = [
                    'company_id' => $dt['company_id'],
                    'grup_id'    => $dt['grup_id'],
                    'group_name' => $dt['grup_id']. '. '.$dt->fkgrup['nama'],
                    'kategori_id'   => $dt['kategori_id'],
                    'category_name' => $dt['grup_id']. '. '.$dt['kategori_id']. '. '.$dt->fkkategori['nama'],
                    'id'         => $dt['id'],
                    'uuid'       => $dt['uuid'],
                    'subcategory_name' => $dt['nama'],
                    'kodeAkun'   => $dt['grup_id'].'.'.$dt['kategori_id'].'.'.$dt['id'],
                    'status'     => $dt['status'],
                    'status_name'=> ( $dt['status'] ) ? 'Aktif' : 'Blok'
                ];
            }

            return DataTables::of($subkategori)->make(true);
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

    public function getByUuid($company_id, $grup_id, $kategori_id, $uuid)
    {
        $data   = $this->model->where([
            'company_id'  => $company_id,
            'grup_id'     => $grup_id,
            'kategori_id' => $kategori_id,
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
                        'grup_nama' => $data['grup_id']. '.'.$data->fkgrup['nama'],
                        'kategori_id'=> $data['kategori_id'],
                        'kategori_nama' => $data['grup_id'].'.'.$data['kategori_id']. '.'.$data->fkkategori['nama'],
                        'subkategori_nama' => $data['nama'],
                        'kodeAkun'      => $data['grup_id'].'.'.$data['kategori_id'].'.'.$data['id'],
                        'status_id'     => $data['status'],
                        'status'     => ($data['status']) ? 'Aktif' : 'Blok',
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

    public function lists($company_id, $grup_id, $kategori_id)
    {
        $data   = $this->model->where([
            'company_id'    => $company_id,
            'grup_id'       => $grup_id,
            'kategori_id'   => $kategori_id
        ])->orderBy('id', 'asc')->get();

        $response[0] = [
            'id'    => 0,
            'name'  => 'Pilih Sub Kategori Akun' 
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