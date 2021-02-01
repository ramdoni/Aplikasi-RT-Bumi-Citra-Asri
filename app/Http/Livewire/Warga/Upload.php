<?php

namespace App\Http\Livewire\Warga;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
class Upload extends Component
{
    use WithFileUploads;
    public $file;
    public function render()
    {
        return view('livewire.warga.upload');
    }

    public function save()
    {
        $this->validate([
            'file'=>'required|mimes:xls,xlsx|max:51200' // 50MB maksimal
        ]);
        
        $path = $this->file->getRealPath();
       
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $data = $reader->load($path);
        $sheetData = $data->getActiveSheet()->toArray();
        
        if(count($sheetData) > 0){
            $countLimit = 1;
            foreach($sheetData as $key => $i){
                if($key<5) continue; // skip header
                
                foreach($i as $k=>$a){$i[$k] = trim($a);}
                $blok_rumah = $i[1];
                $nomor = $i[2];
                if(empty($i[4])) continue;
                $warga = \App\Models\Warga::where(['blok_rumah'=>$blok_rumah,'nomor'=>$nomor])->first();
                if(!$warga) $warga = new \App\Models\Warga();
                $warga->blok_rumah = $blok_rumah;
                $warga->nomor = $nomor;
                $warga->nik = $i[3];
                $warga->nama = $i[4];
                $warga->no_telepon = $i[5];
                $warga->no_kk = $i[6];
                $warga->status_rumah = $i[7];
                $warga->status_tinggal = $i[8];
                if($i[9]) $warga->tanggal_menetap = date('Y-m-d',strtotime($i[9]));;
                $warga->no_skwb = $i[10];
                $warga->jenis_kelamin = $i[11];
                $warga->status_perkawinan = $i[12];
                $warga->agama = $i[13];
                $warga->tempat_lahir = $i[14];
                if($i[15]) $warga->tanggal_lahir = date('Y-m-d',strtotime($i[15]));;
                $warga->jalan_blok = $i[16];
                $warga->kelurahan_id = $i[17];
                $warga->kecamatan_id = $i[18];
                $warga->kota_kabupaten = $i[19];
                $warga->pasangan_hubungan = $i[20];
                $warga->pasangan_nama = $i[21];
                $warga->pasangan_tempat_lahir = $i[22];
                if($i[23]) $warga->pasangan_tanggal_lahir = date('Y-m-d',strtotime($i[23]));
                $warga->pasangan_nik = $i[24];
                $warga->pasangan_no_hp = $i[25];
                $warga->anak_1_nama = $i[26];
                $warga->anak_1_tempat_lahir = $i[27];
                if($i[28]) $warga->anak_1_tanggal_lahir = date('Y-m-d',strtotime($i[28]));
                $warga->anak_1_nik_kia = $i[29];
                $warga->anak_1_jenis_kelamin = $i[30];
                $warga->anak_2_nama = $i[31];
                $warga->anak_2_tempat_lahir = $i[32];
                if($i[33]) $warga->anak_2_tanggal_lahir = date('Y-m-d',strtotime($i[33]));
                $warga->anak_2_nik_kia = $i[34];
                $warga->anak_2_jenis_kelamin = $i[35];
                $warga->anak_3_nama = $i[36];
                $warga->anak_3_tempat_lahir = $i[37];
                $warga->anak_3_nik_kia = $i[38];
                if($i[39]) $warga->anak_3_tanggal_lahir = date('Y-m-d',strtotime($i[39]));
                $warga->anak_3_jenis_kelamin = $i[40];
                $warga->anak_4_nama = $i[41];
                $warga->anak_4_tempat_lahir = $i[42];
                if($i[43]) $warga->anak_4_tanggal_lahir = date('Y-m-d',strtotime($i[43]));
                $warga->anak_4_nik_kia = $i[44];
                $warga->anak_4_jenis_kelamin = $i[45];
                $warga->anak_5_nama = $i[46];
                $warga->anak_5_tempat_lahir = $i[47];
                if($i[48]) $warga->anak_5_tanggal_lahir = date('Y-m-d',strtotime($i[48]));
                $warga->anak_5_nik_kia = $i[49];
                $warga->anak_5_jenis_kelamin = $i[50];
                $warga->lain_1_nama = $i[51];
                $warga->lain_1_tempat_lahir = $i[52];
                if($i[53]) $warga->lain_1_tanggal_lahir = date('Y-m-d',strtotime($i[53]));
                $warga->lain_1_nik_kia = $i[54];
                $warga->lain_1_no_hp = $i[55];
                $warga->lain_1_jenis_kelamin = $i[56];
                $warga->lain_2_nama = $i[57];
                $warga->lain_2_tempat_lahir = $i[58];
                if($i[59]) $warga->lain_2_tanggal_lahir = date('Y-m-d',strtotime($i[59]));
                $warga->lain_2_nik_kia = $i[60];
                $warga->lain_2_no_hp = $i[61];
                $warga->lain_2_jenis_kelamin = $i[62];
                $warga->save();
                
            }
        }
        session()->flash('message-success','Upload success !');   
        return redirect('/');
    }
}
