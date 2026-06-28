<?php

namespace App\Http\Controllers\Admin\Contents;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class GalleryCategoryController extends Controller
{
    public function index()
    {

        $categories = GalleryCategory::orderBy('id')->get();
        return view('admin.content-management.gallery-category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'category_name' => 'required|string|regex:/^[a-zA-Z \s\(\)]+$/'
            ],
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return response()->json([
                'status' => false,
                'results' => $validator->errors()
            ]);
        }

        try {
            GalleryCategory::create([
                'category_name' => $request->category_name
            ]);
            Alert::toast("Gallery Category Created Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Gallery Category Created Successfully!"
            ]);
        } catch (Exception $e) {
            Alert::toast("Something Went Wrong!", 'error');
            return response()->json([
                'status' => false,
                'results' => $e
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:pgsql.Content.gallery_categories,id',
                'gallery_category_name' => 'required|string|regex:/^[a-zA-Z \s\(\)]+$/'
            ],
            [
                'gallery_category_name.required' => "Category Name cannot be empty"
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
            GalleryCategory::where('id', $request->id)->update([
                'category_name' => $request->gallery_category_name
            ]);
            Alert::toast("Gallery Category Updated Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Gallery Category Updated Successfully!"
            ]);
        } catch (Exception $e) {
            Alert::toast("Something Went Wrong!", 'error');
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
                'gallery_category_id' => 'required|numeric|exists:pgsql.Content.gallery_categories,id'
            ],
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                GalleryCategory::where('id', $request->gallery_category_id)->delete();
                Alert::toast("Gallery Category Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
