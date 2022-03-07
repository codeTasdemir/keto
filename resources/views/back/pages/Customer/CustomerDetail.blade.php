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
                                            <b>Boy :</b> <a class="float-right">{{strval($customer->height) . " Cm"}}</a>
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
                                                <b>Öğün Sayısı</b><a class="float-right">{{ $customer->numberOfMeals . " öğün" }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col">
                                                        <b>İdeal kilo</b>
                                                    </div>
                                                    <div class="col">
                                                        <input name="" id="idealWeight" type="number" step="0.1" class="form-control w-75 float-end" value="{{ number_format($IdealWeight,1) }}">
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
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header text-muted">Ana Öğün Seçimleri</div>
                                        <div class="card-body">
                                            @foreach($customer->food['mainDish'] as $foodID)
                                                {{ !empty($calories[$foodID]) ? $calories[$foodID]->food : '' }}
                                                <br>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header text-muted">Ara Öğün Seçimleri</div>
                                        <div class="card-body">
                                            @foreach($customer->food['snack'] as $foodID)
                                                {{ !empty($calories[$foodID]) ? $calories[$foodID]->food : '' }}
                                                <br>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
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
<script type="text/javascript">
    $(document).ready(function (){
        $('#idealWeight').change(function (){
            var idealWeight = $('#idealWeight').val();
            if(idealWeight)
            {
                var idealCalorie = $('#idealCalorie').val();
                var idealCaloriePerKilo = (idealCalorie /  idealWeight) /10  ;
                $('#idealCalorie').val( Number(parseInt(idealCalorie))  + Number(parseFloat(idealCaloriePerKilo).toFixed(0)));
            }
            else {
                $('#idealCalorie').val( Number(parseInt(idealCalorie))  - Number(parseFloat(idealCaloriePerKilo).toFixed(0)));
            }
        })
    })
</script>
@endsection
