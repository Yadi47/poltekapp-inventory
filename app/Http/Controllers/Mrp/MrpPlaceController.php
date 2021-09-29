<?php

namespace App\Http\Controllers\Mrp;
use App\Models\Mrp\MrpPlace;
use App\Models\Mrp\Mrpemployee;
use App\Models\Mrp\MrpMachine;
use App\Imports\PlaceImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel; 
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class MrpPlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:place-list', ['only' => ['index']]);
        $this->middleware('permission:place-create', ['only' => ['create']]);
        $this->middleware('permission:place-edit', ['only' => ['edit']]);
        $this->middleware('permission:place-delete', ['only' => ['delete']]);

    }
    public function index()
    {
        $data['page_title'] = 'Place List';
        $data['places'] = MrpPlace::orderBy('id','desc')->get();
        return view('mrp.places.place-list',$data);
    }   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Place Create';
        return view('mrp.places.place-create',$data);
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
            'place_code' => 'required|max:255',
            'place_name' => 'required|max:255',
            'description' => 'nullable'
        ]);
        try {
            MrpPlace::create([
                'place_code' => $request->place_code,
                'place_name' => $request->place_name,
                'description' => $request->description,
            ]);
            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.place-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.place-list');
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
        $data['page_title'] = 'Place Edit';
        $data['place'] = MrpPlace::find($id);
        return view('mrp.places.place-edit',$data);
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
            'place_code' => "required|max:255",
            'place_name' => "required|max:255",
            'description' => "nullable"
        ]);
        try {
            MrpPlace::where('id',$id)->update([
                'place_code' => $request->place_code,
                'place_name' => $request->place_name,
                'description' => $request->description

                
                ]);
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success'); 
            return redirect()->route('mrp.place-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect()->route('mrp.place-list');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            Session::flash('message', "Data $request->text Successfuly deleted !");
            Session::flash('alert-class', 'alert-success'); 
            MrpEmployee::where('place_id', $request->id)->update(['place_id' => null]);
            MrpMachine::where('place_id', $request->id)->update(['place_id' => null]);
            MrpPlace::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used');
            Session::flash('alert-class', 'alert-danger'); 
            //throw $th;
        }
    }
    public function importPlace(Request $request)
    {
        if ($request->hasFile('import_file')) {
            try {
                Excel::import(new PlaceImport, $request->file('import_file')); 
                return back()->with(['success' => 'Import Place Success!']);
            } catch (\Throwable $th) {
                // dd($th);
                return back()->with(['failed' => $th->getMessage()]);
            }
        } 
    }

}
