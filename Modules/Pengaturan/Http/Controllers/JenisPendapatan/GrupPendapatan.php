<?php namespace Modules\Pengaturan\Http\Controllers\JenisPendapatan;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class GrupPendapatan extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('pengaturan::jenis-pendapatan.grup-pendapatan.index');
    }
}