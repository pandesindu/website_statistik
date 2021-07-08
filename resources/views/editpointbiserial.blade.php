@extends('layout.v_template')

@section('title', 'Edit Data')
@section('content')

<div class="col-md-6 my-2 mx-1">
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3">
                    <h6 class="mb-0">Nilai</h6>
                </div>
                <div class="col-sm-4 text-secondary">
                    {{$nilai->nilai}}
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <h6 class="mb-0"> Kategori</h6>
                </div>
                <div class="col-sm-4 text-secondary">
                    {{$nilai->status}}
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{(isset($nilai))?route('pointbiserial.update',$nilai->id): route('pointbiserial.store')}}}" method="POST"
    enctype="multipart/form-data" class="form-inline">
    @csrf
    @if((isset($nilai)))
    @method('PUT')
    @endif
    <div class=" form-group mx-sm-3">
        <label class="sr-only">Masukan Nilai</label>
        <input type="number" class="form-control @error('nilai')  @enderror" name="nilai"
            placeholder="@error('nilai') {{$message}} @enderror masukan nilai" value="{{$nilai->nilai}}">
    </div>

    <select class="form-control @error('Y_besar')  @enderror" name="status" value="{{$nilai->status}}">
        <option selected>pilih status </option>
        <option value="aktif">aktif</option>
        <option value="non aktif">non aktif</option>
    </select>

    <button type="submit" class="btn btn-primary mt-1 mx-3">Simpan</button>
</form>

@endsection