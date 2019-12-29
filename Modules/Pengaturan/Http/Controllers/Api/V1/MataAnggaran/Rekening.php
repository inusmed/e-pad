<?php namespace Modules\Pengaturan\Http\Controllers\Api\V1\MataAnggaran;

use Uuid;
use DataTables;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Pengaturan\Repositories\MataAnggaran\RekeningRepository;

class Rekening extends Controller
{
    /**
     * Display a listing of the resource to datatable.
     * 
     * @return Response
     */
    public function datatable(RekeningRepository $RekeningRepository, $company_id, $grup_id, $kategori_id, $subkategori_id, $subrekening_id)
    {
        return $RekeningRepository->datatable($company_id, $grup_id, $kategori_id, $subkategori_id, $subrekening_id);
    }

    /**
     * Show the specified resource.
     * @param string $company_id
     * @param string $uuid
     * 
     * @return Response
     */
    public function get(RekeningRepository $RekeningRepository, $company_id, $pajak_id, $grup_id, $kategori_id, $subkategori, $subrekening, $uuid)
    {
        return $RekeningRepository->getByUuid($company_id, $pajak_id, $grup_id, $kategori_id, $subkategori, $subrekening, $uuid);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(RekeningRepository $RekeningRepository)
    {
        $kategori = $RekeningRepository->getBy([
            ['company_id', '=', request('company_id')],
            ['kategori_pajak_id', '=', request('kategori_pajak')],
            ['grup_id', '=', request('grup_id')],
            ['kategori_id', '=', request('kategori_id')],
            ['subkategori_id', '=', request('subkategori_id')],
            ['subrekening_id', '=', request('subrekening_id')],
            ['id', '=', request('id')]
        ]);

        if($kategori->count() == 0)
        {
            /* set rules validation */
            $rules = [
                'id'     => 'required|min:1|max:2',
                'nama'   => 'required|min:5|max:70',
                'status' => 'required'
            ];
            
            /* set message bag error */
            $errorMessages = [
                'id.required'   => 'Terjadi kesalahan pada kode rekening',
                'nama.required' => 'Terjadi kesalahan pada nama rekening',
                'nama.min'      => 'Minimal kode rekening adalah 5 karakter huruf',
                'nama.max'      => 'Maksimal kode rekening adalah 70 karakter huruf',
            ];

            $validator = Validator::make(request()->all(), $rules, $errorMessages);

            // Validate the input and return correct response
            if ($validator->fails())
            {
                return response()->json(array(
                    'success' => false,
                    'validate'  => 'validator',
                    'messages' => $validator->getMessageBag()->toArray()
                ), 422);
            }

            $datastore = [
                'company_id' => request('company_id'),
                'kategori_pajak_id' => request('kategori_pajak'),
                'grup_id'    => request('grup_id'),
                'kategori_id'=> request('kategori_id'),
                'subkategori_id'=> request('subkategori_id'),
                'subrekening_id'=> request('subrekening_id'),
                'id'         => request('id'),
                'uuid'       => Uuid::generate(4)->string,
                'nama'       => request('nama'),
                'status'     => request('status'),
            ];

            $store = $RekeningRepository->store($datastore);

            if($store) {
                return response()->json(array('success' => true, 'data' => $datastore), 200);
            }
        }

        return response()->json(array(
            'success'    => false,
            'validate'  => 'exist',
            'messages'   => 'Nomor akun telah tersedia, silahkan gunakan nomor lain'
        ), 422);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(RekeningRepository $RekeningRepository, $company_id, $kategori_pajak_id, $grup_id, $kategori_id, $subkategori_id, $subrekening_id, $uuid)
    {
        /* set rules validation */
        $rules = [
            'kodeAkun' => 'required|min:1|max:2',
            'nama'     => 'required|min:5|max:70',
            'status'   => 'required'
        ];

        /* set message bag error */
        $errorMessages = [
            'kodeAkun.required'   => 'Terjadi kesalahan pada kode rekening',
            'nama.required' => 'Terjadi kesalahan pada nama rekening',
            'nama.min'      => 'Minimal kode rekening adalah 5 karakter huruf',
            'nama.max'      => 'Maksimal kode rekening adalah 70 karakter huruf',
        ];

        $validator = Validator::make(request()->all(), $rules, $errorMessages);

         // Validate the input and return correct response
         if ($validator->fails())
         {
             return response()->json(array(
                 'success' => false,
                 'validate'  => 'validator',
                 'messages' => $validator->getMessageBag()->toArray()
             ), 422);
         }

         $updated = $RekeningRepository->updated([
            'company_id'   => $company_id,
            'kategori_pajak_id' => $kategori_pajak_id,
            'grup_id'      => $grup_id,
            'kategori_id'  => $kategori_id,
            'subkategori_id' => $subkategori_id,
            'subrekening_id' => $subrekening_id,
            'uuid'         => $uuid
        ], [
            'nama'     => request('nama'),
            'status'   => request('status'),
        ]);

        if($updated == true)
        {
            return response()->json([
                'success'   => true,
                'data'      => [
                    'company_id'   => $company_id,
                    'kategori_pajak_id' => $kategori_pajak_id,
                    'grup_id'      => $grup_id,
                    'kategori_id'  => $kategori_id,
                    'subkategori_id' => $subkategori_id,
                    'subrekening_id' => $subrekening_id,
                    'uuid'         => $uuid,
                    'nama'     => request('nama'),
                    'status'   => request('status'),
                ]
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(RekeningRepository $RekeningRepository)
    {
        $delete =  $RekeningRepository->deleteBy([
            'company_id'    => request('company_id'),
            'kategori_pajak_id' => request('kategori_pajak'),
            'grup_id'       => request('grup_id'),
            'kategori_id'   => request('kategori_id'),
            'subkategori_id' => request('subkategori_id'),
            'subrekening_id' => request('subrekening_id'),
            'uuid'          => request('kodeAkun')
        ]);

        if($delete)
        {
            return response()->json([
                'status'    => true,
                'message'   => 'Data rekening barhasil dihapus'
            ], 200);
        }

        return response()->json([
            'status'    => false,
            'message'   => 'Terjadi kesalahan gagal hapus, silahkan hubungi administrator untuk support'
        ], 500);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function lists(RekeningRepository $RekeningRepository, $company_id, $grup_id)
    {
        return $RekeningRepository->lists($company_id, $grup_id);
    }
}