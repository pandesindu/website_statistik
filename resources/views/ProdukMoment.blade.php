@extends('layout.v_template')

@section('title', 'Korelasi Produk Moment')
@section('content')

@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif

@if ($message = Session::get('updated'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif

@if ($message = Session::get('deleted'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif


<div class="container">
    <div class="card mt-5">
        <div class="card-body">

            <div class="row">
                <div class="col-12">
                    <form action="{{route('produkmoment.store')}}" method="POST" enctype="multipart/form-data"
                        class="form-inline">
                        @csrf
                        <div class=" form-group mx-sm-3">
                            <label class="sr-only">Masukan Nilai X</label>
                            <input type="number" class="form-control @error('X_besar')  @enderror" name="X_besar"
                                placeholder="@error('X_besar') {{$message}} @enderror masukan nilai X">
                        </div>

                        <div class=" form-group mx-sm-3">
                            <label class="sr-only">Masukan Nilai Y</label>
                            <input type="number" class="form-control @error('Y_besar')  @enderror" name="Y_besar"
                                placeholder="@error('Y_besar') {{$message}} @enderror masukan nilai Y">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <div class="mx-sm-3 text-danger text-sm">@error ('X_besar') {{$message}} @enderror</div>
                        <div class="mx-sm-3 text-danger text-sm">@error ('Y_besar') {{$message}} @enderror</div>
                    </form>
                </div>

            </div>

            <table id="table" class="table table-striped table-bordered my-4">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>X</th>
                        <th>Y</th>
                        <th>x</th>
                        <th>y</th>
                        <th>x^2</th>
                        <th>y^2</th>
                        <th>xy</th>
                        <th>aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < $jumlahData; $i++) <tr>
                        <th>{{ $i+1 }}</th>
                        <td>{{ $moments[$i]->X_besar}}</td>
                        <td>{{ $moments[$i]->Y_besar}}</td>
                        <td>{{ $xKecil[$i] }}</td>
                        <td>{{ $yKecil[$i] }}</td>
                        <td>{{ number_format($xKuadrat[$i], 4) }}</td>
                        <td>{{ number_format($yKuadrat[$i], 4) }}</td>
                        <td>{{ number_format($xKaliY[$i], 4) }}</td>
                        <td>
                            <form action="{{route('produkmoment.destroy', $moments[$i]->id)}}" method="POST">
                                @csrf
                                @method('Delete')
                                <a href="{{route('produkmoment.edit',$moments[$i]->id)}}"> <button type="button"
                                        class="btn btn-primary btn-sm">
                                        Edit</button></a>
                                <button type="Submit" class="btn btn-danger btn-sm">Delete </button>
                            </form>
                        </td>
                        </tr>
                        @endfor
                        <tr>
                            <th> Jumlah: </th>
                            <th> {{ $sumX }}</th>
                            <th> {{ $sumY}} </th>
                            <th></th>
                            <th></th>
                            <th> {{ $sumXKuadrat }}</th>
                            <th> {{ $sumYKuadrat }}</th>
                            <th> {{ $sumXY }}</th>
                        </tr>
                        <tr>
                            <th>Rata-Rata: </th>
                            <th> {{ number_format($rata2X,2) }}</th>
                            <th> {{ number_format($rata2Y,2) }}</th>
                        </tr>
                </tbody>
            </table>

            <table class="table text-left mt-1">
                <tr>
                    <td> <b>Produk Moment : </b> &nbsp {{ number_format($korelasimoment, 4) }} </td>
                </tr>
            </table>
            <div class=" col-12">
                <div class="float-lg-right">
                    <form action="{{route('importMoment')}}" method="POST" enctype="multipart/form-data"
                        class="form-inline">
                        @csrf
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile04" name="file">
                                <label class="custom-file-label" for="inputGroupFile04">Choose file
                                </label>
                            </div>

                            <div class="input-group-append">
                                <button class="btn btn-success" type="submit"><i class="fa fa-upload mr-1"
                                        aria-hidden="true"></i>Import</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

            <div class="col-2">
                <div class="float-left"><a href="{{route('exportMoment')}}"> <button type="button"
                            class="btn btn-success">
                            <i class="fa fa-download mx-1" aria-hidden="true"></i> export</button></a></div>
            </div>

        </div>
    </div>
</div>





@endsection