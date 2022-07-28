@extends('back.layouts.master')
@section('title')
Diyet Listesi Oluştur
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-title">
                        <div class="alert alert-warning text-white ">
                            <div class="row">
                                <div class="col-2"><h3>Diyet Listesi</h3></div>
                                    <div class="col-10 ">
                                        <button class="btn btn-success float-end" onclick="window.location.reload();">Yenile <i class="fa fa-refresh ml-2" aria-hidden="true"> </i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @if(!empty($besinler['breakfast']['besinler']))
                            <div class="col-md-2">
                                <div class="card">
                                    <div class="card-header bg-green text-white">Kahvaltılık <a data-bs-toggle="modal" data-bs-target="#exampleModalCenter" data-type="breakfast" data-id="Kahvaltı" class="addItemModal btn btn-sm btn-warning float-end"><i class="fa-solid fa-plus"></i></a></div>
                                    <div class="card-body">
                                        @foreach(collect($besinler['breakfast']['besinler'])->countBy() as $breakfast => $count)
                                            -  {{ $count }} {{$breakfast}}
                                            <br>
                                        @endforeach
                                    </div>
                                    <div class="card-footer">
                                        Protein : {{$besinler['breakfast']['degerler']['protein'] }} gr<br>
                                        Karbonhidrat : {{$besinler['breakfast']['degerler']['karbonhidrat'] }} gr<br>
                                        Yağ : {{$besinler['breakfast']['degerler']['yag'] }} gr <br>
                                        <hr>
                                        Protein kcal: {{$besinler['breakfast']['degerler']['protein'] *4}} <br>
                                        Karbonhidrat kcal : {{$besinler['breakfast']['degerler']['karbonhidrat']*4 }} <br>
                                        Yağ kcal: {{$besinler['breakfast']['degerler']['yag'] *9}}  <br>
                                        Kalori : {{$besinler['breakfast']['toplam_kalori']}}<br>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(!empty($besinler['snack_1']['besinler']))
                            <div class="col-md-2">
                                <div class="card">
                                    <div class="card-header bg-green text-white">Ara Öğün 1 <a data-bs-toggle="modal" data-bs-target="#exampleModalCenter" data-type="snack_1" data-id="Ara Öğün"  class="addItemModal btn btn-sm btn-warning float-end"><i class="fa-solid fa-plus"></i></a></div>
                                    <div class="card-body">
                                        @foreach(collect($besinler['snack_1']['besinler'])->countBy() as $snack_1 => $count)
                                          -  {{ $count }} {{$snack_1}}
                                            <br>
                                        @endforeach
                                    </div>
                                    <div class="card-footer">
                                        Protein : {{$besinler['snack_1']['degerler']['protein'] }} gr<br>
                                        Karbonhidrat : {{$besinler['snack_1']['degerler']['karbonhidrat'] }} gr<br>
                                        Yağ : {{$besinler['snack_1']['degerler']['yag'] }} gr <br>
                                        <hr>
                                        Protein kcal: {{$besinler['snack_1']['degerler']['protein'] *4}} <br>
                                        Karbonhidrat kcal : {{$besinler['snack_1']['degerler']['karbonhidrat']*4 }} <br>
                                        Yağ kcal: {{$besinler['snack_1']['degerler']['yag'] *9}}  <br>
                                        Kalori : {{$besinler['snack_1']['toplam_kalori']}}<br>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(!empty($besinler['lunch']['besinler']))
                            <div class="col-md-2">
                                <div class="card">
                                    <div class="card-header bg-green text-white">Öğle Yemeği <a data-bs-toggle="modal" data-bs-target="#exampleModalCenter" data-type="lunch" data-id="öğle Yemeği"  class="addItemModal btn btn-sm btn-warning float-end"><i class="fa-solid fa-plus"></i></a></div>
                                    <div class="card-body">
                                        @foreach(collect($besinler['lunch']['besinler'])->countBy() as $lunch => $count)
                                         -   {{ $count }} {{$lunch}}
                                            <br>
                                        @endforeach
                                    </div>
                                    <div class="card-footer">
                                        Protein : {{$besinler['lunch']['degerler']['protein'] }} gr<br>
                                        Karbonhidrat : {{$besinler['lunch']['degerler']['karbonhidrat']}} gr<br>
                                        Yağ : {{$besinler['lunch']['degerler']['yag'] }} gr <br>
                                        <hr>
                                        Protein kcal: {{$besinler['lunch']['degerler']['protein'] *4}} <br>
                                        Karbonhidrat kcal : {{$besinler['lunch']['degerler']['karbonhidrat']*4 }} <br>
                                        Yağ kcal: {{$besinler['lunch']['degerler']['yag'] *9}}  <br>
                                        Kalori : {{$besinler['lunch']['toplam_kalori']}}<br>
                                    </div>
                                </div>
                            </div>
                            @endif
                                @if(!empty($besinler['snack_2']['besinler']))
                                <div class="col-md-2">
                                <div class="card">
                                    <div class="card-header bg-green text-white">Ara Öğün 2 <a data-bs-toggle="modal" data-bs-target="#exampleModalCenter" data-type="snack_2" data-id="Ara Öğün"  class="addItemModal btn btn-sm btn-warning float-end"><i class="fa-solid fa-plus"></i></a></div>
                                    <div class="card-body">
                                        @foreach(collect($besinler['snack_2']['besinler'])->countBy() as $snack_2 => $count)
                                           - {{ $count }} {{$snack_2}}
                                            <br>
                                        @endforeach
                                    </div>
                                    <div class="card-footer">
                                        Protein : {{$besinler['snack_2']['degerler']['protein'] }} gr<br>
                                        Karbonhidrat : {{$besinler['snack_2']['degerler']['karbonhidrat'] }} gr<br>
                                        Yağ : {{$besinler['snack_2']['degerler']['yag'] }} gr <br>
                                        <hr>
                                        Protein kcal: {{$besinler['snack_2']['degerler']['protein'] *4}} <br>
                                        Karbonhidrat kcal : {{$besinler['snack_2']['degerler']['karbonhidrat']*4 }} <br>
                                        Yağ kcal: {{$besinler['snack_2']['degerler']['yag'] *9}}  <br>
                                        Kalori : {{$besinler['snack_2']['toplam_kalori']}}<br>
                                    </div>
                                </div>
                            </div>
                                @endif
                                @if(!empty($besinler['dinner']['besinler']))
                            <div class="col-md-2">
                                <div class="card">
                                    <div class="card-header bg-green text-white">Akşam Yemeği <a data-bs-toggle="modal" data-bs-target="#exampleModalCenter" data-type="dinner" data-id="Akşam Yemeği"  class="addItemModal btn btn-sm btn-warning float-end"><i class="fa-solid fa-plus"></i></a></div>
                                    <div class="card-body">
                                        @foreach(collect($besinler['dinner']['besinler'])->countBy() as $dinner => $count)
                                          -  {{ $count }} {{$dinner}}
                                            <br>
                                        @endforeach
                                    </div>
                                    <div class="card-footer">
                                        Protein : {{$besinler['dinner']['degerler']['protein'] }} gr<br>
                                        Karbonhidrat : {{$besinler['dinner']['degerler']['karbonhidrat'] }} gr<br>
                                        Yağ : {{$besinler['dinner']['degerler']['yag'] }} gr <br>
                                        <hr>
                                        Protein kcal: {{$besinler['dinner']['degerler']['protein'] *4}} <br>
                                        Karbonhidrat kcal : {{$besinler['dinner']['degerler']['karbonhidrat']*4 }} <br>
                                        Yağ kcal: {{$besinler['dinner']['degerler']['yag'] *9}}  <br>
                                        Kalori : {{$besinler['dinner']['toplam_kalori']}}<br>
                                    </div>
                                </div>
                            </div>
                                @endif
                            <div class="col-md-2">
                                <div class="card">
                                    <div class="bg-warning"><p class="text-white m-2">Müşteri Verileri</p></div>
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <li class="list-group-item">Yağ: {{number_format($arr1['alması_gereken_yag'],2)}} gr</li>
                                            <li class="list-group-item">Protein: {{$arr1['alması_gereken_protein']}} gr</li>
                                            <li class="list-group-item">Karbonhidrat: {{$arr1['alması_gereken_karbonhidrat']}} gr</li>
                                            <li class="list-group-item">Kalori İhtiyacı: {{$idealCalorie}} kcal</li>
                                        </ul>
                                    </div>
                                    <div class="card-footer">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row bg-success p-1 rounded-1">
                                    <div class="col-md-2 text-bold">Çıkan Yağ(kcal): {{$arr2['cıkan_yag']}}</div>
                                    <div class="col-md-2 text-bold">Çıkan Protein(kcal): {{$arr2['cıkan_protein']}}</div>
                                    <div class="col-md-3 text-bold">Çıkan Karbonhidrat(kcal): {{$arr2['cıkan_karbonhidrat']}}</div>
                                    <div class="col-md-5 text-bold text-end">Liste Kalori: {{$listCalorie}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('back.partials.addItemModal')

    <script>
        $(document).ready(function(){
            $('.addItemModal').on('click',function (){

                var selectedMeals= @php echo json_encode($besinler) @endphp;
                var mealType = $(this).attr('data-id');
                var dataType = $(this).attr('data-type');

                $('#mealType').html('');
                $('#addMealForModal').html('');
                $('#addSelectedItem').html('');

                $.ajax({
                    type:'post',
                    url:'{{route('calorie.addItem')}}',
                    data:
                        {
                            mealType: mealType,
                            selectedMeals:selectedMeals,
                        },
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(data){
                        var meals =data.data['meals'];
                        var selectMeals =data.data['selectMeals'];
                        var selectMealsValues =data.data['selectMeals'][dataType]['degerler'];



                        const counts = {};
                        selectMeals[dataType]['besinler'].forEach(function (x) { counts[x] = (counts[x] || 0) + 1; });


                        $('#mealType').append(mealType);

                        $.each(meals,function(index, value ) {
                            $('#addMealForModal').append('<tr> <th scope="row"> '+value.food+' </th> <td> '+value.carbohydrate+' gr   ( '+parseFloat(value.carbohydrate*4,10)+' kcal )  </td> <td> '+value.protein+' gr   ( '+parseInt(value.protein*4,10)+' kcal )  </td> <td> '+value.fat+' gr   ( '+parseInt(value.fat*9,10)+' kcal )  </td> <td>  '+parseInt(value.carbohydrate*4 + value.fat*9 + value.protein*4,10) +' kcal </td> <td> <a href="" class="btn btn-success"><i class="fa-solid fa-plus"></i></a> </td> </tr>');
                        });



                        let uniqueSubjects = [...new Set(selectMeals[dataType]['besinler'])];
                        $.each(uniqueSubjects,function(i, v) {
                            $('#addSelectedItem').append('<tr> <th scope="row">  '+counts[v]+' '+v+'  </th> <td>  '+selectMeals[dataType]['degerler']['karbonhidrat']+' gr</td> <td> '+selectMeals[dataType]['degerler']['protein']+' gr</td>  <td>'+selectMeals[dataType]['degerler']['yag']+' gr</td> <td>'+ parseFloat((selectMeals[dataType]['degerler']['yag']*9) + (selectMeals[dataType]['degerler']['karbonhidrat']*4) + (selectMeals[dataType]['degerler']['protein']*4)) +'</td> </tr>');
                        });
                    }
                })
            })
        })
    </script>


@endsection

