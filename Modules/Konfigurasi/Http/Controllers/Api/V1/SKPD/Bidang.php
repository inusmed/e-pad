<?php namespace Modules\Konfigurasi\Http\Controllers\Api\V1\Skpd;

use Uuid;
use DataTables;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Konfigurasi\Repositories\SKPD\BidangRepository;

class Bidang extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(BidangRepository $bidangRepository, $company_id)
    {
        return $bidangRepository->datatable();
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function get(BidangRepository $bidangRepository, $company_id, $urusan_id, $id)
    {
        $bidang = $bidangRepository->getBy($company_id, $urusan_id, $id);

        if(!is_null($bidang))
        {
            $data = [
                'company_id'   => $bidang->company_id,
                'urusan_id'    => $bidang->urusan_id,
                'urusan_nama'  => strtoupper($bidang->fkurusan['nama']),
                'kode'         => $bidang->urusan_id.'.'.$bidang->id,
                'nama'         => strtoupper($bidang->nama),
                'id'           => $bidang->id,
                'status'       => $bidang->status,
                'status_nama'  => ( $bidang['status'] ) ? 'Aktif' : 'Blok',
                'created_at' => date('d M Y h:m:i', strtotime($bidang['created_at'])),
                'updated_at' => date('d M Y h:m:i', strtotime($bidang['updated_at'])),
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