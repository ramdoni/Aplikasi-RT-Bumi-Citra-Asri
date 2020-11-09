<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Warga;
use App\WargaKeluarga;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class WargaController extends Controller
{
    public function index()
    {
        return Inertia::render('Warga/Index', [
            'filters' => Request::all('search', 'block'),
            'blocks' => Warga::groupBy('blok_rumah')->get()->map->only('blok_rumah'),
            'warga' => Warga::orderBy('id','DESC')
                ->filter(Request::only('search', 'block'))
                ->paginate(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Warga/Create');
    }

    public function store()
    {
        Request::validate([
            'nama' => ['required'],
            'jenis_kelamin' => ['nullable'],
            'no_telepon' => ['required'],
            'nik' => ['nullable'],
            //'no_kk' => ['nullable'],
            'blok_rumah' => ['required'],
            'nomor' => ['required'],
        ]);
        $r = Request::post();

        $id = Warga::create(
            [
                'nama' => strtoupper($r['nama']),
                'no_telepon' => $r['no_telepon'],
                'nik' => $r['nik'],
                'blok_rumah' => strtoupper($r['blok_rumah']),
                'nomor' => $r['nomor'],
                'jenis_kelamin' => $r['jenis_kelamin'],
                'status_rumah' => $r['status_rumah'],
                'status_tinggal' => $r['status_tinggal']
            ]
        )->id;

        if(isset($r['keluarga_hubungan'])){
            foreach($r['keluarga_hubungan'] as $k =>$i){
                $keluarga = WargaKeluarga::create([
                    'warga_id'=>$id,
                    'hubungan'=> $r['keluarga_hubungan'][$k],
                    'nama'=> $r['keluarga_nama'][$k],
                    'jenis_kelamin'=>$r['keluarga_jenis_kelamin'][$k]
                ]);
            }
        }

        return Redirect::route('warga')->with('success', 'Warga berhasil ditambahkan.');
    }

    public function edit(Warga $warga)
    {
        return Inertia::render('Warga/Edit', [
            'warga' => [
                'id' => $warga->id,
                'nama' => $warga->nama,
                'no_telepon' => $warga->no_telepon,
                'nik' => $warga->nik,
                'blok_rumah' => $warga->blok_rumah,
                'nomor' => $warga->nomor,
                'keluarga'=>$warga->keluarga,
                'jenis_kelamin'=>$warga->jenis_kelamin,
                'status_tinggal'=>$warga->status_tinggal,
                'status_rumah'=>$warga->status_rumah
            ],
        ]);
    }

    public function update(Warga $warga)
    {
        Request::validate([
            'nama' => ['required'],
            'no_telepon' => ['required'],
            'jenis_kelamin' => ['nullable'],
            'nik' => ['nullable'],
            'blok_rumah' => ['required'],
            'nomor' => ['required'],
        ]);
        $r = Request::post();

        $warga->update(
            [
                'nama' => strtoupper($r['nama']),
                'no_telepon' => $r['no_telepon'],
                'jenis_kelamin' => $r['jenis_kelamin'],
                'nik' => $r['nik'],
                'blok_rumah' => strtoupper($r['blok_rumah']),
                'nomor' => $r['nomor'],
                'status_rumah' => $r['status_rumah'],
                'status_tinggal' => $r['status_tinggal']
            ]
        );

        if(isset($r['keluarga_hubungan'])){
            foreach($r['keluarga_hubungan'] as $k =>$i){
                $keluarga = WargaKeluarga::create([
                    'warga_id'=>$warga->id,
                    'hubungan'=> $r['keluarga_hubungan'][$k],
                    'nama'=> $r['keluarga_nama'][$k],
                    'jenis_kelamin'=>$r['keluarga_jenis_kelamin'][$k]
                ]);
            }
        }

        return Redirect::route('warga')->with('success', 'Warga berhasil diubah.');
    }

    public function destroy(Warga $warga)
    {
        $warga->delete();

        return Redirect::back()->with('success', 'Warga deleted.');
    }

    public function restore(Warga $warga)
    {
        $warga->restore();

        return Redirect::back()->with('success', 'Warga restored.');
    }
}
