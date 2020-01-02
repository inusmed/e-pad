<?php namespace Modules\Pengaturan\Http\Controllers\Api\V1\JenisPendapatan;

use Uuid;
use DataTables;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Pengaturan\Repositories\JenisPendapatan\GrupPendapatanRepository;

class GrupPendapatan extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function datatable(GrupPendapatanRepository $grupPendapatanRepository)
    {
        return $grupPendapatanRepository->datatable();
    }
}