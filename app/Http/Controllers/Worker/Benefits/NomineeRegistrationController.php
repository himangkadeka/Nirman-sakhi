<?php

namespace App\Http\Controllers\Worker\Benefits;

use App\Http\Controllers\Controller;
use App\Models\Benefit;
use App\Models\FormSubmission;
use App\Models\MainWorkerFamily;
use App\Models\MainWorkerForm;
use App\Models\NomineeRegistration;
use App\Models\User;
use App\Services\GetVaultDataService;
use App\Services\SmsGatewayService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class NomineeRegistrationController extends Controller
{

    private $smsService;
    protected $getVaultDataService;

    public function __construct(GetVaultDataService $getVaultDataService, SmsGatewayService $smsService)
    {
        $this->getVaultDataService = $getVaultDataService;
        $this->smsService = $smsService;
    }
    public function index()
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }


        $workerData = session()->get('worker');
        $workerId = $workerData->worker_id;
        try {
            $vaultData = $this->getVaultDataService->getVaultData($workerId, "F");
            $getVaultData = json_decode($vaultData->getData(), true);
        } catch (Exception $e) {
            Alert::error("Aadhar Vault Error, Please try again later!");
            return back();
        }
        $nominees = MainWorkerFamily::where('nominee', 1)->where('worker_id', $workerId)->get();
        // return $nominees;
        return view('worker.benefits.nominee.nominee-registration', compact('getVaultData', 'nominees'));
    }


    public function nomineeEkyc(Request $request, $id)
    {
        if (!session()->get('worker-session')) {
            return Redirect::to('/');
        }

        if ($request->isMethod('get')) {
            try {
                $workerData = session()->get('worker');
                $workerId = $workerData->worker_id;
                $nonceValue = session()->get('nonce_value');

                $nominee = MainWorkerFamily::findOrFail($id);
                $vaultData = $this->getVaultDataService->getVaultData($workerId, "F");
                $getVaultData = json_decode($vaultData->getData(), true);

                return view('worker.benefits.nominee.nominee-ekyc', compact('getVaultData', 'nominee', 'workerData', 'nonceValue'));
            } catch (Exception $e) {
                Alert::error("An error occurred", "We couldn't load the page. Please try again later.");
                return back();
            }
        }

        if ($request->isMethod('post')) {
            $workerData = session()->get('worker');
            $workerId = $workerData->worker_id;
            $validator = Validator::make($request->all(), [
                'Name' => 'required|string',
                'phone' => 'required|string|digits:10',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }


            try {
                DB::beginTransaction();
                $user_id = User::where('username', $workerData->id_card)->first()->id;
                $uid_data = json_decode(session()->get('uid_data'), true);
                $count = NomineeRegistration::where('worker_id', $workerId)->where('status', 1)->count() + 1;
                NomineeRegistration::create([
                    'worker_id' => $workerId,
                    'name' => $request->Name,
                    'phone' => $request->phone,
                    'nominee_percentage' => MainWorkerFamily::where('id', $id)->first()->nominee_percentage,
                    'family_id' => $id,
                    'nominee_or_legal' => 0,
                    'vault_token' => $uid_data['vaultToken'],
                    'valut_passkey' => $uid_data['vaultPassKey'],
                    'status' => 1,
                    'approved_by' => $user_id,
                    'approved_at' => Carbon::now(),
                    'nomine_id' => $workerData->id_card . "-N" . $count
                ]);
                MainWorkerFamily::where('id', $id)->update([
                    'is_nominee_registered' => true,
                    'is_aadhar_verified' => true,
                    'vault_data' => $uid_data['vaultToken'], // Store the vault token
                    'vault_pass_key' => $uid_data['vaultPassKey'],
                    'aadhar_verified_at' => now()
                ]);
                $user = User::Create([
                    'username' => $workerData->id_card . "-N" . $count,
                    'password' => Hash::make($workerData->id_card . "-N" . $count),
                    'firstname' => $request->Name,
                    'lastname' => '-',
                    'phone' => $request->phone,
                    'email' => '-',
                    'role_id' =>  10,
                    'office_id' => $workerData->office_id,
                    'district' => $workerData->district,
                    'status' => 1
                ]);
                DB::commit();

                Alert::success('Success', 'Nominee e-KYC has been completed successfully!');
                return redirect()->route('nominee.index');
            } catch (Exception $e) {
                DB::rollBack();
                Alert::error('Update Failed', 'There was a problem saving the information. Please try again.');
                return redirect()->back()->withInput();
            }
        }

        // Fallback for other request methods (like PUT/DELETE if not expected)
        return Redirect::to('/');
    }


    public function downloadKycAcknowledgment($family_id)
    {
        // 1. Get the authenticated worker's data from the session
        $workerData = session()->get('worker');
        if (!$workerData) {
            // Handle case where worker is not in session
            return redirect()->route('worker-login')->with('error', 'Session expired. Please log in again.');
        }

        // 2. Fetch the full worker record to get the KYC timestamp
        // NOTE: Replace 'kyc_verified_at' with the actual column name in your database
        $wmf = MainWorkerForm::where('worker_id', $workerData->worker_id)->firstOrFail();

        // 3. Prepare the emblem image for the PDF
        $emblemPath = public_path('/assets/template/images/bocw.png');
        $emblem = ''; // Default to empty string
        if (file_exists($emblemPath)) {
            $type = pathinfo($emblemPath, PATHINFO_EXTENSION);
            $data = file_get_contents($emblemPath);
            $emblem = 'data:image/' . $type . ';base64,' . base64_encode($data);
        } else {
            Log::error("Emblem file not found for PDF generation at: " . $emblemPath);
        }

        $nominee_id = NomineeRegistration::where('family_id', $family_id)->where('nomine_id', "!=", null)->exists();
        if ($nominee_id) {
            $nominee_detail = NomineeRegistration::where('family_id', $family_id)->first();
        } else {
            $nominee_detail = null;
        }
        $familyDetail = MainWorkerFamily::find($family_id);
        $vaultData = $this->getVaultDataService->getVaultData($workerData->worker_id, "F");
        $getVaultData = json_decode($vaultData->getData(), true);
        $familyVaultData = $this->getVaultDataService->getFamilyVaultData($family_id);
        $applicantVaultDetails = json_decode($familyVaultData->getData(), true);

        // 5. Render the new Blade view
        $html = view('worker.benefits.nominee.ekyc-acknowledgement', compact(
            'nominee_detail',
            'familyDetail',
            'wmf',
            'getVaultData',
            'applicantVaultDetails',
            'emblem'
        ))->render();

        $fileName = 'KYC-Acknowledgment-' . $wmf->id_card . '.pdf';

        // 6. Generate and stream the PDF
        $pdfContent = Pdf::loadHTML($html)->output();

        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
        ]);
    }

    public function dashboard()
    {
        $nominee = session()->get('nominee');
        $getDetails = NomineeRegistration::where('nomine_id', $nominee)->first();
        $userDetails = User::where('username', $nominee)->first();
        $getVaultData = [
            'name' => $getDetails->name
        ];
        $userRoleId = $userDetails->role_id;

        // 2. Get ALL active benefits from the database first
        $allActiveBenefits = Benefit::where('status', 1)->orderBy('id')->get();

        // 3. Filter the collection in PHP
        $benefits = $allActiveBenefits->filter(function ($benefit) use ($userRoleId) {
            // Check if the role_ids string is not empty
            if (empty($benefit->role_ids)) {
                return false;
            }

            // Convert the comma-separated string into an array of IDs
            $roleIdsArray = explode(',', $benefit->role_ids);

            // Check if the user's role ID exists in that array
            // We use in_array() which is perfect for this check
            return in_array($userRoleId, $roleIdsArray);
        });
        // $applications = FormSubmission::where('worker_id', $workerData->worker_id)->get();
        return view('worker.benefits.nominee.nominee-dashboard', compact('getVaultData', 'benefits','getDetails'));
    }
}
