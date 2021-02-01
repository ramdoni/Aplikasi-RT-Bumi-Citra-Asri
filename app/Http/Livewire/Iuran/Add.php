<?php

namespace App\Http\Livewire\Iuran;

use Livewire\Component;

class Add extends Component
{
    public $warga_id,$tahun,$bulan,$tanggal_pembayaran,$is_validate=true;
    public function render()
    {
        return view('livewire.iuran.add');
    }
    public function mount()
    {
        $this->tanggal_pembayaran = date('Y-m-d');
    }
    public function save()
    {
        $cek = \App\Models\Iuran::where('warga_id',$this->warga_id)
                                ->where('tahun',$this->tahun)
                                ->where('bulan',$this->bulan)
                                ->first();
        if($cek) $this->is_validate = false;
        $this->validate([
                'warga_id' => 'required',
                'tahun' => 'required',
                'bulan' => 'required',
                'tanggal_pembayaran' => 'required',
                'is_validate' => 'accepted'
            ],
            [
                'is_validate.accepted' => 'Data sudah pernah di input,silahkan pilih bulan atau tahun yang berbeda !'
            ]
        );
        $data = new \App\Models\Iuran();
        $data->warga_id = $this->warga_id;
        $data->tahun = $this->tahun;
        $data->bulan = $this->bulan;
        $data->created_at = $this->tanggal_pembayaran;
        $data->save();

        $id = $data->id;
        $warga = \App\Models\Warga::find($this->warga_id);
            
        $monthName = date("F", mktime(0, 0, 0,$this->bulan , 10));
        $minimal_iuran = 50000;

        $kwitansi = "E/".date('dmy')."/".$warga->blok_rumah .'-'. $warga->nomor."/IU/".$id;
        \App\Models\Iuran::where('id',$id)->update(['admin_user_id'=>\Auth::user()->id,'kwitansi'=>$kwitansi]);

        $msg  = "E-Kwitansi  : ".$kwitansi."\n\nTelah diterima dari : Bp. ".$warga->nama." Blok ".$warga->blok_rumah .'-'. $warga->nomor." Iuran Kas RT/RW sebesar ".format_idr($minimal_iuran)." untuk bulan ". $monthName .' pada tanggal '.date('d F Y');
        $msg .="\n\nTerima kasih atas partisipasinya, iuran dari warga akan digunakan untuk kepentingan warga."; 
        $msg .= "\n\n_Noted : E-Kwitansi ini adalah bukti transaksi yang sah sebgai alternatif kwitansi secara fisik_";
        $this->reset();
        $this->emit('refresh-page');
        //wa(['p'=>$warga->no_telepon,'m'=>$msg]);
        //wa(['p'=>'081284884586','m'=>$msg]);
    }
}
