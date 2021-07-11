@extends('layout.v_template')

@section('title', 'Liliefors')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card bg-light">
            <div class="card-body">
                <table class="table text-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Yi</th>
                            <th>Frekuensi</th>
                            <th>Fkum</th>
                            <th>Zi</th>
                            <th>F(Zi)</th>
                            <th>S(Zi)</th>
                            <th>|F(Zi)-S(Zi)|</th>

                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < $banyakData; $i++) <tr>
                            <th> {{ $i+1 }}</th>
                            <td> {{ $frekuensi[0][$i]->nilai}}</td>
                            <td> {{ $frekuensi[0][$i]->frekuensi}}</td>
                            <td> {{ $fkum2[$i] }}</td>
                            <td> {{ $Zi[$i] }}</td>
                            <td> {{ $fZi[$i] }}</td>
                            <td> {{ number_format($sZi[$i], 4) }}</td>
                            <td> {{ number_format($lilliefors[$i], 4) }}</td>
                            </tr>
                            @endfor
                            <tr class="text-bold">
                                <td>Total:</td>
                                <td></td>
                                <td>{{ $n }}</td>
                                <td>{{ $n }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td> {{ number_format($totalLillie, 4) }}</td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection