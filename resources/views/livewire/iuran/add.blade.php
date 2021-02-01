<div class="modal-content">
    <form wire:submit.prevent="save">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> Tambah Iuran</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true close-btn">×</span>
            </button>
        </div>
        <div class="modal-body"> 
            @error('is_validate')
            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
            @enderror
            <div class="form-group">
                <select class="form-control" wire:model="warga_id">
                    <option value=""> --- Warga --- </option>
                    @foreach(\App\Models\Warga::orderBy('nama',"ASC")->get() as $item)
                    <option value="{{$item->id}}">{{$item->nama}} / {{$item->blok_rumah}} / {{$item->nomor}}</option>
                    @endforeach
                </select>
                @error('warga_id')
                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                @enderror
            </div>
            <div class="form-group">
                <select class="form-control" wire:model="bulan">
                    <option value=""> --- Bulan --- </option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
                @error('bulan')
                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                @enderror
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" wire:model="tanggal_pembayaran" plaeholder="Tanggal Pembayaran" onfocus="(this.type='date')" />
                    @error('tanggal_pembayaran')
                    <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <select class="form-control" wire:model="tahun">
                        <option value="">--- Tahun ---</option>
                        @for($t=2020;$t<=(date('Y')+1);$t++){
                        <option>{{$t}}</option>
                        @endfor
                    </select>
                    @error('tahun')
                    <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                    @enderror
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-info close-modal"><i class="fa fa-check"></i> Submit</button>
        </div>
    </form>
</div>
