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
            $customer->numberOfMeals = $request->numberOfMeals;
            $customer->activity = 1.55;
            $customer->gender = $request->gender;
            $customer->food = $request->input('food');
            $customer->save();
            return redirect()->back()->with('success', 'Kaydınız başarılı en kısa sürede dönüş yapılacaktır');

        } catch (\Throwable $th) {
            return redirect()->back()->with('alert', 'Lütfen ilgili alanları, doğru ve eksiksiz doldurduğunuzdan emin olunuz!');
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


    public function ShowDietListForm(Request $request, $slug)
    {
        ini_set('max_execution_time', 240);

        //Model Değişkenleri
        $customer = Customer::where('slug', $slug)->first();

        //Request Değişkenleri
        $idealCalorie = $request->idealCalorie; // Liste Oluştururken ulaşılabilecek max kalori değeri

        $CustomerfoodIDs = collect($customer->food)->flatten();
        //$calories = Calorie::whereIn('id',$foodIDs)->get();
        $loopMax = 30000;
        $loop = 1;

        $calories2 = Calorie::all();

        /* //

         //data
         $arr = $calories2->pluck('carbohydrate')->toArray();
         $sum = 10.4;


         //get sum



         $result = $this->getKnapsackSum($arr, $sum);
         dd($result);



         //*/


        //Müşterinin Besinlerden alabilceği maximum Besin değerleridir
        $Customerfat = $idealCalorie * 0.75 / 9;
        $CustomerProtein = $customer->weight * 1.08;
        $CustomerCarbohydrate = 32;


        $hesaplamalar = array();

        if ($hesaplama = $this->hesapla($Customerfat, $CustomerProtein, $CustomerCarbohydrate)) {
            $hesaplamar[0]["degerler"] = $hesaplama;
            $hesaplamar[0]["sapma"] = ["yag" => $hesaplama["yag"] - $Customerfat, "protein" => $hesaplama["protein"] - $CustomerProtein, "karbon" => $hesaplama["karbon"] - $CustomerCarbohydrate];
            $topla = ($hesaplama["yag"] * 9) + ($hesaplama["karbon"] * 4) + ($hesaplama["protein"] * 4);


            while (!($topla > ($idealCalorie - 20) && $topla < ($idealCalorie + 20))) {
                if ($loop >= $loopMax) {
                    dd("deneme hakkı doldu");
                }
                $hesaplama = $this->hesapla($Customerfat, $CustomerProtein, $CustomerCarbohydrate);

                $topla = ($hesaplama["yag"] * 9) + ($hesaplama["karbon"] * 4) + ($hesaplama["protein"] * 4);

                $hesaplamar[$loop]["degerler"] = $hesaplama;
                $hesaplamar[$loop]["sapma"] = ["yag" => $hesaplama["yag"] - $Customerfat, "protein" => $hesaplama["protein"] - $CustomerProtein, "karbon" => $hesaplama["karbon"] - $CustomerCarbohydrate];

                $loop++;
            }
        }


        dd(
            " ideal Kalori :" . $idealCalorie,
            $topla, " Kalori Farkı : " . ($idealCalorie - $topla),
            $hesaplama,
            $hesaplamar,

        );


//        return view('back.pages.Customer.CreateDietList');

    }

    public function hesapla($CustomerFat, $CustomerProtein, $CustomerCarbohydrate)
    {
        $calories = Calorie::all();
        $calories = $calories->each(function ($item, $key) use ($calories) {
            for ($i = 1; $i < $item->max; $i++) {
                $calories->push($item);
            }
        })->shuffle();

        $yag = 0;
        $protein = 0;
        $karbon = 0;
        $i = 0;
        $dif = 5;


        while ($i < $calories->count()) {


            // 1 besin alındı
            // besinin yag degeri default yag degerinden kucukse ve
            // besinin yag degeri ve su ana kadar secilmis toplam yag degeri,
            // default deger + sapma payından kucukse
            while ($yag <= abs($CustomerFat) && $CustomerFat + $dif >= ($yag + $calories[$i]->fat)) {
                while ($protein <= abs($CustomerProtein) && $CustomerProtein + 3 >= ($protein + $calories[$i]->protein)) {
                    while ($karbon <= abs($CustomerCarbohydrate) && $CustomerCarbohydrate + 2 >= ($karbon + $calories[$i]->carbohydrate)) {
                        $yag = $yag + $calories[$i]->fat;
                        $protein = $protein + $calories[$i]->protein;
                        $karbon = $karbon + $calories[$i]->carbohydrate;
                        
                    }
                }
            }

        }


        return [
            'yag' => $yag,
            'karbon' => $karbon,
            'protein' => $protein,
            'food_list' => $selectedMeals
        ];
    }
}

// hesaplama Fonksiyonları
//    public function ShowDietListForm(Request $request, $slug)
//    {
//
//        //Model Değişkenleri
//        $customer = Customer::where('slug', $slug)->first();
//
//        //Request Değişkenleri
//        $idealWeight = $request->idealWeight;
//        $idealCalorie = $request->idealCalorie; // Liste Oluştururken ulaşılabilecek max kalori değeri
//
//        $loopMax = 30000;
//        $loop = 1;
//
//        $y1 = $idealCalorie * 0.75 / 9;
//        $p1 = $customer->weight * 1.08;
//        $k1 = 32;
//
//        $selectedMeals = array();
//
//        $CustomerfoodIds = collect($customer->food)->flatten();
//        $calori = Calorie::get()->flatten();
//        $deneme = $CustomerfoodIds->diff($calori)->flatten();
//
//        $MusteriSectigiBesinlerinId = collect($customer->food)->flatten();
//        $Besinler = Calorie::whereIn('id', $MusteriSectigiBesinlerinId)->get()->shuffle();
//
//
//            if ($hesaplama = $this->hesapla($y1, $p1, $k1)) {
//                $hesaplamar[0]['degerler'] = $hesaplama;
//                $hesaplamar[0]['sapma'] = ['yag' => $hesaplama['yag'] - $y1, 'protein' => $hesaplama['protein'] - $p1, 'karbon' => $hesaplama['karbon'] - $k1];
//                $topla = ($hesaplama['yag'] * 9) + ($hesaplama['karbon'] * 4) + ($hesaplama['protein'] * 4);
//                while (!($topla > $idealCalorie - 20 && $topla < $idealCalorie + 20)) {
//                    if ($loop > $loopMax) {
//                        dd('deneme hakkı doldu');
//                    }
//                    $hesaplama = $this->hesapla($y1, $p1, $k1);
//                    $topla = ($hesaplama['yag'] * 9) + ($hesaplama['karbon'] * 4) + ($hesaplama['protein'] * 4);
//                    $hesaplamar[$loop]['degerler'] = $hesaplama;
//                    $hesaplamar[$loop]['sapma'] = ['yag' => $hesaplama['yag'] - $y1, 'protein' => $hesaplama['protein'] - $p1, 'karbon' => $hesaplama['karbon'] - $k1];
//
//                    $loop++;
//                }
//            }
//
//
//            dd($topla, $hesaplama, $hesaplamar);
//
//
//        //        return view('back.pages.Customer.CreateDietList');
//
//    }
//
//    //hesaplama 2
//    public function hesapla($yagDefault, $proteinDefault, $karbonDefault)
//    {
//
//        $calories = Calorie::all();
//        $calories = $calories->each(function ($item, $key) use ($calories) {
//            for ($i = 1; $i < $item->max; $i++) {
//                $calories->push($item);
//            }
//        })->shuffle();
//
//
//        $yag = 0;
//        $protein = 0;
//        $karbon = 0;
//        $i = 0;
//
//        $dif = 5;
//
//
//        $selectedMeals = array();
//        foreach ($calories as $calory) {
//            if ($yag <= $yagDefault && $yagDefault + $dif >= ($yag + $calory->fat)) {
//                $yag = $yag + $calory->fat;
//                if ($protein <= $proteinDefault && $proteinDefault + 3 >= ($protein + $calory->protein)) {
//                    $protein = $protein + $calory->protein;
//                    if ($karbon <= $karbonDefault && $karbonDefault + 2 >= ($karbon + $calory->carbohydrate)) {
//                        $karbon = $karbon + $calory->carbohydrate;
//
//                    }
//                }
//            }
//
//        }
//
//        return [
//            'yag' => $yag,
//            'karbon' => $karbon,
//            'protein' => $protein,
//        ];
//    }
//
//}


//    public function ShowDietListForm(Request $request,$slug)
//    {
//
//        //Model Değişkenleri
//        $customer = Customer::where('slug', $slug)->first();
//
//        //Request Değişkenleri
//        $idealWeight = $request->idealWeight;
//        $idealCalorie = $request->idealCalorie; // Liste Oluştururken ulaşılabilecek max kalori değeri
//
//        $MusteriSectigiBesinlerinId = collect($customer->food)->flatten();
//        $Besinler = Calorie::whereIn('id',$MusteriSectigiBesinlerinId)->get()->shuffle();
//
//        $musteriMaxYag =$idealCalorie *0.75 / 9;
//        $musteriMaxProtein =$customer->weight * 1.08;
//        $musteriMaxKarbonhidrat =32;
//
//
//
//        foreach ($Besinler as $Besin){
//            if( (((($Besin->fat * $Besin->max * 9 ) <= $musteriMaxYag)) && (($musteriMaxYag +10 >= $Besin->carbohydrate * $Besin->max * 4)) ) &&
//                ((((($Besin->carbohydrate * $Besin->max * 4 ) <= $musteriMaxKarbonhidrat)) && (($musteriMaxKarbonhidrat +3 >= $Besin->carbohydrate * $Besin->max * 4)))) &&
//                ((((($Besin->protein * $Besin->max * 4 ) <= $musteriMaxProtein)) && (($musteriMaxProtein + 3 >= $Besin->protein * $Besin->max * 4))))
//            )
//            {
//                echo $Besin->food ."  " . $Besin->fat * $Besin->max * 9 . " " .$Besin->carbohydrate * $Besin->max * 4 . " ". $Besin->protein * $Besin->max * 4;
//                echo "<br>";
//            }
//        }
//
//
//        //        return view('back.pages.Customer.CreateDietList');
//    }}
