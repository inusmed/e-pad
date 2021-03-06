<?php namespace Modules\Pengaturan\Http\Controllers\MataAnggaran;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class Subkategori extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index($company_id)
    {
        if( request()->has('grup_id') &&  !is_null(request('grup_id')) ) 
        {
            $grup_id = request('grup_id');

            if( request()->has('kategori_id') &&  !is_null(request('kategori_id')) )
            {
                $kategori_id = request('kategori_id');

                return view('pengaturan::mata-anggaran.subkategori-akun.index', compact(
                    'company_id', 'grup_id', 'kategori_id'
                ));
            }

            return redirect('/pengaturan/mata-anggaran/kategori-akun/'.$company_id.'?grup_id='.$grup_id);
        }

        return redirect('/pengaturan/mata-anggaran/grup-akun');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create($company_id)
    {
        if( request()->has('grup_id') &&  !is_null(request('grup_id')) ) 
        {
            $grup_id = request('grup_id');

            if( request()->has('kategori_id') &&  !is_null(request('kategori_id')) )
            {
                $kategori_id = request('kategori_id');
                $uuid    = request('uuid');

                return view('pengaturan::mata-anggaran.subkategori-akun.create', compact(
                    'company_id', 'grup_id', 'kategori_id', 'uuid'
                ));
            }

            return redirect('/pengaturan/mata-anggaran/kategori-akun/'.$company_id.'?grup_id='.$grup_id);
        }

        return redirect('/pengaturan/mata-anggaran/grup-akun');
    }

    /**
     * Show the form for editing the specified resource.
     * @param str $company_id
     * @param int $grup_id
     * @param str $uuid
     * @return Response
     */
    public function edit($company_id)
    {
        if( request()->has('grup_id') &&  !is_null(request('grup_id')) ) 
        {
            $grup_id = request('grup_id');

            if( request()->has('kategori_id') &&  !is_null(request('kategori_id')) )
            {
                $kategori_id = request('kategori_id');
                $uuid    = request('uuid');

                return view('pengaturan::mata-anggaran.subkategori-akun.edit', compact(
                    'company_id', 'grup_id', 'kategori_id', 'uuid'
                ));
            }

            return redirect('/pengaturan/mata-anggaran/kategori-akun/'.$company_id.'?grup_id='.$grup_id);
        }

        return redirect('/pengaturan/mata-anggaran/grup-akun');
    }
}