@extends('layout.v_template')

@section('content')

<div class="row justify-content-center w-100">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-0">
                <p class="h3">Tabel Data Bergolong</p>
            </div>
            <div class="card-body">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Rentangan</th>
                            <th>Frekuensi</th>

                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < $kelas; $i++) <tr>
                            <th> {{ $i+1 }} </th>
                            <td> {{ $data[$i] }}</td>
                            <td> {{ $frekuensi[$i] }}</td>
                            </tr>

                            @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection