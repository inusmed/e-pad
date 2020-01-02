<?php namespace Modules\Pengaturan\Repositories\JenisPendapatan;

/*----------------------------------------------------------------------------------------------------
* Project : e-PAD Kab Karo
*
* Author : Andriyanto <admin@indonusamedia.co.id>
* Logic Jenis Pendapatan Repository
*
* Version: 1.0.0
* Latest update: Desember 26, 2019
*
*----------------------------------------------------------------------------------------------------*/

use DataTables;
use Illuminate\Support\Facades\Session;
use Modules\Pengaturan\Entities\MataAnggaran\Rekening;
use Modules\Pengaturan\Entities\JenisPendapatan\Pendapatan;

class PendapatanRepository
{
    /**
     * @var mixed
     */
    protected $model;

    /**
     * @param Invoice $invoice
     */
    public function __construct(Pendapatan $pendapatan)
    {
        $this->model = $pendapatan;
    }

    /**
     * Datatable Data Pendapatan
     * @param Pendapatan $pendapatan
     * 
     * @return Datatable
     */
    public function datatable()
    {
        /* inquery all data order by id desc */
        $data     = $this->model->orderBy('id', 'asc')->get();

        if($data->count() > 0)
        {
            /* push data to pendapatan */
            foreach($data as $dt) {
                $pendapatan[] = [
                    'company_id' => $dt['company_id'],
                    'kategori_pajak'=> $dt['kategori_pajak_id'],
                    'ketetapan_id'  => $dt['reff_pajak_id'],
                    'grup_id'       => $dt['grup_id'],
                    'kategori_id'   => $dt['kategori_id'],
                    'subkategori_id'=> $dt['subkategori_id'],
                    'subrekening_id'=> $dt['subrekening_id'],
                    'rekening_id'=> $dt['rekening_id'],
                    'id'         => $dt['id'],
                    'kode'       => $dt['kode'],
                    'kode_akun'  => $dt['kode_akun'],
                    'nama'       => $dt['nama'],
                    'reffpajak'  => $dt->fkreffpajak['nama'],
                    'utama'      => $dt['grup_id'].'.'.$dt['kategori_id'].'.'.$dt['subkategori_id'].'.'.$dt['subrekening_id'].'. '.$dt->fksubrekening['nama'],
                    'pendapatan' => $dt['grup_id'].'.'.$dt['kategori_id'].'.'.$dt['subkategori_id'].'.'.$dt['subrekening_id'].'.'.$dt['rekening_id'].'. '.$dt['nama'],
                    'status'     => $dt['status'],
                    'status_name'=> ( $dt['status'] ) ? 'Aktif' : 'Blok'
                ];
            }

            /* set datatable provider */
            return DataTables::of($pendapatan)->make(true);
        }

        /* data tidak ditemukan */
        return response()->json([
            'status'    => false,
            'message'   => 'data tidak ditemukan'
        ], 522);
    }

    /**
     * Get data dengan metdata
     * 
     * @param str company_id
     * @param int pajak_id
     * @param int ketetapan_id
     * @param int grup_id
     * @param int kategori_id
     * @param int subkategori_id
     * @param int subrekening_id
     * @param int rekening_id
     * @param int id
     * 
     * @return array
     */
    public function get(
        $company_id, $pajak_id, $ketetapan_id, $grup_id, $kategori_id, 
        $subkategori_id, $subrekening_id, $rekening_id, $id
    )
    {
        /* inquery data */
        $pendapatan = $this->model->where([
            ['kategori_pajak_id', '=', $pajak_id],
            ['reff_pajak_id',     '=', $ketetapan_id],
            ['company_id',        '=', $company_id],
            ['grup_id',           '=', $grup_id],
            ['kategori_id',       '=', $kategori_id],
            ['subkategori_id',    '=', $subkategori_id],
            ['subrekening_id',    '=', $subrekening_id],
            ['rekening_id',       '=', $rekening_id],
            ['id',                '=', $id],
        ])->first();

        if(!is_null($pendapatan))
        {
            /* relation data akun denda */
            $kode_akun_denda = $pendapatan->fkMetapendapatan['kode_akun_denda'];

            $search = [
                'company_id'    => $company_id,
                'grup_id'       => $kode_akun_denda[0],
                'kategori_id'   => $kode_akun_denda[1],
                'subkategori_id'=> $kode_akun_denda[2],
                'subrekening_id'=> $kode_akun_denda[3],
                'id'            => $kode_akun_denda[4]
            ];
    
            /* akun denda */
            $kode_akun_denda   = Rekening::where($search)
                           ->orderBy('id', 'asc')
                           ->first();


            /* push information data */
            $data = [
                'company_id'         => $pendapatan->company_id,
                'kode'               => $pendapatan->kode,
                'kategori_pajak'     => $pendapatan->fkreffkategori['nama'],
                'kategori_pajak_id'  => $pendapatan->kategori_pajak_id,
                'reff_pajak'         => $pendapatan->fkreffpajak['nama'],
                'reff_pajak_id'      => $pendapatan->reff_pajak_id,
                'jenis_pajak'        => $pendapatan->fkMetapendapatan->fkReffpajak['nama'],
                'jenis_pajak_id'     => $pendapatan->fkMetapendapatan['reff_jenis_pajak_id'],
                'sub_rekening'       => $pendapatan->grup_id.'.'.$pendapatan->kategori_id.'.'.$pendapatan->subkategori_id.'.'.$pendapatan->subrekening_id.'. '.$pendapatan->fksubrekening['nama'],
                'rekening'           => $pendapatan->grup_id.'.'.$pendapatan->kategori_id.'.'.$pendapatan->subkategori_id.'.'.$pendapatan->subrekening_id.'.'.$pendapatan->rekening_id.'. '.$pendapatan->fkrekening['nama'],
                'pendapatan'         => $pendapatan['nama'],
                'metode_hitung'      => $pendapatan->fkMetapendapatan->fkReffMetodeHitung['nama'],
                'metode_hitung_id'   => $pendapatan->fkMetapendapatan['reff_metode_hitung_id'],
                'persentase'         => $pendapatan->fkMetapendapatan['persentase'],
                'jenis_pelaporan'    => $pendapatan->fkMetapendapatan->fkJenisPelaporan['nama'],
                'jenis_pelaporan_id' => $pendapatan->fkMetapendapatan['reff_pelaporan_id'],
                'jenis_penetapan'    => $pendapatan->fkMetapendapatan->fkJenisPenetapan['nama'],
                'jenis_penetapan_id' => $pendapatan->fkMetapendapatan['reff_penetapan_pajak_id'],
                'jatuh_tempo'        => $pendapatan->fkMetapendapatan['jatuh_tempo'],
                'akun_denda'         => $kode_akun_denda['grup_id'].'.'.$kode_akun_denda['kategori_id'].'.'.$kode_akun_denda['subkategori_id'].'.'.$kode_akun_denda['subrekening_id'].'.'.$kode_akun_denda['id'].' -- '.$kode_akun_denda['nama'],
                'status'             => ($pendapatan['status'] == 0) ? 'Blok' : 'Aktif'
            ];

            return response()->json([
                'status'    => true,
                'data'      => $data
            ], 200);
        }

        return response()->json([
            'status'    => false,
            'data'      => 'Data pendapatan tidak ditemukan'
        ], 500);
    }

    /**
     * Get data
     * 
     * @param str company_id
     * @param int pajak_id
     * @param int ketetapan_id
     * @param int grup_id
     * @param int kategori_id
     * @param int subkategori_id
     * @param int subrekening_id
     * @param int rekening_id
     * @param int id
     * 
     * @return array
     */
    public function getBy(
        $company_id, $pajak_id, $ketetapan_id, $grup_id, $kategori_id, 
        $subkategori_id, $subrekening_id, $rekening_id, $id
    )
    {
        return $this->model->where([
            ['kategori_pajak_id', '=', $pajak_id],
            ['reff_pajak_id',     '=', $ketetapan_id],
            ['company_id',        '=', $company_id],
            ['grup_id',           '=', $grup_id],
            ['kategori_id',       '=', $kategori_id],
            ['subkategori_id',    '=', $subkategori_id],
            ['subrekening_id',    '=', $subrekening_id],
            ['rekening_id',       '=', $rekening_id],
            ['id',                '=', $id],
        ])->get();
    }

    /**
     * Get data
     * 
     * @param array data
     * */
    public function getWith($data)
    {
        return $this->model->where($data);
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    /**
     * Pembaharuan data
     * 
     * @param array key
     * @param array data
     * 
     * @return boolen
     */
    public function updated($key, $data)
    {
        return $this->model->where($key)->update($data);
    }

    public function deleteBy($data)
    {
        $destroy = $this->model->where($data)->delete();

        if($destroy)
            return true;

        return false;
    }
}