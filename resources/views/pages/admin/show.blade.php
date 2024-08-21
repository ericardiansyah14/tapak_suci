@extends('layouts.app')
@section('body')
@if(Session::has('success'))
    @include('sweetalert::alert')
    @php Session::forget('success'); @endphp
@endif
<div class="card">
    <div class="card-header bg-primary">
        <h4 class="text-white">Tambah Ujian Kenaikan Tingkat</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive mt-3">
            <table id="basic-datatables" class="display table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        
                    </tr>
                </thead>
                <tbody>
                   
                        <tr>
                            
                        </tr>

                        
                   
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection
