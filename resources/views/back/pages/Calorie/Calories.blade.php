@extends('back.layouts.master')
@section('title')
Kaloriler
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-title"></div>
                <div class="card-body">
                    <table id="table_id" class="p-2 table">
                        <thead>
                        <tr>
                            <th scope="col">Besin</th>
                            <th scope="col">Karbonhidrat</th>
                            <th scope="col">Protein</th>
                            <th scope="col">Yağ</th>
                            <th scope="col">Kalori</th>
                            <th scope="col">Miktar</th>
                            <th scope="col">Birim</th>
                            <th scope="col">Min</th>
                            <th scope="col">Max</th>
                            <th scope="col">Öğün</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($calories as $calorie)
                            <tr>
                                <td><b>{{$calorie->food}}</b></td>
                                <td>{{$calorie->carbohydrate}}</td>
                                <td>{{$calorie->protein}}</td>
                                <td>{{$calorie->fat}}</td>
                                <td>{{$calorie->calorie}}</td>
                                <td>{{$calorie->amount}}</td>
                                <td>{{$calorie->unit}}</td>
                                <td>{{$calorie->min}}</td>
                                <td>{{$calorie->max}}</td>
                                <td>@foreach($calorie['meal'] as $arrayValue)
                                        {{ $loop->first ? '' : ' , ' }}
                                        {{ $arrayValue }}
                                    @endforeach</td>
                                <td><a href="{{route('calorie.edit',$calorie->id)}}" class="btn btn-warning btn-sm w-100">Düzenle</a></td>
                                <td>
                                    <form method="post" action="{{route('calorie.delete',$calorie->id)}}">
                                        @csrf
                                        <button class="btn btn-danger btn-sm w-100">Sil</button>
                                    </form></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
