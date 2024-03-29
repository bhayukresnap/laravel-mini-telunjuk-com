<?php

namespace App\Http\Controllers\Main;
use App\Promotion;
use Carbon\Carbon;
use App\Http\Controllers\MainController;
use Illuminate\Http\Request;

class PromotionController extends MainController
{
    public function index(){
    	$current = Carbon::now();
    	$promotions = Promotion::where([
    		['started_at','<', $current],
    		['ended_at','>', $current],
    	])->get()->sortByDesc('id')->paginate(28);
    	return view('main.promo.index',['promotions'=>$promotions]);
    }
}
