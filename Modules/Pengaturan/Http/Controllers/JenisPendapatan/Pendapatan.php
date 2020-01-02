<?php namespace Modules\Pengaturan\Http\Controllers\JenisPendapatan;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Pengaturan\Entities\Referensi\RefPajak;
use Modules\Pengaturan\Entities\Referensi\RefJenisPajak;
use Modules\Pengaturan\Entities\Referensi\RefKategoriPajak;
use Modules\Pengaturan\Entities\Referensi\RefMetodeHitungPajak;
use Modules\Pengaturan\Entities\Referensi\RefJenisPenetapanPajak;
use Modules\Pengaturan\Entities\Referensi\RefJenisPelaporanPajak;

class Pendapatan extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('pengaturan::jenis-pendapatan.pendapatan.index');
    }

    public function create()
    {
        $company_id = 'X3B196590X9';
        foreach(RefPajak::all() as $reffPajak) {
            $optReffPajak[$reffPajak->id]   = $reffPajak->id.' - '.$reffPajak->nama;
        }

        foreach(RefJenisPajak::all() as $jenisPajak) {
            $optJenisPajak[$jenisPajak->id]   = $jenisPajak->id.' - '.$jenisPajak->nama;
        }

        foreach(RefKategoriPajak::all() as $kategoriPajak) {
            $optKategoriTax[$kategoriPajak->id]   = $kategoriPajak->id.' - '.$kategoriPajak->nama;
        }

        foreach(RefMetodeHitungPajak::all() as $metodeHitung) {
            $optMetodeHitung[$metodeHitung->id]   = $metodeHitung->id.' - '.$metodeHitung->nama;
        }

        foreach(RefJenisPenetapanPajak::all() as $penetapanPajak) {
            $optPenetapanPajak[$penetapanPajak->id]   = $penetapanPajak->id.' - '.$penetapanPajak->nama;
        }

        foreach(RefJenisPelaporanPajak::all() as $pelaporanPajak) {
            $optPelaporanPajak[$pelaporanPajak->id]   = $pelaporanPajak->id.' - '.$pelaporanPajak->nama;
        }

        return view('pengaturan::jenis-pendapatan.pendapatan.create', compact(
            'company_id',
            'optReffPajak',
            'optJenisPajak',
            'optKategoriTax',
            'optMetodeHitung',
            'optPenetapanPajak',
            'optPelaporanPajak'
        ));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($company_id)
    {
        if( request()->has('grup_id') && !is_null(request('grup_id')) && request()->has('kategori_pajak_id') &&  !is_null(request('kategori_pajak_id')) ) 
        {
            $grup_id = request('grup_id');

            if( request()->has('kategori_id') && !is_null(request('kategori_id')) && request()->has('subkategori_id') && !is_null(request('subkategori_id')) )
            {
                $subkategori_id = request('subkategori_id');
                $kategori_id = request('kategori_id');

                if( request()->has('subrekening_id') && !is_null(request('subrekening_id')) && request()->has('rekening_id') &&  !is_null(request('rekening_id')) )
                {
                    $subrekening_id = request('subrekening_id');
                    $rekening_id    = request('rekening_id');

                    if( request()->has('pendapatan_id') && !is_null(request('pendapatan_id')) && request()->has('ketetapan_id') &&  !is_null(request('ketetapan_id')) )
                    {
                        $kategori_pajak_id  = request('kategori_pajak_id');
                        $ketetapan_id     = request('ketetapan_id');
                        $pendapatan_id      = request('pendapatan_id');

                        return view('pengaturan::jenis-pendapatan.pendapatan.show', compact(
                            'company_id', 'kategori_pajak_id', 'ketetapan_id','grup_id',
                            'kategori_id', 'subkategori_id', 'subrekening_id', 'rekening_id', 'pendapatan_id'
                        ));
                    }
                }
            }
        }

        return redirect('/pengaturan/jenis-pendapatan');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($company_id)
    {
        if( request()->has('grup_id') && !is_null(request('grup_id')) && request()->has('kategori_pajak_id') &&  !is_null(request('kategori_pajak_id')) ) 
        {
            $grup_id = request('grup_id');

            if( request()->has('kategori_id') && !is_null(request('kategori_id')) && request()->has('subkategori_id') && !is_null(request('subkategori_id')) )
            {
                $subkategori_id = request('subkategori_id');
                $kategori_id = request('kategori_id');

                if( request()->has('subrekening_id') && !is_null(request('subrekening_id')) && request()->has('rekening_id') &&  !is_null(request('rekening_id')) )
                {
                    $subrekening_id = request('subrekening_id');
                    $rekening_id    = request('rekening_id');

                    if( request()->has('pendapatan_id') && !is_null(request('pendapatan_id')) && request()->has('ketetapan_id') &&  !is_null(request('ketetapan_id')) )
                    {
                        $kategori_pajak_id  = request('kategori_pajak_id');
                        $ketetapan_id     = request('ketetapan_id');
                        $pendapatan_id      = request('pendapatan_id');

                        foreach(RefPajak::all() as $reffPajak) {
                            $optReffPajak[$reffPajak->id]   = $reffPajak->id.' - '.$reffPajak->nama;
                        }
                
                        foreach(RefJenisPajak::all() as $jenisPajak) {
                            $optJenisPajak[$jenisPajak->id]   = $jenisPajak->id.' - '.$jenisPajak->nama;
                        }
                
                        foreach(RefKategoriPajak::all() as $kategoriPajak) {
                            $optKategoriTax[$kategoriPajak->id]   = $kategoriPajak->id.' - '.$kategoriPajak->nama;
                        }
                
                        foreach(RefMetodeHitungPajak::all() as $metodeHitung) {
                            $optMetodeHitung[$metodeHitung->id]   = $metodeHitung->id.' - '.$metodeHitung->nama;
                        }
                
                        foreach(RefJenisPenetapanPajak::all() as $penetapanPajak) {
                            $optPenetapanPajak[$penetapanPajak->id]   = $penetapanPajak->id.' - '.$penetapanPajak->nama;
                        }
                
                        foreach(RefJenisPelaporanPajak::all() as $pelaporanPajak) {
                            $optPelaporanPajak[$pelaporanPajak->id]   = $pelaporanPajak->id.' - '.$pelaporanPajak->nama;
                        }

                        return view('pengaturan::jenis-pendapatan.pendapatan.edit', compact(
                            'company_id', 'kategori_pajak_id', 'ketetapan_id','grup_id',
                            'kategori_id', 'subkategori_id', 'subrekening_id', 'rekening_id', 'pendapatan_id',
                            'optReffPajak',
                            'optJenisPajak',
                            'optKategoriTax',
                            'optMetodeHitung',
                            'optPenetapanPajak',
                            'optPelaporanPajak'
                        ));
                    }
                }
            }
        }

        return redirect('/pengaturan/jenis-pendapatan');
    }
}