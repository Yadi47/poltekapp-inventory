<?php

namespace App\Http\Controllers\Mrp;
use Illuminate\Support\Facades\Session;
use App\Models\Mrp\MrpCar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MrpCarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:vehicle-list', ['only' => ['index']]);
        $this->middleware('permission:vehicle-create', ['only' => ['create']]);
        $this->middleware('permission:vehicle-edit', ['only' => ['edit']]);
        $this->middleware('permission:vehicle-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data['page_title'] = 'Car List';
        $data['cars'] = MrpCar::orderBy('id','desc')->get();
        return view('mrp.cars.car-list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Car Create';
        return view('mrp.cars.car-create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_code' => 'required|max:255',
            'type' => 'required|max:255',
            'driver' => 'required|max:255',
            'description' => 'nullable|min:3'
        ]);
        try {
            MrpCar::create([
                'car_code' => $request->car_code,
                'type' => $request->type,
                'driver' => $request->driver,
                'description' => $request->description,
            ]);
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.car-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.car-list');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['page_title'] = 'Car Edit';
        $data['car'] = MrpCar::find($id);
        return view('mrp.cars.car-edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'car_code' => "required|max:255",
            'type' => 'required|max:255',
            'driver' => 'required|max:255',
            'description' => "nullable|min:3"
        ]);
        try {
            MrpCar::where('id',$id)->update([
                'car_code' => $request->car_code,
                'type' => $request->type,
                'driver' => $request->driver,
                'description' => $request->description

                
                ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success'); 
            return redirect()->route('mrp.car-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.car-list');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Session::flash('message', "Data $request->text Successfuly deleted !");
            Session::flash('alert-class', 'alert-success'); 
            MrpCar::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used');
            Session::flash('alert-class', 'alert-danger'); 
            //throw $th;
        }
    }
}
