@extends('back.layouts.master')
@section('title')
Müşteri Detayı
@endsection
@section('content')
<div class="container-fluid">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-success card-outline">
                        <div class="card-body box-profile">
                            <h3 class="profile-username text-start"></h3>
                            <div class="card">
                                <div class="card-header h5">Kişisel Bilgiler</div>
                                <div class="card-body">
                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Ad Soyad :</b> <a class="float-right">{{$customer->name . " " . $customer->lastName}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Yaş :</b> <a class="float-right">{{$customer->age}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Kilo :</b> <a class="float-right">{{$customer->weight . " Kg"}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Boy :</b> <a class="float-right">{{number_format($customer->height,2) . " Cm"}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Cinsiyet :</b> <a class="float-right">{{$customer->gender}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                                <div class="card">
                                    <div class="card-header h5">Vücut Bilgileri</div>
                                    <div class="card-body">
                                        <form action="{{route('customer.CreateDietList',$customer->slug)}}">
                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>BMI :</b> <a class="float-right">{{ $bodyMassIndex }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>İdeal BMI :</b><a class="float-right">{{ $IdealBmi     }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <label for="">Öğün Seçimleri</label>
                                                    <p>
                                                        <a class="">
                                                            @foreach($customer->mealSelect as $k=> $meals)
                                                                {{ !empty($customer->mealSelect) ? $meals  : '' }}
                                                                <br>
                                                            @endforeach
                                                        </a>
                                                    </p>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col">
                                                        <b>İdeal kilo</b>
                                                    </div>
                                                    <div class="col">
                                                        <a class="float-right">{{ number_format($IdealWeight,1) }}</a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col">
                                                        <b>İdeal Kalori</b>
                                                    </div>
                                                    <div class="col">
                                                        <input name="idealCalorie" id="idealCalorie" type="number" step="0" class="form-control w-75 float-end" value="{{ intval($IdealCalorie) }}">
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                        </div>

                    </div>

                </div>

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <div class="alert alert-warning text-white h4">
                                Besin Seçimleri
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if(!empty($customer->food['breakfast']))
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header text-muted">Kahvaltılık Seçimler</div>
                                        <div class="card-body">
                                            @foreach($customer->food['breakfast'] as $foodID)

                                                {{ !empty($calories[$foodID]) ? $calories[$foodID]->food : '' }}
                                                <br>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(!empty($customer->food['snack1']))
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header text-muted">Ara Öğün 1 Seçimleri</div>
                                        <div class="card-body">
                                            @foreach($customer->food['snack1'] as $foodID)
                                                {{ !empty($calories[$foodID]) ? $calories[$foodID]->food : '' }}
                                                <br>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(!empty($customer->food['lunch']))
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header text-muted">Öğle Yemeği Seçimleri</div>
                                        <div class="card-body">
                                            @foreach($customer->food['lunch'] as $foodID)
                                                {{ !empty($calories[$foodID]) ? $calories[$foodID]->food : '' }}
                                                <br>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(!empty($customer->food['dinner']))
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header text-muted">Akşam Yemeği Seçimleri</div>
                                        <div class="card-body">
                                            @foreach($customer->food['dinner'] as $foodID)
                                                {{ !empty($calories[$foodID]) ? $calories[$foodID]->food : '' }}
                                                <br>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(!empty($customer->food['snack2']))
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header text-muted">Ara Öğün 2 Seçimleri</div>
                                        <div class="card-body">
                                            @foreach($customer->food['snack2'] as $foodID)
                                                {{ !empty($calories[$foodID]) ? $calories[$foodID]->food : '' }}
                                                <br>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col m-2">
                                    <button class="btn btn-success w-25 float-end" type="submit">Diet Oluştur</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>

        </div>
    </section>
</div>

@endsection
