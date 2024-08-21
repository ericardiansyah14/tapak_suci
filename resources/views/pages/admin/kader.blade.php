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
        <h4 class="text-white">Tabel Kaderisasi Anggota</h4>
    </div>
    <div class="card-body">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin: 8px">Tambah Data Kaderisasi +</button>
        <hr>
        <div class="table-responsive mt-3">
            <table id="basic-datatables" class="display table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Anggota</th>
                        <th>Cabang</th>
                        <th>Tingkatan</th>
                        <th>Tanggal Ijazah</th>
                        <th>Foto Ijazah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kaderisasi as $data)
                        <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->nama_anggota }}</td>
                            <td>{{ $data->kode_cabang ??'----' }}</td>
                            <td>{{ $data->nomor_tingkatan }}</td>
                            <td>{{ $data->tanggal_ijazah }}</td>
                            <td>
                                    <img style="width: 60px; aspect-ratio: 1/1; background-position: center;" class="img-avatar" src="{{ asset( $data->foto_ijazah) }}" alt="Foto" width="100">
                            </td>
                        </tr>
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
                <h5 class="modal-title" id="exampleModalLabel">Form Tambah Data Kaderisasi</h5>
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('kader.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_anggota" class="form-label">Nama Anggota</label>
                        <select name="nama_anggota" id="nama_anggota" class="form-select" required>
                            <option value="">-- Pilih Nama Anggota --</option>
                            @foreach($anggota as $a)
                                <option value="{{ $a->id }}">{{ $a->nama_anggota }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal Ijazah</label>
                        <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto ijazah</label>
                        <input type="file" id="foto" name="foto" class="form-control" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
