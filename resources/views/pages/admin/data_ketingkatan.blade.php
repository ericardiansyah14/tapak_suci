@extends('layouts.app')
@section('body')
<style>
    table, th {
        border: 1px solid;
    }
</style>
@if(Session::has('success'))
 @include('sweetalert::alert')    
 @php Session::forget('success'); @endphp  
                @endif
<div class="card mt-4 rounded">
    <div class="card-header bg-primary">
        <h4 class="text-white">
            Tabel Data Ketingkatan
        </h4>
    </div>
    <div class="card-body">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin: 8px">Tambah Data Cabang +</button>
        <hr>
        <div class="table-responsive mt-3">
            <table id="basic-datatables" class="display table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nomor Ketingkatan</th>
                        <th>Nama Ketingkatan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tingkatan as $data)
                        <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->nomor_tingkatan }}</td>
                            <td>{{ $data->nama_tingkatan }}</td>
                            <td>
                                <button style="box-shadow: 0px 3px 4px blue" class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Aksi
                                </button>
                                <div class="dropdown-menu justify-content-center align-items-center" aria-labelledby="dropdownMenuButton">
                                    <button class="btn btn-warning btn-sm" style="width: 100%;" data-bs-toggle="modal" data-bs-target="#ediTingkatan{{ $data->nomor_tingkatan }}">Edit</button>
                                    <form action="{{route('tingkatan.destroy',['tingkatan' => $data->nomor_tingkatan])}}" method="post" class="mt-3">
                                        @csrf
                                        @method('DELETE')                 
                                    <button style="box-shadow:0px 3px 6px rgb(79, 77, 77); width: 40px;"  class="btn btn-danger justify-content-center align-items-center d-flex btn-sm w-100" onclick="return confirm('APakah Yakin Akan Hapus Data Ini?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                       
                        <div class="modal fade" id="ediTingkatan{{ $data->nomor_tingkatan }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Form Edit Data Ketingkatan</h5>
                                        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('tingkatan.update',['tingkatan' => $data->nomor_tingkatan]) }}" method="POST">
                                            @method('PUT')
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" class="form-control" placeholder="id">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Nomor Ketingkatan</label>
                                                <input type="text" name="nik" value="{{ $data->nomor_tingkatan }}" placeholder="" readonly required class="form-control" id="">
                                            </div>
                                            <div class="mb-3">
                                                <label for="" class="form-label">Nama Ketingkatan</label>
                                                <input type="text" name="nama_ketingkatan" value="{{ $data->nama_tingkatan }}" class="form-control" placeholder="Masukan Nama ketingkatan...." required id="">
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="simpan" class="btn btn-primary">Update</button>
                                    </div>
                                        </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Data Ketingkatan</h5>
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tingkatan.store') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" class="form-control" placeholder="id">
                    <div class="mb-3">
                        <label for="" class="form-label">Nomor Ketingkatan</label>
                        <input type="text" name="nik" value="{{ $newKode }}" placeholder="" required class="form-control" id="">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Nama Ketingkatan</label>
                        <input type="text" name="nama_ketingkatan" class="form-control" placeholder="Masukan Nama ketingkatan...." required id="">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
            </div>
                </form>
        </div>
    </div>
</div>

@endsection