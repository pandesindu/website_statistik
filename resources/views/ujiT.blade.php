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
                        <th>X2</th>
                        <th>aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ujiT as $t)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $t->x1 }}</td>
                        <td>{{ $t->x2 }}</td>
                        <td>
                            <form action="{{route('ujit.destroy', $t->id)}}" method="POST">
                                @csrf
                                @method('Delete')
                                <a href="{{route('ujit.edit',$t->id)}}"> <button type="button"
                                        class="btn btn-primary btn-sm">
                                        Edit</button></a>
                                <button type="Submit" class="btn btn-danger btn-sm">Delete </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <th>Rata-Rata: </th>
                        <td>{{ number_format($rata2x1, 2) }}</td>
                        <td>{{ number_format($rata2x2, 2) }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Varians:</th>
                        <td>{{ number_format($variansX1, 2) }}</td>
                        <td>{{ number_format($variansX2, 2) }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Standar Deviasi:</th>
                        <td>{{ $sdX1 }}</td>
                        <td>{{ $sdX2 }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Nilai Uji T: </th>
                        <td> {{ $nilaiUjiT }}</td>
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
</div>


@endsection