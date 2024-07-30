@extends('layouts.app')
@section('body')
@if(Session::has('success'))
 @include('sweetalert::alert')    
 @php Session::forget('success'); @endphp  
                @endif
    <div class="card shadow mt-4">
        <div class="card-header bg-info">
            <h3 class="text-white" style="font-family: Genova;">Data Prestasi</h3>
        </div>
        <div class="card-body">
            <button class="btn btn-primary shadow" data-bs-toggle="modal" data-bs-target="#PrestasiModal">Add Prestasi +</button>
            <hr>
            <div class="table-responsive mt-3">
                <table id="basic-datatables" class="display table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Nama Event</th>
                            <th>Skala Event</th>
                            <th>Tanggal Event</th>
                            <th>Prestasi Yang Diraih</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prestasi as $data)
                            <tr>
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->nama_event }}</td>
                                <td>{{ $data->skala_event }}</td>
                                <td>{{ $data->tanggal_event }}</td>
                                <td>{{ $data->prestasi_yang_diraih }}</td>
                                <td>
                                    <button style="box-shadow: 0px 3px 4px blue" class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <div class="dropdown-menu justify-content-center align-items-center flex-column" aria-labelledby="dropdownMenuButton">
                                        <button class="btn btn-warning btn-sm w-100" data-bs-toggle="modal" data-bs-target="#editPrestasiModal{{ $data->id }}">Edit</button>
                                        <form action="{{ route('prestasi.destroy',['prestasi'=>$data->id]) }}" method="post" class="mt-3">
                                            @csrf
                                            @method('DELETE')                 
                                        <button style="box-shadow:0px 3px 6px rgb(79, 77, 77); width: 40px;"  class="btn btn-danger justify-content-center align-items-center d-flex btn-sm w-100" onclick="return confirm('APakah Yakin Akan Hapus Data Ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="editPrestasiModal{{ $data->id }}" tabindex="-1" aria-labelledby="UktModal" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Form Tambah data prestasi</h5>
                                            <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('prestasi.update',['prestasi'=>$data->id]) }}" method="POST">
                                                @method('PUT')
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" class="form-control" placeholder="id">
                                                <div class="mb-3">
                                                    <label for="" class="form-label">Nama Event</label>
                                                    <input type="text" name="nama" value="{{ $data->nama_event }}" required class="form-control" id="" placeholder="masukan nama event yang diikuti">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label">Skala Event</label>
                                                    <select name="skala" id="" class="form-select">
                                                        <option value="internasional">internasional</option>
                                                        <option value="nasional">nasional</option>
                                                        <option value="provinsi">provinsi</option>
                                                        <option value="kota">kota</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label">Tanggal Event</label>
                                                    <input type="date" name="tanggal" value="{{ $data->tanggal_event }}" class="form-control" required id="">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="form-label">Prestasi Yang di raih</label>
                                                    <textarea name="prestasi" id="" cols="30" rows="10" class="form-control" placeholder="Masukan prestasi yang telah diraih..">{{ $data->prestasi_yang_diraih }}</textarea>
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

           
            <div class="modal fade" id="PrestasiModal" tabindex="-1" aria-labelledby="UktModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Form Tambah data prestasi</h5>
                            <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('prestasi.store') }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" class="form-control" placeholder="id">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama Event</label>
                                    <input type="text" name="nama" value="" required class="form-control" id="" placeholder="masukan nama event yang diikuti">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Skala Event</label>
                                    <select name="skala" id="" class="form-select">
                                        <option value="">--skala events--</option>
                                        <option value="internasional">internasional</option>
                                        <option value="nasional">nasional</option>
                                        <option value="provinsi">provinsi</option>
                                        <option value="kota">kota</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal Event</label>
                                    <input type="date" name="tanggal" value="" class="form-control" required id="">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Prestasi Yang di raih</label>
                                    <textarea name="prestasi" id="" cols="30" rows="10" class="form-control" placeholder="Masukan prestasi yang telah diraih.."></textarea>
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
        </div>
    </div>
@endsection