<?php namespace Modules\Pengaturan\Http\Controllers\JenisPendapatan;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Pengaturan\Entities\Tarif\TarifGrup;
use Modules\Pengaturan\Entities\Referensi\ReffPeriodeTarif;


class TarifOmzet extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {        
        return view('pengaturan::jenis-pendapatan.tarif-omzet.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $company_id     = session('company_id');
        $TarifGrup      = TarifGrup::all();
        $ReffPeriodeTarif     = ReffPeriodeTarif::all();

        foreach($TarifGrup as $tarifGrup) {
            $opttarifGrup[$tarifGrup->id]   = $tarifGrup->id.' - '.$tarifGrup->nama;
        }

        foreach($ReffPeriodeTarif as $reffPeriodeTarif) {
            $optreffPeriodeTarif[$reffPeriodeTarif->id]   = $reffPeriodeTarif->id.' - '.$reffPeriodeTarif->nama;
        }

        return view('pengaturan::jenis-pendapatan.tarif-omzet.create', compact(
            'company_id',
            'opttarifGrup',
            'optreffPeriodeTarif'
        ));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function edit($company_id, $uuid)
    {
        $company_id     = session('company_id');
        $TarifGrup      = TarifGrup::all();
        $ReffPeriodeTarif     = ReffPeriodeTarif::all();

        foreach($TarifGrup as $tarifGrup) {
            $opttarifGrup[$tarifGrup->id]   = $tarifGrup->id.' - '.$tarifGrup->nama;
        }

        foreach($ReffPeriodeTarif as $reffPeriodeTarif) {
            $optreffPeriodeTarif[$reffPeriodeTarif->id]   = $reffPeriodeTarif->id.' - '.$reffPeriodeTarif->nama;
        }

        return view('pengaturan::jenis-pendapatan.tarif-omzet.edit', compact(
            'company_id',
            'uuid',
            'opttarifGrup',
            'optreffPeriodeTarif'
        ));
    }

    /**
     * filter form
     * @return Response
     */
    public function filter($company_id)
    {
        if( request()->has('kategori_pajak_id') &&  !is_null(request('kategori_pajak_id')) && request()->has('ketetapan_pajak') &&  !is_null(request('ketetapan_pajak')) ) 
        {
            if( request()->has('grup_id') &&  !is_null(request('grup_id')) && request()->has('kategori_id') &&  !is_null(request('kategori_id')) ) 
            {
                if( request()->has('subkategori_id') &&  !is_null(request('subkategori_id')) && request()->has('subrekening_id') &&  !is_null(request('subrekening_id')) ) 
                {
                    if( request()->has('rekening_id') &&  !is_null(request('rekening_id')) && request()->has('pendapatan_id') &&  !is_null(request('pendapatan_id')) )
                    {
                        $company_id = $company_id;
                        $kategori_pajak_id = request('kategori_pajak_id');
                        $ketetapan_pajak   = request('ketetapan_pajak');
                        $grup_id           = request('grup_id');
                        $kategori_id       = request('kategori_id');
                        $subkategori_id    = request('subkategori_id');
                        $subrekening_id    = request('subrekening_id');
                        $rekening_id       = request('rekening_id');
                        $pendapatan_id     = request('pendapatan_id');

                        return view('pengaturan::jenis-pendapatan.tarif-omzet.filter', compact(
                            'company_id', 'kategori_pajak_id', 'ketetapan_pajak', 'grup_id', 'kategori_id',
                            'subkategori_id', 'subrekening_id', 'rekening_id', 'pendapatan_id'
                        ));
                    }
                }
            }
        }

        return redirect('pengaturan/tarif-omzet');
    }
}