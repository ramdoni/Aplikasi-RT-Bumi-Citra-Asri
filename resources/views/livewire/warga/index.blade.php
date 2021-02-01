<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="header row">
                <div class="col-md-1 px-0">
                    <select class="form-control" wire:model="blok_rumah">
                        <option value="">--- Blok ---</option>
                        @foreach(\App\Models\Warga::groupBy('blok_rumah')->get() as $i)
                        <option>{{$i->blok_rumah}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" wire:model="keyword" placeholder="Searching..." />
                </div>
                <div class="col-md-2">
                    <a href="javascript:;" data-toggle="modal" data-target="#modal_upload" class="btn btn-warning"><i class="fa fa-upload"></i> Upload</a>
                </div>
            </div>
            <div class="body pt-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover m-b-0 c_list">
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Blok</th>                                    
                                <th rowspan="2">No Rumah</th>                                    
                                <th rowspan="2">NIK</th>                                    
                                <th rowspan="2">Nama</th>                                    
                                <th rowspan="2">No HP</th>
                                <th rowspan="2">No KK</th>
                                <th rowspan="2">Status Rumah</th>
                                <th rowspan="2">Status Tinggal</th>
                                <th rowspan="2">Tanggal Menempati</th>
                                <th rowspan="2">No SKWB</th>
                                <th rowspan="2">Jenis Kelamin</th>
                                <th rowspan="2">Status Perkawinan</th>
                                <th rowspan="2">Agama</th>
                                <th rowspan="2">Tempat Lahir</th>
                                <th rowspan="2">Tanggal Lahir</th>
                                <th colspan="4" class="text-center" style="background: #eee;">Alamat (Sesuai KTP)</th>
                                <th colspan="6" class="text-center" style="background: rgb(238, 200, 200);">Pasangan</th>
                                <th colspan="5" class="text-center" style="background: rgb(192, 228, 159);">Anak (1)</th>
                                <th colspan="5" class="text-center" style="background: rgb(240, 174, 240);">Anak (2)</th>
                                <th colspan="5" class="text-center" style="background: rgb(226, 144, 144);">Anak (3)</th>
                                <th colspan="5" class="text-center" style="background: rgb(224, 236, 152);">Anak (4)</th>
                                <th colspan="5" class="text-center" style="background: rgb(191, 224, 130);">Anak (5)</th>
                                <th colspan="6" class="text-center" style="background: rgb(167, 210, 238);">Lainnya (1)</th>
                                <th colspan="6" class="text-center" style="background: rgb(240, 152, 232);">Lainnya (2)</th>
                            </tr>
                            <tr>
                                <th><div style="width:250px">Jalan, Blok Rumah / Nomor RT/RW</div></th>
                                <th>Kelurahan</th>
                                <th>Kecamatan</th>
                                <th>Kota/Kabupaten</th>
                                <th>Hubungan</th>
                                <th>Nama</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th>NIK</th>
                                <th>No HP</th>
                                <th>Nama</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th><div style="width:80px;">NIK / KIA</div></th>
                                <th>Jenis Kelamin</th>
                                <th>Nama</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th><div style="width:80px;">NIK / KIA</div></th>
                                <th>Jenis Kelamin</th>
                                <th>Nama</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th><div style="width:80px;">NIK / KIA</div></th>
                                <th>Jenis Kelamin</th>
                                <th>Nama</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th><div style="width:80px;">NIK / KIA</div></th>
                                <th>Jenis Kelamin</th>
                                <th>Nama</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th><div style="width:80px;">NIK / KIA</div></th>
                                <th>Jenis Kelamin</th>
                                <th>Nama</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th><div style="width:80px;">NIK / KIA</div></th>
                                <th>No HP</th>
                                <th>Jenis Kelamin</th>
                                <th>Nama</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th><div style="width:80px;">NIK / KIA</div></th>
                                <th>No HP</th>
                                <th>Jenis Kelamin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $k => $item)
                            <tr>
                                <td style="width: 50px;">{{$k+1}}</td>
                                <td>{{$item->blok_rumah}}</td> 
                                <td>{{$item->nomor}}</td> 
                                <td>{{$item->nik}}</td> 
                                <td>{{$item->nama}}</td> 
                                <td>{{$item->no_telepon}}</td>                                   
                                <td>{{$item->no_kk}}</td>
                                <td>{{$item->status_rumah}}</td>
                                <td>{{$item->status_tinggal}}</td>
                                <td>{{$item->tanggal_menetap}}</td>
                                <td>{{$item->no_skwb}}</td>
                                <td>{{$item->jenis_kelamin}}</td>
                                <td>{{$item->status_perkawinan}}</td>
                                <td>{{$item->agama}}</td>
                                <td>{{$item->tempat_lahir}}</td>
                                <td>
                                    @if(!empty($item->tanggal_lahir) and $item->tanggal_lahir != '1970-01-01')
                                    {{$item->tanggal_lahir}} ({{umur($item->tanggal_lahir)}}thn)
                                    @endif
                                </td>
                                <td>{{$item->jalan_blok}}</td>
                                <td>{{$item->kelurahan_id}}</td>
                                <td>{{$item->kecamatan_id}}</td>
                                <td>{{$item->kota_kabupaten}}</td>
                                <td>{{$item->pasangan_hubungan}}</td>
                                <td>{{$item->pasangan_nama}}</td>
                                <td>{{$item->pasangan_tempat_lahir}}</td>
                                <td>{{$item->pasangan_tanggal_lahir}}</td>
                                <td>{{$item->pasangan_nik}}</td>
                                <td>{{$item->pasangan_no_hp}}</td>
                                <td>{{$item->anak_1_nama}}</td>
                                <td>{{$item->anak_1_tempat_lahir}}</td>
                                <td>{{$item->anak_1_tanggal_lahir}}</td>
                                <td>{{$item->anak_1_nik_kia}}</td>
                                <td>{{$item->anak_1_jenis_kelamin}}</td>
                                <td>{{$item->anak_2_nama}}</td>
                                <td>{{$item->anak_2_tempat_lahir}}</td>
                                <td>{{$item->anak_2_tanggal_lahir}}</td>
                                <td>{{$item->anak_2_nik_kia}}</td>
                                <td>{{$item->anak_2_jenis_kelamin}}</td>
                                <td>{{$item->anak_3_nama}}</td>
                                <td>{{$item->anak_3_tempat_lahir}}</td>
                                <td>{{$item->anak_3_tanggal_lahir}}</td>
                                <td>{{$item->anak_3_nik_kia}}</td>
                                <td>{{$item->anak_3_jenis_kelamin}}</td>
                                <td>{{$item->anak_4_nama}}</td>
                                <td>{{$item->anak_4_tempat_lahir}}</td>
                                <td>{{$item->anak_4_tanggal_lahir}}</td>
                                <td>{{$item->anak_4_nik_kia}}</td>
                                <td>{{$item->anak_4_jenis_kelamin}}</td>
                                <td>{{$item->anak_5_nama}}</td>
                                <td>{{$item->anak_5_tempat_lahir}}</td>
                                <td>{{$item->anak_5_tanggal_lahir}}</td>
                                <td>{{$item->anak_5_nik_kia}}</td>
                                <td>{{$item->anak_5_jenis_kelamin}}</td>
                                <td>{{$item->lain_1_nama}}</td>
                                <td>{{$item->lain_1_tempat_lahir}}</td>
                                <td>{{$item->lain_1_tanggal_lahir}}</td>
                                <td>{{$item->lain_1_nik_kia}}</td>
                                <td>{{$item->lain_1_no_hp}}</td>
                                <td>{{$item->lain_1_jenis_kelamin}}</td>
                                <td>{{$item->lain_2_nama}}</td>
                                <td>{{$item->lain_2_tempat_lahir}}</td>
                                <td>{{$item->lain_2_tanggal_lahir}}</td>
                                <td>{{$item->lain_2_nik_kia}}</td>
                                <td>{{$item->lain_2_no_hp}}</td>
                                <td>{{$item->lain_2_jenis_kelamin}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <br />
                {{$data->links()}}
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <livewire:warga.upload />
    </div>
</div>