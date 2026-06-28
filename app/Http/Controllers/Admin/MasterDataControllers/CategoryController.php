<?php

namespace App\Http\Controllers\Admin\MasterdataControllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:masterdata management', ['only' => ['index','store','update','delete']]);
        $this->middleware('permission:view category', ['only' => ['index']]);
        $this->middleware('permission:create category', ['only' => ['store']]);
        $this->middleware('permission:update category', ['only' => ['update']]);
        $this->middleware('permission:delete category', ['only' => ['delete']]);
    }
    public function index()
    {
        $categories = Category::orderBy('category_code')->get();
        return view('admin.masterdata.category.index', compact('categories'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'category_name' => 'required|regex:/^[a-zA-Z\s]+$/'
            ],
            [
                'category_name.required' => "Category name cannot be empty.",
                'category_name.regex' => "Category name can only contain letters and spaces."
            ]
        );

        // Handle validation failure
        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return response()->json([
                'status' => false,
                'results' => $validator->errors()
            ]);
        }


        $sanitizedData = [
            'category_name' => filter_var($request->category_name),
        ];

        try {

            Category::create($sanitizedData);

            Alert::toast("Category created successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Category created successfully."
            ]);
        } catch (Exception $e) {

            Alert::toast("Something went wrong!", 'error');
            return response()->json([
                'status' => false,
                'results' => "An error occurred while creating the category. Please try again."
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'category_code' => 'required|numeric|exists:pgsql.Masterdata.categories,category_code',
                'category_name' => 'required|regex:/^[a-zA-Z\s]+$/'
            ],
            [
                'category_code.required' => "Category Code Cannot be Empty!",
                'category_code.numeric' => "Category Code must be numeric",
                'category_name.required' => "Category name cannot be Empty.",
                'category_name.regex' => "Category name can only contain letters and spaces"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return response()->json([
                'status' => false,
                'results' => $validator->errors()
            ]);
        }

        try {
            Category::where('category_code', $request->category_code)->update([
                'category_name' => $request->category_name
            ]);
            Alert::toast("Category Updated Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Category Updated Successfully"
            ]);
        } catch (Exception $e) {
            Alert::toast("Something went Wrong!", 'error');
            return response()->json([
                'status' => false,
                'results' => $e
            ]);
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'category_id' => 'required|numeric|exists:pgsql.Masterdata.categories,category_code'
            ],
            [
                'category_id.required' => "Category Code Required",
                'category_id.numeric' => "Category Code can only be Numeric",
                'category_id.exists' => "Category Code Invalid"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                Category::where('category_code', $request->category_id)->delete();
                Alert::toast("Category Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
