<?php namespace Modules\Pengaturan\Repositories\MataAnggaran;

/*----------------------------------------------------------------------------------------------------
* Project : e-PAD Kab Karo
*
* Author : Andriyanto <admin@indonusamedia.co.id>
* Logic Rekening Akun Entities
*
* Version: 1.0.0
* Latest update: Desember 26, 2019
*
*----------------------------------------------------------------------------------------------------*/

use DataTables;
use Illuminate\Support\Facades\Session;
use Modules\Pengaturan\Entities\MataAnggaran\Rekening;

class RekeningRepository
{
    /**
     * @var mixed
     */
    protected $model;

    /**
     * @param Invoice $invoice
     */
    public function __construct(Rekening $rekening)
    {
        $this->model = $rekening;
    }

    public function datatable($company_id, $grup_id, $kategori_id, $subkategori_id, $subrekening_id)
    {
        $data     = $this->model->where([
            'company_id'    => $company_id,
            'grup_id'       => $grup_id,
            'kategori_id'   => $kategori_id,
            'subkategori_id'=> $subkategori_id,
            'subrekening_id'=> $subrekening_id
        ])->orderBy('id', 'asc')->get();

        if($data->count() > 0)
        {
            foreach($data as $dt) {
                $rekening[] = [
                    'company_id' => $dt['company_id'],
                    'grup_id'   => $dt['grup_id'],
                    'grup_nama' => $dt['grup_id']. '.'.$dt->fkgrup['nama'],
                    'kategori_id'   => $dt['kategori_id'],
                    'kategori_nama' => $dt['grup_id']. '.'.$dt['kategori_id']. '.'.$dt->fkkategori['nama'],
                    'subkategori_id'   => $dt['subkategori_id'],
                    'subkategori_nama' => $dt['grup_id']. '.'.$dt['kategori_id']. '.'.$dt['subkategori_id']. '.'.$dt->fksubkategori['nama'],
                    'subrekening_id' => $dt['subrekening_id'],
                    'subrekening_nama' => $dt['grup_id']. '.'.$dt['kategori_id']. '.'.$dt['subkategori_id'].'.'.$dt['subrekening_id']. '.'.$dt->fksubrekening['nama'],
                    'id'         => $dt['id'],
                    'uuid'       => $dt['uuid'],
                    'rekening_nama' => $dt['nama'],
                    'kategori_pajak'=> $dt['kategori_pajak_id'],
                    'kodeAkun'      => $dt['grup_id'].'.'.$dt['kategori_id'].'.'.$dt['subkategori_id'].'.'.$dt['subrekening_id'].'.'.$dt['id'],
                    'status'     => $dt['status'],
                    'status_nama'=> ( $dt['status'] ) ? 'Aktif' : 'Blok'
                ];
            }

            return DataTables::of($rekening)->make(true);
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

    public function getByUuid($company_id, $pajak_id, $grup_id, $kategori_id, $subkategori_id, $subrekening_id, $uuid)
    {
        $data   = $this->model->where([
            'company_id'  => $company_id,
            'kategori_pajak_id' => $pajak_id,
            'grup_id'     => $grup_id,
            'kategori_id' => $kategori_id,
            'subkategori_id' => $subkategori_id,
            'subrekening_id' => $subrekening_id,
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
                        'grup_id'   => $data['grup_id'],
                        'grup_nama' => $data['grup_id']. '.'.$data->fkgrup['nama'],
                        'kategori_id' => $data['kategori_id'],
                        'kategori_nama' => $data['grup_id'].'.'.$data['kategori_id']. '.'.$data->fkkategori['nama'],
                        'subkategori_id'   => $data['subkategori_id'],
                        'subkategori_nama' => $data['grup_id']. '.'.$data['kategori_id']. '.'.$data['subkategori_id']. '.'.$data->fksubkategori['nama'],
                        'subrekening_id' => $data['subrekening_id'],
                        'subrekening_nama' => $data['grup_id']. '.'.$data['kategori_id']. '.'.$data['subkategori_id'].'.'.$data['subrekening_id']. '.'.$data->fksubrekening['nama'],
                        'id'            => $data['id'],
                        'rekening_nama' => $data['nama'],
                        'kodeAkun'      => $data['grup_id'].'.'.$data['kategori_id'].'.'.$data['subkategori_id'].'.'.$data['subrekening_id'].'.'.$data['id'],
                        'kategori_pajak'=> $data['kategori_pajak_id'],
                        'status_id'  => $data['status'],
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

    public function lists($company_id, $grup_id, $kategori_id, $subkategori_id)
    {
        $data   = $this->model->where([
            'company_id'    => $company_id,
            'grup_id'       => $group_id,
            'kategori_id'   => $category_id,
            'subkategori_id'=> $subkategori_id
        ])->get();

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

    public function listRekening($company_id, $pajak_id, $grup_id, $kategori_id, $subkategori_id, $subrekening_id)
    {
        $response[0] = [
            'id'    => 0,
            'name'  => 'Pilih Kode Rekening' 
        ];

        $search = [
            'company_id'    => $company_id,
            'grup_id'       => $grup_id,
            'kategori_id'   => $kategori_id,
            'subrekening_id'=> $subrekening_id,
            'kategori_pajak_id'  => $pajak_id
        ];

        $data   = $this->model->where($search)
                       ->orderBy('id', 'asc')
                       ->get();
    
        foreach($data as $key => $value)
        {
            $response[] = array(
                'id'     => $value->id,
                'name'   => $value->grup_id.'.'.$value->kategori_id.'.'.$value->subkategori_id.'.'.$value->subrekening_id.'.'.$value->id.' -- '.$value->nama
            );
        }

        return response()->json($response);
    }

    public function listRekeningDenda($search)
    {
        $data   = $this->model->where($search)
                       ->orderBy('id', 'asc')
                       ->get();
    
        foreach($data as $key => $value)
        {
            $response[] = array(
                'company_id'    => $value->company_id,
                'grup_id'       => $value->grup_id,
                'kategori_id'   => $value->kategori_id,
                'subkategori_id'=> $value->subkategori_id,
                'subrekening_id'=> $value->subrekening_id,
                'id'            => $value->id,
                'nama'          => $value->nama
            );
        }

        return DataTables::of($response)->make(true);
    }
}