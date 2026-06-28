<?php

namespace App\Http\Controllers\Admin\Contents;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class GalleryController extends Controller
{
    public function index()
    {

        $galleries = Gallery::orderBy('id')->get();
        return view('admin.content-management.gallery.index', compact('galleries'));
    }

    public function create()
    {
        $galleries = Gallery::orderBy('id')->get();
        $data['categories'] = GalleryCategory::orderBy('id')->get();
        return view('admin.content-management.gallery.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'inputs.*.image_path' => 'required|mimes:jpg,png,jpeg,gif,svg,webp',
            'inputs.*.caption' => 'required|regex:/^[a-zA-Z \s\(\)]+$/',
            'inputs.*.category_id' => 'required|array|exists:pgsql.Content.gallery_categories,id'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back()->withInput();
        }

        try {

            foreach ($request->input('inputs') as $key => $data) {
                $timestamp = now()->timestamp.Str::random(10); // Generate a unique timestamp

                // Generate the image name using the timestamp
                $image_name = 'gallery_images/' . $timestamp . '.' . $request->file('inputs.' . $key . '.image_path')->extension();

                // Store the image using Laravel's storage
                Storage::disk('public')->put($image_name, file_get_contents($request->file('inputs.' . $key . '.image_path')->getRealPath()));

                // Create the gallery entry
                $gallery = Gallery::create([
                    'image_path' => $image_name,
                    'caption' => $data['caption'],
                    'category_id' => implode(',', $data['category_id'])
                ]);
            }

            Alert::toast('Gallery Created Successfully!', 'success');
            return back();
        } catch (Exception $e) {
            return $e;
            Alert::toast("Something went Wrong!", 'error');
            return back()->withInput();
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'image_path' => 'required|string',
                'caption' => 'required|string|regex:/^[a-zA-Z \s\(\)]+$/',
                'category_id' => 'required|numeric|exists:pgsql.Content.gallery_categories,id',
            ],
            [
                'image_path.required' => "Category Name cannot be empty"
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
                'gallery_id' => 'required|numeric|exists:pgsql.Content.galleries,id'
            ],
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                Gallery::where('id', $request->gallery_id)->delete();
                Alert::toast("Gallery Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
