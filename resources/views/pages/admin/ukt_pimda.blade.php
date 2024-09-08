@extends('layouts.app')
@section('body')
@if(Session::has('success'))
    @include('sweetalert::alert')
    @php Session::forget('success'); @endphp
@endif
<div class="card">
    <div class="card-header bg-primary">
        <h4 class="text-white" style="text-transform: uppercase;">Tambah Ujian Kenaikan Tingkat</h4>
    </div>
    <div class="card-body">
        <button class="btn btn-primary" data-bs-toggle="modal" style="text-transform: uppercase;" data-bs-target="#UktPimda">Tambah UKT</button>

        <div class="table-responsive mt-3">
            <table id="basic-datatables" class="display table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Lokasi UKT</th>
                        <th>Alamat UKT</th>
                        <th>Tanggal UKT</th>
                        <th>Ketua Panitia</th>
                        <th>Jumlah Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($uktCounts as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td style="text-transform: uppercase;">{{ $item->lokasi_ukt }}</td>
                            <td style="text-transform: uppercase;">{{ $item->alamat_ukt }}</td>
                            <td>{{ $item->tanggal_ukt }}</td>
                            <td style="text-transform: uppercase;">{{ $item->ketua_panitia }}</td>
                            <td>{{ $item->jumlah_data }} 
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewUktModal{{ $item->id }}"><i class="fa-solid fa-eye"></i></button>
                            </td>
                            <td>
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#UktPimdaEdit{{ $item->id }}"><i class="fa-solid fa-pen-to-square"></i></button>
                                <form action="{{ route('uktpimda.destroy',['uktpimda' => $item->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('APakah Yakin Akan Hapus Data Ini?')"><i class="fa-solid fa-eraser"></i></button>
                            </form>
                            </td>
                        </tr>

                        <div class="modal fade" id="UktPimdaEdit{{ $item->id }}" tabindex="-1" aria-labelledby="" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Form Edit UKT</h5>
                                        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('uktpimda.update',['uktpimda' => $item->id]) }}" method="POST">
                                            {{ csrf_field() }}
                                            @method('PUT')
                                            <input type="hidden" name="id" class="form-control" placeholder="id">
                        
                                            <div class="mb-3">
                                                <label for="" class="form-label">Lokasi Pelaksanaan UKT</label>
                                                <input type="text" style="text-transform: uppercase;" name="lokasi" value="{{ $item->lokasi_ukt }}" class="form-control" placeholder="Masukan lokasi pelaksanaan UKT...">
                                            </div>
                        
                                            <div class="mb-3">
                                                <label for="" class="form-label">Alamat Pelaksanaan UKT</label>
                                                <input type="text" style="text-transform: uppercase;" name="alamat" value="{{ $item->alamat_ukt }}" class="form-control" placeholder="Masukan lokasi pelaksanaan UKT...">
                                            </div>
                        
                                            <div class="mb-3">
                                                <label for="" class="form-label">Tanggal pelaksanaan UKT</label>
                                                <input type="date" name="tanggal" value="{{ $item->tanggal_ukt }}" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label for="" class="form-label">Pilih ketua panitia</label>
                                                <select name="panitia" id="" class="form-select">
                                                    <option value="">{{ $item->ketua_panitia }}</option>
                                                    @foreach ($panitia as $item1)
                                                        <option value="{{ $item1->username }}">{{ $item1->username }}</option>
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

                        <!-- Modal untuk menampilkan data UKT -->
                        <div class="modal fade" id="viewUktModal{{ $item->id }}" tabindex="-1" aria-labelledby="viewUktModalLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewUktModalLabel{{ $item->id }}">Data UKT {{ $item->lokasi_ukt }} - {{ $item->tanggal_ukt }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @php
                                            $uktData = \App\Models\Ukt::where('ukt_pimda_id', $item->id)->get();
                                        @endphp

                                        @if($uktData->isEmpty())
                                            <p>Tidak ada data UKT terkait.</p>
                                        @else
                                            @foreach($uktData as $ukt)
                                                <div class="row mb-3">
                                                    <div class="col-4"><strong>NIS:</strong></div>
                                                    <div class="col-8">{{ $ukt->nomor_induk }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-4"><strong>Nama:</strong></div>
                                                    <div class="col-8">{{ $ukt->nama_siswa }}</div>
                                                </div>
                                                 <div class="row mb-3">
                                                    <div class="col-4"><strong>tingkatan saat ini</strong></div>
                                                    <div class="col-8">{{ $ukt->tingkatanSaatIni->tingkatan_saat_ini }}</div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-4"><strong>tingkatan selanjutnya</strong></div>
                                                    <div class="col-8">{{ $ukt->tingkatanSelanjutnya->tingkatan_selanjutnya }}</div>
                                                </div> 
                                                <hr>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="UktPimda" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Tambah UKT</h5>
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('uktpimda.store') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" class="form-control" placeholder="id">

                    <div class="mb-3">
                        <label for="" class="form-label">Lokasi Pelaksanaan UKT</label>
                        <input type="text" style="text-transform: uppercase;" name="lokasi" class="form-control" placeholder="Masukan lokasi pelaksanaan UKT...">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Alamat Pelaksanaan UKT</label>
                        <input type="text" style="text-transform: uppercase;" name="alamat" class="form-control" placeholder="Masukan alamat pelaksanaan UKT...">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Tanggal pelaksanaan UKT</label>
                        <input type="date" name="tanggal" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Pilih ketua panitia</label>
                        <select name="panitia" id="" class="form-select">
                            <option value="">--Pilih panitia UKT--</option>
                            @foreach ($panitia as $item)
                                <option value="{{ $item->username }}">{{ $item->username }}</option>
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
