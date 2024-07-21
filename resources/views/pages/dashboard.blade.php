@extends('layouts.app')
@section('body')
@if(Session::has('success'))
 @include('sweetalert::alert')    
 @php Session::forget('success'); @endphp  
                @endif
<script src="https://code.highcharts.com/highcharts.js"></script>
<div class="row mt-3">
    <!-- Card untuk chart cabang -->
  

    <!-- Card untuk chart anggota -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                Jumlah Anggota
            </div>
            <div class="card-body">
                {!! $chartAnggota->container() !!}
            </div>
        </div>
    </div>


<div class="col-md-6">
    <div class="card">
        <div class="card-header bg-success text-white">
            Jumlah Tinggkatan
        </div>
        <div class="card-body">
            {!! $chartTingkatan->container() !!}
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card">
        <div class="card-header bg-primary text-white">
            Jumlah Cabang
        </div>
        <div class="card-body">
            {!! $chartCabang->container() !!}
        </div>
    </div>
</div>
</div>


<script src="{{ $chartCabang->cdn() }}"></script>
{{ $chartCabang->script() }}

<script src="{{ $chartAnggota->cdn() }}"></script>
{{ $chartAnggota->script() }}
<script src="{{ $chartTingkatan->cdn() }}"></script>
{{ $chartTingkatan->script() }}
@endsection