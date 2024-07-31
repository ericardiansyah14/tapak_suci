@extends('layouts.app')
@section('body')
@if(Session::has('success'))
 @include('sweetalert::alert')    
 @php Session::forget('success'); @endphp  
                @endif
    <div class="card mt-4 rounded">
        <div class="card-header bg-primary">
            <h4>Data Ukt Siswa</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table id="basic-datatables" class="display table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Nomor induk siswa</th>
                            <th>Nama siswa</th>
                            <th>Tingkat saat ini</th>
                            <th>Status kenaikan tingkat</th>
                            <th>Tingkat Selanjutnya</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ukts as $data)
                        <tr>
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->nomor_induk }}</td>
                                <td>{{ $data->nama_siswa }}</td>
                                <td>@if ($data->nama_tingkatan_saat_ini)
                                    {{ $data->nama_tingkatan_saat_ini }}
        </td>
        <td>@if ($data->tingkatan_saat_ini == $data->tingkatan_selanjutnya)
            <span class="badge bg-success ms-2">Tingkat Tercapai</span>
        @else
            <span class="badge bg-warning ms-2">Belum Tercapai</span>
        @endif
    @else
        <span class="badge bg-danger">Tidak Ditemukan</span>
    @endif</td>
                                <td>{{ $data->nama_tingkatan_selanjutnya }}</td>
                                <td>
                                    <form action="{{ route('ukt.destroy',['ukt'=>$data->id]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin membatlkan ukt siswa ini?')">Batlkan</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>    
        </div>
    </div>
@endsection