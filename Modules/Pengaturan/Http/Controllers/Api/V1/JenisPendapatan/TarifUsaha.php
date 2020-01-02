<?php namespace Modules\Pengaturan\Http\Controllers\Api\V1\JenisPendapatan;

use Uuid;
use DataTables;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Pengaturan\Repositories\JenisPendapatan\TarifUsahaRepository;

class TarifUsaha extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function datatable(TarifUsahaRepository $tarifUsahaRepository)
    {
        $data = [
            'company_id' =>  request('company_id'),
            'kategori_pajak_id' => request('kategori_pajak'),
            'reff_pajak_id' => request('reff_pajak'),
            'grup_id' => request('grup_id'),
            'kategori_id' => request('kategori_id'),
            'subkategori_id' => request('subkategori_id'),
            'subrekening_id' => request('subrekening_id'),
            'rekening_id'    => request('rekening_id'),
            'pendapatan_id'  => request('pendapatan_id'),
        ];
        
        return $tarifUsahaRepository->datatable($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function get(TarifUsahaRepository $tarifUsahaRepository, $company_id, $uuid)
    {
        $tarifPendapatan = $tarifUsahaRepository->getByUuid($company_id, $uuid);

        if( !is_null($tarifPendapatan) )
        {
            $data = [
                'company_id'        => $tarifPendapatan['company_id'],
                'kategori_pajak'    => $tarifPendapatan['kategori_pajak_id'],
                'reff_pajak'        => $tarifPendapatan['reff_pajak_id'],
                'grup_id'           => $tarifPendapatan['grup_id'],
                'kategori_id'       => $tarifPendapatan['kategori_id'],
                'subkategori_id'    => $tarifPendapatan['subkategori_id'],
                'subrekening_id'    => $tarifPendapatan['subrekening_id'],
                'rekening_id'       => $tarifPendapatan['rekening_id'],
                'pendapatan_id'     => $tarifPendapatan['pendapatan_id'],
                'tarif_group_id'    => $tarifPendapatan['tarif_group_id'],
                'reff_periode_tarif_id'     => $tarifPendapatan['reff_periode_tarif_id'],
                'id'                => $tarifPendapatan['id'],
                'nama'              => $tarifPendapatan['nama'],
                'nama_pendapatan'   => $tarifPendapatan->fkpendapatan['nama'],
                'satuan'            => $tarifPendapatan['satuan'],
                'persentase'        => $tarifPendapatan['persentase'],
                'nilai'        => number_format($tarifPendapatan['nilai'], 0, ',', '.'),
                'keterangan'   => $tarifPendapatan['keterangan'],
                'status'       => ($tarifPendapatan['status'] == '1') ? 'Aktif' : 'Blok'
            ];

            return response()->json([
                'status' => true,
                'data'   => $data
            ], 200);
        }
        else
        {
            return response()->json([
                'status' => false,
                'message'=> 'Data tidak ditemukan, periksa kembali data anda'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(TarifUsahaRepository $tarifUsahaRepository)
    {
        $data = [
            'kategori_pajak_id' => request('kategori_pajak'),
            'reff_pajak_id'     => request('reff_pajak'),
            'company_id'        => request('company_id'),
            'grup_id'           => request('grup_id'),
            'kategori_id'       => request('kategori_id'),
            'subkategori_id'    => request('subkategori_id'),
            'subrekening_id'    => request('subrekening_id'),
            'rekening_id'       => request('rekening_id'),
            'pendapatan_id'     => request('id'),
        ];
        
        /** set error rules */
        $rules = array(
            'id'     => 'required', 
            'kode_akun' => 'required',
            'persentase' => 'required',
            'nama'       => 'required|min:3|max:150',
            'periodeTarif' => 'required|integer',
            'status' => 'required'
        );

        /** create validator */
        $validator = Validator::make(request()->all(), $rules, $this->errorMessageBag());

        // Validate the input and return correct response
        if (!$validator->fails())
        {

            $tarifPendapatan = $tarifUsahaRepository->get($data);

            $store_data = array_merge($data, [
                'id'                    => ( is_null($tarifPendapatan) ) ? 1 : $tarifPendapatan['id'] + 1,
                'kode_akun'             => preg_replace('/\D/', '', request('kode_akun')),
                'uuid'                  => Uuid::generate(4)->string,
                'nama'                  => request('nama'),
                'reff_periode_tarif_id' => request('periodeTarif'),
                'tarif_group_id'        => 1,
                'persentase'            => request('persentase'),
                'nilai'                 => 1,
                'keterangan'            => request('keterangan'),
                'status'                => request('status')
            ]);

            /* store data to database */
            if($tarifUsahaRepository->store($store_data))
            {
                return response()->json(array(
                    'success'   => true,
                    'data'      => $store_data,
                    'messages'  => 'Penambahan data tarif usaha berhasil'
                ), 200);
            }
        }

        return response()->json(array(
            'success' => false,
            'validate' => 'validator',
            'messages' => $validator->getMessageBag()->toArray()
        ), 422);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(TarifUsahaRepository $tarifUsahaRepository, $company_id, $uuid)
    {
        /** set error rules */
        $rules = array(
            'persentase' => 'required',
            'nama'       => 'required|min:3|max:150',
            'periodeTarif' => 'required|integer',
            'status' => 'required'
        );

        /** set error message */
        $errorMessages = [
            'nama.required'   => 'Terjadi kesalahan pada nama pendapatan',
            'nama.min'        => 'Minimal nama pendapatan adalah 3 karakter huruf',
            'nama.max'        => 'Maksimal nama pendapatan adalah 150 karakter huruf',
            'periodeTarif.required' =>  'Pilih periode terlebih dahulu',
            'persentase.required' =>  'Nilai persentase tidak boleh kosong',
        ];

        /** create validator */
        $validator = Validator::make(request()->all(), $rules, $errorMessages);

        // Validate the input and return correct response
        if ($validator->fails())
        {
            return response()->json(array(
                'success' => false,
                'validate' => 'validator',
                'messages' => $validator->getMessageBag()->toArray()
            ), 422);
        }

        $updated = $tarifUsahaRepository->updated([
            ['company_id', '=', $company_id],
            ['uuid', '=', $uuid]
        ], [
            'nama'                  => request('nama'),
            'reff_periode_tarif_id' => request('periodeTarif'),
            'satuan'                => request('satuan'),
            'persentase'            => request('persentase'),
            'keterangan'            => request('keterangan'),
            'status'                => request('status')
        ]);

        if($updated) {
            return response()->json(array(
                'success'   => true,
                'data'      => $tarifUsahaRepository->get(['uuid' => $uuid]),
                'messages'  => 'perubahan data tarif usaha berhasil'
            ), 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(TarifUsahaRepository $tarifUsahaRepository)
    {
        $validator = Validator::make(request()->all(), ['captcha' => 'required|captcha']);

        if( !$validator->fails() )
        {
            $data = $tarifUsahaRepository->get([
                'company_id' => request('company_id'),
                'uuid'       => request('uuid')
            ]);

            $tarifOmzet = [
                'company_id'        => $data['company_id'],
                'kategori_pajak'    => $data['kategori_pajak_id'],
                'reff_pajak'        => $data['reff_pajak_id'],
                'grup_id'           => $data['grup_id'],
                'kategori_id'       => $data['kategori_id'],
                'subkategori_id'    => $data['subkategori_id'],
                'subrekening_id'    => $data['subrekening_id'],
                'rekening_id'       => $data['rekening_id'],
                'pendapatan_id'     => $data['pendapatan_id'],
            ];

            $delete =  $tarifUsahaRepository->deleteBy([
                'company_id' => request('company_id'),
                'uuid'       => request('uuid')
            ]);

            if($delete)
            {
                return response()->json([
                    'status'    => true,
                    'data'      => $tarifOmzet,
                    'message'   => 'Data rekening barhasil dihapus'
                ], 200);
            }

            return response()->json([
                'status'    => false,
                'message'   => 'Terjadi kesalahan gagal hapus, silahkan hubungi administrator untuk support'
            ], 500);
        }

        return response()->json([
            'status'   => false,
            'message'  => $validator->getMessageBag()->toArray()
        ], 422);
    }

    private function errorMessageBag()
    {
        /** set error message */
        return [
            'id.required'     => 'Terjadi kesalahan pemilihan jenis pendapatan',
            'nama.required'   => 'Terjadi kesalahan pada nama pendapatan',
            'nama.min'        => 'Minimal nama pendapatan adalah 3 karakter huruf',
            'nama.max'        => 'Maksimal nama pendapatan adalah 150 karakter huruf',
            'kode_akun.required' =>  'Terjadi kesalahan pemilihan jenis pendapatan',
            'periodeTarif.required' =>  'Pilih periode terlebih dahulu',
            'persentase.required' =>  'Nilai persentase tidak boleh kosong',
        ];
    }
}