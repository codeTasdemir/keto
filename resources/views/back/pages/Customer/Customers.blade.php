@extends('back.layouts.master')
@section('title')
Online Diyet Talepleri
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <table id="table_id" class="table">
                            <thead>
                            <tr>
                                <th scope="col">Ad</th>
                                <th scope="col">Soyad</th>
                                <th scope="col">Cinsiyet</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($customers as $customer)
                            <tr>
                                <th>{{$customer->name}}</th>
                                <td>{{$customer->lastName}}</td>
                                <td>{{$customer->gender}}</td>
                                <td><a href="{{route('customer.detail',$customer->slug)}}" class="btn btn-warning">Detayı Görüntüle</a></td>
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
