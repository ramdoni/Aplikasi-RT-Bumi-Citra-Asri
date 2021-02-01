<?php

namespace App\Http\Livewire\Warga;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $keyword,$blok_rumah;
    public function render()
    {
        $data = \App\Models\Warga::orderBy('nama','asc');
        if($this->blok_rumah) $data = $data->where('blok_rumah',$this->blok_rumah);
        if($this->keyword) $data = $data->where(function($table){
                                                $table->where('nomor','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('nik','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('nama','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('no_telepon','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('no_kk','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('status_rumah','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('status_tinggal','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('tanggal_menetap','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('no_skwb','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('jenis_kelamin','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('status_perkawinan','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('agama','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('tempat_lahir','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('tanggal_lahir','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('jalan_blok','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('kelurahan_id','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('kecamatan_id','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('kota_kabupaten','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('pasangan_hubungan','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('pasangan_nama','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('pasangan_tempat_lahir','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('pasangan_tanggal_lahir','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('pasangan_nik','LIKE',"%{$this->keyword}%")
                                                      ->orWhere('pasangan_no_hp','LIKE',"%{$this->keyword}%")
                                                      ;
                                                });
        return view('livewire.warga.index')->with(['data'=>$data->paginate(100)]);
    }
}
