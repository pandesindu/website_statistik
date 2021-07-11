@extends('layout.v_template')

@section('title', 'Chi-Kuadrat')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-15">
        <div class="card">
            <div class="card-body">
                <table class="table table-responsive text-xs">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Rentangan</th>
                            <th>f0</th>
                            <th>Batas Kelas Bawah</th>
                            <th>Batas Kelas Atas</th>
                            <th>Batas Bawah Z</th>
                            <th>Batas Atas Z</th>
                            <th>Nilai Z Bawah</th>
                            <th>Nilai Z Atas</th>
                            <th>L/Proporsi</th>
                            <th>(fe) L*N </th>
                            <th>(f0-fe)^2/fe</th>

                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < $kelas; $i++) <tr>
                            <th> {{ $i }} </th>
                            <td> {{ $data[$i] }}</td>
                            <td> {{ $frekuensi[$i] }}</td>
                            <td> {{ $batasBawahBaru[$i] }}</td>
                            <td> {{ $batasAtasBaru[$i] }}</td>
                            <td> {{ $zBawah[$i] }}</td>
                            <td> {{ $zAtas[$i] }}</td>
                            <td> {{ $zTabelBawahFix[$i] }}</td>
                            <td> {{ $zTabelAtasFix[$i] }}</td>
                            <td> {{ $lprop[$i] }}</td>
                            <td> {{ $fe[$i] }}</td>
                            <td> {{ number_format($kai[$i], 4) }}</td>
                            </tr>

                            @endfor
                            <tr>
                                <th> Total: </th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>{{ number_format($totalchi, 4) }}</th>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection