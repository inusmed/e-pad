<?php namespace Modules\Konfigurasi\Http\Controllers\Api\V1\Skpd;

use Uuid;
use DataTables;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Konfigurasi\Repositories\SKPD\SatkerRepository;

class Satker extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(SatkerRepository $satkerRepository, $company_id, $urusan_id, $bidang_id)
    {
        return $satkerRepository->datatable($company_id, $urusan_id, $bidang_id);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function get(SatkerRepository $satkerRepository, $company_id, $urusan_id, $bidang_id, $id)
    {
        $satker = $satkerRepository->getBy($company_id, $urusan_id, $bidang_id, $id);

        if(!is_null($satker))
        {
            $data = [
                'company_id'   => $satker->company_id,
                'urusan_id'    => $satker->urusan_id,
                'urusan_nama'  => strtoupper($satker->fkurusan['nama']),
                'bidang_id'    => $satker->bidang_id,
                'bidang_nama'  => strtoupper($satker->fkbidang['nama']),
                'kode'         => $satker->urusan_id.'.'.$satker->bidang_id.'.'.$satker->id,
                'nama'         => strtoupper($satker->nama),
                'id'           => $satker->id,
                'status'       => $satker->status,
                'status_nama'  => ( $satker['status'] ) ? 'Aktif' : 'Blok',
                'created_at' => date('d M Y h:m:i', strtotime($satker['created_at'])),
                'updated_at' => date('d M Y h:m:i', strtotime($satker['updated_at'])),
            ];
            return response()->json([
                'status' => true,
                'data'   => $data
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message'=> 'Data tidak ditemukan, periksa kembali data anda'
        ], 522);
    }
}