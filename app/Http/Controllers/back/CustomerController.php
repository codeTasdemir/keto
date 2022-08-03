<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Calorie;
use App\Models\Calorie2;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Array_;
use function Composer\Autoload\includeFile;
use function PHPUnit\Framework\at;
use function PHPUnit\Framework\containsIdentical;

class CustomerController extends Controller
{
    public function FrontIndex()
    {
        $foods = Calorie::orderBy('meal', 'DESC')->get();
        return view('front.pages.onlineDiet.onlineDietForm', compact('foods'));
    }

    public function BackIndex()
    {
        $customers = Customer::get();
        return view('back.pages.Customer.Customers', compact('customers'));
    }

    public function store(Request $request)
    {
        try {
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->lastName = $request->lastName;
            $customer->slug = Str::slug($request->name . "-" . $request->lastName);
            $customer->age = $request->age;
            $customer->weight = $request->weight;
            $customer->height = $request->height;
            $customer->mealSelect = $request->input('mealSelect');
            $customer->activity = 1.55;
            $customer->gender = $request->gender;
            $customer->food = $request->input('food');
            $customer->save();
            return redirect()->back()->with('success');

        } catch (\Throwable $th) {
            return $th;
//            return redirect()->back()->with('alert', 'Lütfen ilgili alanları, doğru ve eksiksiz doldurduğunuzdan emin olunuz!');
        }
    }

    public function show($slug)
    {
        $customer = Customer::where('slug', $slug)->first();
        $customerHeight = $customer->height;
        $customerWeight = $customer->weight;

        //Bmi Calculation /vücut kitle endeksi
        $customerHeightMultiplication = pow($customerHeight, 2);
        $bodyMassIndexCalculate = $customerWeight / $customerHeightMultiplication; //Ağırlığın Uzunluğun Karasine Bölünmesi
        $bodyMassIndex = number_format($bodyMassIndexCalculate, 2);

        if ($bodyMassIndex >= 18 && $bodyMassIndex <= 25) {
            $IdealBmi = 18;
            $IdealWeight = $IdealBmi * pow($customerHeight, 2);
            if ($customer->gender == "Kadın") {
                $IdealCalorie = $IdealWeight * 22.8 * 1.2;
            } else {
                $IdealCalorie = $IdealWeight * 24 * 1.2;
            }
        } elseif ($bodyMassIndex > 25) {
            $IdealBmi = 25;
            $IdealWeight = $IdealBmi * pow($customerHeight, 2);
            if ($customer->gender == "Kadın") {
                $IdealCalorie = $IdealWeight * 22.8 * 1.2;
            } else {
                $IdealCalorie = $IdealWeight * 24 * 1.2;
            }
        } else {
            return "hata";
        }


        $calories = Calorie::all()->keyBy('id');

        return view('back.pages.Customer.CustomerDetail', compact('calories', 'customer', 'bodyMassIndex', 'IdealBmi', 'IdealWeight', 'IdealCalorie'));
    }

    //hesapla meal count değişecek
    //besinler her bir öğün için ayrı seçtirilecek

    public function ShowDietListForm(Request $request, $slug)
    {
        ini_set('max_execution_time', 120);
        $customer = Customer::where('slug',$slug)->first();

        //Müşterinin besinler için seçtikleri
        $customerBreakfastSelect = $customer->food["breakfast"] ?? '';
        $customerSnack1Select =  $customer->food['snack1'] ?? '';
        $customerDinnerSelect = $customer->food['dinner'] ?? '';
        $customerLunchSelect = $customer->food['lunch'] ?? '';
        $customerSnack2Select = $customer->food['snack2'] ?? '';


        $array['breakfast'] = null;
        $array['lunch'] = null;
        $array['dinner'] = null;
        $array['snack_1'] = null;
        $array['snack_2'] = null;


        //Model Değişkenleri
        $customer = Customer::where('slug', $slug)->first();

        //Request Değişkenleri
        $idealCalorie = $request->idealCalorie; // Liste Oluştururken ulaşılabilecek max kalori değeri

        $CustomerMealSelect = collect($customer->mealSelect);
        $CustomerMealNumber = $CustomerMealSelect->count();

        $CaloriOfMeal = $idealCalorie / $CustomerMealNumber;

        $k=0;

        foreach ($CustomerMealSelect as $mealName) {
            switch ($mealName){
                case "Kahvaltı":
                    $k= $k+2;
                    break;
                case "Akşam Yemeği":
                    $k= $k+2;
                    break;
                case "Öğle Yemeği":
                    $k= $k+2;
                    break;
                case "Ara Öğün 1":
                    $k= $k+1;
                    break;
                case "Ara Öğün 2":
                    $k= $k+1;
                    break;
            }
        }

        $kCal = $idealCalorie /$k;


        //Müşterinin Besinlerden alabilceği maximum Besin değerleridir
        $Customerfat = $idealCalorie * 0.75 / 9; //Kalorininin %75 i yagdan gelmeli /Gr
        $CustomerProtein = $customer->weight * 1.08 ; //Kilo başına düşen protein miktarı/ GR
        $CustomerCarbohydrate = rand(28,35); //Karbonhidrattan gelecek Max Kalori Miktari /Gr


        if(!empty($customer->food["breakfast"])) {
            if ($CustomerMealSelect->contains('Kahvaltı')) {
                //Kahvaltı Katsayısı
                $BreakfasthCoefficient = 2;
                //

                //Kahvatı Besinleri
                $BreakfastFood = Calorie::whereJsonContains('meal', 'Kahvaltı')->whereIn('id', $customerBreakfastSelect)->get();
                $BreakfastFood = $BreakfastFood->each(function ($item, $key) use ($BreakfastFood) {
                    for ($i = 1; ($i < $item->max); $i++) {
                        $BreakfastFood->push($item);
                    }
                })->shuffle();
                $BreakfastFood = collect($BreakfastFood->values()->all());
                //Kahvaltı Öğünün Katsayı ddğeri 2K'dır
                $CustomerBreakfastResult = $this->CustomerMaxValueCalculate($kCal, $Customerfat, $CustomerProtein, $CustomerCarbohydrate, $BreakfasthCoefficient, $k);
                $array['breakfast'] = $this->hesapla($CustomerBreakfastResult['MaxProtein'], $CustomerBreakfastResult['MaxCarbohydrate'], $CustomerBreakfastResult['MaxFat'], $BreakfastFood);

            }
        }
        if(!empty($customer->food["snack1"])) {
            if ($CustomerMealSelect->contains('Ara Öğün 1')) {
                //Ara Öğün Katsayısı
                $SnackCoefficient = 1;
                //

                //Ara Öğün Besinleri
                $SnackFood1 = Calorie::whereJsonContains('meal', 'Ara Öğün')->whereIn('id', $customerSnack1Select)->get();
                $SnackFood1 = $SnackFood1->each(function ($item, $key) use ($SnackFood1) {
                    for ($i = 1; ($i < $item->max); $i++) {
                        $SnackFood1->push($item);
                    }
                })->shuffle();
                $SnackFood1 = collect($SnackFood1->values()->all());

                //Ara Öğünler Katsayısı 1K 'dır
                $CustomerSnackResult = $this->CustomerMaxValueCalculate($kCal, $Customerfat, $CustomerProtein, $CustomerCarbohydrate, $SnackCoefficient, $k);
                $array['snack_1'] = $this->hesapla($CustomerSnackResult['MaxProtein'], $CustomerSnackResult['MaxCarbohydrate'], $CustomerSnackResult['MaxFat'], $SnackFood1);

            }
        }

        if(!empty($customer->food["lunch"])) {
            if ($CustomerMealSelect->contains('Öğle Yemeği')) {
                //Öğle Yemeği Katsayısı
                $MainDishCoefficient = 2;

                //Öğle Yemeği Besinleri
                $LunchFood = Calorie::whereJsonContains('meal', 'öğle Yemeği')->orWhereJsonContains('meal','Akşam Yemeği')->whereIn('id', $customerLunchSelect)->get();
                $LunchFood = $LunchFood->each(function ($item, $key) use ($LunchFood) {
                    for ($i = 1; ($i < $item->max); $i++) {
                        $LunchFood->push($item);
                    }
                })->shuffle();

                $LunchFood = collect($LunchFood->values()->all());

                if ($CustomerMealSelect->contains('Öğle Yemeği')) {
                    $CustomerLunchResult = $this->CustomerMaxValueCalculate($kCal, $Customerfat, $CustomerProtein, $CustomerCarbohydrate, $MainDishCoefficient, $k);

                    $array['lunch'] = $this->hesapla($CustomerLunchResult['MaxProtein'], $CustomerLunchResult['MaxCarbohydrate'], $CustomerLunchResult['MaxFat'], $LunchFood);
                }
            }
        }

        if(!empty($customer->food["snack2"])) {
            if ($CustomerMealSelect->contains('Ara Öğün 2')) {
                //Ara Öğün Katsayısı
                $SnackCoefficient = 1;
                //

                //Ara Öğün Besinleri
                $SnackFood2 = Calorie::whereJsonContains('meal', 'Ara Öğün')->whereIn('id', $customerSnack2Select)->get();
                $SnackFood2 = $SnackFood2->each(function ($item, $key) use ($SnackFood2) {
                    for ($i = 1; ($i >= $item->min && $i <= $item->max); $i++) {
                        $SnackFood2->push($item);
                    }
                })->shuffle();
                $SnackFood2 = collect($SnackFood2->values()->all());

                //Ara Öğünler Katsayısı 1K 'dır
                $CustomerSnackResult = $this->CustomerMaxValueCalculate($kCal, $Customerfat, $CustomerProtein, $CustomerCarbohydrate, $SnackCoefficient, $k);
                $array['snack_2'] = $this->hesapla($CustomerSnackResult['MaxProtein'], $CustomerSnackResult['MaxCarbohydrate'], $CustomerSnackResult['MaxFat'], $SnackFood2);
            }
        }
        if(!empty($customer->food["dinner"])) {
            if ($CustomerMealSelect->contains('Akşam Yemeği')) {

                //Ana Öğün Katsayısı
                $MainDishCoefficient = 2;
                //

                //Ana Öğün Besinleri
                $MainDishFood = Calorie::whereJsonContains('meal', ['öğle Yemeği','Akşam Yemeği'])->whereIn('id', $customerDinnerSelect)->get();
                $MainDishFood = $MainDishFood->each(function ($item, $key) use ($MainDishFood) {
                    for ($i = 1; ($i >= $item->min && $i <= $item->max); $i++) {
                        $MainDishFood->push($item);
                    }
                })->shuffle();
                $MainDishFood = collect($MainDishFood->values()->all());

                if ($CustomerMealSelect->contains('Akşam Yemeği')) {
                    $CustomerDinnerResult = $this->CustomerMaxValueCalculate($kCal, $Customerfat, $CustomerProtein, $CustomerCarbohydrate, $MainDishCoefficient, $k);
                    $array['dinner'] = $this->hesapla($CustomerDinnerResult['MaxProtein'], $CustomerDinnerResult['MaxCarbohydrate'], $CustomerDinnerResult['MaxFat'], $MainDishFood);

                }
            }
        }

            $arr2= ["Çıkan_Protein_gr" =>
                        (isset($array['breakfast']['degerler']['protein'])+
                        isset($array['dinner']['degerler']['protein'])+
                        isset($array['lunch']['degerler']['protein'])+
                        isset($array['snack_1']['degerler']['protein'])+
                        isset($array['snack_2']['degerler']['protein'])),
                "Çıkan_Karbonhidrat_gr" =>
                        (isset($array['breakfast']['degerler']['karbonhidrat']) +
                        isset($array['dinner']['degerler']['karbonhidrat']) +
                        isset($array['lunch']['degerler']['karbonhidrat']) +
                        isset($array['snack_1']['degerler']['karbonhidrat'])+
                        isset($array['snack_2']['degerler']['karbonhidrat'])),
                "Çıkan_yag_gr"=>
                        (isset($array['breakfast']['degerler']['yag']) +
                         isset($array['dinner']['degerler']['yag'])+
                         isset($array['lunch']['degerler']['yag']) +
                         isset($array['snack_1']['degerler']['yag'])+
                         isset($array['snack_2']['degerler']['yag'])),
                "cıkan_yag"=>
                    ($array['breakfast']['yag_Kalori'] ?? 0)+
                    ($array['lunch']['yag_Kalori'] ?? 0)+
                    ($array['snack_1']['yag_Kalori'] ?? 0)+
                    ($array['snack_2']['yag_Kalori'] ?? 0)+
                    ($array['dinner']['yag_Kalori'] ?? 0),
                "cıkan_protein"=>
                    ($array['breakfast']['protein_Kalori']?? 0)+
                    ($array['lunch']['protein_Kalori'] ?? 0)+
                    ($array['snack_1']['protein_Kalori'] ?? 0)+
                    ($array['snack_2']['protein_Kalori'] ?? 0)+
                    ($array['dinner']['protein_Kalori'] ?? 0),
                "cıkan_karbonhidrat"=>
                    ($array['breakfast']['karbonhidrat_Kalori'] ?? 0)+
                    ($array['lunch']['karbonhidrat_Kalori'] ?? 0)+
                    ($array['snack_1']['karbonhidrat_Kalori'] ?? 0)+
                    ($array['snack_2']['karbonhidrat_Kalori'] ?? 0)+
                    ($array['dinner']['karbonhidrat_Kalori'] ?? 0)

                ];

                $arr1 = ["alması_gereken_protein" =>$CustomerProtein,
                        "alması_gereken_karbonhidrat" =>$CustomerCarbohydrate,
                        "alması_gereken_yag" => $Customerfat];


                if(!empty($array['breakfast'])){
                    $breakfastCalorie = $array['breakfast']['toplam_kalori'];
                }
                else{
                    $breakfastCalorie = 0;
                }

                if(!empty($array['lunch'])){
                    $lunchMaxCalorie =$array['lunch']['toplam_kalori'];
                }
                else{
                    $lunchMaxCalorie = 0;
                }
                if(!empty($array['dinner'])){
                    $dinnerMaxCalorie =  $array['dinner']['toplam_kalori'];
                }
                else{
                    $dinnerMaxCalorie = 0;
                }

                if(!empty($array['snack_1'])){
                    $snack1MaxCalorie =  $array['snack_1']['toplam_kalori'];
                }
                else{
                    $snack1MaxCalorie = 0;
                }

                if(!empty($array['snack_2'])){
                    $snack2MaxCalorie =  $array['snack_2']['toplam_kalori'];
                }
                else{
                    $snack2MaxCalorie = 0;
                }

                $listCalorie = $breakfastCalorie + $lunchMaxCalorie +$dinnerMaxCalorie +$snack1MaxCalorie +$snack2MaxCalorie;
                $besinler = $array;


        return view('back.pages.Customer.CreateDietList',compact('besinler','arr1','arr2','listCalorie','idealCalorie'));

    }


    public function hesapla($MaxProtein,$MaxCarbohydrate,$MaxFat,$Meal)
    {

        $fat=0;
        $carbohydrate=0;
        $protein=0;


        $i = 0;
        $result =[];
        for($i=0; $i<$Meal->count(); $i++) {
            if ($protein <= $MaxProtein && ( ($protein + $Meal[$i]->protein) <= $MaxProtein) &&( $MaxProtein >= ($protein + $Meal[$i]->protein))  ) {
                if ($carbohydrate <= $MaxCarbohydrate && (($carbohydrate + $Meal[$i]->carbohydrate) <= $MaxCarbohydrate) && $MaxCarbohydrate >= ($carbohydrate + $Meal[$i]->carbohydrate) ) {
                    if ($fat <= $MaxFat && (($fat + $Meal[$i]->fat) <= $MaxFat ) && $MaxFat >= ($fat + $Meal[$i]->fat) )  {
                        $protein = $protein + $Meal[$i]->protein;
                        $carbohydrate = $carbohydrate + $Meal[$i]->carbohydrate;
                        $fat = $fat + $Meal[$i]->fat;
                        array_push($result,  $Meal[$i]->unit ." ". $Meal[$i]->food);
                    }
                    else{
                        $i++;
                    }
                }else{
                    $i++;
                }
            }else{
                $i++;
            }
        }
        $details =[
            'besinler'=>$result,
            'degerler'=> ['protein'=>$protein, 'karbonhidrat'=>$carbohydrate,'yag'=>$fat],
            'protein_Kalori'=>$protein*4,
            'karbonhidrat_Kalori'=>$carbohydrate*4,
            'yag_Kalori'=>$fat*9,
            'toplam_kalori'=> ($fat *9) + ($protein *4) + ($carbohydrate *4),
        ];

        return $details;



    }

    public function CustomerMaxValueCalculate($kCal,$CustomerFat,$CustomerProtein,$CustomerCarbohydrate,$coefficient,$totalK){

        $MaxCalory = $kCal * $coefficient ;
        $MaxFat = ($CustomerFat / $totalK) * $coefficient;
        $MaxProtein = $CustomerProtein /$totalK *$coefficient;
        $MaxCarbohydrate = $CustomerCarbohydrate /$totalK * $coefficient ;

        return $CustomerMaxValueCalculateResult = [
            'MaxCalory'=>$MaxCalory,
            'MaxFat'=>$MaxFat,
            'MaxProtein'=>$MaxProtein,
            'MaxCarbohydrate'=>$MaxCarbohydrate
        ];

    }

    public function addItemModal(Request $request)
    {
        $selectedMeals = collect($request->selectedMeals);
        $meals =  Calorie::whereJsonContains('meal',$request->mealType)->get();
        return response()->json(['data'=>['meals'=>$meals,'selectMeals'=>$selectedMeals]]);
    }

}



