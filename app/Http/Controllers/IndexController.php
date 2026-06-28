<?php

namespace App\Http\Controllers;

use App\Models\CancelledAppModal;
use App\Models\District;
use App\Models\MainWorkerAddress;
use App\Models\PfcKioskDetail;
use App\Models\PfcList;
use App\Models\CscList;
use App\Models\RevertBack;
use App\Models\IndexNotification;
use App\Models\TemporaryWorkerForm;
use App\Models\MainWorkerForm;
use App\Models\MainWorkerBasicDetail;
use App\Models\Visitor;
use App\Models\WorkerApplicationStatus;
use App\Models\MainWorkerBank;
use App\Models\MainWorkerFamily;
use App\Models\Content;

use App\Models\WorkerPaymentSuccess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Services\AesCipher;
use Barryvdh\Snappy\Facades\SnappyPdf as Pdf;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\GetVaultDataService;
use Exception;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    protected $getVaultDataService;
    /**
     * @var AesCipher
     */


    public function __construct(GetVaultDataService $getVaultDataService)
    {
        $this->getVaultDataService = $getVaultDataService;


    }

    public function index()
    {
        // Fetch distinct years for category_id = 5
        $data['years_returned'] = IndexNotification::where('category', 5)
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year'); // Fetch only the 'year' column as a collection

        // dd($data['years_returned']); // This should now display an array/collection of year values

        // Fetch distinct years for category_id = 4
        $data['years_disbursed'] = IndexNotification::where('category', 4)
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year'); // Fetch only the 'year' column

        // return $data['years_disbursed'];

        $data['alerts_index'] = IndexNotification::where('category', 6)
            ->orderBy('id', 'desc')
            ->get();




        $rtps_trans_id = session()->get('pfcData');
        $data['dists'] = District::where('state_code', '=', 18)->get();
        // $data['index_notifications'] = IndexNotification::orderBy('id')->get();
        $data['contents'] = Content::orderBy('id', 'asc')->get();

        // Fetch only Index Notifications
        $data['index_notifications'] = IndexNotification::where('category', '1') // 1 is the value for Index Notifications
            ->orderBy('id', 'desc')
            ->get();
        // Fetch only Index Newsletters
        $data['index_newsletters'] = IndexNotification::where('category', '2') // 1 is the value for Index Notifications
            ->orderBy('id', 'desc')
            ->get();
        // Fetch only Index Newsletters
        $data['index_tenders'] = IndexNotification::where('category', '3') // 1 is the value for Index Notifications
            ->orderBy('id', 'desc')
            ->get();

            // return $data;

        if (session()->has('pfcData')) {
            $data['pfcData'] = PfcKioskDetail::where('rtps_trans_id', $rtps_trans_id)->first();

//             return $data['pfcData'];
            if ($data['pfcData'] != null) {
                if ($data['pfcData']->service_id == 1) {
                    if ($data['pfcData']->worker_id == null) {
                        // return $data;
                        return view('index', $data);
                    } else {
                        // if ($data['pfcData']->is_worker_registered == "No") {
                        try {

                            $tempWorkerId = $data['pfcData']->worker_id;

                            $userFinalData = MainWorkerForm::where('worker_id', $tempWorkerId)->first();

                            $userTempData = TemporaryWorkerForm::where('worker_id', $tempWorkerId)
                                ->first();

                            if ($userFinalData) {
                                if ($userFinalData->payment_status == 'success') {
                                    Alert::toast("You have Completed the Registration Process");
                                    return redirect()->route('home.index');
                                } else {
                                    Alert::toast("Payment is Pending,login and pay the registration fees", 'warning');
                                    session()->put('worker_id', $userTempData->worker_id);
                                    return redirect()->route('submit-worker-payment');
                                }
                            }
                            if ($userTempData) {
                                session()->put('worker_id', $userTempData->worker_id);
                                return redirect()->route('main-page');
                            }

                        } catch (\Exception $e) {
                            // return $e;
                            Alert::toast('Error in loginWithTempId: ' . $e->getMessage(), 'error');
                            return redirect()->route('home.index');
                        }
                        // } else {
                        //     return view('index', $data);
                        // }
                    }
                } elseif ($data['pfcData']->service_id == 4) {
                    return redirect()->route('home.onboarding-criteria');
                } elseif ($data['pfcData']->service_id == [2,3]) {
                    if ($data['pfcData']->worker_id == null) {
                        $data['id_cards'] = MainWorkerForm::where('phone_no', $data['pfcData']->mobile)->where('id_card', '!=', null)->get();
                    } else {
                        $data['id_cards'] = MainWorkerForm::where('id_card', $data['pfcData']->worker_id)->get();
                    }

                }
            }
        }
        return view('index', $data);
    }


    public function testSiteRedirect(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('test-site');
        }
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'invalid Password'
                ]);
            }

            if ($request->password == 'Labour@123454321') {
                session()->put('website-session', $request->password);
            }

            return redirect()->route('home.index');
        }
    }

    public function testData()
    {

        return MainWorkerForm::get();
    }

    public function countVisitor()
    {


        $visitorCount = Visitor::distinct('ip_address')->count('ip_address');
        return response()->json($visitorCount);
    }

    public function trackApp(Request $request)
    {


        return view('track-application');
    }

    public function  trackAndDownload(Request $request)
    {
        $searchBy = $request->input('search_by');
        $searchValue = $request->input('search_value');

        if (!in_array($searchBy, ['phone', 'ack_no', 'worker_id'])) {
            return response()->json(['error' => 'Invalid search type'], 422);
        }
        if (!$searchValue) {
            return response()->json(['error' => 'Search value is required'], 422);
        }

        if ($searchBy === 'phone') {
            $workerIds = TemporaryWorkerForm::where('phone_no', $searchValue)->pluck('worker_id');

            if ($workerIds->isEmpty()) {
                return response()->json(['error' => 'No worker found with this phone number'], 404);
            }

            $applications = WorkerApplicationStatus::whereIn('worker_id', $workerIds)
                ->orderBy('created_at', 'asc')
                ->get();
        } else {
            // ack_no or worker_id
            $applications = WorkerApplicationStatus::where($searchBy, $searchValue)
                ->orderBy('created_at', 'asc')
                ->get();
        }

    }

    public function trackApplication(Request $request)
    {
        $applicationNo = $request->input('application_no');
        $applicationSuccess = MainWorkerForm::where('payment_status','success')->where('ack_no',$applicationNo)->value('ack_no');

        if (!$applicationSuccess) {
            $applicationSuccess = Revertback::where('ack_no', $applicationNo)
//                ->where('resubmit_status',0)
                ->value('ack_no');
        }
        if (!$applicationSuccess) {
            $applicationSuccess = CancelledAppModal::where('ack_no', $applicationNo)
                ->value('ack_no');
        }

// Fetch all matching application records
        $applications = WorkerApplicationStatus::where('ack_no', $applicationSuccess)
            ->where('is_renewal', 0)
            ->orderBy('created_at', 'asc')
            ->get();

        $applicationRenewal = WorkerApplicationStatus::where('ack_no', $applicationNo)
            ->where('is_renewal', 1)
            ->orderBy('created_at', 'asc')
            ->get();


// Decide which dataset to use
        if ($applications->isNotEmpty()) {
            $dataToProcess = $applications;
        } elseif ($applicationRenewal->isNotEmpty()) {
            $dataToProcess = $applicationRenewal;
        } else {
            return response()->json(['error' => 'Application not found'], 404);
        }

// Fetch reasons for each application
        $modified_applications = $dataToProcess->map(function ($application) {
            $reasons = $application->getReasons();

            $alreadyRegistered = TemporaryWorkerForm::where('worker_id', $application->worker_id)
                ->where('already_registered', 1)
                ->exists();

            $revert = RevertBack::where('worker_id', $application->worker_id)->first();
            $has_cancelled = $revert ? $revert->revert_back_status == 1 : false;

            $contact_no = TemporaryWorkerForm::where('worker_id', $application->worker_id)->value('phone_no');

            $applicationArray = $application->toArray();

            if ($application->application_status == 'F') {
                $idCardNumber = MainWorkerForm::where('worker_id', $application->worker_id)
                        ->where('status', 'F')
                        ->first()
                        ->id_card ?? null;
                $applicationArray['idCardNumber'] = $idCardNumber;
            } else {
                $applicationArray['idCardNumber'] = null;
            }

            $applicationArray['reasons_details'] = $reasons;
            $applicationArray['already_registered'] = $alreadyRegistered;
            $applicationArray['contact_no'] = $contact_no;
            $applicationArray['has_cancelled'] = $has_cancelled;

            return $applicationArray;
        });

        return response()->json($modified_applications);
    }

        public function downloadAcknowledgement(Request $request)
    {
        $acknowledgementNumber = $request->query('ack_no');

        if (!$acknowledgementNumber) {
            return response()->json(['error' => 'Acknowledgement number is required'], 400);
        }

        $data['worker'] = DB::table('Worker.main_worker_forms')
            ->where('ack_no', $acknowledgementNumber)
            ->first();

        $isRenew = false;
        if (!$data['worker']) {
            $data['worker'] = DB::table('Worker.renew_worker_forms')
                ->where('ack_no', $acknowledgementNumber)
                ->first();

            $isRenew = true;
        }

        $data['revert_back'] = RevertBack::where('worker_id', $data['worker']->worker_id)->count();

        $vaultData = $this->getVaultDataService->getVaultData($data['worker']->worker_id, "T");
        $data['getVaultData'] = json_decode($vaultData->getData(), true);
        if ($isRenew) {
            // If found in renew_worker_forms
            $data['mwf'] = DB::table('Worker.renew_worker_forms as rwfm')
                ->join('Masterdata.offices as ofc', 'rwfm.office_id', '=', 'ofc.office_id')
                ->where('rwfm.worker_id', $data['worker']->worker_id)
                ->select('rwfm.*', 'ofc.*')
                ->first();
        } else {
            // If found in main_worker_forms
            $data['mwf'] = DB::table('Worker.main_worker_forms as wmfm')
                ->join('Masterdata.offices as ofc', 'wmfm.office_id', '=', 'ofc.office_id')
                ->where('wmfm.worker_id', $data['worker']->worker_id)
                ->select('wmfm.*', 'ofc.*')
                ->first();
        }

// 4. Load Basic Details (common for both)
            $data['mfb'] = DB::table('Worker.main_worker_basic_details as wmbd')
                ->where('worker_id', $data['worker']->worker_id)
                ->first();
            $data['payment_date'] = WorkerPaymentSuccess::where('worker_id',$data['worker']->worker_id)->first();

        if (!$data['worker']) {
            return response()->json(['error' => 'No records found for this Acknowledgement Number'], 404);
        }
        $data['emblem'] = public_path('/assets/template/images/emblem-dark.png');
        $data['isRenew'] = $isRenew;



        $html = view('worker.pdf.download-as-pdf', $data);
        $options = [
            'encoding' => 'utf-8', // Set encoding to UTF-8
            'enable-local-file-access' => true, // Enable external links
        ];
        // Generate PDF from HTML content
        $pdfContent = Pdf::loadHTML($html)
            ->setOptions($options)
            ->output();

        // Set response headers to indicate PDF content
        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="application.pdf"',
        ]);
    }

    public function TrackApplicationMobile()
    {
        return view('worker.track-application-by-mobile');
    }

    /**
     * Track applications by mobile number from multiple sources.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function trackByMobile(Request $request)
    {
        // 1. Validate the input
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|string|min:10|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $mobileNumber = $request->input('mobile_number');

        // 2. Fetch applications directly from each source model
        // We use 'select' to get specific columns and aliases to keep the output consistent
        $mainApps = MainWorkerForm::where('phone_no', $mobileNumber)
            ->select('application_no', 'ack_no', 'status as application_status')
            ->get();

        $revertedApps = Revertback::where('phone_no', $mobileNumber)
            ->select('application_no', 'ack_no', 'status as application_status')
            ->get();

        $cancelledApps = CancelledAppModal::where('phone_no', $mobileNumber)
            ->select('application_no', 'ack_no', 'status as application_status')
            ->get();

        // 3. Combine results from all three queries into a single collection
        $allApplications = $mainApps->concat($revertedApps)->concat($cancelledApps);

        // 4. Ensure the list is unique, for instance by 'ack_no' to avoid duplicates
        // This is crucial if an application can appear in more than one table.
        $uniqueApplications = $allApplications->unique('ack_no');

        // 5. Check if any applications were found after combining results
        if ($uniqueApplications->isEmpty()) {
            return response()->json(['error' => 'No applications found for this mobile number.'], 404);
        }

        // 6. Return a successful response with the combined list of applications
        // ->values() resets the array keys to be sequential (0, 1, 2...) which is good practice for JSON APIs.
        return response()->json(['success' => true, 'applications' => $uniqueApplications->values()]);
    }





    public function sessionFlash()
    {
        Session::flush();
        session()->regenerate();
        return redirect()->route('home.index');
    }

    // public function homepageNotifications()
    // {
    //     $index_notification = IndexNotification::orderBy('id')->get();
    //     return view('index', compact('index_notification'));  // Pass data to the view
    // }
    public function introduction()
    {
        return view('introduction');
    }

    public function whosWho()
    {
        return view('members_of_the_board');
    }

    public function missionAndVission()
    {
        return view('missionandvission');
    }

    public function aimsAndAbjectives()
    {
        return view('aimsandobjectives');
    }
    public function Functions()
    {
        return view('functions');
    }

    public function organizations()
    {
        return view('organizations');
    }

    public function contactUs()
    {
        return view('contactus');
    }


    public function schemes()
    {
        return view('schemes');
    }
    // public function iit()
    // {
    //     return view('iit');
    // }
    public function iit()
     {
        $iit = IndexNotification::where('category', 8)
            ->orderBy('id', 'desc')
            ->get();

        return view('iit', compact('iit'));
    }

    public function actandrules()
    {
        return view('actandrules');
    }
    public function Benefits()
    {
        return view('benefits');
    }

    public function listofapprovedpfcs()
    {
        return view('listofapprovedpfcs');
    }
    // public function returned2022()
    // {
    //     return view('returned2022');
    // }
    // public function returned2023()
    // {
    //     return view('returned2023');
    // }
    // public function returned2024()
    // {
    //     return view('returned2024');
    // }
    // public function returned2025()
    // {
    //     return view('returned2025');
    // }

    public function returned($year)
    {
        $viewName = "benefits_returned"; // Ensure the view file exists

        if (!view()->exists($viewName)) {
            abort(404, "The view for benefits returned was not found.");
        }

        // Fetch distinct years and filter out null values
        $years_returned = IndexNotification::distinct()->pluck('year')->filter();

        // Fetch districts only for the given year
        $districts = DB::table('Masterdata.districts')
            ->join('Content.index_notifications', function ($join) use ($year) {
                $join->on('Masterdata.districts.district_code', '=', 'Content.index_notifications.district_code')
                    ->where('Content.index_notifications.year', '=', $year)
                    ->where('category', 5); // Filter by year
            })
            ->select('Masterdata.districts.district_code', 'Masterdata.districts.district_name')
            ->where('Masterdata.districts.state_code', '=', 18) // Ensure state_code = 18
            ->groupBy('Masterdata.districts.district_code', 'Masterdata.districts.district_name')
            ->get();

        // Ensure there is at least one valid year
        if ($years_returned->isEmpty()) {
            return view($viewName, compact('years_returned', 'districts', 'year'))
                ->with('error', 'No years available.');
        }

        return view($viewName, compact('years_returned', 'districts', 'year'));
    }
    public function getDistrictReturnedFiles(Request $request)
    {

        $districtCode = $request->input('district_code');
        $year = $request->input('year');



        if (!$districtCode) {
            return response()->json(['error' => 'Missing district code'], 400);
        }

        $files = IndexNotification::where('district_code', $districtCode)
            ->where('year', $year)
            ->select('caption', 'pdf_path','district_code','year','category')
            ->where('category', 5)
            ->get();
        // dd($files);
        // die;
        return response()->json($files);

    }









    public function disbursed($year)
    {
        $viewName = "benefits_disbursed"; // Ensure the Blade file exists

        if (!view()->exists($viewName)) {
            abort(404, "The view for benefits disbursed was not found.");
        }

        // Fetch distinct years
        $years_disbursed = IndexNotification::distinct()->pluck('year')->filter();


        // $benefits = IndexNotification::where('year', $year)
        //     ->join('Masterdata.type_of_benefits', 'Content.index_notifications.benefit_id', '=', 'Masterdata.type_of_benefits.id')
        //     ->leftJoin('Masterdata.districts', 'Content.index_notifications.district_code', '=', 'Masterdata.districts.district_code')
        //     ->where(function ($query) {
        //         $query->whereNull('Masterdata.districts.state_code') // include even if there's no match
        //             ->orWhere('Masterdata.districts.state_code', 18);
        //     })
        //     ->select('Masterdata.type_of_benefits.benefit_name', 'Content.index_notifications.benefit_id', 'Masterdata.districts.district_name')
        //     ->distinct()
        //     ->get();


        $benefits = IndexNotification::where('year', $year)
            ->join('Masterdata.type_of_benefits', 'Content.index_notifications.benefit_id', '=', 'Masterdata.type_of_benefits.id')
            ->leftJoin('Masterdata.districts', 'Content.index_notifications.district_code', '=', 'Masterdata.districts.district_code')
            ->where(function ($query) {
                $query->whereNull('Masterdata.districts.state_code') // include even if there's no match
                    ->orWhere('Masterdata.districts.state_code', 18);
            })
            ->select('Content.index_notifications.benefit_id', 'Masterdata.type_of_benefits.benefit_name')
            ->distinct()
            ->orderBy('Masterdata.type_of_benefits.benefit_name')
            ->get();

        // dd($benefits);



        return view($viewName, compact('years_disbursed', 'benefits', 'year'));
    }


    // {
    //     $benefitId = $request->input('benefit_id');
    //     $year = $request->input('year');

    //     if (!$benefitId) {
    //         return response()->json(['error' => 'Missing Benefit Id'], 400);
    //     }

    //     $allDistricts = DB::table('Masterdata.districts')->select('district_code', 'district_name')->get();

    //     $uploadedFiles = DB::table('Content.index_notifications')
    //         ->where('Content.index_notifications.benefit_id', $benefitId)
    //         ->where('Content.index_notifications.year', $year)
    //         ->select('district_code', 'caption', 'pdf_path')
    //         ->get()
    //         ->groupBy('district_code');

    //     $result = $allDistricts->map(function ($district) use ($uploadedFiles) {
    //         $files = $uploadedFiles->has($district->district_code)
    //             ? $uploadedFiles[$district->district_code]->map(function ($file) {
    //                 return [
    //                     'caption' => $file->caption,
    //                     'pdf_path' => $file->pdf_path
    //                 ];
    //             })->values()
    //             : [];

    //         return [
    //             'district_name' => $district->district_name,
    //             'district_code' => $district->district_code,
    //             'files' => $files
    //         ];
    //     });

    //     return response()->json($result);
    // }


    // public function getDisbursedBenefitFiles(Request $request)
    // {

    //     $benefitId = $request->input('benefit_id');
    //     $year = $request->input('year');



    //     if (!$benefitId) {
    //         return response()->json(['error' => 'Missing Benefit Id'], 400);
    //     }



    //     $files = IndexNotification::where('Content.index_notifications.benefit_id', $benefitId)
    //         ->where('Content.index_notifications.year', $year)
    //         ->leftJoin('Masterdata.districts', 'Content.index_notifications.district_code', '=', 'Masterdata.districts.district_code')
    //         ->select(
    //             'Content.index_notifications.caption',
    //             'Content.index_notifications.pdf_path',
    //             'Masterdata.districts.district_name'
    //         )
    //         ->get();




    //     return response()->json($files);

    // }
    public function getDisbursedBenefitFiles(Request $request)
{
    $benefitId = $request->input('benefit_id');
    $year = $request->input('year');

    if (!$benefitId) {
        return response()->json(['error' => 'Missing Benefit Id'], 400);
    }

    // Step 1: Get all real districts with potential PDF uploads
    $rawFiles = DB::table('Masterdata.districts')
        ->leftJoin('Content.index_notifications', function ($join) use ($benefitId, $year) {
            $join->on('Masterdata.districts.district_code', '=', 'Content.index_notifications.district_code')
                ->where('Content.index_notifications.benefit_id', '=', $benefitId)
                ->where('Content.index_notifications.year', '=', $year)
                ->where('Content.index_notifications.category', '=', 4);
        })
        ->where('Masterdata.districts.state_code', 18)
        ->select(
            'Masterdata.districts.district_name',
            'Content.index_notifications.caption',
            'Content.index_notifications.pdf_path'
        )
        ->get();

    // Step 2: Sort manually in PHP - PDFs first
    $files = collect($rawFiles)->sortBy(function ($item) {
        return empty($item->pdf_path) ? 1 : 0;
    })->values(); // Reindex after sorting

    // Step 3: Fetch "All Districts" entries
    $allDistrictEntries = DB::table('Content.index_notifications')
        ->where('benefit_id', $benefitId)
        ->where('year', $year)
        ->where('category', 4)
        ->where(function ($query) {
            $query->whereNull('district_code')
                  ->orWhere('district_code', 0);
        })
        ->select('caption', 'pdf_path')
        ->get();

    // Step 4: Prepend "All Districts" to the files list
    if ($allDistrictEntries->isNotEmpty()) {
        foreach ($allDistrictEntries as $entry) {
            $files->prepend((object)[
                'district_name' => 'All Districts',
                'caption' => $entry->caption,
                'pdf_path' => $entry->pdf_path
            ]);
        }
    } else {
        $files->prepend((object)[
            'district_name' => 'All Districts',
            'caption' => 'No PDF uploaded',
            'pdf_path' => null
        ]);
    }

    return response()->json($files);
}












    public function onboardingCriteria()
    {
        return view('onboarding-criteria');
    }

    public function newRegistrationCriteria()
    {
        return view('new-registration-criteria');
    }

    public function mis()
    {
        $mainNew = MainWorkerForm::count();

        $countRejected = MainWorkerForm::where('status', 'D')->count();
        $countPending = MainWorkerForm::whereNotIn('status', ['F', 'D', 'G'])->count();
        $countApproved = MainWorkerForm::where('status', 'F')->count();
        $countReverted = RevertBack::where('status', 'G')->count();
        $countForwarded = MainWorkerForm::where('status', 'C')->count();
        $rowCount = $mainNew + $countReverted;

        $onboarding = MainWorkerForm::where('already_registered', 1)->count();

        $totalPendingOnboarding = MainWorkerForm::whereNotIn('status', ['F', 'D', 'G'])->where('already_registered', 1)->count();
        $approveOnboarding = MainWorkerForm::where('status', 'F')->where('already_registered', 1)->count();
        $onboardingRejected = MainWorkerForm::where('status', 'D')->where('already_registered', 1)->count();
        $onboardingReverted = RevertBack::where('status', 'G')->where('already_registered', 1)->count();
        $totalOnboarding = $onboarding + $onboardingReverted;

        $New = MainWorkerForm::where('already_registered', null)->count();
        $totalPendingNew = MainWorkerForm::whereNotIn('status', ['F', 'D', 'G'])->where('already_registered', null)->count();
        $approveNew = MainWorkerForm::where('status', 'F')->where('already_registered', null)->count();
        $newRejected = MainWorkerForm::where('status', 'D')->where('already_registered', null)->count();
        $newReverted = RevertBack::where('status', 'G')->where('already_registered', null)->count();
        $totalNew = $New + $newReverted;

        $data = MainWorkerForm::get();

        return view('MIS', compact('onboardingReverted', 'newReverted', 'newRejected', 'onboardingRejected', 'approveOnboarding', 'approveNew', 'totalPendingOnboarding', 'totalPendingNew', 'totalOnboarding', 'totalNew', 'data', 'countApproved', 'countPending', 'countForwarded', 'countReverted', 'countRejected', 'rowCount'));
    }

    public function sop1()
    {
        return view('sop1');
    }

    public function sop2()
    {
        return view('sop2');
    }

    public function sop3()
    {
        return view('sop3');
    }
    public function sop4()
    {
        return view('sop4');
    }
    public function sop5()
    {
        return view('sop5');
    }
    public function sop6()
    {
        return view('sop6');
    }
    public function sop7()
    {
        return view('sop7');
    }
    public function tenders()
    {
        return view('tenders');
    }
    public function benefits2()
    {
        return view('benefits2');
    }
    public function cess()
    {
        return view('cess');
    }
    public function grievance()
    {
        return view('grievance');
    }


    public function gallery()
    {
        return view('gallery');
    }
    // public function downloads()
    // {

    //     return view('downloads');
    // }

    public function downloads()
    {
        $download = IndexNotification::where('category', 7)
            ->orderBy('id', 'desc')
            ->get();

        return view('downloads', compact('download'));
    }


    public function cscdetails()
    {

        $districts = DB::table('Masterdata.districts')->where('state_code', '=', 18)->orderBy('district_name')->get();
        // dd($districts);
        $cscdetails = CscList::get();
        return view('cscdetails', compact('cscdetails', 'districts'));
    }


    // public function search()
    // {
    //     $pfcdetails = PfcList::get();
    //     return view('pfcdetails', compact('search'));
    // }


    public function checklistpfc()
    {

        return view('checklistpfc');
    }
    public function helpdesk()
    {

        return view('helpdesk');
    }


    public function sitemaps()
    {
        return view('sitemaps');
    }

    public function progressreport()
    {
        return view('progressreport');
    }
    public function termsofuse()
    {
        return view('termsofuse');
    }
    public function copyrightpolicy()
    {
        return view('copyrightpolicy');
    }

    public function privacypolicy()
    {
        return view('privacypolicy');
    }
    public function accessibilitypolicy()
    {
        return view('accessibilitypolicy');
    }

    public function faq()
    {
        return view('faq');
    }

    public function showPdf()
    {
        // Replace 'sample.pdf' with your actual PDF file path
        $pdfPath = public_path('pdf/The_AadhaarRegulations.pdf');

        return response()->file($pdfPath);
    }

    public function qrCode($id)
    {
        try {
            $workerId = decrypt($id);
            $vaultData = $this->getVaultDataService->getVaultData($workerId, "T");
            $data['getVaultData'] = json_decode($vaultData->getData(), true);
            $data['user'] = MainWorkerForm::where('worker_id', $workerId)->first();
            $data['emblem'] = public_path('/assets/template/images/emblem-dark.png');
            $data['logo'] = public_path('assets/template/images/bocw.png');
            $data['bankDetails'] = MainWorkerBank::where('worker_id', $workerId)->first();
            $data['base64Image'] = $data['getVaultData']['photo'];
            $data['basicDetails'] = MainWorkerBasicDetail::where('worker_id', $workerId)->first();
            $data['add'] = MainWorkerAddress::where('worker_id', $workerId)->first();
            $data['workerDetails'] = MainWorkerFamily::where('worker_id', $workerId)->get();
            $data['family'] = MainWorkerFamily::where('worker_id', $workerId)
                ->whereIn('relation', [3, 4])
                ->where('already_registered', 1)
                ->first();
            if ($data['user']->already_registered == 1) {
                $data['profession_already'] = DB::table('Worker.temporary_worker_basic_details as mwc')
                    ->leftJoin('Masterdata.professions as pro', 'mwc.profession', '=', 'pro.profession_code')
                    ->where('mwc.worker_id', $workerId)
                    ->select(
                        'mwc.profession',
                        'mwc.profession_others',
                        'pro.*'
                    )
                    ->first();
            } else {
                $data['profession'] = DB::table('Worker.main_worker_certificates as mwc')
                    ->leftJoin('Masterdata.professions as pro', 'mwc.profession', '=', 'pro.profession_code')
                    ->where('mwc.worker_id', $workerId)
                    ->select(
                        'mwc.profession',
                        'pro.*'
                    )->first();
            }
            $options = [
                'encoding' => 'utf-8', // Set encoding to UTF-8
                'enable-local-file-access' => true, // Enable external links
            ];
            $html = view('office.dsc-registration.e-sign-id.qr-code', $data)->render();

            // Generate PDF from HTML content
            $pdfContent = Pdf::loadHTML($html)
                ->setOptions($options)
                ->output();

            // Set response headers to indicate PDF content
            return response($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="id-card.pdf"',
            ]);
        } catch (Exception $e) {
            return $e;
            Alert::toast('Failed to load Aadhar Data! Please try after sometimes!', 'error');
            return redirect('home.index');
        }
        // return view('office.dsc-registration.e-sign-id.id-card');
    }
}
