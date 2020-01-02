<?php namespace Modules\Pengaturan\Http\Controllers\Api\V1\JenisPendapatan;

use Uuid;
use DataTables;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Pengaturan\Entities\JenisPendapatan\PendapatanMeta;
use Modules\Pengaturan\Repositories\JenisPendapatan\PendapatanRepository;

class Pendapatan extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function datatable(PendapatanRepository $pendapatanRepository)
    {
        return $pendapatanRepository->datatable();
    }

    /**
     * Show the specified resource.
     * @param Dependencies Pendapatan Repository
     * @param string $company_id
     * @param string $uuid
     * 
     * @return Response
     */
    public function get(PendapatanRepository $pendapatanRepository, 
        $company_id, $pajak_id, $jenis_pajak, $grup_id, $kategori_id, 
        $subkategori_id, $subrekening_id, $rekening_id, $pendapatan_id
    )
    {
        return $pendapatanRepository->get(
            $company_id, $pajak_id, $jenis_pajak, $grup_id, $kategori_id, 
            $subkategori_id, $subrekening_id, $rekening_id, $pendapatan_id
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(PendapatanRepository $pendapatanRepository, PendapatanMeta $pendapatanMetadata)
    {
        $jenisPendapatan = $pendapatanRepository->getWith([
            ['kategori_pajak_id', '=', request('kategoriPajak')],
            ['reff_pajak_id', '=', request('reffPajak')],
            ['company_id', '=', request('company_id')],
            ['grup_id', '=', request('akun_grup')],
            ['kategori_id', '=', request('akun_kategori')],
            ['subkategori_id', '=', request('akun_subkategori')],
            ['subrekening_id', '=', request('akun_subrekening')],
            ['rekening_id', '=', request('akun_rekening')],
        ]);

        if($jenisPendapatan->count() == 0) {
            if(!is_null(request('kode')))
            {
                /** set error rules */
                $rules = array(
                    'kode' => 'required|max:4', 
                    'akun_subrekening' => 'required', 
                    'akun_rekening' => 'required',
                    'akun_denda_rekening' => 'required',
                    'nama' => 'required|min:3|max:150',
                    'jatuh_tempo' => 'required|integer',
                    'status' => 'required'
                );

                /** set error message */
                $errorMessages = [
                    'kode.required'   => 'Terjadi kesalahan pada kode rekening',
                    'nama.required'   => 'Terjadi kesalahan pada nama pendapatan',
                    'nama.min'        => 'Minimal nama pendapatan adalah 3 karakter huruf',
                    'nama.max'        => 'Maksimal nama pendapatan adalah 150 karakter huruf',
                    'akun_subrekening.required' =>  'Anda belum memilih rekening utama',
                    'akun_rekening.required'    =>  'Anda belum memilih kode rekening',
                    'jatuh_tempo.required'         =>  'Anda belum mengisi jatuh tempo',
                    'akun_denda_rekening.required' =>  'Anda belum memilih rekening pendapatan denda',
                ];

                /* merger array for typeReport  */
                if(request('jenisPajak') == 2)
                {
                    $rules = array_merge($rules, ['metode_hitung' => 'required|not_in:0']);
                    $errorMessages = array_merge($errorMessages, ['jenisPajak.not_in'=>  'Anda belum memilih Metode Hitung']);
                }

                /** create validator */
                $validator = Validator::make(request()->all(), $rules, $errorMessages);

                // Validate the input and return correct response
                if ($validator->fails())
                {
                    return response()->json(array(
                        'success' => false,
                        'validate' => 'validator',
                        'messages' => $validator->getMessageBag()->toArray()
                    ), 422);
                }

                $dataPendapatan = [
                    'company_id'        => request('company_id'),
                    'kategori_pajak_id' => request('kategoriPajak'),
                    'reff_pajak_id'     => request('reffPajak'),
                    'grup_id'           => request('akun_grup'),
                    'kategori_id'       => request('akun_kategori'),
                    'subkategori_id'    => request('akun_subkategori'),
                    'subrekening_id'    => request('akun_subrekening'),
                    'rekening_id'       => request('akun_rekening'),
                    'id'                => (int)request('kode'),
                    'uuid'              => Uuid::generate(4)->string,
                    'kode'              => request('kode'),
                    'kode_akun'         => request('akun_grup').request('akun_kategori').request('akun_subkategori').request('akun_subrekening').request('akun_rekening'),
                    'nama'              => request('nama'),
                    'status'            => request('status')
                ];

                $storePendapatan = $pendapatanRepository->store($dataPendapatan);

                if($storePendapatan) {
                    $storeMedatada = $pendapatanMetadata->create([
                        'company_id'            => request('company_id'),
                        'kategori_pajak_id'     => request('kategoriPajak'),
                        'reff_pajak_id'         => request('reffPajak'),
                        'grup_id'               => request('akun_grup'),
                        'kategori_id'           => request('akun_kategori'),
                        'subkategori_id'        => request('akun_subkategori'),
                        'subrekening_id'        => request('akun_subrekening'),
                        'rekening_id'           => request('akun_rekening'),
                        'id'                    => (int)request('kode'),
                        'reff_jenis_pajak_id'   => request('jenisPajak'),
                        'reff_pelaporan_id'     => request('jenisPelaporan'),
                        'reff_metode_hitung_id' => request('metode_hitung'),
                        'reff_penetapan_pajak_id' => request('jenisPenetapan'),
                        'jatuh_tempo'             => request('jatuh_tempo'),
                        'persentase'              => (is_null(request('persentase'))) ? 0 : request('persentase'),
                        'kode_akun'               => $storePendapatan['kode_akun'],
                        'kode_akun_denda'         => request('akun_denda_grup').request('akun_denda_kategori').request('akun_denda_subkategori').request('akun_denda_subrekening').request('akun_denda_rekening'),
                    ]);

                    return response()->json(array(
                        'success'   => true,
                        'message'   => 'Data berhasil ditambahkan',
                        'data'      => $dataPendapatan
                    ));
                }
            }
        }

        return response()->json(array(
            'success'   => false,
            'messages'  => 'Jenis Pendapatan dengan rekening yang anda pilih telah digunakan, silahkan masukkan data yang lain atau buat rekening baru'
        ), 422);
    }

    /**
     * Show the specified resource.
     * @param string $company_id
     * @param string $uuid
     * 
     * @return Response
     */
    public function update(PendapatanRepository $pendapatanRepository, 
        $company_id, $pajak_id, $ketetapan_id, $grup_id, $kategori_id, 
        $subkategori_id, $subrekening_id, $rekening_id, $pendapatan_id
    )
    {
        /* init flag */
        $flag = false;

        /**
         * jika terjadi perubahan pada data primay key
         * maka set flag menjadi true dan masukkan data ke temporary variabel
         */
        if($rekening_id != request('akun_rekening')) {
            $flag           = true;
            $rekening_idx   = request('akun_rekening');
            $pendapatan_idx = (int)request('kode');
        }

        if($flag)
        {
            /* check pendapatan dengan request data baru rekening dan kode */
            $pendapatan = $pendapatanRepository->getBy(
                $company_id, $pajak_id, $ketetapan_id, $grup_id, $kategori_id, 
                $subkategori_id, $subrekening_id, request('akun_rekening'), (int)request('kode')
            );

            /* data telah tersedia */
            if($pendapatan->count() > 0) {
                return response()->json(array(
                    'success'    => false,
                    'validate'   => 'exist',
                    'messages'   => 'Nomor akun telah tersedia, silahkan gunakan nomor lain'
                ), 422);
            }
        }

        /* set error rules */
        $rules = array(
            'kode' => 'required|max:4', 
            'akun_rekening' => 'required',
            'akun_denda_rekening' => 'required',
            'nama' => 'required|min:3|max:150',
            'jatuh_tempo' => 'required|integer',
            'status' => 'required'
        );

        /* set error message */
        $errorMessages = [
            'kode.required'   => 'Terjadi kesalahan pada kode rekening',
            'nama.required'   => 'Terjadi kesalahan pada nama pendapatan',
            'nama.min'        => 'Minimal nama pendapatan adalah 3 karakter huruf',
            'nama.max'        => 'Maksimal nama pendapatan adalah 150 karakter huruf',
            'akun_rekening.required'       =>  'Anda belum memilih kode rekening',
            'jatuh_tempo.required'         =>  'Anda belum mengisi jatuh tempo',
            'akun_denda_rekening.required' =>  'Anda belum memilih rekening pendapatan denda',
        ];
        
        /* merger array for typeReport  */
        if(request('jenisPajak') == 2)
        {
            $rules = array_merge($rules, ['metode_hitung' => 'required|not_in:1']);
            $errorMessages = array_merge($errorMessages, ['metode_hitung.not_in'=>  'Anda belum memilih Metode Hitung']);
        }

        /* create validator */
        $validator = Validator::make(request()->all(), $rules, $errorMessages);

        // Validate the input and return correct response
        if ($validator->fails())
        {
            return response()->json(array(
                'success' => false,
                'validate' => 'validator',
                'messages' => $validator->getMessageBag()->toArray()
            ), 422);
        }

        /* set primary key */
        $data_akun = $rekening_id;
        $kode_akun = $pendapatan_id;

        if($flag) {
            $data_akun = $rekening_idx;
            $kode_akun = $pendapatan_idx;
        }

        /* data perubahan data */
        $dataPendapatan = [
            'rekening_id'       => request('akun_rekening'),
            'id'                => (int)request('kode'),
            'kode'              => request('kode'),
            'kode_akun'         => $grup_id.$kategori_id.$subkategori_id.$subrekening_id.$data_akun, 
            'nama'              => request('nama'),
            'status'            => request('status')
        ];

        /* update data pendapatan */
        $updatePendapatan = $pendapatanRepository->updated([
            'company_id'    => $company_id,
            'kategori_pajak_id' => $pajak_id,
            'reff_pajak_id' => $ketetapan_id,
            'grup_id'       => $grup_id,
            'kategori_id'   => $kategori_id,
            'subkategori_id'=> $subkategori_id,
            'subrekening_id'=> $subrekening_id,
            'rekening_id'   => $rekening_id,
            'id'            => $pendapatan_id
        ], $dataPendapatan);

        if($updatePendapatan)
        {
            $metadata = new PendapatanMeta;
            /* update metadata pendapatan */
            $updateMetaPendapatan = $metadata->where([
                'company_id'    => $company_id,
                'kategori_pajak_id' => $pajak_id,
                'reff_pajak_id' => $ketetapan_id,
                'grup_id'       => $grup_id,
                'kategori_id'   => $kategori_id,
                'subkategori_id'=> $subkategori_id,
                'subrekening_id'=> $subrekening_id,
                'rekening_id'   => $data_akun,
                'id'            => $kode_akun
            ])->update([
                'reff_jenis_pajak_id'   => request('jenisPajak'),
                'reff_pelaporan_id'     => request('jenisPelaporan'),
                'reff_metode_hitung_id' => request('metode_hitung'),
                'reff_penetapan_pajak_id' => request('jenisPenetapan'),
                'jatuh_tempo'           => request('jatuh_tempo'),
                'persentase'            => (is_null(request('persentase'))) ? 0 : request('persentase'),
                'kode_akun'             => $grup_id.$kategori_id.$subkategori_id.$subrekening_id.$data_akun, 
                'kode_akun_denda'       => request('akun_denda_grup').request('akun_denda_kategori').request('akun_denda_subkategori').request('akun_denda_subrekening').request('akun_denda_rekening'),
            ]);

            if($updateMetaPendapatan) {
                return response()->json(array(
                    'success'   => true,
                    'messages'  => 'data berhasil diperbaharui',
                    'data'      => [
                        'company_id'    => $company_id,
                        'kategori_pajak_id' => $pajak_id,
                        'ketetapan_id' => $ketetapan_id,
                        'grup_id'       => $grup_id,
                        'kategori_id'   => $kategori_id,
                        'subkategori_id'=> $subkategori_id,
                        'subrekening_id'=> $subrekening_id,
                        'rekening_id'   => $data_akun,
                        'id'            => $kode_akun
                    ]
                ), 200);
            }else
            {
                return response()->json([
                    'status'    => false,
                    'messages'  => 'Data tidak ditemukan'
                ], 500);
            }
            
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(PendapatanRepository $pendapatanRepository)
    {
        $validator = Validator::make(request()->all(), ['captcha' => 'required|captcha']);

        if( !$validator->fails() )
        {
            $data = [
                'company_id' => request('company_id'),
                'kategori_pajak_id' => request('kategori_pajak'),
                'reff_pajak_id' => request('ketetapan_id'),
                'grup_id' => request('grup_id'),
                'kategori_id' => request('kategori_id'),
                'subkategori_id' => request('subkategori_id'),
                'subrekening_id' => request('subrekening_id'),
                'rekening_id' =>  request('rekening_id'),
                'id' => request('id')
            ];

            $delete =  $pendapatanRepository->deleteBy($data);
            if($delete)
            {
                return response()->json([
                    'status'    => true,
                    'data'      => $data,
                    'message'   => 'Data rekening barhasil dihapus'
                ], 200);
            }

            return response()->json([
                'status'    => false,
                'message'   => 'Terjadi kesalahan gagal hapus, silahkan hubungi administrator untuk support'
            ], 500);
        }

        return response()->json([
            'status'   => false,
            'message'  => $validator->getMessageBag()->toArray()
        ], 422);
    }
}