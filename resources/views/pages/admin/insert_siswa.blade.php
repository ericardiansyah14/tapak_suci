@extends('layouts.app')
@section('body')
<style>
    table, th {
        border: 1px solid;
    }
</style>
@if (Session::has('error'))
    @include('sweetalert::alert')
@endif
@if(Session::has('success'))
 @include('sweetalert::alert')    
 @php Session::forget('success'); @endphp  
                @endif
<div class="card mt-4 rounded">
    <div class="card-header bg-primary">
        <h4 class="text-white">
            Tabel Data Anggota Tapak Suci
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
                        <th>Nomor induk</th>
                        <th>Nama anggota</th>
                        <th>tempat lahir</th>
                        <th>tanggal lahir</th>
                        <th>alamat</th>
                        <th>telepon/wa</th>
                        <th>Tingkatan</th>
                        <th>Photo</th>
                        <th>cabang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siswa as $item)

                        <tr>
                           <td>{{ $item->id }}</td>
                           <td>{{ $item->nomor_induk }}</td>
                           <td style="text-transform: uppercase;">{{ $item->nama_anggota }}</td>
                           <td style="text-transform: uppercase;">{{ $item->tempat_lahir }}</td>
                           <td>{{ $item->tanggal_lahir }}</td>
                           <td>{{ $item->alamat }}</td>
                           <td>{{ $item->telepon_wa }}</td>
                           <td>{{ $item->tingkatan->nama_tingkatan }}</td>
                           <td><img style="width: 60px; aspect-ratio: 1/1; background-position: center;" src="{{ asset($item->photo) }}" alt=""></td>
                           <td>{{ $item->cabang->nama_cabang }}</td>
                    
                           <td style="">
                            <button style="box-shadow: 0px 3px 4px blue" class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Aksi
                            </button>
                            <div class="dropdown-menu justify-content-center align-items-center flex-column" aria-labelledby="dropdownMenuButton">
                                
                                <form action="{{route('anggota.destroy',['anggota' => $item->nomor_induk])}}" method="post" class="mt-3">
                                    @csrf
                                    @method('DELETE')                 
                                <button style="box-shadow:0px 3px 6px rgb(79, 77, 77); width: 40px;"  class="btn btn-danger justify-content-center align-items-center d-flex btn-sm w-100" onclick="return confirm('APakah Yakin Akan Hapus Data Ini?')">Hapus</button>
                                </form>
                            </div>
                           
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
                <h5 class="modal-title" id="exampleModalLabel">Form Data Keanggotaan Tapak Suci</h5>
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin2.store') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="mb-4">
                        <span class="" style="font-size: 11px;">
                            Note : Field yang berisi <sup><b style="font-size: 13px">(<span class="text-danger">*</span>)</b></sup> Wajib diisi 
                            dan <sup>( jika ada )</sup> Opsional bisa diisi bisa tidak  
                        </span>
                    </div>
                    <input type="hidden" name="id" class="form-control" placeholder="id">
                    <div class="mb-3">
                        <label for="" class="form-label">Nomor Induk Anggota <sup><b style="font-size: 13px">(<span class="text-danger">*</span>)</b></sup></label>
                        <input type="text" name="nia" value="{{ $newKode }}" placeholder="Masukan Nomor induk anggota..." required class="form-control" id="" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Nama Anggota <sup><b style="font-size: 13px">(<span class="text-danger">*</span>)</b></sup></label>
                        <input type="text" style="text-transform: uppercase;" name="nama_anggota" class="form-control" placeholder="Masukan Nama Anggota..." required id="">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Tempat Lahir Anggota <sup><b style="font-size: 13px">(<span class="text-danger">*</span>)</b></sup></label>
                        <input type="text" style="text-transform: uppercase;" name="tempat_lahir" class="form-control" placeholder="Masukan Tempat Lahir Anggota..." required id="">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Tanggal Lahir Anggota <sup><b style="font-size: 13px">(<span class="text-danger">*</span>)</b></sup></label>
                        <input type="date" name="tgl_anggota" class="form-control" placeholder="Masukan Nama Anggota..." required id="">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Alamat Anggota <sup><b style="font-size: 13px">(<span class="text-danger">*</span>)</b></sup></label>
                        <textarea name="alamat" id="" class="form-control" cols="10" rows="10" placeholder="Masukan alamat anggota..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">No Telepon/Wa <sup><b style="font-size: 13px">(<span class="text-danger">*</span>)</b></sup></label>
                        <input type="text" name="wa" class="form-control" placeholder="Masukan Nomor Telepon/Wa..." id="">
                    </div>
                   

                    <div class="mb-3">
                        <label for="" class="form-label">Tingkatan Anggota <sup><b style="font-size: 13px">(<span class="text-danger">*</span>)</b></sup></label>
                        <select name="tingkatan" class="form-select" id="">
                            <option value="">--Pilih Tingkatan Anggota--</option>
                            @foreach ($tingkat as $item)
                                <option value="{{ $item->nomor_tingkatan }}">{{ $item->nama_tingkatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Foto Anggota <sup><b style="font-size: 13px">(<span class="text-danger">* wajib menggunakan seragam tapak suci</span>)</b></sup></label>
                        <input type="file" name="foto" class="form-control" id="">
                    </div>

                 
                     <div class="mb-3">
                        <label for="" class="form-label">Cabang Pelatihan <sup><b style="font-size: 13px">(<span class="text-danger">*</span>)</b></sup></label>
                        <select name="cabang" class="form-select" id="">
                            <option value="">--Pilih Cabang Pelatihan--</option>
                            @foreach ($cabang as $item)
                                <option value="{{ $item->nomor_induk_cabang }}">{{ $item->nama_cabang }}</option>
                            @endforeach
                        </select>
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