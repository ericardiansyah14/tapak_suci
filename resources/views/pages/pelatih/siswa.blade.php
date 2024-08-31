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
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin: 8px">Tambah Data Siswa +</button>
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
                        
                        <div class="modal fade" id="editAnggota{{ $item->nomor_induk }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Form Edit Data Keanggotaan Tapak Suci</h5>
                                        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('pelatih.update',['siswa'=>$item->nomor_induk]) }}" method="POST" enctype="multipart/form-data">
                                            @method('PUT')
                                            {{ csrf_field() }}
                                        
                                            <div class="mb-4">
                                                <span class="" style="font-size: 11px;">
                                                    Note : Field yang berisi <sup><b style="font-size: 13px">(<span class="text-danger">*</span>)</b></sup> Wajib diisi 
                                                    dan <sup>( jika ada )</sup> Opsional bisa diisi bisa tidak  
                                                </span>
                                            </div>
                                            <input type="hidden" name="id" class="form-control" placeholder="id">
    <div class="mb-3">
        <label for="nia" class="form-label">Nomor Induk Anggota <sup><b style="font-size: 13px">(<span class="text-danger">*</span>)</b></sup></label>
        <input type="number" name="nia" value="{{ $item->nomor_induk }}" placeholder="Masukan Nomor induk anggota..." required class="form-control" id="nia">
    </div>
    <div class="mb-3">
        <label for="nama_anggota" class="form-label">Nama Anggota <sup><b style="font-size: 13px">(<span class="text-danger">*</span>)</b></sup></label>
        <input type="text" name="nama_anggota" value="{{ $item->nama_anggota }}" class="form-control" placeholder="Masukan Nama Anggota..." required id="nama_anggota">
    </div>
    <div class="mb-3">
        <label for="tempat_lahir" class="form-label">Tempat Lahir Anggota <sup><b style="font-size: 13px">(<span class="text-danger">*</span>)</b></sup></label>
        <input type="text" name="tempat_lahir" value="{{ $item->tempat_lahir }}" class="form-control" placeholder="Masukan Tempat Lahir Anggota..." required id="tempat_lahir">
    </div>
    <div class="mb-3">
        <label for="tgl_anggota" class="form-label">Tanggal Lahir Anggota <sup><b style="font-size: 13px">(<span class="text-danger">*</span>)</b></sup></label>
        <input type="date" name="tgl_anggota" value="{{ $item->tanggal_lahir }}" class="form-control" placeholder="Masukan Tanggal Lahir Anggota..." required id="tgl_anggota">
    </div>
    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat Anggota <sup><b style="font-size: 13px">(<span class="text-danger">*</span>)</b></sup></label>
        <textarea name="alamat" id="alamat" class="form-control" cols="10" rows="10" placeholder="Masukan alamat anggota...">{{ $item->alamat }}</textarea>
    </div>
    <div class="mb-3">
        <label for="wa" class="form-label">No Telepon/Wa <sup><b style="font-size: 13px">(<span class="text-danger">*</span>)</b></sup></label>
        <input type="text" name="wa" class="form-control" value="{{ $item->telepon_wa }}" placeholder="Masukan Nomor Telepon/Wa..." id="wa">
    </div>
    <div class="mb-3">
        <label for="tingkatan" class="form-label">Tingkatan Anggota <sup><b style="font-size: 13px">(<span class="text-danger">*</span>)</b></sup></label>
        <select name="tingkatan" class="form-select" id="tingkatan">
            <option value="">--Pilih Tingkatan Anggota--</option>
            @foreach ($tingkat as $item1)
                <option value="{{ $item1->nomor_tingkatan }}" {{ $item->kode_angkatan == $item1->nomor_tingkatan ? 'selected' : '' }}>{{ $item1->nama_tingkatan }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="tgl_ijazah" class="form-label">Tanggal Ijazah Tingkatan <sup><b style="font-size: 13px">(<span class="text-danger">*</span>)</b></sup></label>
        <input type="date" name="tgl_ijazah" value="{{ $item->tangga_ijazah_tingkatan }}" class="form-control" placeholder="Masukan Tanggal Ijazah..." required id="tgl_ijazah">
    </div>
    <div class="mb-3">
        <label for="prestasi" class="form-label">Prestasi yang di raih Anggota <sup>(Jika Ada)</sup></label>
        <textarea name="prestasi" id="prestasi" class="form-control" cols="10" rows="10" placeholder="Masukan prestasi yang di raih anggota...">{{ $item->prestasi_yang_diraih }}</textarea>
    </div>
    <div class="mb-3">
        <label for="foto" class="form-label">Foto Anggota <sup><b style="font-size: 13px">(<span class="text-danger">*Wajib menggunakan seragam tapak suci</span>)</b></sup></label>
        <input type="file" name="foto" class="form-control" id="foto">
    </div>
    <div class="mb-3">
        <label for="pengalaman" class="form-label">Pengalaman di organisasi tapak suci <sup>( jika ada )</sup></label>
        <textarea name="pengalaman" id="pengalaman" class="form-control" cols="10" rows="10" placeholder="Masukan pengalaman anggota di organisasi tapak suci...">{{ $item->pengalaman_organisasi_tapak_suci }}</textarea>
    </div>
    
    <div class="mb-3">
        <label for="cabang" class="form-label">Cabang Pelatihan <sup><b style="font-size: 13px">(<span class="text-danger">*</span>)</b></sup></label>
        <select name="cabang" class="form-select" id="cabang">
            <option value="">--Pilih Cabang Pelatihan--</option>
            @foreach ($cabang as $item2)
                <option value="{{ $item2->nomor_induk_cabang }}" {{ $item->kode_cabang == $item2->nomor_induk_cabang ? 'selected' : '' }}>{{ $item2->nama_cabang }}</option>
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
                        <div class="modal fade" id="alertModal{{ $item->nomor_induk }}" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="alertModalLabel">Alert</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Siswa ini belum terdaftar di UKT. Mohon daftarkan siswa terlebih dahulu.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            function handleUpdate(nomorInduk, uktNic) {
                                if (uktNic) {
                                    var modalId = '#editAnggota' + nomorInduk;
                                    var modal = new bootstrap.Modal(document.querySelector(modalId));
                                    modal.show();
                                } else {
                                    var alertModalId = '#alertModal' + nomorInduk;
                                    var alertModal = new bootstrap.Modal(document.querySelector(alertModalId));
                                    alertModal.show();
                                }
                            }
                            </script>
                         <div class="modal fade" id="UktModal{{ $item->nomor_induk }}" tabindex="-1" aria-labelledby="UktModal{{ $item->nomor_induk }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Form Tambah Ukt</h5>
                                        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('ukt.store') }}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="id" class="form-control" placeholder="id">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Nomor Induk Siswa</label>
                                                <input type="text" name="nic" value="{{ $item->nomor_induk }}" placeholder="" required class="form-control" id="" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="" class="form-label">Nama siswa</label>
                                                <input type="text" name="nama_siswa" value="{{ $item->nama_anggota }}" class="form-control" placeholder="Masukan Nama Cabang...." required id="" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nama_tingkatan" class="form-label">Tingkat saat ini</label>
    <span class="form-control">{{ $item->tingkatan->nama_tingkatan }}</span>
    <input 
        type="hidden" 
        name="saat_ini" 
        value="{{ $item->tingkatan->nomor_tingkatan }}"
    >
                                            </div>
                                            <div class="mb-3">
                                                <label for="" class="form-label">Tingkat Selanjutnya</label>
                                                <select name="selanjutnya" class="form-select" id="">
                                                    <option value="">--Tingkatan Selanjutnya--</option>
                                                    @foreach ($tingkat as $item)
                                                        <option value="{{ $item->nomor_tingkatan }}">{{ $item->nama_tingkatan }}</option>
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
                <form action="{{ route('pelatih.store') }}" method="POST" enctype="multipart/form-data">
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