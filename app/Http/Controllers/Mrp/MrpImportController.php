<?php

namespace App\Http\Controllers\Mrp;

use App\Imports\PlaceImport;
use App\Imports\EmployeeImport;
use App\Imports\CustomerImport;
use App\Imports\SupplierImport;
use App\Imports\UnitImport;
use App\Imports\MaterialImport;
use App\Imports\MachineImport;
use App\Imports\BomImport;
use App\Imports\ProcessImport;
use App\Imports\ProductImport;
use App\Imports\InventoryMaterialImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MrpImportController extends Controller
{
    // place
    public function importFilePlace(Request $request)
    {
        if ($request->hasFile('import_file')) {
            try {
                Excel::import(new PlaceImport, $request->file('import_file'));
                return back()->with(['success' => 'Import Place Success!']);
            } catch (\Throwable $th) {
                dd($th);
                return back()->with(['failed' => $th->getMessage()]);
            }
        }

        return back()->with(['failed' => 'Please Check your file, Something is wrong there.']);
    }

    // employee
    public function importFileEmployee(Request $request)
    {
        if ($request->hasFile('import_file')) {
            try {
                Excel::import(new EmployeeImport, $request->file('import_file'));
                return back()->with(['success' => 'Import Employee Success!']);
            } catch (\Throwable $th) {
                dd($th);
                return back()->with(['failed' => $th->getMessage()]);
            }
        }

        return back()->with(['failed' => 'Please Check your file, Something is wrong there.']);
    }

    // customer
    public function importFileCustomer(Request $request)
    {
        if ($request->hasFile('import_file')) {
            try {
                Excel::import(new CustomerImport, $request->file('import_file'));
                return back()->with(['success' => 'Import Customer Success!']);
            } catch (\Throwable $th) {
                dd($th);
                return back()->with(['failed' => $th->getMessage()]);
            }
        }

        return back()->with(['failed' => 'Please Check your file, Something is wrong there.']);
    }

    // supplier
    public function importFileSupplier(Request $request)
    {
        if ($request->hasFile('import_file')) {
            try {
                Excel::import(new SupplierImport, $request->file('import_file'));
                return back()->with(['success' => 'Import Supplier Success!']);
            } catch (\Throwable $th) {
                dd($th);
                return back()->with(['failed' => $th->getMessage()]);
            }
        }

        return back()->with(['failed' => 'Please Check your file, Something is wrong there.']);
    }


    // unit
    public function importFileUnit(Request $request)
    {
        if ($request->hasFile('import_file')) {
            try {
                Excel::import(new UnitImport, $request->file('import_file'));
                return back()->with(['success' => 'Import Unit Success!']);
            } catch (\Throwable $th) {
                dd($th);
                return back()->with(['failed' => $th->getMessage()]);
            }
        }

        return back()->with(['failed' => 'Please Check your file, Something is wrong there.']);
    }

    // material
    public function importFileMaterial(Request $request)
    {
        if ($request->hasFile('import_file')) {
            try {
                Excel::import(new MaterialImport, $request->file('import_file'));
                return back()->with(['success' => 'Import Material Success!']);
            } catch (\Throwable $th) {
                dd($th);
                return back()->with(['failed' => $th->getMessage()]);
            }
        }

        return back()->with(['failed' => 'Please Check your file, Something is wrong there.']);
    }

    // machine
    public function importFileMachine(Request $request)
    {
        if ($request->hasFile('import_file')) {
            try {
                Excel::import(new MachineImport, $request->file('import_file'));
                return back()->with(['success' => 'Import Material Success!']);
            } catch (\Throwable $th) {
                dd($th);
                return back()->with(['failed' => $th->getMessage()]);
            }
        }

        return back()->with(['failed' => 'Please Check your file, Something is wrong there.']);
    }

    // bom
    public function importFileBom(Request $request)
    {
        if ($request->hasFile('import_file')) {
            try {
                Excel::import(new BomImport, $request->file('import_file'));
                return back()->with(['success' => 'Import Bom Success!']);
            } catch (\Throwable $th) {
                dd($th);
                return back()->with(['failed' => $th->getMessage()]);
            }
        }

        return back()->with(['failed' => 'Please Check your file, Something is wrong there.']);
    }

    // inventory material
    public function importFileInventoryMaterial(Request $request)
    {
        if ($request->hasFile('import_file')) {
            try {
                Excel::import(new InventoryMaterialImport, $request->file('import_file'));
                return back()->with(['success' => 'Import Bom Success!']);
            } catch (\Throwable $th) {
                dd($th);
                return back()->with(['failed' => $th->getMessage()]);
            }
        }

        return back()->with(['failed' => 'Please Check your file, Something is wrong there.']);
    }

     // problem
     public function importFileProblem(Request $request)
     {
         if ($request->hasFile('import_file')) {
             try {
                 Excel::import(new ProblemImport, $request->file('import_file'));
                 return back()->with(['success' => 'Import Problem Success!']);
             } catch (\Throwable $th) {
                 dd($th);
                 return back()->with(['failed' => $th->getMessage()]);
             }
         }
 
         return back()->with(['failed' => 'Please Check your file, Something is wrong there.']);
     }
 
     // counter measure
     public function importFileCounterMeasure(Request $request)
     {
         if ($request->hasFile('import_file')) {
             try {
                 Excel::import(new CounerMeasureImport, $request->file('import_file'));
                 return back()->with(['success' => 'Import Problem Success!']);
             } catch (\Throwable $th) {
                 dd($th);
                 return back()->with(['failed' => $th->getMessage()]);
             }
         }
 
         return back()->with(['failed' => 'Please Check your file, Something is wrong there.']);
     }

      // vehicle
      public function importFileVehicle(Request $request)
      {
          if ($request->hasFile('import_file')) {
              try {
                  Excel::import(new VehicleImport, $request->file('import_file'));
                  return back()->with(['success' => 'Import Vehicle Success!']);
              } catch (\Throwable $th) {
                  dd($th);
                  return back()->with(['failed' => $th->getMessage()]);
              }
          }
  
          return back()->with(['failed' => 'Please Check your file, Something is wrong there.']);
      }
 
      // shift
      public function importFileShift(Request $request)
      {
          if ($request->hasFile('import_file')) {
              try {
                  Excel::import(new ShiftImport, $request->file('import_file'));
                  return back()->with(['success' => 'Import Shift Success!']);
              } catch (\Throwable $th) {
                  dd($th);
                  return back()->with(['failed' => $th->getMessage()]);
              }
          }
  
          return back()->with(['failed' => 'Please Check your file, Something is wrong there.']);
      }

    // process
    public function importFileProcess(Request $request)
    {
        if ($request->hasFile('import_file')) {
            try {
                Excel::import(new ProcessImport, $request->file('import_file'));
                return back()->with(['success' => 'Import Bom Success!']);
            } catch (\Throwable $th) {
                dd($th);
                return back()->with(['failed' => $th->getMessage()]);
            }
        }

        return back()->with(['failed' => 'Please Check your file, Something is wrong there.']);
    }

    // product
    public function importFileProduct(Request $request)
    {
        if ($request->hasFile('import_file')) {
            try {
                Excel::import(new ProductImport, $request->file('import_file'));
                return back()->with(['success' => 'Import Bom Success!']);
            } catch (\Throwable $th) {
                dd($th);
                return back()->with(['failed' => $th->getMessage()]);
            }
        }

        return back()->with(['failed' => 'Please Check your file, Something is wrong there.']);
    }
}
