<?php namespace Modules\Konfigurasi\Http\Controllers\SKPD;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class Satker extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index($company_id)
    {
        if( request()->has('urusan_id') && !is_null(request('urusan_id')) && request()->has('bidang_id') &&  !is_null(request('bidang_id')) ) 
        {
            $urusan_id = request('urusan_id');
            $bidang_id = request('bidang_id');

            return view('konfigurasi::skpd.satker.index', compact(
                'company_id', 'urusan_id', 'bidang_id'
            ));
        }

        return redirect('konfigurasi/skpd/bidang/'.$company_id);
    }
}