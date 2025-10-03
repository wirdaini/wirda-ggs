<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data ['name']      = 'Wirda Aini Maqhfiroh';
        $data ['tgl_lahir'] = '2006-08-15';
        $tahun_lahir = substr($data['tgl_lahir'], 0, 4);
        $data['my_age'] = date('Y') - $tahun_lahir;
        $data ['hobbies'] = ['memasak','menyanyi','bersepeda','berenang','berkuda'];

        $data ['tgl_skrg'] = date('Y-m-d');
        $data ['tgl_harus_wisuda'] = '2028-08-23';
        $wisuda_timestamp = strtotime($data['tgl_harus_wisuda']);
        $sekarang_timestamp = strtotime($data['tgl_skrg']);

        $selisih_detik = $wisuda_timestamp - $sekarang_timestamp;

        $data ['time_to_study_left'] = $selisih_detik / (60 * 60 * 24);
        $data ['current_semester'] = '3';

        if ($data['current_semester'] < 3) {
            $data['current_semester'] = 'Masih Awal, Kejar TAK';
        } else {
            $data['current_semester'] = 'Jangan main-main, kurang-kurangi main game!';
        }
        return view('wisuda', $data );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $param1)
    {
        //return 'Data mahasiswa: ' .$param1;


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

