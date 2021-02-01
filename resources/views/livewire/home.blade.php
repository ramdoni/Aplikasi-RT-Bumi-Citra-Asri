
@section('title', 'Dashboard')
<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#warga">Warga</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#iuran">Iuran</a></li>
                </ul>
                <div class="px-0 tab-content">
                    <div class="tab-pane show active" id="warga">
                        <livewire:warga.index />
                    </div>
                    <div class="tab-pane" id="iuran">
                        <livewire:iuran.index />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
