<?php

namespace App\Http\Controllers\Admin\Benefits;

use App\Http\Controllers\Controller;
use App\Models\Benefit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;

class BenefitListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $benefits = Benefit::orderBy('id')->get();
        $roles = Role::whereIn('id', [6, 10, 11])->get();

        $allRoleIds = $benefits->pluck('role_ids')->filter()->unique();
        $uniqueRoleIds = $allRoleIds->map(function ($idString) {
            return explode(',', $idString);
        })->flatten()->unique()->toArray();
        $rolesMap = Role::whereIn('id', $uniqueRoleIds)->get()->keyBy('id');
        $benefits->each(function ($benefit) use ($rolesMap) {
            $ids = explode(',', $benefit->role_ids);
            $names = collect($ids)->map(function ($id) use ($rolesMap) {
                return $rolesMap->get($id)->name ?? '';
            })->filter()->implode(', ');
            $benefit->role_names_string = $names;
        });
        return view('admin.benefits.benefit-list.index', compact('benefits', 'roles'));
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
        $validator = Validator::make($request->all(), [
            'benefit_name' => 'required|string|max:255',
            'benefit_code' => 'required|string|max:255|unique:pgsql.Benefit.benefits,benefit_code',
            'description'  => 'nullable|string',
             'category'     => 'required|integer|in:1,2,3,4',
            'role_ids'     => 'required|array',
            'role_ids.*'   => 'required|integer|exists:pgsql.User.roles,id',
            'maximum_applications_per_worker' => 'required|integer|min:0|max:10',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return response()->json([
                'status'  => false,
                'results' => $validator->errors()->first()
            ]);
        }

        try {
            $roles_csv = implode(',', $request->role_ids);

            Benefit::create([
                'name'        => $request->benefit_name,
                'benefit_code' => $request->benefit_code,
                'description' => $request->description,
                'category_id' => $request->category, 
                'role_ids'    => $roles_csv,
                'maximum_applications_per_worker' => $request->maximum_applications_per_worker,
            ]);

            Alert::toast('Benefit Added Successfully', 'success');
            return response()->json([
                'status'  => true,
                'results' => "Benefit Added Successfully!"
            ]);
        } catch (Exception $e) {
            Log::error($e); // It's good practice to log the actual error
            Alert::toast('An unexpected error occurred.', 'error');
            return response()->json([
                'status'  => false,
                'results' => 'An unexpected error occurred.'
            ]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'benefit_id' => 'required|exists:pgsql.Benefit.benefits,id',
            'benefit_name' => 'required',
            'category'     => 'required|integer|in:1,2,3,4',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return response()->json([
                'status' => false,
                'results' => $validator->errors()->first()
            ]);
        }

        try {
            Benefit::where('id', $request->benefit_id)->update([
                'name' => $request->benefit_name,
                'description' => $request->description,
                 'category_id' => $request->category,
            ]);

            Alert::toast('Benefit Updated Successfully', 'success');
            return response()->json([
                'status' => true,
                'results' => "benefit Updated Successfully!"
            ]);
        } catch (Exception $e) {
            return $e;
            Alert::toast("Something went Wrong!", 'error');
            return response()->json([
                'status' => false,
                'results' => $e->getMessage()
            ]);
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
        //
    }


    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:pgsql.Benefit.benefits,id',
            'status' => 'required|in:0,1',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Alert::toast($error, 'error');
            }
            return redirect()->route('admin.benefit-list.index')->withInput()->withErrors($validator->errors());
        }
        try {
            $benefit = Benefit::where('id', $request->id)->first();
            if (!$benefit) {
                foreach ($validator->errors()->all() as $error) {
                    Alert::toast($error, 'Office Not Found');
                }
                return redirect()->route('admin.offices.index')->withInput()->withErrors($validator->errors());
            }
            Benefit::where('id', $request->id)->update([
                'status' => $request->status,
                'updated_at' => now()
            ]);
            Alert::toast('Status Changed Sucessfully.', "success");
            return redirect()->route('admin.benefit-list.index');
        } catch (Exception $e) {
            Alert::toast("Something Went Wrong!", 'error');
            return redirect()->route('admin.offices.index')->withInput();
        }
    }



    public function delete(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'benefit_code' => 'required|numeric|exists:pgsql.Benefit.benefits,id'
            ],
            [
                'benefit_code.required' => "Benefit Code Required",
                'benefit_code.numeric' => "Benefit Code can only be Numeric",
                'benefit_code.exists' => "Benefit Code Already Exist"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                Benefit::where('id', $request->benefit_code)->delete();
                Alert::toast("Benefit Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
