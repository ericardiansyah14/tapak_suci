@extends('layouts.app')
@section('body')
@if(Session::has('success'))
 @include('sweetalert::alert')    
 @php Session::forget('success'); @endphp  
                @endif
<div class="d-flex justify-content-center align-items-center">
    <div class="card shadow mt-4" style="width: 98%;">
        <div class="card-header bg-primary">
            <h4 class="text-white" style="text-transform: uppercase">Profil Pelatih tapak suci</h4>
        </div>
        <div class="card-body d-flex justify-content-center align-items-center flex-column">
                   <img src="{{ $pelatih->photo }}" style="width: 140px; aspect-ratio:1/1;  background-position: center; background-size: cover; border: 2px solid; border-radius: 5px;" alt="">
                  <div class="alert alert-info mt-3" style="height: 40px; display: flex; justify-content: center; align-items: center; width: 100%;"><h4 style="font-size: 15px; text-transform: uppercase; font-weight: bold; font-family: verdana; margin-top: 5px;">Nama : {{ $pelatih->nama_anggota }}</h4></div>
                  <div class="alert alert-primary" style="height: 40px; display: flex; justify-content: center; align-items: center; width: 100%;"> <h4 style="font-size: 15px; text-transform: uppercase; font-weight: bold; font-family: verdana; margin-top: 5px;">Alamat : {{ $pelatih->alamat }}</h4></div>
                    <div class="alert alert-success" style="height: 40px; display: flex; justify-content: center; align-items: center; width: 100%;"><h4 style="font-size: 15px; text-transform: uppercase; font-weight: bold; font-family: verdana; margin-top: 5px;">Tempat Lahir : {{ $pelatih->tempat_lahir }}</h4></div>
                        <div class="alert alert-warning" style="height: 40px; display: flex; justify-content: center; align-items: center; width: 100%;"><h4 style="font-size: 15px; text-transform: uppercase; font-weight: bold; font-family: verdana; margin-top; 5px;">Tanggal Lahir : {{ $pelatih->tanggal_lahir }}</h4></div>
        </div>
    </div>
</div>
@endsection