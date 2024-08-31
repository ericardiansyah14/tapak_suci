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
        <h4 class="text-white">Tabel Data Pendekar Anggota</h4>
    </div>
    <div class="card-body">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin: 8px">Tambah Data Pendekar +</button>
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
                        <th>Aksi</th>
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
                            <td>
                                <form action="{{ route('pendekar.destroy',['pendekar'=>$data->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                <button class="btn btn-danger" onclick="return confirm('APakah Yakin Akan Hapus Data Ini?')"><i class="fa-solid fa-eraser"></i></button>
                            </form>
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
                <h5 class="modal-title" id="exampleModalLabel">Form Tambah Data Pendekar</h5>
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">Data ini menampilkan pendekar besar - pendekar muda</div>
                <form action="{{ route('pendekar.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_anggota" class="form-label">Nama Anggota</label>
                        <select name="nama_anggota" id="nama_anggota" class="form-select" required>
                            <option value="">-- Pilih Nama Anggota --</option>
                            @foreach($anggota as $a)
                                <option value="{{ $a->id }}" data-tingkatan="{{ $a->tingkatan->nama_tingkatan ?? '' }}">{{ $a->nama_anggota }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tingkatan" class="form-label">Tingkatan</label>
                        <input type="text" id="tingkatan" name="tingkatan" class="form-control" value="{{ $anggotasel->tingkatan->nama_tingkatan ?? '' }}" readonly>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
    var namaAnggotaSelect = document.getElementById('nama_anggota');
    
    namaAnggotaSelect.addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var tingkatanInput = document.getElementById('tingkatan');
        
        tingkatanInput.value = selectedOption.getAttribute('data-tingkatan');
    });

    // Mengisi field tingkatan saat halaman dimuat jika ada anggota yang dipilih
    if (namaAnggotaSelect.value) {
        var selectedOption = namaAnggotaSelect.options[namaAnggotaSelect.selectedIndex];
        var tingkatanInput = document.getElementById('tingkatan');
        
        tingkatanInput.value = selectedOption.getAttribute('data-tingkatan');
    }
});

                    </script>
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
