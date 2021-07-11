@extends('layout.v_template')

@section('title', 'Uji Anava Satu Jalur')
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
                    <form action="{{route('anava.store')}}" method="POST" enctype="multipart/form-data"
                        class="form-inline">
                        @csrf
                        <div class=" form-group mx-sm-3">
                            <label class="sr-only">Masukan Nilai X1</label>
                            <input type="number" class="form-control @error('x2')  @enderror" name="x1"
                                placeholder="@error('x1') {{$message}} @enderror masukan nilai X1">
                        </div>

                        <div class=" form-group mx-sm-3">
                            <label class="sr-only">Masukan Nilai X2</label>
                            <input type="number" class="form-control @error('x2')  @enderror" name="x2"
                                placeholder="@error('x2') {{$message}} @enderror masukan nilai X2">
                        </div>


                        <div class=" form-group mx-sm-3">
                            <label class="sr-only">Masukan Nilai X3</label>
                            <input type="number" class="form-control @error('x2')  @enderror" name="x3"
                                placeholder="@error('x3') {{$message}} @enderror masukan nilai X3">
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
                            <form action="{{route('anava.destroy',  $anava[$i]->id)}}" method="POST">
                                @csrf
                                @method('Delete')
                                <a href="{{route('anava.edit', $anava[$i]->id)}}"> <button type="button"
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
                            <th>Rata - Rata :</th>
                            <td>{{number_format($avgX1, 2)}}</td>
                            <td></td>
                            <td>{{number_format($avgX2, 2)}}</td>
                            <td></td>
                            <td>{{number_format($avgX3, 2)}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                </tbody>
            </table>


            <div class=" col-12">
                <div class="float-lg-right">
                    <form action="{{route('importAnava')}}" method="POST" enctype="multipart/form-data"
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
                <div class="float-left"><a href="{{route('exportAnava')}}"> <button type="button"
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
                        <td>{{number_format($JKA, 4)}}</td>
                        <td>{{$DKA}}</td>
                        <td>{{number_format($RJKA, 4)}}</td>
                        <td>{{number_format($F, 4)}}</td>
                        <td>{{$fTabel, 4}}</td>
                        <td>{{$status}}</td>
                    </tr>

                    <tr>
                        <th>Dalam :</th>
                        <td>{{number_format($jkd, 4)}}</td>
                        <td>{{$dkd}}</td>
                        <td>{{number_format($rjkd, 4)}}</td>
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
                        <td>{{number_format($jkt, 4)}}</td>
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