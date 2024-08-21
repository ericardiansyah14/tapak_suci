@extends('layouts.app')

@section('body')
@if(Session::has('success'))
    @include('sweetalert::alert')    
    @php Session::forget('success'); @endphp  
@endif

@if(Session::has('warning'))
    @include('sweetalert::alert')    
    @php Session::forget('warning'); @endphp  
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
                        <th>ID</th>
                        <th>Data Ukt</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($uktpimda as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                <strong>Lokasi UKT:</strong> {{ $item->lokasi_ukt }}<br>
                                <strong>Tanggal UKT:</strong> {{ $item->tanggal_ukt }}<br>
                                <strong>Ketua Panitia:</strong> {{ $item->ketua_panitia }}
                            </td>
                            <td>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#UktPimdaModal{{ $item->id }}">Daftarkan siswa <i class="fa-solid fa-square-plus"></i></button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="UktPimdaModal{{ $item->id }}" tabindex="-1" aria-labelledby="UktPimdaModalLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="UktPimdaModalLabel{{ $item->id }}">Pilih siswa untuk ikut UKT</h5>
                                        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('ukt.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="ukt_pimda_id" value="{{ $item->id }}">
                                            
                                            @foreach ($siswa as $siswaItem)
    @php
        // Periksa apakah siswa ini sudah terdaftar di UKT ini
        $isRegisteredInThisUKT = isset($uktSiswa[$item->id]) && in_array($siswaItem->nomor_induk, $uktSiswa[$item->id]);
    @endphp
    
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="siswa_ids[]" value="{{ $siswaItem->id }}" id="siswa{{ $siswaItem->id }}" 
            @if ($isRegisteredInThisUKT) checked @endif>
        <label class="form-check-label" for="siswa{{ $siswaItem->id }}">
            {{ $siswaItem->nama_anggota }}
            @if ($isRegisteredInThisUKT)
                <span class="text-success">✔️ Terdaftar</span>
            @endif
        </label>
    </div>
@endforeach

                                            <select name="tingkat" class="form-select mt-3">
                                                <option value="">Tingkatan yang akan dituju</option>
                                                @foreach ($tingkat as $i)
                                                    <option value="{{ $i->nomor_tingkatan }}">{{ $i->nama_tingkatan }}</option>
                                                @endforeach
                                            </select>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
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
@endsection
