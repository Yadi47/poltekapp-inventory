<?php

namespace App\Http\Controllers\Mrp;

use App\Http\Controllers\Controller;
use App\Models\Mrp\MrpBom;
use App\Models\Mrp\MrpCustomer;
use App\Models\Mrp\MrpPlanningProduction;
use App\Models\Mrp\MrpPlanningProductionProcess;
use App\Models\Mrp\MrpProcess;
use App\Models\Mrp\MrpProduct;
use App\Models\Mrp\MrpProduction;
// use App\Models\Mrp\MrpShift;
use App\Models\Mrp\MrpUnit;
use App\Models\Mrp\MrpPlanningProductionBom;
use App\Models\Mrp\MrpPlanningProductionProduct;
use Carbon\Carbon;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Process\Process;

class MrpPlanningProductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:planning-list', ['only' => ['index']]);
        $this->middleware('permission:planning-create', ['only' => ['create']]);
        $this->middleware('permission:planning-edit', ['only' => ['edit']]);
        $this->middleware('permission:planning-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['page_title'] = 'Planning List';
        $data['plannings'] = MrpPlanningProduction::orderBy('id', 'desc')->get();
        return view('mrp.production.plannings.planning-production-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Planning Create';
        $data['boms'] = MrpBom::get();
        $data['customers'] = MrpCustomer::get();
        $data['process'] = MrpProcess::get();
        $data['products'] = MrpProduct::get();
        $data['units'] = MrpUnit::get();
        // $data['shifts'] = MrpShift::get();
        return view('mrp.production.plannings.planning-production-create', $data);
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
            'plan_code' => 'required|max:255',
            'plan_name' => 'required|max:255',
            'array_bom_id' => 'nullable',
            // 'quantity' => 'required',
            'array_process_id' => 'nullable',
            'unit_id' => 'required',
            'customer_id' => 'required',
            'start_date' => 'required',
            'target_date' => 'required',
            'batch' => 'nullable',
            // 'finish_date' => 'required',
            // 'shift_id' => 'required',
            'description' => 'nullable',
            'array_product_id' => 'nullable',
        ],
    [
        'plan_code.required' => 'Planning Code Wajib Diisi!',
        'plan_name.required' => 'Planning Name Wajib Diisi!',
        'unit_id.required' => 'Unit Wajib Diisi!',
        'customer_id.required' => 'Customer Wajib Diisi!',
        'start_date.required' => 'Start Date Wajib Diisi!',
        'target_date.required' => 'Target Date Wajib Diisi!',
    ]);


        try {
            $start_date = new DateTime(date('Y/m/d', strtotime($request->start_date)));
            $end_date = new DateTime(date('Y/m/d', strtotime($request->target_date)));

            $start = strtotime($request->start_date);
            $end = strtotime($request->target_date);

            $count = 1;

            while (date('Y-m-d', $start) < date('Y-m-d', $end)) {
                $count += date('N', $start) < 6 ? 1 : 0;
                $start = strtotime("+1 day", $start);
            }

            $i = 1;
            $y = 0;

            DB::beginTransaction();
            // for ($day = clone $start_date; $day <= $end_date; $day->modify('+1 day')) {
                $planningProcess = MrpPlanningProduction::create([
                    'plan_code' => $request->plan_code ,
                    'plan_name' => $request->plan_name,
                    'bom_id' => $request->bom_id,
                    'plan_qty' => $request->array_plan_qty / $count,
                    'unit_id' => $request->unit_id,
                    // 'customer_id' => $request->customer_id,
                    'date' => date('Y-m-d', strtotime($request->start_date . $y . 'days')),
                    'start_date' => date('Y-m-d', strtotime($request->start_date)),
                    'target_date' => date('Y-m-d', strtotime($request->target_date)),
                    // 'finish_date' => date('Y-m-d', strtotime($request->finish_date)),
                    'batch' => $request->batch . '' . $i,
                    // 'shift_id' => $request->shift_id,
                    'product_id' => $request->product_id,
                    'description' => $request->description,
                ]);

                $pid = $planningProcess->id;
                $planningProcess->process()->attach($request->get('process_id'));
                $planningProcess->customers()->attach($request->get('customer_id'));

                // $i++;
                // $y++;


                // --- CREATE PIVOT PROCESS
                $productInsert = [];
                foreach ($request->array_process_id as $key => $value) {
                    if ($request->array_process_id[$key] != "") {
                        // $productInsert[] = ;
                        $params = [
                            'planning_production_id' => $pid,
                            'process_id' => $request->array_process_id[$key],
                        ];
                        array_push($productInsert, $params);

                    }
                }
                MrpPlanningProductionProcess::insert($productInsert);

                // --- CREATE PIVOT COMPOSISI
                // $planningBomInsert = [];
                // foreach ($request->array_bom_id as $key => $value) {
                //     if ($request->array_bom_id[$key] != "") {
                //         // $bomInsert[] = ;
                //         $params = [
                //             'planning_production_id' => $pid,
                //             'bom_id' => $request->array_bom_id[$key],
                //         ];
                //         array_push($planningBomInsert, $params);

                //     }
                // }
                // MrpPlanningProductionBom::insert($planningBomInsert);

                // --- CREATE PIVOT COMPOSISI
                $planningProductInsert = [];
                foreach ($request->array_product_id as $key => $value) {
                    if ($request->array_product_id[$key] != "") {
                        // $bomInsert[] = ;
                        $params = [
                            'planning_production_id' => $pid,
                            'product_id' => $request->array_product_id[$key],
                            'quantity' => $request->array_quantity[$key],
                            // 'quantity' => $request->array_quantity[$key] / $count,
                            'created_at' => Carbon::now(),
                        ];
                        array_push($planningProductInsert, $params);

                    }
                }
                MrpPlanningProductionProduct::insert($planningProductInsert);

            // }
            DB::commit();



            Session::flash('message', 'Data Successfuly created !');
            Session::flash('alert-class', 'alert-success'); //alert-success alert-warning alert-danger
            return redirect()->route('mrp.production.planning-list');

        } catch (\Throwable $th) {
            DB::rollback();
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('mrp.production.planning-list');
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
        $data['planning'] = MrpPlanningProduction::findOrFail($id);
        return view('mrp.production.plannings.planning-production-show', $data);
    }

    public function showProduct($id)
    {
        $data['planning'] = MrpPlanningProduction::findOrFail($id);
        $data['prod'] = $data['planning']->planningProductionProduct->map(function ($p){
            $v['part_name'] = $p->product->part_name;
            $v['part_number'] = $p->product->part_number;
            $v['bom_name'] = $p->product->bom->bom_name;
            $v['quantity'] = $p->quantity;

            return (object)$v;
        });
        return view('mrp.production.plannings.planning-production-product-show', $data);
    }

    public function showCustomer($id){
        $data['planning_customer'] = MrpPlanningProduction::find($id);
        return view('mrp.production.plannings.planning-production-customer-show', $data);

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['page_title'] = 'Planning Edit';
        $data['boms'] = MrpBom::get();
        $data['products'] = MrpProduct::get();
        // dd($data['products']);
        $data['customers'] = MrpCustomer::get();
        $data['process'] = MrpProcess::get();
        $data['units'] = MrpUnit::get();
        $data['planning_products'] = MrpPlanningProductionProduct::where('planning_production_id',$id)->get();
        // dd($data['planning_products'][0]->product);
        $data['planning'] = MrpPlanningProduction::find($id);
        // dd($data['planning']->planningProductionProduct);
        $data['planning_boms'] = MrpPlanningProductionBom::where('bom_id',$id)->get();
        // $plan = MrpPlanningProductionProduct::find($id);
        // dd($plan->product);
        return view('mrp.production.plannings.planning-production-edit', $data);
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
            'plan_code' => 'required|max:255',
            'plan_name' => 'required|max:255',
            // 'bom_id' => 'required',
            // 'plan_qty' => 'required',
            'process_id' => 'required',
            'unit_id' => 'required',
            'date' => 'nullable',
            // 'part_name' => 'nullable',
            // 'part_no' => 'nullable',
            'start_date' => 'required',
            'target_date' => 'required',
            // 'finish_date' => 'required',
            'description' => 'nullable',
        ],
    [
        'plan_code.required' => '*Planning Code Wajib Diisi!',
        'plan_name.required' => '*Planning Name Wajib Diisi!',
        'process_id.required' => '*Process Name Wajib Diisi!',
        'unit_id.required' => '*Unit Wajib Diisi!',
        'start_date.required' => '*Start Date Wajib Diisi!',
        'target_date.required' => '*Target Date Wajib Diisi!',
    ]);

        try {

            $planning = MrpPlanningProduction::findOrFail($id);
            $planning->update([
                'plan_code' => $request->plan_code,
                'plan_name' => $request->plan_name,
                // 'bom_id' => $request->bom_id,
                // 'plan_qty' => $request->plan_qty,
                // 'product_id' => $request->product_id,
                'unit_id' => $request->unit_id,
                'date' => $request->date,
                // 'part_name' => $request->part_name,
                // 'part_no' => $request->part_no,
                'start_date' => $request->start_date,
                'target_date' => $request->target_date,
                // 'finish_date' => $request->finish_date,
                'description' => $request->description,
            ],
        [
            'plan_code.required' => '*Planning Code Wajib Diisi!',
            'plan_name.required' => '*Planning Name Wajib Diisi!',
            'process_id.required' => '*Process Name Wajib Diisi!',
            'unit_id.required' => '*Unit Wajib Diisi!',
            'start_date.required' => '*Start Date Wajib Diisi!',
            'target_date.required' => '*Target Date Wajib Diisi!',
        ]);
            $pid = $planning->id;
            $planning->process()->sync($request->get('process_id'));
            $planning->customers()->attach($request->get('customer_id'));
            $planningProductInsert = [];

            $data = MrpPlanningProductionProduct::where('planning_production_id', $id);
            $data->delete();

            // --- CREATE PIVOT COMPOSISI
            foreach ($request->array_product_id as $key => $value) {
                if ($request->array_product_id[$key] != "") {
                    // $bomInsert[] = ;
                    $params = [
                        'planning_production_id' => $pid,
                        'product_id' => $request->array_product_id[$key],
                        'quantity' => $request->array_quantity[$key],
                        'updated_at' => Carbon::now(),

                    ];
                    array_push($planningProductInsert, $params);

                }
            }
            MrpPlanningProductionProduct::insert($planningProductInsert);

            Session::flash('message', 'Data Successfuly updated !');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('mrp.production.planning-list');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('mrp.production.planning-list');
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
            MrpPlanningProductionProcess::where('planning_production_id', $request->id)->update(['planning_production_id' => null]);
            MrpPlanningProductionProduct::where('planning_production_id', $request->id)->update(['planning_production_id' => null]);
            MrpPlanningProductionBom::where('planning_production_id', $request->id)->update(['planning_production_id' => null]);
            MrpProduction::where('planning_id', $request->id)->update(['planning_id' => null]);
            MrpPlanningProduction::destroy($request->id);
            return json_encode(['id' => $request->id]);
        } catch (\Throwable $th) {
            Session::flash('message', 'Failde Data Has Been Used');
            Session::flash('alert-class', 'alert-danger');
            //throw $th;
        }
    }

    public function getProductionPlanningById($id)
    {
        $planning = MrpPlanningProduction::where('id',$id)->with('process.processMachines')->first();

        $data['plan_qty'] = $planning->plan_qty;
        $data['planning_detail'] = $planning;
        // $data['bom_name'] = $planning->boms->bom_name;
        // $data['process'] = MrpProcess::find($id);
        $data['process'] = $planning->process;
        return $data;

    }

    public function changeConfirm($id, Request $request)
    {
        try {
            MrpPlanningProduction::find($id)->update(['status' => $request->confirm]);
            return "Sukses ";
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function ajaxProcess(Request $request)
    {
        // $pivot1 = MrpPlanningProductionProcess::where('planning_production_id', $request->planning_id)->get();
        $pivot2 = DB::table('mrp_planning_production_process')->where('planning_production_id', $request->planning_id)->pluck('process_id');
        // $data = MrpProcess::whereIn('id', [$pivot2->process_id])->get();
        $data = DB::table('mrp_process')->whereIn('id', $pivot2)->get();
        return response()->json([
            'process' => $data,
        ]);
    }

    public function ajaxBom(Request $request)
    {
        // $pivot1 = MrpPlanningProductionProcess::where('planning_production_id', $request->planning_id)->get();
        $pivot2 = DB::table('mrp_planning_production_boms')->where('planning_production_id', $request->bom_id)->pluck('bom_id');
        // $data = MrpProcess::whereIn('id', [$pivot2->process_id])->get();
        $data = DB::table('mrp_boms')->whereIn('id', $pivot2)->get();
        return response()->json([
            'boms' => $data,
        ]);
    }

    
}
