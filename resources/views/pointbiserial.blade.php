@extends('layout.v_template')

@section('title', 'Korelasi Point Biserial')
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
                    <form action="{{route('pointbiserial.store')}}" method="POST" enctype="multipart/form-data"
                        class="form-inline">
                        @csrf
                        <div class=" form-group mx-sm-3">
                            <label class="sr-only">Masukan Nilai</label>
                            <input type="number" class="form-control @error('nilai')  @enderror" name="nilai"
                                placeholder="@error('nilai') {{$message}} @enderror masukan nilai">
                        </div>

                        <select class="form-control @error('Y_besar')  @enderror" name="status">
                            <option selected>pilih status </option>
                            <option value="aktif">aktif</option>
                            <option value="non aktif">non aktif</option>
                        </select>


                        <button type="submit" class="btn btn-primary mx-4">Simpan</button>
                        <div class="mx-sm-3 text-danger text-sm">@error ('nilai') {{$message}} @enderror</div>
                        <div class="mx-sm-3 text-danger text-sm">@error ('status') {{$message}} @enderror</div>
                    </form>
                </div>

            </div>

            <table id="table" class="table table-striped table-bordered my-4">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Nilai</th>
                        <th>Kategori</th>
                        <th>x - mean</th>
                        <th>x- mean^2</th>
                        <th>aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @for ($i = 0; $i < $N; $i++) <tr>

                        <th>{{ $i+1 }}</th>
                        <td>{{ $nilai[$i]->nilai}}</td>
                        <td>{{ $nilai[$i]->status}}</td>
                        <td>{{ number_format($XminXt[$i], 4)}}</td>
                        <td>{{number_format ($XminXtKuadrat[$i], 4)}}</td>
                        <td>
                            <form action="{{route('pointbiserial.destroy', $nilai[$i]->id)}}" method="POST">
                                @csrf
                                @method('Delete')
                                <a href="{{route('pointbiserial.edit',$nilai[$i]->id)}}"> <button type="button"
                                        class="btn btn-primary btn-sm">
                                        Edit</button></a>
                                <button type="Submit" class="btn btn-danger btn-sm">Delete </button>
                            </form>
                        </td>
                        </tr>
                        @endfor
                </tbody>
                <tfoot>
                    <tr>
                        <th>Rata - Rata :</th>
                        <td>{{number_format($xt, 4)}}</td>
                        <td></td>
                        <td></td>
                        <td>{{number_format($sigma, 4)}}</td>
                    </tr>
                </tfoot>
            </table>



            <div class="col-12">
                <div class="float-lg-right">
                    <form action="{{route('importBiserial')}}" method="POST" enctype="multipart/form-data"
                        class="form-inline">
                        @csrf
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile04" name="file">
                                <label class="custom-file-label" for="inputGroupFile04">Choose file </label>
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
                <div class="float-left"><a href="{{route('exportBiserial')}}"> <button type="button"
                            class="btn btn-success">
                            <i class="fa fa-download mx-1" aria-hidden="true"></i> export</button></a></div>
            </div>

        </div>
    </div>
    <div class="row my-4">
        <div class="col">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0 ">X1 </h6>
                        </div>
                        <div class="col-sm-2 text-secondary">
                            {{number_format($x1, 2)}}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0">X2</h6>
                        </div>
                        <div class="col-sm-2 text-secondary">
                            {{number_format($x2, 2)}}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0">SDt</h6>
                        </div>
                        <div class="col-sm-2 text-secondary">
                            {{number_format($sdt, 4)}}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0">p</h6>
                        </div>
                        <div class="col-sm-2 text-secondary">
                            {{number_format($p, 4)}}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0">q</h6>
                        </div>
                        <div class="col-sm-2 text-secondary">
                            {{number_format($q, 4)}}
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0">rbis</h6>
                        </div>
                        <div class="col-sm-2 text-secondary">
                            {{number_format($rbis, 4)}}
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>



@endsection