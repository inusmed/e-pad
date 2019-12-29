<?php namespace Modules\Pengaturan\Http\Controllers\MataAnggaran;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Pengaturan\Entities\Referensi\RefKategoriPajak;

class SubRekening extends Controller
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

                if( request()->has('subkategori_id') &&  !is_null(request('subkategori_id')) )
                {
                    $subkategori_id = request('subkategori_id');

                    return view('pengaturan::mata-anggaran.subrekening-akun.index', compact(
                        'company_id', 'grup_id', 'kategori_id', 'subkategori_id'
                    ));
                }

                return redirect('/pengaturan/mata-anggaran/subkategori-akun/'.$company_id.'?grup_id='.$grup_id.'&kategori_id='.$kategori_id);
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

                if( request()->has('subkategori_id') &&  !is_null(request('subkategori_id')) )
                {
                    $subkategori_id = request('subkategori_id');
                    foreach(RefKategoriPajak::all() as $kategori)
                    {
                        $option[$kategori->id]   = $kategori->id.' - '.$kategori->nama;
                    }

                    return view('pengaturan::mata-anggaran.subrekening-akun.create', compact(
                        'company_id', 'grup_id', 'kategori_id', 'subkategori_id', 'option'
                    ));
                }

                return redirect('/pengaturan/mata-anggaran/subkategori-akun/'.$company_id.'?grup_id='.$grup_id.'&kategori_id='.$kategori_id);
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
        if( request()->has('grup_id') && !is_null(request('grup_id')) ) 
        {
            $grup_id = request('grup_id');

            if( request()->has('kategori_id') && !is_null(request('kategori_id')) )
            {
                $kategori_id = request('kategori_id');

                if( request()->has('subkategori_id') && !is_null(request('subkategori_id')) && request()->has('kategori_pajak_id') &&  !is_null(request('kategori_pajak_id')) )
                {
                    $subkategori_id = request('subkategori_id');
                    $kategori_pajak_id = request('kategori_pajak_id');
                    $uuid    = request('uuid');

                    foreach(RefKategoriPajak::all() as $kategori)
                    {
                        $option[$kategori->id]   = $kategori->id.' - '.$kategori->nama;
                    }

                    return view('pengaturan::mata-anggaran.subrekening-akun.edit', compact(
                        'company_id', 'kategori_pajak_id', 'grup_id', 'kategori_id', 'subkategori_id', 'uuid', 'option'
                    ));
                }

                return redirect('/pengaturan/mata-anggaran/subkategori-akun/'.$company_id.'?grup_id='.$grup_id.'&kategori_id='.$kategori_id);
            }

            return redirect('/pengaturan/mata-anggaran/kategori-akun/'.$company_id.'?grup_id='.$grup_id);
        }

        return redirect('/pengaturan/mata-anggaran/grup-akun');
    }
}