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
                {!! $chartTotalCabang->container() !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                Jumlah anggota tiap cabang
            </div>
            <div class="card-body">
                {!! $chartCabang->container() !!}
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-warning text-white">
                Pendekar besar
            </div>
            <div class="card-body">
                <h3>{{ $jumlahPendekarbesar }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-warning text-white">
                Pendekar Muda
            </div>
            <div class="card-body">
                <h3>{{ $jumlahPendekarMuda }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-warning text-white">
                Pendekar kepala
            </div>
            <div class="card-body">
                <h3>{{ $jumlahPendekarkepala }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-warning text-white">
                Pendekar utama
            </div>
            <div class="card-body">
                <h3>{{ $jumlahPendekarutama }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-warning text-white">
                Pendekar Madya
            </div>
            <div class="card-body">
                <h3>{{ $jumlahPendekarmadya }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-info text-white">
                Kader Kepala
            </div>
            <div class="card-body">
                <h3>{{ $jumlahKaderkepala }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-info text-white">
                Kader Utama
            </div>
            <div class="card-body">
                <h3>{{ $jumlahKaderutama }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-info text-white">
                Kader Madya
            </div>
            <div class="card-body">
                <h3>{{ $jumlahKadermadya }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-info text-white">
                Kader Muda
            </div>
            <div class="card-body">
                <h3>{{ $jumlahKaderMuda }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-info text-white">
                Kader Dasar
            </div>
            <div class="card-body">
                <h3>{{ $jumlahKaderdsasar }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-success text-white">
                Siswa 4
            </div>
            <div class="card-body">
                <h3>{{ $jumlahsiswa4 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-success text-white">
                Siswa 3
            </div>
            <div class="card-body">
                <h3>{{ $jumlahsiswa3 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-success text-white">
                Siswa 2
            </div>
            <div class="card-body">
                <h3>{{ $jumlahsiswa2 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-success text-white">
               Siswa 1
            </div>
            <div class="card-body">
                <h3>{{ $jumlahsiswa1 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-success text-white">
                Siswa Dasar
            </div>
            <div class="card-body">
                <h3>{{ $jumlahsiswadasar }}</h3>
            </div>
        </div>
    </div>



</div>
<script src="{{ $chartTotalCabang->cdn() }}"></script>
{{ $chartTotalCabang->script() }}

<script src="{{ $chartCabang->cdn() }}"></script>
{{ $chartCabang->script() }}
@endsection