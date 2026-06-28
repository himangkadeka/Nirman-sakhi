<?php

namespace App\Http\Controllers\Admin\Contents;

use App\Http\Controllers\Controller;
use App\Models\IndexNotification;
use App\Models\District;
use App\Models\TypeOfBenefit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class IndexNotificationController extends Controller
{
    //



    public function index()
    {
        $index_notification = IndexNotification::orderBy('id')->get();

        return view('admin.content-management.index-notification.index', compact('index_notification'));
    }




    // public function indexnotification()
    // {
    //     // Fetch only Index Notifications
    //     $indexnotifications = IndexNotification::where('category', '1') // 1 is the value for Index Notifications
    //         ->orderBy('id', 'desc')
    //         ->get();

    //     // Return view with filtered notifications
    //     return view('resources/views/index', compact('indexnotifications'));
    // }



    public function store(Request $request)
    {

        $request->validate([
            'caption' => 'required|array',
            'caption.*' => 'required|string|max:255',
            'pdf_path' => 'required|array',
            'pdf_path.*' => 'required|file|mimes:pdf|max:5000',
            'category' => 'required|array',
            'benefit_id' => isset($request->category[0]) && $request->category[0] == '4' ? 'required' : 'nullable',
        ]);

        try {
            if ($request->hasFile('pdf_path')) {
                foreach ($request->file('pdf_path') as $key => $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $destinationPath = public_path('pdf/index_notifications');
                    $file->move($destinationPath, $filename);


                    //  Convert 'ALL' to 0 before inserting
                    // $districtCode = $request->district_name[$key] === 'ALL' ? 0 : $request->district_name[$key];
                    $districtCode = isset($request->district_name[$key])
                        ? ($request->district_name[$key] === 'ALL' ? 0 : $request->district_name[$key])
                        : null;



                    IndexNotification::create([
                        'caption' => $request->caption[$key] ?? '',
                        'pdf_path' => 'pdf/index_notifications/' . $filename,
                        'year' => $request->year[$key] ?? null,
                        // 'benefit_id' => $request->benefit[$key] ?? null,
                        'benefit_id' => $request->benefit_id,
                        'category' => $request->category[$key] ?? null,
                        // 'district_code' => $request->district_name[$key] ?? null,
                        'district_code' => $districtCode, //  use converted value
                    ]);
                }

                return redirect()->route('admin.index_notification.index')->with('success', 'Notifications added successfully!');
            } else {
                return redirect()->back()->with('error', 'File upload failed.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }



    public function delete(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'index_notification_id' => 'required|numeric|exists:pgsql.Content.index_notifications,id'

            ],
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                DB::table('Content.index_notifications')->where('id', $request->index_notification_id)->delete();
                Alert::toast("Notification Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }

    // public function update(Request $request, $id)
    // {
    //     $notification = IndexNotification::findOrFail($id);
    //     $notification->title = $request->title;
    //     $notification->content = $request->content;
    //     $notification->save();

    //     return redirect()->route('index_notification.index')->with('success', 'Notification updated successfully.');
    // }
    public function edit($id)
    {
        $notification = IndexNotification::findOrFail($id);
        return response()->json($notification);
    }

    // public function update(Request $request, $id)
    // {
    //     $notification = IndexNotification::findOrFail($id);
    //     $request->validate([
    //         'caption' => 'required|string|max:255',
    //     ]);

    //     $notification->caption = $request->caption;
    //     $notification->save();

    //     return redirect()->route('admin.index_notification.index')->with('success', 'Notification updated successfully.');
    // }
    public function update(Request $request, $id)
    {
        $notification = IndexNotification::findOrFail($id);

        $request->validate([
            'caption' => 'required|string|max:255',
            'pdf' => 'nullable|file|mimes:pdf|max:5000', // Make it nullable
        ]);

        $notification->caption = $request->caption;

        // Handle PDF upload if a new file is provided
        if ($request->hasFile('pdf')) {
            // Delete old PDF file if exists
            if ($notification->pdf_path && file_exists(public_path($notification->pdf_path))) {
                unlink(public_path($notification->pdf_path));
            }

            // Upload new PDF
            $file = $request->file('pdf');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('pdf/index_notifications');
            $file->move($destinationPath, $filename);

            $notification->pdf_path = 'pdf/index_notifications/' . $filename;
        }

        $notification->save();

        return redirect()->route('admin.index_notification.index')->with('success', 'Notification updated successfully.');
    }


    public function create()
    {
        // Fetch notifications ordered by ID
        $index_notification = IndexNotification::orderBy('id')->get();

        // Fetch districts with state_code = 18
        $districts = DB::table('Masterdata.districts')
            ->where('state_code', '=', 18)
            ->orderBy('district_name')
            ->get();


        $categories = DB::table('Masterdata.document_categories')

            ->orderBy('category_name')
            ->get();


        $benefits = TypeOfBenefit::orderBy('benefit_name')->get();

        //  Dynamic Year Range (From 2020 to Current Year)
        $startYear = 2020;
        $endYear = now()->year;
        $years = range($startYear, $endYear);


        // Pass both data to the view
        return view('admin.content-management.index-notification.create', [
            'index_notification' => $index_notification,
            'districts' => $districts,
            'categories' => $categories,
            'benefits' => $benefits,
            'years' => $years,
        ]);
    }




    //     // // HEADER



    public function getYears()
    {
        $years = DB::table('Content.index_notifications')
            ->select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return response()->json($years);
    }



    // ********************Returned Benefit Public Blade****************************

    public function showDistrictsWithNotifications()
    {
        $districts = DB::table('Masterdata.districts')
            ->join('Content.index_notifications', function ($join) {
                $join->on('Masterdata.districts.district_code', '=', 'Content.index_notifications.district_code');
            })
            ->select('Masterdata.districts.district_code', 'Masterdata.districts.district_name')
            ->where('state_code', '=', 18)
            ->groupBy('Masterdata.districts.district_code', 'Masterdata.districts.district_name')
            ->get();

        // Debugging: Check what data is retrieved
        // dd($districts);

        return view('benefits_returned', compact('districts'));
    }



    // public function getGroupedBenefitFiles(Request $request)
    // {
    //     $benefitId = $request->input('benefit_id');
    //     $year = $request->input('year');

    //     $files = DB::table('Content.index_notifications')
    //         ->where('category', 4)
    //         ->where('benefit_id', $benefitId)
    //         ->where('year', $year)
    //         ->select('caption', 'pdf_path')
    //         ->orderBy('caption')
    //         ->get();

    //     return response()->json($files);
    // }

}
