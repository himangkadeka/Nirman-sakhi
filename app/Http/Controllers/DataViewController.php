<?php

namespace App\Http\Controllers;
use App\Models\District;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataViewController extends Controller
{

    public function getDistrictsByState(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'state_code' => 'required|exists:pgsql.Masterdata.states,state_code'
            ],
            [
                'state_code.exist' => 'State Code Does Not Exist!',
                'state_code.required' => 'State Code Required'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'results' => $validator->errors()
            ]);
        } else {
            try {
                $districts = District::where('state_code', $request->state_code)->orderBy('district_name')->get();
                $district_data = '<option value="">--Select District--</option>';
                foreach ($districts as $district) {
                    $district_data .= '<option value="' . $district->district_code . '">' . $district->district_name . '</option>';
                }

                return response()->json([
                    'status' => true,
                    'results' => $district_data
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'status' => false,
                    'results' => $e
                ]);
            }
        }
    }
}
