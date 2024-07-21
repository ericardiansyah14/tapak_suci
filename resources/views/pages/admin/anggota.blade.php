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
            Tabel Data Cabang
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
                        <th>Nomor induk cabang</th>
                        <th>Nama cabang</th>
                        <th>Alamat Cabang</th>
                        <th>Pelatih Cabang</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cabang as $data)
                        <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->nomor_induk_cabang }}</td>
                            <td>{{ $data->nama_cabang }}</td>
                            <td>{{ $data->alamat_cabang }}</td>
                            <td>{{ $data->pelatih_cabang }}</td>
                            <td>
                                <button style="box-shadow: 0px 3px 4px blue" class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Aksi
                                </button>
                                <div class="dropdown-menu justify-content-center align-items-center flex-column" aria-labelledby="dropdownMenuButton">
                                    <button class="btn btn-warning btn-sm w-100" data-bs-toggle="modal" data-bs-target="#editModal{{ $data->nomor_induk_cabang }}">Edit</button>
                                    <form action="{{route('cabang.destroy',['cabang' => $data->nomor_induk_cabang])}}" method="post" class="mt-3">
                                        @csrf
                                        @method('DELETE')                 
                                    <button style="box-shadow:0px 3px 6px rgb(79, 77, 77); width: 40px;"  class="btn btn-danger justify-content-center align-items-center d-flex btn-sm w-100" onclick="return confirm('APakah Yakin Akan Hapus Data Ini?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="editModal{{ $data->nomor_induk_cabang }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Form Edit Cabang</h5>
                                        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('cabang.update',['cabang' => $data->nomor_induk_cabang]) }}" method="POST">
                                            @method('PUT')
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" class="form-control" placeholder="id">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Nomor Induk Cabang</label>
                                                <input type="text" name="nic" placeholder="" value="{{ $data->nomor_induk_cabang }}" required class="form-control" id="" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="" class="form-label">Nama Cabang</label>
                                                <input type="text" name="nama_cabang" class="form-control" value="{{ $data->nama_cabang }}" placeholder="Masukan Nama Cabang...." required id="">
                                            </div>
                                            <div class="mb-3">
                                                <label for="" class="form-label">Alamat Cabang</label>
                                                <input type="text" name="alamat" class="form-control" value="{{ $data->alamat_cabang }}" placeholder="Masukan Alamat Cabang..." required id="">
                                            </div>
                                            <div class="mb-3">
                                                <label for="" class="form-label">Pelatih Cabang</label>
                                                <input type="text" name="pelatih" value="{{ $data->pelatih_cabang }}" class="form-control" placeholder="Masukan Pelatih Cabang...." required id="">
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
                <h5 class="modal-title" id="exampleModalLabel">Form Tamu</h5>
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('cabang.store') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" class="form-control" placeholder="id">
                    <div class="mb-3">
                        <label for="" class="form-label">Nomor Induk Cabang</label>
                        <input type="text" name="nic" value="{{ $newKode }}" placeholder="" required class="form-control" id="">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Nama Cabang</label>
                        <input type="text" name="nama_cabang" class="form-control" placeholder="Masukan Nama Cabang...." required id="">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Alamat Cabang</label>
                        <input type="text" name="alamat" class="form-control" placeholder="Masukan Alamat Cabang..." required id="">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Pelatih Cabang</label>
                        <input type="text" name="pelatih" class="form-control" placeholder="Masukan Pelatih Cabang...." required id="">
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
