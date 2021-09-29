<?php

namespace App\Http\Controllers\Mrp;

use Illuminate\Support\Facades\Session;
use App\Models\Mrp\MrpProcess;
use App\Models\Mrp\MrpBom;
use App\Models\Mrp\MrpShift;
use App\Models\Mrp\MrpCounterMeasure;
use App\Models\Mrp\MrpProblem;
use App\Models\Mrp\MrpProduct;
use App\Models\Mrp\MrpInventoryProductList;
use App\Models\Mrp\MrpInventoryMaterialList;
use App\Models\Mrp\MrpProduction;
use App\Models\Mrp\MrpProductionProcess;
use App\Models\Mrp\MrpPlanningProduction;
use App\Models\Mrp\MrpPlanningProductionProcess;
use App\Models\Mrp\MrpPlanningProductionProduct;
use App\Models\Mrp\MrpMachine;
use App\Http\Controllers\Controller;
use App\Models\Mrp\MrpProductionProcessAndMachine;
use App\Models\Mrp\MrpProductionProcessMachineProduct;
use App\Models\Mrp\MrpWipProcess;
use CreateOeePlcValues;
use Illuminate\Http\Request;
use DB;
use DateTime;

class MrpProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:production-list', ['only' => ['index']]);
        $this->middleware('permission:production-create', ['only' => ['create']]);
        $this->middleware('permission:production-edit', ['only' => ['edit']]);
        $this->middleware('permission:production-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        // $dataWip = MrpWipProcess::with('ProcessMachineProduct.product')
        // ->select('product_name', \DB::raw('product_name as product_name'))
        // ->groupBy('product_name')
        // ->get();


        $getByProduct= MrpWipProcess::with('ProcessMachineProduct.product')
        ->get()
        ->groupBy('ProcessMachineProduct.product.product_name')
        ->all();

        $getByMachine = MrpWipProcess::with('ProcessMachineProduct.product')
        ->get()
        ->groupBy('ProcessMachineProduct.machine.machine_name')
        ->all();

        $getByProcess = MrpWipProcess::with('ProcessMachineProduct.product')
        ->get()
        ->groupBy('ProcessMachineProduct.process.process_name')
        ->all();

        $getByShift = MrpWipProcess::with('ProcessMachineProduct.product')
        ->get()
        ->groupBy('shift_id')
        ->all();
        $dataWip = array_map(function($d)use($getByMachine,$getByProcess) {
            $data = [];
            foreach ($d as $v) {
                foreach ($getByMachine as $key => $value) {
                    if ($v->ProcessMachineProduct->machine->machine_name === $key) {
                        $data[$key] =[];
                            foreach ($getByProcess as $key2 => $value2) {
                                $data[$key][$key2] = [];
                                // array_push($data[$key][$key2],$d);
                            }
                    }
                }
            }
            return $data;
        },$getByProduct);
        
        

        // dd($dataWip);

        // -- ambil stock in product
        // $machineProcess = MrpProductionProcessMachineProduct::where('product_id', 3)->get();
        // $productiStockIn = 0;
        // foreach ($machineProcess as $key => $value) {
        //     $productiStockIn += $value->ProductInWip->sum('qty_good');
        // }
        // // dd($productiStockIn);
        // return $productiStockIn;

        $data['page_title'] = 'Production List';
        $data['productions'] = MrpProduction::orderBy('id', 'desc')->get();
        $data['process'] = MrpProcess::get();
        return view('mrp.production.productions.production-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Production Create';
        $data['process'] = MrpProcess::get();
        $data['shifts'] = MrpShift::get();
        $data['boms'] = MrpBom::get();
        $data['counter_measures'] = MrpCounterMeasure::get();
        $data['problems'] = MrpProblem::get();
        $data['products'] = MrpProduct::get();
        $data['process'] = MrpProcess::get();
        $data['plannings'] = MrpPlanningProduction::get();
        $data['planning_process'] = MrpPlanningProductionProcess::get();
        $data['planning_products'] = MrpPlanningProductionProduct::get();
        // dd($data['planning_products']);
        // dd($data['planning_process']->boms);
        $data['machines'] = MrpMachine::get();
        return view('mrp.production.productions.production-create', $data);
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
            'production_code' => 'required|unique:mrp_productions|max:255',
            'production_name' => 'required',
            // 'qty_plan' => 'required',
            // 'qty_entry' => 'required',
            // 'qty_reject' => 'required',     
            // 'qty_good' => 'required',
            'date_start' => 'required',
            'date_finish' => 'required',
            'recovery_plan' => 'required',
            // 'shift_id' => 'required',
            'planning_id' => 'required',
            // 'bom_id' => 'required',
            // 'product_id' => 'required',
            'target_defect_rate' => 'required',
            'target_effeciency' => 'required',
        ]);


        try {
            DB::beginTransaction();
            $dataPlanning = MrpPlanningProduction::find($request->planning_id);
            $dataInsert = [
                'production_code' => $request->production_code,
                'production_name' => $request->production_name,
                'date_start' => date('Y-m-d', strtotime($request->date_start)),
                'date_finish' => date('Y-m-d', strtotime($request->date_finish)),
                'planning_id' => $request->planning_id,
                'target_defect_rate' => $request->target_defect_rate,
                'target_effeciency' => $request->target_effeciency,
                'recovery_plan' => $request->recovery_plan,
            ];
            $productionId = MrpProduction::create($dataInsert)->id;
 
            $process = [];
            foreach ($request->product as $key => $value) {
                $d = explode('_', $key);
                $e['production_id'] = $productionId;
                $e['process_id'] = $d[0];
                $e['machine_id'] = $d[1];
                foreach ($value as $value) {
                    # code...
                    $e['product_id'] = $value;
                    array_push($process, $e);
                }
            }
            MrpProductionProcessMachineProduct::insert($process);
            DB::commit();

            Session::flash('message', 'Data Successfuly Created !');
            Session::flash('alert-class', 'alert-success'); 
            return redirect()->route('mrp.production.production-list');


        } catch (\Throwable $th) {
            throw $th;
            DB::rollback();
        }
        




        dd($process);
        dd($request->all());

         

            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $data['page_title'] = 'Production Create';

        $production = MrpProduction::find($id);
        $productionProcessMachine = $production->productionProcessMachineProduct;

        $shifts = MrpShift::get();
        $begin = new DateTime($production->date_start);
        $end   = new DateTime($production->date_finish);
        $dateListHeader = [];
        $dateList = [];
        for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
            array_push($dateList,$i->format("Y-m-d"));
            array_push($dateListHeader,$i->format("d"));
        }

        $listProcessProduct = [];
        foreach ($productionProcessMachine as $key => $value) {
            $productWip =[];
            $dwip = [
                'from_wip'=>[],
                'from_oee'=>[],
            ];

            if(!array_key_exists($value->process->process_name, $listProcessProduct)){
                $listProcessProduct[$value->process->process_name] = [];
            }

            if (!array_key_exists($value->machine->machine_name, $listProcessProduct[$value->process->process_name])) {
                $listProcessProduct[$value->process->process_name][$value->machine->machine_name] = [];
            }
            
            // --- get untuk product plan dari planning products
            try {
                //code...
                $planAll = $production->planning->oneProduct($production->planning->id, $value->product->id)->first()->pivot->quantity;
            } catch (\Throwable $th) {
                //throw $th;
                $planAll = 0;
            }
          
            foreach ($dateList as $dl) {
                
                $dataWips = MrpWipProcess::where('date',$dl)->where('mrp_production_process_machine_product_id', $value->id)->orderBy('id','desc')->get();
                $dataProcess = [];
                if ($dataWips->count()>0) {
                    foreach ($dataWips as $dwp) {
                        $dp = [];
                        $dp['date'] = $dl;
                        $dp['shift_id'] = optional($dwp)->shift_id;
                        $dp['qty_plan'] = ($dwp->qty_plan > 0) ? $dwp->qty_plan : $planAll;
                        $dp['qty_total'] = optional($dwp)->qty_total;
                        $dp['qty_good'] = optional($dwp)->qty_good;
                        $dp['qty_reject'] = optional($dwp)->qty_reject;
                        $dp['type'] = optional($dwp)->type;
                        array_push($dataProcess, $dp);
                    }
                }else{
                    $dp = [];
                    $dp['date'] = $dl;
                    $dp['shift_id'] = '-';
                    $dp['qty_plan'] = $planAll;
                    $dp['qty_total'] = '-';
                    $dp['qty_good'] = '-';
                    $dp['qty_reject'] = '-';
                    $dp['type'] = '-';
                    array_push($dataProcess, $dp);
                }

                // --- dari OEE PLC
                $dataProcessOEE = [];
                foreach ($shifts as $shift) {
                    $dateFrom = $dl;
                    $dateTo = $dl;

                    if($shift->over_night == 'true'){
                        $dateTo = date('Y-m-d', strtotime($dl . "+1 days"));
                    }

                    $realOee = DB::table('oee_plc_values')
                        ->where('device', $value->machine->machine_code)
                        ->where('datetime', '>=', $dateFrom .' '.$shift->time_from.':00')
                        ->where('datetime', '<=', $dateTo .' '.$shift->time_to.':00')
                        ->orderBy('datetime', 'desc')
                        ->first();

                    // $realOee = false;
                        
                        if($realOee){
                            
                            $dpo = [];
                            $dpo['date'] = $dl;
                            $dpo['shift_id'] = $shift->id;
                            $dpo['qty_plan'] = $planAll;
                            $dpo['qty_total'] = $realOee->productionquantity;
                            $dpo['qty_good'] = $realOee->passquantity;
                            $dpo['qty_reject'] = $realOee->failquantity;
                            array_push($dataProcessOEE, $dpo);

                        }else{
                            $dpo = [];
                            $dpo['date'] = $dl;
                            $dpo['shift_id'] = '-';
                            $dpo['qty_plan'] = $planAll;
                            $dpo['qty_total'] = '-';
                            $dpo['qty_good'] = '-';
                            $dpo['qty_reject'] = '-'; 
                            array_push($dataProcessOEE, $dpo);

                        }

                }
                
                

                array_push($dwip['from_wip'],$dataProcess);
                array_push($dwip['from_oee'], $dataProcessOEE);
                
                
                
            }


            $productWip[$value->product->product_name] = $dwip;
            
            array_push($listProcessProduct[$value->process->process_name][$value->machine->machine_name],$productWip);
        }



        // dd($listProcessProduct);

        $data['production'] = $production;
        $data['products'] = MrpProduct::get();
        $data['boms'] = MrpBom::get();
        $data['list_process'] = $listProcessProduct;
        $data['shifts'] = $shifts;
        $data['production_process_machine'] =$production->productionProcessMachineProduct;
        $data['date_list_header'] = $dateListHeader;

        


        return view('mrp.production.productions.production-detail', $data);

    }

    public function wipSave(Request $request,$id){

        if ($id == 0) {
            $id = $request->processId;
        }
        $dataInsert = [
            'mrp_production_process_machine_product_id'=>$id,
            'shift_id'=>$request->shift_id,
            'date'=>$request->date,
            'qty_plan'=>$request->qty_plan,
            'qty_total'=>$request->qty_total,
            'qty_good'=>$request->qty_good,
            'qty_reject'=>$request->qty_reject,
            'qty_recovery_plan'=>$request->qty_recovery_plan,
            'type'=>$request->type,
            'bom_id'=>$request->bom_id,
        ];

       

        try {
            DB::beginTransaction();
            $wipLama = MrpWipProcess::where('mrp_production_process_machine_product_id', $id)
                ->where('shift_id', $request->shift_id)
                ->where('date', $request->date);

            if ($wipLama->get()->count() > 0) {
                $wipLama->update($dataInsert);
            } else {
                MrpWipProcess::create($dataInsert);
            }
            DB::commit();
            Session::flash('message', 'Data Successfuly Saved ! <a href="#report_detail"> See Details</a> ');
            Session::flash('alert-class', 'alert-success');
            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
            DB::rollback();
        }
        


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

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
            'production_code' => "required|max:255|unique:mrp_productions,production_code,$id",
            'production_name' => 'required',
            'qty_plan' => 'nullable',
            'qty_entry' => 'required',
            'qty_reject' => 'required',
            'qty_good' => 'required',
            'date_start' => 'required',
            'date_finish' => 'required',
            'recovery_plan' => 'required',
            'planning_id' => 'required',
            'product_id' => 'required',
            'machine_id' => 'required',
            'bom_id' => 'nullable',
            'shift_id' => 'required',
            'problem_id' => 'required',
            'target_defect_rate' => 'required',
            'target_effeciency' => 'required',
            
        ]);
        try {
            $production = MrpProduction::FindOrFail($id);
            $production->update([
                'production_code' => $request->production_code,
                'production_name' => $request->production_name,
                'qty_plan' => $request->qty_plan,
                'qty_entry' => $request->qty_entry,
                'qty_reject' => $request->qty_reject,
                'qty_good' => $request->qty_good,
                'recovery_plan' => $request->recovery_plan,
                'date_start' => date('Y-m-d', strtotime($request->date_start)),
                'date_finish' => date('Y-m-d', strtotime($request->date_finish)),
                'product_id' => $request->product_id,
                'machine_id' => $request->machine_id,
                'bom_id' => $request->bom_id,
                'planning_id' => $request->planning_id,
                'shift_id' => $request->shift_id,
                'problem_id' => $request->problem_id,
                'created_at' => $request->created_at,
                'target_defect_rate' => $request->target_defect_rate,
                'target_effeciency' => $request->target_effeciency,

                ]);
                DB::table('mrp_production_process')->where('production_id', $id)->where('process_id', $request->get('process_id'))->update(
                    ['qty_entry' => $request->qty_entry,'qty_reject' => $request->qty_reject, 'qty_good' =>$request->qty_good,'qty_receive_oee' =>$request->qty_receive_oee,'qty_reject_oee' =>$request->qty_reject_oee,'qty_good_oee' =>$request->qty_good_oee],
                );
            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('mrp.production.production-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('mrp.production.production-list');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function entry($id)
    {
        $data['page_title'] = 'Production Entry WIP';

        $data['productions'] = MrpProduction::find($id);
        $planning_id = MrpProduction::find($id);
        $data['problems'] = MrpProblem::get();
        $data['shifts'] = MrpShift::get();
        $data['process'] = MrpProcess::get();
        $data['products'] = MrpProduct::get();
        $data['machines'] = MrpMachine::get();
        $data['plannings'] = MrpPlanningProduction::get();
        $data['counter_measures'] = MrpCounterMeasure::get();
        $data['planning_process'] = MrpPlanningProductionProcess::get();
        $data['production_process'] = MrpProductionProcess::get();

        $get_oee_shift = MrpShift::find($data['productions']->shift_id);
        $get_oee_start_date = $data['productions']->date_start.' '.$get_oee_shift->time_from.':00';
        $get_oee_end_date = $data['productions']->date_finish.' '.$get_oee_shift->time_to.':00';

        $totalGood = 0;
        $totalReject = 0;
        $totalReceive = 0;
        $date_machines = [];
            //code...
            foreach ($data['productions']->process as $key => $p) {
                $dataOeeValue = DB::table('oee_plc_values')->
                select(DB::raw('max(id),
                max(datetime) as datetime,
                max(productionquantity) as receive,
                max(passquantity) as good,
                max(failquantity) as reject,
                max(device)'))
                
                    ->where('datetime','>=',$get_oee_start_date)
                    ->where('datetime','<=',$get_oee_end_date)
                    ->where('device',$p->process_code)
                    ->groupBy('device')
                    ->first();
                    $totalGood += optional($dataOeeValue)->good;
                    $totalReject += optional($dataOeeValue)->reject;
                    $totalReceive += optional($dataOeeValue)->receive;
    
                $val['process_name'] = $p->process_name;
                $val['receive'] = optional($dataOeeValue)->receive;
                $val['good'] = optional($dataOeeValue)->good;
                $val['reject'] = optional($dataOeeValue)->reject;
                array_push($date_machines,(object)$val);
            };

            $data['process_wip'] = (object)$date_machines; 
            $data['total_good']  = $totalGood; 
            $data['total_reject']  = $totalReject; 
            $data['total_receive']  = $totalReceive; 
            

        $pivot2 = DB::table('mrp_planning_production_process')->where('planning_production_id', $planning_id->planning_id)->pluck('process_id');
        $data['production_process'] = DB::table('mrp_process')->whereIn('id', $pivot2)->get();
        return view('mrp.production.productions.production-entry', $data);
    }


    public function destroy(Request $request)
    {
        try {
            Session::flash('message', "Data $request->text Successfuly deleted !");
            Session::flash('alert-class', 'alert-success');
            MrpProductionProcess::where('production_id', $request->id)->delete();
            MrpProductionProcessMachineProduct::where('production_id', $request->id)->delete();
            MrpProduction::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failed Data,This Data Has Been Used '.$th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            //throw $th;
        }
    }

    public function getProductionProcessById($id)
    {
        $data = MrpProcess::Find($id);
        return $data;
    }

    public function ajaxProduct(Request $request){
        // $pivot1 = MrpPlanningProductionProcess::where('planning_production_id', $request->planning_id)->get();
        $pivot2 = DB::table('mrp_planning_production_products')->where('planning_production_id', $request->planning_id)->pluck('product_id');
        // $data = MrpProcess::whereIn('id', [$pivot2->process_id])->get();
        $data = DB::table('mrp_products')->whereIn('id', $pivot2)->get();
        return response()->json([
            'product' => $data
        ]);
    }

    public function ajaxBom(Request $request)
    {
        // $pivot1 = MrpPlanningProductionProcess::where('planning_production_id', $request->planning_id)->get();
        $pivot2 = DB::table('mrp_planning_production_boms')->where('planning_production_id', $request->planning_id)->pluck('bom_id');
        // $data = MrpProcess::whereIn('id', [$pivot2->process_id])->get();
        $data = DB::table('mrp_boms')->whereIn('id', $pivot2)->get();
        return response()->json([
            'bom' => $data
        ]);
    }


    public function ajaxQuantity(Request $request)
    {
        // $pivot1 = MrpPlanningProductionProcess::where('planning_production_id', $request->planning_id)->get();
        // $pivot2 = DB::table('mrp_planning_production_products')->where('planning_production_id', $request->planning_id)->pluck('quantity');
        // $data = MrpProcess::whereIn('id', [$pivot2->process_id])->get();
        $data = DB::table('mrp_planning_production_products')->get();
        return response()->json([
            'quantity' => $data
        ]);
    }

    

}
