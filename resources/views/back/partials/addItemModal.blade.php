
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> <span id="mealType"></span>  Besinleri Düzenleniyor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <row>
                    <div class="col-md-12">
                        <legend><span class="text-success">Eklenmiş Besinler</span></legend>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">Ürün Adı</th>
                                <th scope="col">Karbonhidrat</th>
                                <th scope="col">Protein</th>
                                <th scope="col">Yağ</th>
                                <th scope="col">Kalori</th>
                                <th scope="col">Artır/Azalt</th>
                            </tr>
                            </thead>
                            <tbody id="addSelectedItem">
{{--                            <tr>--}}

{{--                                <th scope="row">--}}
{{--                                    @foreach(collect($besinler['breakfast']['besinler'])->countBy() as $breakfast => $count)--}}
{{--                                        -  {{ $count }} {{$breakfast}}--}}
{{--                                        <br>--}}
{{--                                    @endforeach</th>--}}
{{--                                <td>--}}
{{--                                    @foreach(collect($besinler['breakfast']['degerler']['karbonhidrat']) as $k => $carbohydrate)--}}

{{--                                        {{$carbohydrate . 'gr' }}  {{ '( '. $carbohydrate * 4 . 'kcal' . ' )' }}--}}
{{--                                        <br>--}}
{{--                                    @endforeach--}}
{{--                                </td>--}}
{{--                                <td> @foreach(collect($besinler['breakfast']['degerler']['protein']) as $v => $protein)--}}

{{--                                        {{$protein . 'gr' }}  {{ '( '. $protein * 4 . 'kcal' . ' )' }}--}}
{{--                                        <br>--}}
{{--                                    @endforeach</td>--}}
{{--                                <td>@foreach(collect($besinler['breakfast']['degerler']['yag']) as $ı => $fat)--}}

{{--                                        {{$fat . 'gr' }}  {{ '( '. $fat * 9 . 'kcal' . ' )' }}--}}
{{--                                        <br>--}}
{{--                                    @endforeach</td>--}}
{{--                                <td>{{ ($fat*9) +  ($protein*4) +  ($carbohydrate*4) . 'kcal'}}</td>--}}
{{--                                <td>--}}
{{--                                    <a href="" class="btn btn-success btn-sm"><i class="fa-solid fa-plus"></i></a>--}}
{{--                                    <a href="" class="btn btn-danger btn-sm"><i class="fa-solid fa-minus"></i></a>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
                            </tbody>
                        </table>
                    </div>
                </row>
                <row>
                    <div class="col-md-12">
                        <legend><span class="text-warning">Eklenecek Besinler</span></legend>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">Ürün Adı</th>
                                <th scope="col">Karbonhidrat</th>
                                <th scope="col">Protein</th>
                                <th scope="col">Yağ</th>
                                <th scope="col">Kalori</th>
                                <th scope="col">Artır</th>
                            </tr>
                            </thead>
                            <tbody id="addMealForModal">

                            </tbody>
                        </table>
                    </div>
                </row>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Vazgeç</button>
                <button type="button" class="btn btn-success">Değişiklikleri Kaydet</button>
            </div>
        </div>
    </div>
</div>
