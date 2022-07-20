<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\back\PanelIndexControlerr;
use App\Http\Controllers\back\CalorieController;
use App\Http\Controllers\back\CustomerController;
use App\Models\Calorie;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/',[CustomerController::class,'FrontIndex'])->name('onlineDietForm');

Route::prefix('panel')->middleware('auth')->group(function(){
    Route::get('/',[PanelIndexControlerr::class,'index'])->name('panel.index');
    Route::get('/kaloriler',[CalorieController::class,'index'])->name('calories');
    Route::get('/kalori-ekle',[CalorieController::class,'create'])->name('calorie.create');
    Route::post('/kalori-ekle',[CalorieController::class,'store'])->name('calorie.store');
    Route::post('/kalori-sil/{id}',[CalorieController::class,'delete'])->name('calorie.delete');
    Route::get('/kalori-düzenle/{id}',[CalorieController::class,'edit'])->name('calorie.edit');
    Route::post('/kalori-güncelle/{id}',[CalorieController::class,'update'])->name('calorie.update');

    Route::get('/online-diyet-talepleri',[CustomerController::class,'BackIndex'])->name('onlineCustomer');
    Route::get('/online-diyet-müşteri-detayı/{slug}',[CustomerController::class,'show'])->name('customer.detail');
    Route::get('/Diet-liste-hazırla/{slug}',[CustomerController::class,'ShowDietListForm'])->name('customer.CreateDietList');


});

    Route::get('/online-diyet-basvuru',[CustomerController::class,'FrontIndex'])->name('onlineDietForm');
    Route::post('/online-diyet-basvuru-kayıt',[CustomerController::class,'store'])->name('customer.store');



// Veri Ekleme Döngüsü

/*Route::get('/veri-ekle',function (){


        for($i=0; $i<=100; $i++){
            $yo1 = rand(0,9);
            $hello1 = rand(0,9);
            $carbonDeger = floatval($hello1.".".$yo1);

            $yo2 = rand(0,9);
            $hello2 = rand(0,9);
            $proteinDeger = floatval($hello2.".".$yo2);

            $yo3 = rand(0,9);
            $hello3 = rand(0,9);
            $fatDeger = floatval($hello3.".".$yo3);

            $carbonCal = $carbonDeger * 4;
            $proteinCal = $proteinDeger * 4;
            $fatCal = $fatDeger * 9;

            $totalCalorie = $carbonCal + $proteinCal + $fatCal;

            $faker = Faker\Factory::create();
            $calories = new Calorie();
            $calories->food = $faker->name;
            $calories->carbohydrate = $carbonDeger;
            $calories->protein = $proteinDeger;
            $calories->fat = $fatDeger;
            $calories->calorie = $totalCalorie;
            $calories->amount = 1;
            $calories->unit = "Adet";
            $calories->min = 1;
            $calories->max = 5;
            $calories->meal = ["Kahvaltı"];
            $calories->save();

        }
});*/
