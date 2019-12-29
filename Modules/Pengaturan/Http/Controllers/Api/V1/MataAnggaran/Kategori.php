<?php namespace Modules\Pengaturan\Http\Controllers\Api\V1\MataAnggaran;

use Uuid;
use DataTables;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Pengaturan\Repositories\MataAnggaran\KategoriRepository;

class Kategori extends Controller
{
    /**
     * Display a listing of the resource to datatable.
     * 
     * @return Response
     */
    public function datatable(KategoriRepository $KategoriRepository, $company_id, $grup_id)
    {
        return $KategoriRepository->datatable($company_id, $grup_id);
    }

    /**
     * Show the specified resource.
     * @param string $company_id
     * @param string $uuid
     * 
     * @return Response
     */
    public function get(KategoriRepository $KategoriRepository, $company_id, $grup_id, $uuid)
    {
        return $KategoriRepository->getByUuid($company_id, $grup_id, $uuid);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(KategoriRepository $KategoriRepository)
    {
        $kategori = $KategoriRepository->getBy([
            ['company_id', '=', request('company_id')],
            ['grup_id', '=', request('grup_id')],
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
                'grup_id'    => request('grup_id'),
                'id'         => request('id'),
                'uuid'       => Uuid::generate(4)->string,
                'nama'       => request('nama'),
                'status'     => request('status'),
            ];

            $store = $KategoriRepository->store($datastore);

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
    public function update(KategoriRepository $KategoriRepository, $company_id, $grup_id, $uuid)
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

         $updated = $KategoriRepository->updated([
            'company_id'   => $company_id,
            'grup_id'      => $grup_id,
            'uuid'         => $uuid
        ], [
            'nama'     => request('nama'),
            'status'   => request('status'),
        ]);

        if($updated == true)
        {
            return response()->json([
                'status'    => true,
                'data'      => [
                    'company_id'   => $company_id,
                    'grup_id'      => $grup_id,
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
    public function destroy(KategoriRepository $KategoriRepository)
    {
        $delete =  $KategoriRepository->deleteBy([
            'company_id'    => request('company_id'),
            'grup_id'       => request('grup_id'),
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
    public function lists(KategoriRepository $KategoriRepository, $company_id, $grup_id)
    {
        return $KategoriRepository->lists($company_id, $grup_id);
    }
}