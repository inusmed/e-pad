<?php namespace Modules\Konfigurasi\Http\Controllers\Api\V1\Skpd;

use Uuid;
use DataTables;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Konfigurasi\Repositories\SKPD\PegawaiRepository;

class Kepegawaian extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(PegawaiRepository $pegawaiRepository, $company_id)
    {
        return $pegawaiRepository->datatable();
    }
}