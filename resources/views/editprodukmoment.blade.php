@extends('layout.v_template')

@section('title', 'Edit Data')
@section('content')

<div class="col-md-6 my-2 mx-1">
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3">
                    <h6 class="mb-0">Nilai X</h6>
                </div>
                <div class="col-sm-4 text-secondary">
                    {{$nilai->X_besar}}
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <h6 class="mb-0"> Nilai Y</h6>
                </div>
                <div class="col-sm-4 text-secondary">
                    {{$nilai->Y_besar}}
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{(isset($nilai))?route('produkmoment.update',$nilai->id): route('produkmoment.store')}}}" method="POST"
    enctype="multipart/form-data" class="form-inline">
    @csrf
    @if((isset($nilai)))
    @method('PUT')
    @endif
    <div class=" form-group mx-sm-3 mb-2">
        <label class="sr-only">Masukan Nilai</label>
        <input type="number" class="form-control" name="X_besar" value="{{$nilai->X_besar}}">
    </div>

    <div class=" form-group mx-sm-3 mb-2">
        <label class="sr-only">Masukan Nilai</label>
        <input type="number" class="form-control" name="Y_besar" value="{{$nilai->Y_besar}}">
    </div>

    <button type="submit" class="btn btn-primary mb-2">Simpan</button>
</form>

@endsection