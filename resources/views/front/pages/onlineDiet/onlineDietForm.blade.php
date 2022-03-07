@extends('front.layouts.master')
@section('title')
Online Diyet Başvuru
@endsection
@section('content')
        <div class="row mt-2">
            <div class="col-6 m-auto">
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
                                    <input type="number" class="form-control" name="weight" step="0.1" required placeholder="örn: 86.5">
                                </div>
                                <div class="col-md-2">
                                    <label for="exampleInputEmail1" class="form-label">Boy (cm)</label>
                                    <input id="height" type="number"  class="form-control" name="height"  step="0"  max="220" required placeholder="örn: 1.80">
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
                {{--gün içi hareketlilik --}}
                {{--<div class="card">
                    <div class="card-header"><legend>Gün içi hareketlilik seviyeniz</legend></div>
                    <div class="card-body">
                        <div class="">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="activity" required value="1.2" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Hareket etmiyorum,çok az hareket ediyorum
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="activity" value="1.375" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Az hareketli (Hafif hareketli bir yaşam / Haftada 1-3 gün egzersiz yapıyorum.)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="activity" value="1.55" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Orta derece hareketli (Hareketli bir yaşam / Haftada 3-5 gün egzersiz yapıyorum.)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="activity" value="1.72" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Çok hareketli (Çok hareketli bir yaşam / Haftada 6-7 gün egzersiz yapıyorum.)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="activity" value="1.9" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Aşırı hareketli (Profesyonel sporcu, atlet seviyesi.)
                                </label>
                            </div>

                        </div>
                    </div>
                </div>--}}
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <legend>Besin Listesi</legend>
                            </div>
                            <div class="col-4 m-2">
                                <label class="form-label text-muted" for="">Kaç öğüne bölmek istersiniz?</label>
                                <input class="form-control" type="number" value="3" name="numberOfMeals" min="3" max="6" required>
                            </div>
                        </div>
                            <div class="row border p-2 ">
                                <div class="row">
                                    <label for="">Kahvaltı</label>
                                    <hr>
                                    <div class="col mb-4 ">
                                            @foreach($foods as $food)
                                                @if(in_array('Kahvaltı',$food->meal) ? $food->food : '')
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"  name="food[breakfast][]"  value="{{in_array('Kahvaltı',$food->meal) ? $food->id : ''}}">
                                                            <label class="form-check-label" for="inlineCheckbox1">{{in_array('Kahvaltı',$food->meal) ? $food->food : ''}}</label>
                                                        </div>
                                                @endif
                                            @endforeach
                                    </div>
                                    <br>
                                    <label>Ana Öğün</label>
                                    <hr>
                                    <div class="col mb-4">
                                            @foreach($foods as $food)
                                                @if(in_array("Akşam Yemeği",$food->meal) & in_array("öğle Yemeği",$food->meal) ? $food->food : '')
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"  name="food[mainDish][]" value="{{ in_array("Akşam Yemeği",$food->meal) & in_array("öğle Yemeği",$food->meal) ? $food->id : ''}}">
                                                            <label class="form-check-label" for="inlineCheckbox1">{{in_array("Akşam Yemeği",$food->meal) & in_array("öğle Yemeği",$food->meal) ? $food->food : ''}}</label>
                                                        </div>
                                                @endif
                                            @endforeach
                                    </div>
                                    <br>
                                    <label>Ara Öğün</label>
                                    <hr>
                                    <div class="col mb-4">
                                        @foreach($foods as $food)
                                            @if(in_array("Ara Öğün",$food->meal) ? $food->food : '')
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input"  type="checkbox" name="food[snack][]" value="{{ in_array("Ara Öğün",$food->meal) ? $food->id : ''}}">
                                                    <label class="form-check-label" for="inlineCheckbox1">{{ in_array("Ara Öğün",$food->meal) ? $food->food : ''}}</label>
                                                </div>
                                            @endif
                                        @endforeach
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
@endsection
