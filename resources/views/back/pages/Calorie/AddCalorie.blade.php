@extends('back.layouts.master')
@section('title')
Kalori Ekle
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 m-auto">
                <div class="card">
                    <div class="alert alert-warning text-white h3">Besin Ekleme Formu</div>
                    <div class="card-body">
                        <form method="post" class="row g-3" action="{{route('calorie.store')}}">
                            @csrf
                            <div class="col-md-12">
                                <label class="form-label">Besin</label>
                                <input type="text" class="form-control" name="food" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Karbonhidrat</label>
                                <input type="number" class="form-control" name="carbohydrate" step="0.01" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Protein</label>
                                <input type="number" class="form-control" name="protein" step="0.01" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Yağ</label>
                                <input type="number" class="form-control" name="fat" step="0.01" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Kalori</label>
                                <input type="number" class="form-control" name="calorie"  step="0.1" required>
                            </div>
                            <div class="col-md-4">
                                <label for="">Birim</label>
                                <select name="unit" class=" form-select" required>
                                    <option value="Gr">Gr</option>
                                    <option value="Adet">Adet</option>
                                    <option value="Paket">Paket</option>
                                    <option value="Yemek Kaşığı">Yemek Kaşığı</option>
                                    <option value="Tatlı Kaşığı">Tatlı Kaşığı</option>
                                    <option value="Çay Bardağı">Çay Bardağı</option>
                                    <option value="Yarım Çay Bardağı">Yarım Çay Bardağı</option>
                                    <option value="Su Bardağı">Su Bardağı</option>
                                    <option value="Yarım Su Bardağı">Yarım Su Bardağı</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class=" form-label">Miktar</label>
                                <input type="number" class="form-control" name="amount" step="0.1" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Min</label>
                                <input type="number" class="form-control" name="min" step="0.1" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Max</label>
                                <input type="number" class="form-control" name="max" step="0.1" required>
                            </div>

                            <label for="">Öğünler</label>
                            <select name="meal[]" class="js-example-basic-multiple" required multiple="">
                                <option  value="Kahvaltı"> Kahvaltı </option>
                                <option  value="Ara Öğün">Ara Öğün</option>
                                <option  value="öğle Yemeği">Öğle Yemeği</option>
                                <option  value="Akşam Yemeği">Akşam Yemeği</option>
                            </select>

                            <button type="submit" class="btn btn-outline-success float-end">Ekle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
