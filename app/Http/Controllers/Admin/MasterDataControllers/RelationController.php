<?php

namespace App\Http\Controllers\Admin\MasterDataControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Relation;
use App\Models\Gender;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;
class RelationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:masterdata management', ['only' => ['index','update']]);
        $this->middleware('permission:view relation', ['only' => ['index']]);

        $this->middleware('permission:update relation', ['only' => ['update']]);

    }
    public function index()
    {
        $relations = Relation::orderBy('id')->get();
        return view('admin.masterdata.relations.index', compact('relations'));
    }

    /**
     * Store a new relation.
     */
    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'relation_code' => 'required|numeric',
    //         'relation_name' => 'required|string|regex:/^[a-zA-Z\s]+$/',
    //         'gender'        => 'nullable|in:Male,Female,Other',
    //     ], [
    //         'relation_code.required' => 'Relation Code cannot be empty.',
    //         'relation_code.numeric'  => 'Relation Code must be numeric.',
    //         'relation_name.required' => 'Relation Name cannot be empty.',
    //         'relation_name.regex'    => 'Only letters and spaces are allowed in Relation Name.',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status'  => false,
    //             'results' => $validator->errors()
    //         ]);
    //     }

    //     try {
    //         $relation = Relation::create([
    //             'relation_code' => $request->relation_code,
    //             'relation_name' => $request->relation_name,
    //             'gender'        => $request->gender,
    //         ]);

    //         return response()->json([
    //             'status'  => true,
    //             'results' => 'Relation created successfully.',
    //             'data'    => $relation
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status'  => false,
    //             'results' => $e->getMessage()
    //         ]);
    //     }
    // }

    /**
     * Update an existing relation.
     */
     public function update(Request $request)
{
    $validator = Validator::make($request->all(), [
        'relation_code' => 'required|numeric|exists:pgsql.Masterdata.relations,relation_code',
        'gender'        => 'required|in:Male,Female,Other',
    ], [
        'relation_code.required' => 'Relation code is missing.',
        'relation_code.exists'   => 'Relation not found.',
        'gender.required'        => 'Please select a gender.',
        'gender.in'              => 'Invalid gender value.',
    ]);

    if ($validator->fails()) {
        Alert::toast($validator->errors()->first(), 'error');
        return redirect()->back()->withInput();
    }

    try {
        Relation::where('relation_code', $request->relation_code)
                ->update(['gender' => $request->gender]);

        Alert::toast('Gender updated successfully!', 'success');
        return redirect()->back();

    } catch (\Exception $e) {
        Alert::toast('Something went wrong!', 'error');
        return redirect()->back()->withInput();
    }
}

    /**
     * Delete a relation.
     */
    public function destroy($id)
    {
        try {
            Relation::findOrFail($id)->delete();

            return response()->json([
                'status'  => true,
                'results' => 'Relation deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'results' => $e->getMessage()
            ]);
        }
    }
}
