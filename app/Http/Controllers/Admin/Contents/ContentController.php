<?php

namespace App\Http\Controllers\Admin\Contents;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ContentController extends Controller
{
    public function index()
    {

        $contents = Content::orderBy('id')->get();
        return view('admin.content-management.content.index', compact('contents'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|string',
                'description' => 'required|string'
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
            Content::create([
                'title' => $request->title,
                'description' => $request->description
            ]);
            Alert::toast("Content Created Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Content Created Successfully!"
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
                'id' => 'required|numeric|exists:pgsql.Content.contents,id',
                'title' => 'required|string',
                'description' => 'required|string'
            ],
            [
                'title.required' => "Title cannot be empty",
                'description.required' => "Description cannot be empty"
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
            Content::where('id', $request->id)->update([
                'title' => $request->title,
                'description' => $request->description
            ]);
            Alert::toast("Content Updated Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Content Updated Successfully!"
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
                'content_id' => 'required|numeric|exists:pgsql.Content.contents,id'
            ],
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                Content::where('id', $request->content_id)->delete();
                Alert::toast("Content Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
