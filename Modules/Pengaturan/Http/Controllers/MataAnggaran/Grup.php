<?php namespace Modules\Pengaturan\Http\Controllers\MataAnggaran;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class Grup extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('pengaturan::mata-anggaran.grup-akun.index');
    }
}