@extends('back.layouts.master')
@section('title')
Besin Düzenle
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 m-auto">
                <div class="card">
                    <div class="card-title">
                        <div class="card-body">
                            <form method="post" class="row g-3" action="{{route('calorie.update',$calorie->id)}}">
                                @csrf
                                <div class="col-md-4">
                                    <label  class="form-label">Besin</label>
                                    <input type="text" class="form-control" value="{{$calorie->food}}" name="food" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Karbonhidrat</label>
                                    <input type="number" class="col-auto form-control" value="{{$calorie->carbohydrate}}" step="0.01" name="carbohydrate" required>
                                </div>
                                <div class="col-md-2">
                                    <label  class="form-label">Protein</label>
                                    <input type="number" class="col-auto form-control" value="{{$calorie->protein}}" step="0.01" name="protein" required>
                                </div>
                                <div class="col-md-2">
                                    <label  class="form-label">Yağ</label>
                                    <input type="number" class="col-auto form-control" value="{{$calorie->fat}}" step="0.01" name="fat" required>
                                </div>
                                <div class="col-md-2">
                                    <label  class="form-label">Kalori</label>
                                    <input type="number" class="col-auto form-control" value="{{$calorie->calorie}}" step="0.1" name="calorie" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Birim</label>
                                    <select name="unit" class="form-select" required>
                                        <option {{ ($calorie->unit) == 'Gr' ? 'selected' : '' }} value="Gr">Gr</option>
                                        <option {{ ($calorie->unit) == 'Adet' ? 'selected' : '' }} value="Adet">Adet</option>
                                        <option {{ ($calorie->unit) == 'Paket' ? 'selected' : '' }} value="Paket">Paket</option>
                                        <option {{ ($calorie->unit) == 'Yemek Kaşığı' ? 'selected' : '' }} value="Yemek Kaşığı">Yemek Kaşığı</option>
                                        <option {{ ($calorie->unit) == 'Tatlı Kaşığı' ? 'selected' : '' }} value="Tatlı Kaşığı">Tatlı Kaşığı</option>
                                        <option {{ ($calorie->unit) == 'Çay Bardağı' ? 'selected' : '' }} value="Çay Bardağı">Çay Bardağı</option>
                                        <option {{ ($calorie->unit) == 'Yarım Çay Bardağı' ? 'selected' : '' }} value="Yarım Çay Bardağı">Yarım Çay Bardağı</option>
                                        <option {{ ($calorie->unit) == 'Su Bardağı' ? 'selected' : '' }} value="Su Bardağı">Su Bardağı</option>
                                        <option {{ ($calorie->unit) == 'Yarım Su Bardağı' ? 'selected' : '' }} value="Yarım Su Bardağı">Yarım Su Bardağı</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class=" form-label">Miktar</label>
                                    <input type="number" class="col-auto form-control" value="{{$calorie->amount}}" step="0.1" name="amount" required>
                                </div>
                                <div class="col-md-2">
                                    <label  class="form-label">Min</label>
                                    <input type="number" class="col-auto form-control" value="{{$calorie->min}}" step="0.1" name="min" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="col-auto form-label">Max</label>
                                    <input type="number" class="form-control" name="max" value="{{$calorie->max}}" step="0.1" required>
                                </div>

                                <label for="">Öğünler</label>

                                    <select name="meal[]" class="js-example-basic-multiple" required multiple="">
                                        <option {{ ( in_array("Kahvaltı" , $calorie->meal ))  ? 'selected' : '' }} value="Kahvaltı"> Kahvaltı </option>
                                        <option {{ ( in_array("Ara Öğün" , $calorie->meal ))  ? 'selected' : '' }} value="Ara Öğün">Ara Öğün</option>
                                        <option {{ ( in_array("öğle Yemeği" , $calorie->meal ))  ? 'selected' : '' }} value="öğle Yemeği">Öğle Yemeği</option>
                                        <option {{ ( in_array("Akşam Yemeği" , $calorie->meal ))  ? 'selected' : '' }} value="Akşam Yemeği">Akşam Yemeği</option>
                                    </select>

                                <button type="submit" class="btn btn-primary float-end">Ekle</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
