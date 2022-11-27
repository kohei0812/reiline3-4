<?php

namespace App\Http\Controllers;

use App\Models\Reserve;
use App\Models\Driver;
use App\Models\Pattern;
use App\Models\Place;
use App\Models\Plan;
use App\Models\ReserveList;
use App\Models\Price;
use App\Models\Waiting;
use Illuminate\Http\Request;

class ReserveController extends Controller
{

    private $reserve;
    private $reserveList;
    private $waiting;
    private $driver;
    private $pattern;
    private $place;
    private $plan;
    private $price;
    public function __construct(Driver $driver,Pattern $pattern,Place $place,Plan $plan,Price $price,Reserve $reserve,ReserveList $reserveList,Waiting $waiting){
        $this->reserve = $reserve;
        $this->reserveList = $reserveList;
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
        $all_reserves = $this->reserve->paginate(20);
        return view('reserve.index')->with('all_reserves',$all_reserves);
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
        $date = $request->date;
        $plan = $request->plan;
        $driver = $request->driver;
        $reserve_exist =
            $this->reserve
            ->where('date',$date)
            ->where('plan',$plan)
            ->where('driver',$driver)
            ->exists();
            if($reserve_exist == false){
                $this->reserve->date = $request->date;
                $this->reserve->plan = $request->plan;
                $this->reserve->boat_num = $request->boat_num;
                $this->reserve->pattern = $request->pattern;
                $this->reserve->place = $request->place;
                $this->reserve->price = $request->price;
                $this->reserve->driver = $request->driver;
                $this->reserve->memo = $request->memo;
                $this->reserve->user_id = $request->user_id;
                $this->reserve->save();

              return 1;
              } else {
                return 0;
              }

    }
    public function waitStore(Request $request)
    {
        //

                $this->reserve->date = $request->date;
                $this->reserve->plan = $request->plan;
                $this->reserve->boat_num = $request->boat_num;
                $this->reserve->pattern = $request->pattern;
                $this->reserve->place = $request->place;
                $this->reserve->price = $request->price;
                $this->reserve->memo = $request->memo;
                $this->reserve->user_id = $request->user_id;
                $this->reserve->save();

              return 1;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reserve  $reserve
     * @return \Illuminate\Http\Response
     */
    public function show(Reserve $reserve)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reserve  $reserve
     * @return \Illuminate\Http\Response
     */
    public function edit(ReserveList $reserveList)
    {
        //
        $all_drivers = $this->driver->where('enable',1)->get();
        $all_patterns = $this->pattern->all();
        $all_places = $this->place->all();
        $all_plans = $this->plan->all();
        $all_prices = $this->price->all();

        return view('reserve.edit')
        ->with('all_drivers',$all_drivers)
        ->with('all_patterns',$all_patterns)
        ->with('all_places',$all_places)
        ->with('all_plans',$all_plans)
        ->with('all_prices',$all_prices)
        ->with('reserveList',$reserveList);
    }
    public function shipEdit(ReserveList $reserveList)
    {
        //
        $all_drivers = $this->driver->where('enable',1)->get();
        $all_patterns = $this->pattern->all();
        $all_places = $this->place->all();
        $all_plans = $this->plan->all();
        $all_prices = $this->price->all();

        return view('reserve.shipEdit')
        ->with('all_drivers',$all_drivers)
        ->with('all_patterns',$all_patterns)
        ->with('all_places',$all_places)
        ->with('all_plans',$all_plans)
        ->with('all_prices',$all_prices)
        ->with('reserveList',$reserveList);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reserve  $reserve
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReserveList $reserveList)
    {
        //

        $reserve_list_id = $reserveList->id;
        $this->reserveList
        ->where('id', $reserve_list_id)
        ->update(['place' => $request->place,'price' => $request->price,'memo' => $request->memo]);

        $this->reserve
        ->where('reserve_list_id', $reserve_list_id)
        ->update(['place' => $request->place,'price' => $request->price,'memo' => $request->memo]);
        return redirect('/user/'.$reserveList->user_id.'/reserve');
    }
    public function patternEdit(Request $request)
    {
        //

        $this->reserve
        ->where('id', $request->id)
        ->update(['pattern' => $request->pattern]);
        return 1;
    }

    public function driverEdit(Request $request)
    {
        //
        $date = $request->date;
        $plan = $request->plan;
        $driver = $request->driver;
        $id = $request->id;
        $reserve_exist =
            $this->reserve
            ->where('date',$date)
            ->where('plan',$plan)
            ->where('driver',$driver)
            ->exists();
            if($reserve_exist == false){
                $this->reserve
                ->where('id', $id)
                ->update(['driver' => $driver]);

              return 1;
              } else {
                return 0;
              }
    }
    public function shipDel(Request $request)
    {
        //
        $date = $request->date;
        $plan = $request->plan;
        $user_id = $request->user_id;
        $id = $request->id;

        $reserve_list_id =
        $this->reserve
        ->where('user_id', $user_id)
        ->where('plan', $plan)
        ->where('date', $date)
        ->where('status', 1)
        ->value('reserve_list_id');

        $this->reserve
        ->where('id', $id)
        ->delete();

        $reserves = $this->reserve
        ->where('user_id', $user_id)
        ->where('plan', $plan)
        ->where('date', $date)
        ->where('status', 1)
        ->get()->toArray();

        $boat_num = count($reserves);


        if($boat_num > 0){
        $reserves = $this->reserve
        ->where('user_id', $user_id)
        ->where('plan', $plan)
        ->where('date', $date)
        ->where('status', 1)
        ->update(['boat_num' => $boat_num]);

        $this->reserveList
        ->where('id', $reserve_list_id)
        ->update(['boat_num' => $boat_num]);
        }else{
         $this->reserveList
        ->where('id', $reserve_list_id)
        ->delete();
        }

    //繰り上がり処理

    if($plan == '一部'){
        $reserve_plan = 1;
    }else{
        $reserve_plan = 0;
    }
    $all_drivers = $this->driver->where('enable',1)->where('plan',$reserve_plan)->get();
        foreach($all_drivers as $driver){

            $driver_exist = $this->reserve
            ->where('date',$date)
            ->where('plan',$plan)
            ->where('driver',$driver->name)
            ->where('status',1)
            ->exists();
            $reserve_drivers[$driver->name] = $driver_exist;
        }

        $ava_drivers = array();
        $left_num =0;
        foreach($reserve_drivers as $key => $reserve_driver){
            if($reserve_driver == false){
                $ava_drivers[] = $key;
                $left_num ++;
            }
        }

        $waitings = $this->waiting
        ->where('date',$date)->where('plan',$plan)
        ->oldest()->get();

        if(!empty($waitings)){
        foreach($waitings as $waiting ){

            $all_drivers = $this->driver->where('enable',1)->where('plan',$reserve_plan)->get();
            foreach($all_drivers as $driver){

                $driver_exist = $this->reserve
                ->where('date',$date)
                ->where('plan',$plan)
                ->where('driver',$driver->name)
                ->where('status',1)
                ->exists();
                $reserve_drivers[$driver->name] = $driver_exist;
            }

            $ava_drivers = array();
            $left_num =0;
            foreach($reserve_drivers as $key => $reserve_driver){
                if($reserve_driver == false){
                    $ava_drivers[] = $key;
                    $left_num ++;
                }
            }

            if($left_num >= $waiting->boat_num){

                $new_reserve = $this->reserveList->create([
                    'date' => $waiting->date,
                    'plan' => $waiting->plan,
                    'boat_num' => $waiting->boat_num,
                    'place' => $waiting->place,
                    'price' => $waiting->price,
                    'memo' => $waiting->memo,
                    'user_id' => $waiting->user_id,
                ]);

                $reserve_list_id = $new_reserve->id;


                for ( $i = 0; $i < $waiting->boat_num; $i++) {
                    $this->reserve
                    ->latest()
                    ->where('waiting_id',$waiting->id)->where('status',2)
                    ->limit(1)
                    ->update(['waiting_id'=> '0','status' => 1,'reserve_list_id' => $reserve_list_id,'driver' =>$ava_drivers[$i]]);

                    }

            $this->waiting
            ->where('id',$waiting->id)
            ->delete();


        }
        }
        }
    //繰り上がり処理ここまで
    $date = $request->date;
    $plan = $request->plan;
    $user_id = $request->user_id;
    $id = $request->id;

    $reserve_list_id =
    $this->reserve
    ->where('user_id', $user_id)
    ->where('plan', $plan)
    ->where('date', $date)
    ->where('status', 1)
    ->value('reserve_list_id');

    return redirect('/reserve/'. $reserve_list_id.'/shipEdit');
        // return '船を削除しました。';


    }
    public function waitShipDel(Request $request)
    {
        //
        $date = $request->date;
        $plan = $request->plan;
        $user_id = $request->user_id;
        $id = $request->id;

        $waiting_id =
        $this->reserve
        ->where('user_id', $user_id)
        ->where('plan', $plan)
        ->where('date', $date)
        ->where('status', 2)
        ->value('waiting_id');

        $this->reserve
        ->where('id', $id)
        ->delete();

        $reserves = $this->reserve
        ->where('user_id', $user_id)
        ->where('plan', $plan)
        ->where('date', $date)
        ->where('status', 2)
        ->get()->toArray();

        $boat_num = count($reserves);


        if($boat_num > 0){
        $reserves = $this->reserve
        ->where('user_id', $user_id)
        ->where('plan', $plan)
        ->where('date', $date)
        ->where('status', 2)
        ->update(['boat_num' => $boat_num]);

        $this->waiting
        ->where('id', $waiting_id)
        ->update(['boat_num' => $boat_num]);
        }else{
         $this->waiting
        ->where('id', $waiting_id)
        ->delete();
        }
        return redirect('/waiting/'. $waiting_id.'/shipEdit');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reserve  $reserve
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReserveList $reserveList)
    {
        //
        $date = $reserveList->date;
        $plan = $reserveList->plan;
        $boat_num = $reserveList->boat_num;
        if($plan == '一部'){
            $reserve_plan = 1;
        }else{
            $reserve_plan = 0;
        }
        $this->reserve
        ->where('reserve_list_id', $reserveList->id)
        ->delete();
        $user_id = $reserveList->user_id;
        $reserveList->delete();

        $all_drivers = $this->driver->where('enable',1)->where('plan',$reserve_plan)->get();
        foreach($all_drivers as $driver){

            $driver_exist = $this->reserve
            ->where('date',$date)
            ->where('plan',$plan)
            ->where('driver',$driver->name)
            ->where('status',1)
            ->exists();
            $reserve_drivers[$driver->name] = $driver_exist;
        }

        $ava_drivers = array();
        $left_num =0;
        foreach($reserve_drivers as $key => $reserve_driver){
            if($reserve_driver == false){
                $ava_drivers[] = $key;
                $left_num ++;
            }
        }

        $waitings = $this->waiting
        ->where('date',$date)->where('plan',$plan)
        ->oldest()->get();

        if(!empty($waitings)){
        foreach($waitings as $waiting ){

            $all_drivers = $this->driver->where('enable',1)->where('plan',$reserve_plan)->get();
            foreach($all_drivers as $driver){

                $driver_exist = $this->reserve
                ->where('date',$date)
                ->where('plan',$plan)
                ->where('driver',$driver->name)
                ->where('status',1)
                ->exists();
                $reserve_drivers[$driver->name] = $driver_exist;
            }

            $ava_drivers = array();
            $left_num =0;
            foreach($reserve_drivers as $key => $reserve_driver){
                if($reserve_driver == false){
                    $ava_drivers[] = $key;
                    $left_num ++;
                }
            }

            if($left_num >= $waiting->boat_num){

                $new_reserve = $this->reserveList->create([
                    'date' => $waiting->date,
                    'plan' => $waiting->plan,
                    'boat_num' => $waiting->boat_num,
                    'place' => $waiting->place,
                    'price' => $waiting->price,
                    'memo' => $waiting->memo,
                    'user_id' => $waiting->user_id,
                ]);

                $reserve_list_id = $new_reserve->id;


                for ( $i = 0; $i < $waiting->boat_num; $i++) {
                    $this->reserve
                    ->latest()
                    ->where('waiting_id',$waiting->id)->where('status',2)
                    ->limit(1)
                    ->update(['waiting_id'=> '0','status' => 1,'reserve_list_id' => $reserve_list_id,'driver' =>$ava_drivers[$i]]);

                    }

            $this->waiting
            ->where('id',$waiting->id)
            ->delete();
        }
        }
        }
        return redirect('/user/'.$user_id.'/reserve');
    }
    public function determine(Request $request)
    {
        //
        $date = $request->date;
        $plan = $request->plan;
        $user_id = $request->user_id;
        $boat_num = $request->boat_num;
        if ($request->has('reserve')) {

            $this->reserveList->date = $request->date;
            $this->reserveList->plan = $request->plan;
            $this->reserveList->boat_num = $request->boat_num;
            $this->reserveList->place = $request->place;
            $this->reserveList->price = $request->price;
            $this->reserveList->memo = $request->memo;
            $this->reserveList->user_id = $request->user_id;
            $this->reserveList->save();

            $reserve_list_id = $this->reserveList
            ->where('date',$date)
            ->where('plan',$plan)
            ->where('boat_num',$boat_num)
            ->where('user_id',$user_id)
            ->value('id');

            for ( $i = 0; $i < $boat_num; $i++) {
            $this->reserve
            ->latest()
            ->where('date',$date)
            ->where('plan',$plan)
            ->where('user_id',$user_id)
            ->where('status','0')
            ->first()
            ->update(['status' => 1,'reserve_list_id' => $reserve_list_id]);
            }

            $this->reserve
            ->where('date',$date)
            ->where('plan',$plan)
            ->where('user_id',$user_id)
            ->where('status','0')
            ->delete();

            return redirect('/');

          }  elseif ($request->has('wait')) {

            $this->waiting->date = $request->date;
            $this->waiting->plan = $request->plan;
            $this->waiting->boat_num = $request->boat_num;
            $this->waiting->place = $request->place;
            $this->waiting->price = $request->price;
            $this->waiting->memo = $request->memo;
            $this->waiting->user_id = $request->user_id;
            $this->waiting->save();

            $waiting_id = $this->waiting
                ->where('date',$date)
                ->where('plan',$plan)
                ->where('boat_num',$boat_num)
                ->where('user_id',$user_id)
                ->value('id');

            for ( $i = 0; $i < $boat_num; $i++) {
                $this->reserve
                ->latest()
                ->where('date',$date)
                ->where('plan',$plan)
                ->where('user_id',$user_id)
                ->where('status','0')
                ->first()
                ->update(['status' => 2,'waiting_id' =>  $waiting_id]);
                }
                $this->reserve
                ->where('date',$date)
                ->where('plan',$plan)
                ->where('user_id',$user_id)
                ->where('status','0')
                ->delete();

                return redirect('/');
          } elseif ($request->has('delete')) {
            $this->reserve
            ->where('date',$date)
            ->where('plan',$plan)
            ->where('user_id',$user_id)
            ->where('status','0')
            ->delete();

            return redirect('/');
          } elseif ($request->has('ship_add')) {


            $reserve_list_id = $this->reserveList
            ->where('date',$date)
            ->where('plan',$plan)
            ->where('user_id',$user_id)
            ->value('id');

            for ( $i = 0; $i < $boat_num; $i++) {
            $this->reserve
            ->latest()
            ->where('date',$date)
            ->where('plan',$plan)
            ->where('user_id',$user_id)
            ->where('status','0')
            ->first()
            ->update(['status' => 1,'reserve_list_id' => $reserve_list_id]);
            }

            $total_reserves = $this->reserve
            ->where('reserve_list_id',$reserve_list_id)
            ->get()->toArray();
            $total_num = count($total_reserves);

            $this->reserve
            ->where('reserve_list_id',$reserve_list_id)
            ->update(['boat_num' => $total_num]);

            $this->reserveList
            ->where('id',$reserve_list_id)
            ->update(['boat_num' => $total_num]);

            $this->reserve
            ->where('date',$date)
            ->where('plan',$plan)
            ->where('user_id',$user_id)
            ->where('status','0')
            ->delete();
            return redirect('/user/'.$user_id.'/reserve');
          } elseif ($request->has('wait_ship_add')) {


            $waiting_id = $this->waiting
            ->where('date',$date)
            ->where('plan',$plan)
            ->where('user_id',$user_id)
            ->value('id');

            for ( $i = 0; $i < $boat_num; $i++) {
            $this->reserve
            ->latest()
            ->where('date',$date)
            ->where('plan',$plan)
            ->where('user_id',$user_id)
            ->where('status','0')
            ->first()
            ->update(['status' => 2,'waiting_id' => $waiting_id]);
            }

            $total_reserves = $this->reserve
            ->where('waiting_id',$waiting_id)
            ->get()->toArray();
            $total_num = count($total_reserves);

            $this->reserve
            ->where('waiting_id',$waiting_id)
            ->update(['boat_num' => $total_num]);

            $this->waiting
            ->where('id',$waiting_id)
            ->update(['boat_num' => $total_num]);

            $this->reserve
            ->where('date',$date)
            ->where('plan',$plan)
            ->where('user_id',$user_id)
            ->where('status','0')
            ->delete();
            return redirect('/user/'.$user_id.'/reserve');
          }


    }


}
