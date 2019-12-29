<?php namespace Modules\Pengaturan\Http\Controllers\Api\V1\MataAnggaran;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Pengaturan\Repositories\MataAnggaran\GrupRepository;

class Grup extends Controller
{
    /**
     * Display a listing of the resource to datatable.
     * 
     * @return Response
     */
    public function datatable(GrupRepository $GrupRepository)
    {
        return $GrupRepository->datatable();
    }

    /**
     * Show the specified resource.
     * @param string $company_id
     * @param string $uuid
     * 
     * @return Response
     */
    public function get(GrupRepository $GrupRepository, $company_id, $uuid)
    {
        return $GrupRepository->getByUuid($company_id, $uuid);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function lists(GrupRepository $GrupRepository, $company_id, $id)
    {
        return $GrupRepository->lists($company_id, $id);
    }
}