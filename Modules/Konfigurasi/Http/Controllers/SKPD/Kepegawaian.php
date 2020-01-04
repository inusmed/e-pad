<?php namespace Modules\Konfigurasi\Http\Controllers\SKPD;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class Kepegawaian extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('konfigurasi::skpd.kepegawaian.index');
    }
}