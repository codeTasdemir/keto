<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Calorie;
use Illuminate\Http\Request;

class CalorieController extends Controller
{

    public function index()
    {
        $calories = Calorie::get();
        return view('back.pages.Calorie.Calories',compact('calories'));
    }
    public function create()
    {
        return view('back.pages.Calorie.AddCalorie');
    }
    public function edit(Request $request ,$id)
    {
        $calorie = Calorie::find($id);
        return view('back.pages.Calorie.calorieEdit',compact('calorie'));
d
    }
    public function update(Request $request,$id)
    {
        try {
            $calorie = Calorie::find($id);
            $calorie->food = $request->food;
            $calorie->carbohydrate = $request->carbohydrate;
            $calorie->protein = $request->protein;
            $calorie->fat = $request->fat;
            $calorie->calorie = $request->calorie;
            $calorie->amount = $request->amount;
            $calorie->unit = $request->unit;
            $calorie->min = $request->min;
            $calorie->max = $request->max;
            $calorie->meal = $request->input('meal');
            $calorie->save();
            return redirect()->back()->with('success','Başarılı');
        }
        catch (\Throwable $th)
        {
            return redirect()->back()->with('alert','Güncelleme Yapılamadı');
        }

    }
    public function store(Request $request)
    {
        try {
            $calorie = new Calorie();
            $calorie->food = $request->food;
            $calorie->carbohydrate = $request->carbohydrate;
            $calorie->protein = $request->protein;
            $calorie->fat = $request->fat;
            $calorie->calorie = $request->calorie;
            $calorie->amount = $request->amount;
            $calorie->unit = $request->unit;
            $calorie->min = $request->min;
            $calorie->max = $request->max;
            $calorie->meal = $request->input('meal');
            $calorie->save();
            return redirect()->back()->with('success','Başarılı');

        }
        catch (\Throwable $th){
            return dd($th);

//            return redirect()->back()->with('alert','Bilgiler Eklenemedi !');
        }

    }
    public function delete($id)
    {
        try {
            Calorie::find($id)->delete();
            return redirect()->back()->with('success', 'Besin Silinmiştir');
        }
        catch (\Throwable $th)
        {
            return redirect()->back()->with('alert', 'Besin Silinemedi');
        }
    }
}
