@extends('front.layouts.master')
@section('title')
Online Diyet Başvuru
@endsection
@section('content')
        <div class="row mt-2">
            <div class="col-md-6 m-auto">
                <div class="card">
                    <div class="alert alert-warning border-0 text-white h3">Online Diyet Talebi</div>
                        <div class="card-body">
                            <form method="post" class="row g-3" action="{{route('customer.store')}}">
                                @csrf
                                <legend>Kişisel Bilgiler</legend>
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Ad</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Soyad</label>
                                    <input type="text" class="form-control" name="lastName" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="exampleInputEmail1" class="form-label">Yaş</label>
                                    <input type="number" class="form-control" name="age" step="0" required placeholder="örn: 18">
                                </div>
                                <div class="col-md-2">
                                    <label for="exampleInputEmail1" class="form-label">Kilo</label>
                                    <input type="number" class="form-control" name="weight" step="0.1" max="200" required placeholder="örn: 86.5">
                                </div>
                                <div class="col-md-2">
                                    <label for="exampleInputEmail1" class="form-label">Boy (cm)</label>
                                    <input id="height" type="number"  class="form-control" name="height"  step="0.01"  required placeholder="örn: 1.80">
                                </div>
                                <div class="col-md-2">
                                    <label for="">Cinsiyet</label>
                                    <select name="gender" class=" form-select" required>
                                        <option value="Erkek">Erkek</option>
                                        <option value="Kadın">Kadın</option>
                                    </select>
                                </div>
                        </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <legend>Besin Listesi</legend>
                            </div>
                        </div>
                        <div class="col-12 mb-4 border p-3">
                            <label for="">Öğün Seçimi</label>
                            <hr>
                            <div class="form-check form-check-inline">
                                <input class="mealSelect form-check-input" data-value="breakfast" name="mealSelect[]" type="checkbox" id="inlineCheckbox1" value="Kahvaltı">
                                <label class="form-check-label" for="inlineCheckbox1">Kahvaltı</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="mealSelect form-check-input" data-value="snack1" name="mealSelect[]" type="checkbox" id="inlineCheckbox2" value="Ara Öğün 1">
                                <label class="form-check-label" for="inlineCheckbox2">Ara Öğün 1</label>
                            </div>
                            <div class="form-check form-check-inline">
                                    <input class="mealSelect form-check-input" data-value="lunch" name="mealSelect[]" type="checkbox" id="inlineCheckbox3" value="Öğle Yemeği">
                                <label class="form-check-label" for="inlineCheckbox3">Öğle Yemeği</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="mealSelect form-check-input" data-value="snack2" name="mealSelect[]" type="checkbox" id="inlineCheckbox4" value="Ara Öğün 2">
                                <label class="form-check-label" for="inlineCheckbox4">Ara Öğün 2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="mealSelect form-check-input" data-value="dinner" name="mealSelect[]" type="checkbox" id="inlineCheckbox5" value="Akşam Yemeği">
                                <label class="form-check-label" for="inlineCheckbox5">Akşam Yemeği</label>
                            </div>

                        </div>
                            <div class="row border p-2 ">
                                <div class=" row">
                                    <div style="display: none"  class="breakfastArea col-md-12 mb-4">
                                        <label for="">Kahvaltı</label>
                                        <hr>
                                            @foreach($foods as $k=> $food)
                                                @if(in_array('Kahvaltı',$food->meal) ? $food->food : '')
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" id="breakfastCheckbox{{$k}}" type="checkbox"  name="food[breakfast][]"  value="{{in_array('Kahvaltı',$food->meal) ? $food->id : ''}}">
                                                            <label class="form-check-label" for="breakfastCheckbox{{$k}}">{{in_array('Kahvaltı',$food->meal) ? $food->food : ''}}</label>
                                                        </div>
                                                @endif
                                            @endforeach
                                    </div>
                                </div>
                                <div class="row">
                                    <br>
                                    <div style="display: none" class="lunchArea col-md-12 mb-4">
                                        <label>öğle yemeği</label>
                                        <hr>
                                            @foreach($foods as $k=> $food)
                                                @if(in_array("Akşam Yemeği",$food->meal) & in_array("öğle Yemeği",$food->meal) ? $food->food : '')
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" id="lunchCheckbox{{$k}}" type="checkbox"  name="food[lunch][]" value="{{ in_array("Akşam Yemeği",$food->meal) & in_array("öğle Yemeği",$food->meal) ? $food->id : ''}}">
                                                            <label class="form-check-label" for="lunchCheckbox{{$k}}">{{in_array("Akşam Yemeği",$food->meal) & in_array("öğle Yemeği",$food->meal) ? $food->food : ''}}</label>
                                                        </div>
                                                @endif
                                            @endforeach
                                    </div>
                                </div>
                                <div class="row">
                                    <br>
                                    <div style="display: none" class="dinnerArea col-md-12 mb-4">
                                        <label>Akşam Yemeği</label>
                                        <hr>
                                        @foreach($foods as $k=> $food)
                                            @if(in_array("Akşam Yemeği",$food->meal) & in_array("öğle Yemeği",$food->meal) ? $food->food : '')
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" id="dinnerCheckbox{{$k}}" type="checkbox"  name="food[dinner][]" value="{{ in_array("Akşam Yemeği",$food->meal) & in_array("öğle Yemeği",$food->meal) ? $food->id : ''}}">
                                                    <label class="form-check-label" for="dinnerCheckbox{{$k}}">{{in_array("Akşam Yemeği",$food->meal) & in_array("öğle Yemeği",$food->meal) ? $food->food : ''}}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row">
                                    <br>
                                    <div style="display: none" class="SnackArea1 col-md-12 mb-4">
                                        <label>Ara Öğün 1</label>
                                        <hr>
                                        @foreach($foods as $k=> $food)
                                            @if(in_array("Ara Öğün",$food->meal) ? $food->food : '')
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" id="snack1Checkbox{{$k}}" type="checkbox" name="food[snack1][]" value="{{ in_array("Ara Öğün",$food->meal) ? $food->id : ''}}">
                                                    <label class="form-check-label" for="snack1Checkbox{{$k}}">{{ in_array("Ara Öğün",$food->meal) ? $food->food : ''}}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row">
                                    <br>
                                    <div style="display: none" class="SnackArea2 col-md-12 mb-4">
                                        <label>Ara Öğün 2</label>
                                        <hr>
                                        @foreach($foods as $k=> $food)
                                            @if(in_array("Ara Öğün",$food->meal) ? $food->food : '')
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" id="snack2Checkbox{{$k}}" type="checkbox" name="food[snack2][]" value="{{ in_array("Ara Öğün",$food->meal) ? $food->id : ''}}">
                                                    <label class="form-check-label" for="snack2Checkbox{{$k}}">{{ in_array("Ara Öğün",$food->meal) ? $food->food : ''}}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col mt-2">
                                    @if (session('alert'))
                                        <p class="lead text-danger">{{ session('alert') }}</p>
                                    @endif
                                    @if (session('success'))
                                        <p class="lead text-success">{{ session('success') }}</p>
                                    @endif
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-success float-end mt-3" type="submit">Gönder</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function (){
                console.log($('.mealSelect')[4].checked);
                $('.mealSelect').on('click', function(){
                    if( $(this).data('value') == "breakfast"){
                        $('.breakfastArea').slideToggle('slow');
                    }
                    else if($(this).data('value') == "snack1"){
                        if($('.mealSelect')[1].checked == true){
                            $('.SnackArea1').show('slow');
                        }
                        else if($('.mealSelect')[1].checked == false){
                            $('.SnackArea1').hide('slow');
                        }
                    }
                    else if($(this).data('value') == "snack2"){
                        if($('.mealSelect')[3].checked == true){
                            $('.SnackArea2').show('slow');
                        }
                        else if($('.mealSelect')[3].checked == false){
                            $('.SnackArea2').hide('slow');
                        }
                    }
                    else if($(this).data('value') == "lunch"){
                        if($('.mealSelect')[2].checked == true){
                            $('.lunchArea').show('slow');
                        }
                        else if($('.mealSelect')[2].checked == false){
                            $('.lunchArea').hide('slow');
                        }
                    }
                    else if($(this).data('value') == "dinner"){
                        if($('.mealSelect')[4].checked == true){
                            $('.dinnerArea').show('slow');
                        }
                        else if($('.mealSelect')[4].checked == false ){
                            $('.dinnerArea').hide('slow');
                        }
                    }
                })
            })
        </script>
@endsection
