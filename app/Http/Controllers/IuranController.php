<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Warga;
use App\Iuran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class IuranController extends Controller
{
    public function index()
    {
        $data = new \stdClass;

        foreach(Warga::orderBy('nama')->get() as $k => $i){
            $data->$k = new \stdClass(); 
            
            $data->$k->id = $i->id;
            $data->$k->nama = $i->nama;
            $data->$k->januari = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',1)->count();
            $data->$k->februari = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',2)->count();
            $data->$k->maret = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',3)->count();
            $data->$k->april = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',4)->count();
            $data->$k->mei = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',5)->count();
            $data->$k->juni = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',6)->count();
            $data->$k->juli = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',7)->count();
            $data->$k->agustus = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',8)->count();
            $data->$k->september = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',9)->count();
            $data->$k->oktober = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',10)->count();
            $data->$k->november = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',11)->count();
            $data->$k->desember = Iuran::where('warga_id',$i->id)->where('tahun',date('Y'))->where('bulan',12)->count();
        }

        return Inertia::render('Iuran/Index', [
            'filters' => Request::all('search', 'trashed'),
            'iurans' => $data,
        ]);
    }

    public function bayar(){
        $id = Iuran::create(
            Request::validate([
                    'warga_id' => ['required'],
                    'bulan' => ['required'],
                    'tahun' => ['required'],
                ]))->id;

        $warga = Warga::where('id',Request::get('warga_id'))->first();
            
        $monthName = date("F", mktime(0, 0, 0,Request::get('bulan') , 10));
        $minimal_iuran = 50000;

        $kwitansi = "E/".date('dmy')."/".$warga->blok_rumah .'-'. $warga->nomor."/IU/".$id;
        Iuran::where('id',$id)->update(['admin_user_id'=>\Auth::user()->id,'kwitansi'=>$kwitansi]);

        $msg  = "E-Kwitansi  : ".$kwitansi."\n\nTelah diterima dari : Bp. ".$warga->nama." Blok ".$warga->blok_rumah .'-'. $warga->nomor." Iuran Kas RT/RW sebesar ".format_idr($minimal_iuran)." untuk bulan ". $monthName .' pada tanggal '.date('d F Y');
        $msg .="\n\nTerima kasih atas partisipasinya, iuran dari warga akan digunakan untuk kepentingan warga."; 
        $msg .= "\n\n_Noted : E-Kwitansi ini adalah bukti transaksi yang sah sebgai alternatif kwitansi secara fisik_";

        wa(['p'=>$warga->no_telepon,'m'=>$msg]);

        return 200;
        return Redirect::back()->with('success', 'Iuran berhasil dibayarkan.');    
    }
}