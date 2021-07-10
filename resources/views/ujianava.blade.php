@extends('layout.v_template')

@section('title', 'Liliefors')
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
                    <form action="{{route('ujit.store')}}" method="POST" enctype="multipart/form-data"
                        class="form-inline">
                        @csrf
                        <div class=" form-group mx-sm-3">
                            <label class="sr-only">Masukan Nilai X</label>
                            <input type="number" class="form-control @error('x2')  @enderror" name="x1"
                                placeholder="@error('x1') {{$message}} @enderror masukan nilai X1">
                        </div>

                        <div class=" form-group mx-sm-3">
                            <label class="sr-only">Masukan Nilai Y</label>
                            <input type="number" class="form-control @error('x2')  @enderror" name="x2"
                                placeholder="@error('x1') {{$message}} @enderror masukan nilai X2">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <div class="mx-sm-3 text-danger text-sm">@error ('x1') {{$message}} @enderror</div>
                        <div class="mx-sm-3 text-danger text-sm">@error ('x2') {{$message}} @enderror</div>
                    </form>
                </div>

            </div>

            <table id="table" class="table table-striped table-bordered my-4">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>X1</th>
                        <th>X1^2</th>
                        <th>X2</th>
                        <th>X2^2</th>
                        <th>X3</th>
                        <th>X3^2</th>
                        <th>Xt</th>
                        <th>Xt^2</th>
                        <th>aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < $jumlahData; $i++) <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $anava[$i]->x1}}</td>
                        <td>{{$x1kuadrat[$i]}}</td>
                        <td>{{ $anava[$i]->x2}}</td>
                        <td>{{$x2kuadrat[$i]}}</td>
                        <td>{{ $anava[$i]->x3}}</td>
                        <td>{{$x3kuadrat[$i]}}</td>
                        <td>{{$xtotal[$i]}}</td>
                        <td>{{$xtotalkuadrat[$i]}}</td>
                        <td>
                            <form action="{{route('ujit.destroy',  $anava[$i]->id)}}" method="POST">
                                @csrf
                                @method('Delete')
                                <a href="{{route('ujit.edit', $anava[$i]->id)}}"> <button type="button"
                                        class="btn btn-primary btn-sm">
                                        Edit</button></a>
                                <button type="Submit" class="btn btn-danger btn-sm">Delete </button>
                            </form>
                        </td>
                        </tr>
                        @endfor
                        <tr>
                            <th></th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <th>sigma :</th>
                            <td>{{$sumX1}}</td>
                            <td>{{$sigmaX1kuadrat}}</td>
                            <td>{{$sumX2}}</td>
                            <td>{{$sigmaX2kuadrat}}</td>
                            <td>{{$sumX3}}</td>
                            <td>{{$sigmaX3kuadrat}}</td>
                            <td>{{$sumxtotal}}</td>
                            <td>{{$sumxtotalkuadrat}}</td>
                        </tr>

                        <tr>
                            <th>mean :</th>
                            <td>{{$avgX1}}</td>
                            <td></td>
                            <td>{{$avgX2}}</td>
                            <td></td>
                            <td>{{$avgX3}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                </tbody>
            </table>


            <div class=" col-12">
                <div class="float-lg-right">
                    <form action="{{route('importnilai')}}" method="POST" enctype="multipart/form-data"
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
                <div class="float-left"><a href="{{route('exportnilai')}}"> <button type="button"
                            class="btn btn-success">
                            <i class="fa fa-download mx-1" aria-hidden="true"></i> export</button></a></div>
            </div>

        </div>
    </div>

    <div class="card mt-5">
        <div class="card-body">
            <table id="table" class="table table-striped table-bordered my-4">

                <thead>
                    <tr>
                        <th>Sumber Variasi</th>
                        <th>JK</th>
                        <th>DK</th>
                        <th>RJK</th>
                        <th>F</th>
                        <th>Ftabel</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Antar :</th>
                        <td>{{$JKA}}</td>
                        <td>{{$DKA}}</td>
                        <td>{{$RJKA}}</td>
                        <td>{{$F}}</td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <th>Dalam :</th>
                        <td>{{$jkd}}</td>
                        <td>{{$dkd}}</td>
                        <td>{{$rjkd}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <th></th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <th>Total :</th>
                        <td>{{$jkt}}</td>
                        <td>{{$dkt}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                </tbody>
            </table>

        </div>
    </div>
</div>


@endsection