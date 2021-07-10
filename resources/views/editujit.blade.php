@extends('layout.v_template')

@section('title', 'Edit Data')
@section('content')

<div class="col-md-6 my-2 mx-1">
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3">
                    <h6 class="mb-0">X1</h6>
                </div>
                <div class="col-sm-4 text-secondary">
                    {{$nilai->x1}}
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <h6 class="mb-0"> X2</h6>
                </div>
                <div class="col-sm-4 text-secondary">
                    {{$nilai->x2}}
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{(isset($nilai))?route('ujit.update',$nilai->id): route('ujit.store')}}}" method="POST"
    enctype="multipart/form-data" class="form-inline">
    @csrf
    @if((isset($nilai)))
    @method('PUT')
    @endif
    <div class=" form-group mx-sm-3">
        <label class="sr-only">Masukan Nilai</label>
        <input type="number" class="form-control @error('x1')  @enderror" name="x1"
            placeholder="@error('x1') {{$message}} @enderror masukan nilai" value="{{$nilai->x1}}">
    </div>

    <div class=" form-group mx-sm-3">
        <label class="sr-only">Masukan Nilai</label>
        <input type="number" class="form-control @error('x2')  @enderror" name="x2"
            placeholder="@error('x2') {{$message}} @enderror masukan nilai" value="{{$nilai->x2}}">
    </div>


    <button type="submit" class="btn btn-primary mt-1 mx-3">Simpan</button>
</form>

@endsection