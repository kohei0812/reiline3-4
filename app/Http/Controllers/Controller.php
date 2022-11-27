<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Driver;
use App\Models\Pattern;
use App\Models\Place;
use App\Models\Plan;
use App\Models\Price;
use App\Models\Reserve;
use App\Models\ReserveList;
use App\Models\Waiting;
use App\Models\User;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $driver;
    private $pattern;
    private $place;
    private $plan;
    private $price;
    private $reserve;
    private $reserveList;
    private $waiting;

    public function __construct(Driver $driver,Pattern $pattern,Place $place,Plan $plan,Price $price,Reserve $reserve,ReserveList $reserveList,Waiting $waiting){
        $this->driver = $driver;
        $this->pattern = $pattern;
        $this->place = $place;
        $this->plan = $plan;
        $this->price = $price;
        $this->reserve = $reserve;
        $this->reserveList = $reserveList;
        $this->waiting = $waiting;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $all_drivers = $this->driver->where('enable',1)->get();
        $all_patterns = $this->pattern->all();
        $all_places = $this->place->all();
        $all_plans = $this->plan->all();
        $all_prices = $this->price->all();
        $all_reserves = $this->reserve->all();
        return view('top')
        ->with('all_drivers',$all_drivers)
        ->with('all_patterns',$all_patterns)
        ->with('all_places',$all_places)
        ->with('all_plans',$all_plans)
        ->with('all_prices',$all_prices)
        ->with('all_reserves',$all_reserves);
    }

    public function dsearch(Request $request)
    {
        //
        $reserve_drivers = array();
        $all_drivers = $this->driver->where('enable',1)->get();
        $date = $request->reserve_date;
        $plan = $request->reserve_plan;

        foreach($all_drivers as $driver){
            $reserve_drivers[] =
            $this->reserve
            ->where('date',$date)
            ->where('plan',$plan)
            ->where('driver',$driver->name)
            ->where('status',1)
            ->exists();
        }

      return $reserve_drivers;

    }
    public function rsearch(Request $request)
    {
        //
        $result = array();
        $plan1_drivers = $this->driver->where('enable',1)->where('plan',1)->get();
        $plan2_drivers = $this->driver->where('enable',1)->where('plan',0)->get();
        $date = $request->date;
        $plan_1 = $request->plan_1;
        $plan_2 = $request->plan_2;
        $month =  date('Y-m', strtotime($date));
        $firstDate = date('Y-m-d', strtotime('first day of ' . $month));
        $lastDate = date('Y-m-d', strtotime('last day of ' . $month));

        $reserve_data_1 = $this->reserve
        ->whereBetween('date',[$firstDate,  $lastDate])
        ->where('date',$date)
        ->where('plan',$plan_1)
        ->where('status',1)
        ->get()->toArray();

        $reserve_data_2 = $this->reserve
        ->whereBetween('date',[$firstDate,  $lastDate])
        ->where('date',$date)
        ->where('plan',$plan_2)
        ->where('status',1)
        ->get()->toArray();

        $waiting_data_1 = $this->waiting
        ->whereBetween('date',[$firstDate,  $lastDate])
        ->where('date',$date)
        ->where('plan',$plan_1)
        ->get()->toArray();

        $waiting_data_2 = $this->waiting
        ->whereBetween('date',[$firstDate,  $lastDate])
        ->where('date',$date)
        ->where('plan',$plan_2)
        ->get()->toArray();

        $result[] = count($plan1_drivers) - count($reserve_data_1);
        $result[] = count($plan2_drivers) - count($reserve_data_2);
        $result[] = count($waiting_data_1);
        $result[] = count($waiting_data_2);
        // $test = array( $month,$firstDate,$lastDate);
      return $result;
    //   return $test;

    }

    public function add_ship(Request $request)
    {
        //
        $this->reserve->date = $request->date;
        $this->reserve->plan = $request->plan;
        $this->reserve->pattern = $request->pattern;
        $this->reserve->place = $request->place;
        $this->reserve->driver = $request->driver;
        $this->reserve->memo = $request->memo;
        $this->reserve->user_id = $request->user_id;
        $this->reserve->save();

        $reserve_drivers = array();
        $all_drivers = $this->driver->where('enable',1)->get();
        $date = $request->date;
        $plan = $request->plan;

        foreach($all_drivers as $driver){
            $reserve_drivers[] =
            $this->reserve
            ->where('date',$date)
            ->where('plan',$plan)
            ->where('driver',$driver->name)
            ->exists();
        }

      return $reserve_drivers;

    }
}
