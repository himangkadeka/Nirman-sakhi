<?php

namespace App\Http\Controllers;

use App\Models\CscList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CscListController extends Controller
{
    public function showCscs(Request $request)
    {
        $data['districts'] = DB::table('Masterdata.districts')
            ->where('state_code', 18)
            ->orderBy('district_name')
            ->get();

        // Load CSCs with district relationship
        $data['cscdetails'] = CscList::with('districts')->get();

        return view('cscdetails', $data);
    }


    public function search(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'district' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'results' => $validator->errors()->first()
            ]);
        }

        $table_data = "";

        try {
            $cscs = CscList::where('district', $request->district)->get();

            if ($cscs->count() > 0) {

                foreach ($cscs as $key => $csc) {
                    $table_data .= '<tr data-district-code="' . $csc->district . '">
    <td>' . ($key + 1) . '</td>
    <td>' . htmlspecialchars($csc->cscid, ENT_QUOTES) . '</td>
    <td>' . htmlspecialchars($csc->vlename, ENT_QUOTES) . '</td>
    <td>' . htmlspecialchars($csc->districts->district_name ?? 'N/A', ENT_QUOTES) . '</td>
    <td>' . htmlspecialchars($csc->subdistrict, ENT_QUOTES) . '</td>
    <td>' . htmlspecialchars($csc->gp, ENT_QUOTES) . '</td>
    <td>' . htmlspecialchars($csc->village, ENT_QUOTES) . '</td>
    <td>' . htmlspecialchars($csc->locality, ENT_QUOTES) . '</td>
</tr>';

                }

                return response()->json([
                    'status' => true,
                    'results' => $table_data
                ]);

            } else {
                return response()->json([
                    'status' => false,
                    'results' => "No Data Found!"
                ]);
            }

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'results' => $e->getMessage()
            ]);
        }
    }
}
