@extends('layout.v_template')

@section('title', 'Data Tunggal')
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
                <div class="col-6">
                    <form action="{{route('nilai.store')}}" method="POST" enctype="multipart/form-data"
                        class="form-inline">
                        @csrf
                        <div class=" form-group mx-sm-3">
                            <label class="sr-only">Masukan Nilai</label>
                            <input type="number" class="form-control" name="nilai" placeholder="silahkan masukan nilai">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <div class="mx-sm-3 text-danger text-sm">@error ('nilai') {{$message}} @enderror</div>
                    </form>
                </div>

                <div class="col-4">
                    <div class="float-lg-right">
                        <form action="/import" method="POST" enctype="multipart/form-data" class="form-inline">
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
                    <div class="float-left"><a href="/export"> <button type="button" class="btn btn-success">
                                <i class="fa fa-download mx-1" aria-hidden="true"></i> export</button></a></div>
                </div>

            </div>
            <table id="table" class="table table-striped table-bordered my-4">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NILAI </th>
                        <th>AKSI</th>

                    </tr>
                </thead>
                <tbody>
                    <?php $no = 0;?>
                    @foreach($nilai as $data)
                    <?php $no++ ;?>

                    <tr>
                        <td>{{$no}}</td>
                        <td>{{$data->nilai}}</td>
                        <td>
                            <form action="{{route('nilai.destroy', $data->id)}}" method="POST">
                                @csrf
                                @method('Delete')
                                <a href="{{route('nilai.edit',$data->id)}}"> <button type="button"
                                        class="btn btn-primary btn-sm">
                                        Edit</button></a>
                                <button type="Submit" class="btn btn-danger btn-sm">Delete </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            Halaman : {{ $nilai->currentPage() }} <br />
            Data Per Halaman : {{ $nilai->perPage() }} <br>
            <br>
            {{$nilai->links()}}
        </div>
    </div>
</div>

<div class="container">

    <div class="row my-4">
        <div class="col">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0 ">Rata-Rata</h6>
                        </div>
                        <div class="col-sm-2 text-secondary">
                            <?= round($rata, 2); ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Nilai Terkecil</h6>
                        </div>
                        <div class="col-sm-2 text-secondary">
                            {{$min}}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Nilai Terbesar</h6>
                        </div>
                        <div class="col-sm-2 text-secondary">
                            {{$max}}
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col">
            <div class="container">
                <table class="table table-bordered bg-white" width="1">
                    <thead>
                        <tr>
                            <td>NILAI</td>
                            <td>FREKUENSI</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($count as $data)
                        <tr>
                            <td>{{$data->nilai}}</td>
                            <td>{{$data->frek}}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection