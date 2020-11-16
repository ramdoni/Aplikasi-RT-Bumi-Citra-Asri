<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Warga;
use App\Iuran;
use App\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class WaController extends Controller
{
    public function index()
    {
        $post = Request::post();

        // cek user
        $phone = $post['phone'];
        $phone = str_replace_first('62','0', $phone);
        $phone = str_replace('-', '', $phone);
        $post['message'] = strtolower($post['message']);
        $act = $post['message'];
        $minimal_iuran = 50000;
        $user = User::where('telepon',$phone)->first();
        
        if($user){
            $act = explode(".",$act);
            
            if(isset($act[0]) and $act[0]=='iuran' and count($act) >1){
                // iuran.blokrumah.nominal
                $blok = explode("-",$act[1]);
                $nominal = str_replace('.','',$act[2]);
                $nominal = str_replace('.','',$nominal);

                $warga = Warga::where('blok_rumah',$blok[0])->where('nomor',$blok[1])->first();
                
                if(!$warga){ return "Data warga dengan blok rumah :".$act[1] .' tidak ditemukan.'; }

                // cek nominal harus kelipatan 50.000
                if($nominal < $minimal_iuran){ return "Minimal pembayaran iuran 50.000"; }

                // get terakhir bayar
                $last_month = Iuran::where('tahun',date('Y'))->where('warga_id',$warga->id)->orderBy('bulan','DESC')->first();
                if($last_month){ 
                    $last_month = $last_month->bulan+1;
                }else{
                    $last_month = 1;
                }

                $nominal = floor($nominal / $minimal_iuran);
                
                for($m=$last_month;$m<($nominal+$last_month);$m++){
                    $iuran = new Iuran();
                    $iuran->warga_id = $warga->id;
                    $iuran->bulan = $m;
                    $iuran->tahun = date('Y');
                    $iuran->status =1;
                    $iuran->admin_user_id = $user->id;
                    $iuran->save();

                    $monthName = date("F", mktime(0, 0, 0, $m, 10));
                    
                    $kwitansi = "E/".date('dmy')."/".strtoupper($act[1])."/IU/".$iuran->id;
                    Iuran::where('id',$iuran->id)->update(['kwitansi'=>$kwitansi]);

                    $msg  = "E-Kwitansi  : ".$kwitansi."\n\nTelah diterima dari : ".$warga->jenis_kelamin.". ".$warga->nama." Blok ".strtoupper($act[1])." Iuran Kas RT/RW sebesar ".format_idr($minimal_iuran)." untuk bulan ". $monthName .' pada tanggal '.date('d F Y');
                    $msg .="\n\nTerima kasih atas partisipasinya, iuran dari warga akan digunakan untuk kepentingan warga."; 
                    $msg .= "\n\n_Noted : E-Kwitansi ini adalah bukti transaksi yang sah sebgai alternatif kwitansi secara fisik_";

                    wa(['p'=>$warga->no_telepon,'m'=>$msg]);
                    wa(['p'=>'081284884586','m'=>$msg]);
                }

                return 'Iuran berhasil dibayarkan';
            }
        }
        // cek warga
        $warga = Warga::where('no_telepon',$phone)->first();
        $act = $post['message'];
        
        if($warga){
            if($act=='iuran' || $act=='cekiuran' ){
                $msg = "Iuran Tahun ".date('Y')."\n\n";
                $msg .= "Januari - *". cek_iuran($warga->id,1) ."*\n";
                $msg .= "Februari - *". cek_iuran($warga->id,2) ."*\n";
                $msg .= "Maret - *". cek_iuran($warga->id,3) ."*\n";
                $msg .= "April - *". cek_iuran($warga->id,4) ."*\n";
                $msg .= "Mei - *". cek_iuran($warga->id,5) ."*\n";
                $msg .= "Juni - *". cek_iuran($warga->id,6) ."*\n";
                $msg .= "Juli - *". cek_iuran($warga->id,7) ."*\n";
                $msg .= "Agustus - *". cek_iuran($warga->id,8) ."*\n";
                $msg .= "September - *". cek_iuran($warga->id,9) ."*\n";
                $msg .= "Oktober - *". cek_iuran($warga->id,10) ."*\n";
                $msg .= "November - *". cek_iuran($warga->id,11) ."*\n";
                $msg .= "Desember - *". cek_iuran($warga->id,12) ."*\n";

                return $msg;
            }
        }

        return '';
    }
}