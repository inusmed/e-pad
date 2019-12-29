<?php namespace Modules\Pengaturan\Repositories\MataAnggaran;

/*----------------------------------------------------------------------------------------------------
* Project : e-PAD Kab Karo
*
* Author : Andriyanto <admin@indonusamedia.co.id>
* Logic Grup Entities
*
* Version: 1.0.0
* Latest update: Desember 26, 2019
*
*----------------------------------------------------------------------------------------------------*/

use DataTables;
use Illuminate\Support\Facades\Session;
use Modules\Pengaturan\Entities\MataAnggaran\Grup;

class GrupRepository
{
    /**
     * @var mixed
     */
    protected $model;

    /**
     * @param Invoice $invoice
     */
    public function __construct(Grup $grup)
    {
        $this->model = $grup;
    }

    public function datatable()
    {
        $data = $this->model->orderBy('id', 'asc')->get();

        foreach($data as $dt) {
            $group[] = [
                'id'    => $dt['id'],
                'uuid'  => $dt['uuid'],
                'company_id' => $dt['company_id'],
                'nama_grup'  => $dt['nama'],
                'status'     => $dt['status'],
                'keterangan' => ( $dt['status'] ) ? 'Aktif' : 'Blok'
            ];
        }

        return DataTables::of($group)->make(true);
    }

    public function getByUuid($company_id, $uuid)
    {
        $data   = $this->model->where([
            'company_id'    => $company_id,
            'uuid'          => $uuid
        ])->first();

        if( !is_null($data))
        {
            return
                response()->json(array(
                    'status'    => true,
                    'data'      => [
                        'id'    => $data['id'],
                        'company_id' => $data['company_id'],
                        'name'  => $data['nama'],
                        'status'=> ($data['status']) ? 'Aktif' : 'Blok',
                        'created_at' => date('d M Y h:m:i', strtotime($data['created_at'])),
                        'updated_at' => date('d M Y h:m:i', strtotime($data['updated_at'])),
                    ]
                ));
        }

        return response()->json([
            'status'    => false,
        ], 500);
    }

    public function lists($company_id, $grup_id)
    {
        $data   = $this->model->where([
            'company_id'    => $company_id,
            'id'            => $grup_id
        ])->orderBy('id', 'asc')->get();

        $response[0] = [
            'id'    => 0,
            'name'  => 'Pilih Grup Akun' 
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