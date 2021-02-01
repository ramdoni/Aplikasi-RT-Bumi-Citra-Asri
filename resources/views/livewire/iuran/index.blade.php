<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="header row">
                <div class="col-md-1 px-0">
                    <select class="form-control" wire:model="tahun">
                        <option value="">--- Tahun ---</option>
                        @for($t=2020;$t<=(date('Y')+1);$t++){
                        <option>{{$t}}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" wire:model="keyword" placeholder="Searching..." />
                </div>
                <div class="col-md-2 px-0">
                    <a href="javascript:;" wire:click="downloadExcel" class="btn btn-primary"><i class="fa fa-download"></i> Dowload</a>
                    <a href="javascript:;" data-toggle="modal" data-target="#modal_add_iuran" class="btn btn-warning"><i class="fa fa-plus"></i> Iuran</a>
                </div>
            </div>
            <div class="body pt-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover m-b-0 c_list">
                        <thead>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jan</th>
                            <th>Feb</th>
                            <th>Mar</th>
                            <th>Apr</th>
                            <th>Mei</th>
                            <th>Juni</th>
                            <th>Juli</th>
                            <th>Ags</th>
                            <th>Sep</th>
                            <th>Okt</th>
                            <th>Nov</th>
                            <th>Des</th>
                        </thead>
                        <tbody>
                        @foreach($data as $key => $item)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item['nama']}} / {{$item['blok_rumah']}} / {{$item['nomor']}}</td>
                                <td>
                                    @if($item['januari']==1)
                                        <span class="text-success"><i class="fa fa-check"></i></span>
                                    @else
                                        <a href="javascript:;" wire:click="$emit('confirm-bayar-iuran',{'bulan':'Januari', 'month':1, 'id' : {{$item['id']}}} )" class="text-danger"><i class="fa fa-times"></i></a>
                                    @endif
                                </td>
                                <td>
                                    @if($item['februari']==1)
                                        <span class="text-success"><i class="fa fa-check"></i></span>
                                    @else
                                        <a href="javascript:;" wire:click="$emit('confirm-bayar-iuran',{'bulan':'Februari', 'month':2, 'id' : {{$item['id']}}} )" class="text-danger"><i class="fa fa-times"></i></a>
                                    @endif
                                </td>
                                <td>
                                    @if($item['maret']==1)
                                        <span class="text-success"><i class="fa fa-check"></i></span>
                                    @else
                                        <a href="javascript:;" wire:click="$emit('confirm-bayar-iuran',{'bulan':'Maret', 'month':3, 'id' : {{$item['id']}}} )" class="text-danger"><i class="fa fa-times"></i></a>
                                    @endif
                                </td>
                                <td>
                                    @if($item['april']==1)
                                        <span class="text-success"><i class="fa fa-check"></i></span>
                                    @else
                                        <a href="javascript:;" wire:click="$emit('confirm-bayar-iuran',{'bulan':'April', 'month':4, 'id' : {{$item['id']}}} )" class="text-danger"><i class="fa fa-times"></i></a>
                                    @endif
                                </td>
                                <td>
                                    @if($item['mei']==1)
                                        <span class="text-success"><i class="fa fa-check"></i></span>
                                    @else
                                        <a href="javascript:;" wire:click="$emit('confirm-bayar-iuran',{'bulan':'Mei', 'month':5, 'id' : {{$item['id']}}} )" class="text-danger"><i class="fa fa-times"></i></a>
                                    @endif
                                </td>
                                <td>
                                    @if($item['juni']==1)
                                        <span class="text-success"><i class="fa fa-check"></i></span>
                                    @else
                                        <a href="javascript:;" wire:click="$emit('confirm-bayar-iuran',{'bulan':'Juni', 'month':6, 'id' : {{$item['id']}}} )" class="text-danger"><i class="fa fa-times"></i></a>
                                    @endif
                                </td>
                                <td>
                                    @if($item['juli']==1)
                                        <span class="text-success"><i class="fa fa-check"></i></span>
                                    @else 
                                        <a href="javascript:;" wire:click="$emit('confirm-bayar-iuran',{'bulan':'Juli', 'month':7, 'id' : {{$item['id']}}} )" class="text-danger"><i class="fa fa-times"></i></a>
                                    @endif
                                </td>
                                <td>
                                    @if($item['agustus']==1)
                                        <span class="text-success"><i class="fa fa-check"></i></span>
                                    @else 
                                        <a href="javascript:;" wire:click="$emit('confirm-bayar-iuran',{'bulan':'Agustus', 'month':8, 'id' : {{$item['id']}}} )" class="text-danger"><i class="fa fa-times"></i></a>
                                    @endif
                                </td>
                                <td>
                                    @if($item['september']==1)
                                        <span class="text-success"><i class="fa fa-check"></i></span>
                                    @else 
                                        <a href="javascript:;" wire:click="$emit('confirm-bayar-iuran',{'bulan':'September', 'month':9, 'id' : {{$item['id']}}} )" class="text-danger"><i class="fa fa-times"></i></a>
                                    @endif
                                </td>
                                <td>
                                    @if($item['oktober']==1)
                                        <span class="text-success"><i class="fa fa-check"></i></span>
                                    @else 
                                        <a href="javascript:;" wire:click="$emit('confirm-bayar-iuran',{'bulan':'Oktober', 'month':10, 'id' : {{$item['id']}}} )" class="text-danger"><i class="fa fa-times"></i></a>
                                    @endif
                                </td>
                                <td>
                                    @if($item['november']==1)
                                        <span class="text-success"><i class="fa fa-check"></i></span>
                                    @else 
                                        <a href="javascript:;" wire:click="$emit('confirm-bayar-iuran',{'bulan':'November', 'month':11, 'id' : {{$item['id']}}} )" class="text-danger"><i class="fa fa-times"></i></a>
                                    @endif
                                </td>
                                <td>
                                    @if($item['desember']==1)
                                        <span class="text-success"><i class="fa fa-check"></i></span>
                                    @else
                                        <a href="javascript:;" wire:click="$emit('confirm-bayar-iuran',{'bulan':'Desember', 'month':12, 'id' : {{$item['id']}}} )" class="text-danger"><i class="fa fa-times"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_add_iuran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <livewire:iuran.add />
    </div>
</div>
@push('after-scripts')
<script>
    Livewire.on('refresh-page',()=>{
        $("#modal_add_iuran").modal('hide');
    });
    Livewire.on('confirm-bayar-iuran',(data)=>{
        if(confirm('Apakah kamu ingin membayara iuran untuk bulan '+ data.bulan + " ? ")){
            Livewire.emit('submit-bayar-iuran', data);
        }
    });
</script>
@endpush