<?php

namespace App\Http\Controllers;

use App\Models\Reserve;
use App\Models\Driver;
use App\Models\Pattern;
use App\Models\Place;
use App\Models\Plan;
use App\Models\Price;
use App\Models\Waiting;
use Illuminate\Http\Request;

class WaitingController extends Controller
{
    private $reserve;
    private $waiting;
    private $driver;
    private $pattern;
    private $place;
    private $plan;
    private $price;
    public function __construct(Driver $driver,Pattern $pattern,Place $place,Plan $plan,Price $price,Reserve $reserve,Waiting $waiting){
        $this->reserve = $reserve;
        $this->waiting = $waiting;
        $this->driver = $driver;
        $this->pattern = $pattern;
        $this->place = $place;
        $this->plan = $plan;
        $this->price = $price;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Waiting  $waiting
     * @return \Illuminate\Http\Response
     */
    public function show(Waiting $waiting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Waiting  $waiting
     * @return \Illuminate\Http\Response
     */
    public function edit(Waiting $waiting)
    {
        //
        $all_drivers = $this->driver->where('enable',1)->get();
        $all_patterns = $this->pattern->all();
        $all_places = $this->place->all();
        $all_plans = $this->plan->all();
        $all_prices = $this->price->all();

        return view('waiting.edit')
        ->with('all_drivers',$all_drivers)
        ->with('all_patterns',$all_patterns)
        ->with('all_places',$all_places)
        ->with('all_plans',$all_plans)
        ->with('all_prices',$all_prices)
        ->with('waiting',$waiting);
    }
    public function shipEdit(Waiting $waiting)
    {
        //
        $all_drivers = $this->driver->where('enable',1)->get();
        $all_patterns = $this->pattern->all();
        $all_places = $this->place->all();
        $all_plans = $this->plan->all();
        $all_prices = $this->price->all();

        return view('waiting.shipEdit')
        ->with('all_drivers',$all_drivers)
        ->with('all_patterns',$all_patterns)
        ->with('all_places',$all_places)
        ->with('all_plans',$all_plans)
        ->with('all_prices',$all_prices)
        ->with('waiting',$waiting);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Waiting  $waiting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Waiting $waiting)
    {
        //

        $waiting_id = $waiting->id;
        $this->waiting
        ->where('id', $waiting_id)
        ->update(['place' => $request->place,'price' => $request->price,'memo' => $request->memo]);

        $this->reserve
        ->where('waiting_id', $waiting_id)
        ->update(['place' => $request->place,'price' => $request->price,'memo' => $request->memo]);
        return redirect('/user/'.$waiting->user_id.'/reserve');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Waiting  $waiting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Waiting $waiting)
    {
        //
        $this->reserve
        ->where('waiting_id', $waiting->id)
        ->delete();
        $user_id = $waiting->user_id;
        $waiting->delete();

        return redirect('/user/'.$user_id.'/reserve');
    }
}
