<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SecurityController;
use App\Models\District;
use App\Models\MainWorkerForm;
use App\Models\State;
use App\Models\SubDistrict;
use App\Services\AesCipher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class WorkerDataController extends Controller
{
    public function fetchWorkerData(Request $request)
    {
        $request->validate([
            'id_card' => 'required',
        ]);

        $idCard = $request->input('id_card');
        $worker = DB::table('Worker.main_worker_forms as wmf')
//            ->join('Worker.main_worker_basic_details as wmd','wmf.worker_id','=','wmd.worker_id' )
//            ->join('Worker.main_worker_addresses as wma','wmf.worker_id','=','wma.worker_id')
//            ->select('wmf.*','wmd.*','wma.*')
            ->where('wmf.id_card', $idCard)
            ->first();

        if ($worker) {
            Session::put('workerData', $worker);
            return response()->json([
                'success' => true,
                'msg' => 'Worker record found.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Worker data not found.'
            ], 404);
        }
    }

    public  function showData()
    {
        $workerData = Session::get('workerData');
        $worker_id = $workerData->worker_id;
        if ($workerData) {

            $vaultDataNew = $this->getVaultData($worker_id);
            $getVaultData = json_decode($vaultDataNew, true);
            $renewalDate = \Carbon\Carbon::parse($workerData->renewal_date);
            return view('worker.show-worker-data',compact('workerData','getVaultData','renewalDate'));
        } else {
            abort(404);
        }
    }

    public function vaultEnc($worker_id)
    {

        $data = DB::table('Worker.main_worker_forms')->where('worker_id',$worker_id)->first();
        $vaultToken = $data->vaultToken;
        $vaultPass = $data->vaultPassKey;
        $string = '{"vaultToken":"'.$vaultToken.'","vaultPassKey":"'.$vaultPass.'"}';
        $securityController = new SecurityController();
        $key = "VGHJnjhgvhfGCGVBhjghh45678iHgTFgvhbjnFFGHJ87FGHJRTYUIO";
        $licenceKey = $securityController->decrypt(env('LICENSE_KEY'),$key);
        $encrypted = AesCipher::encrypt($licenceKey, $string);
        return $encrypted->getData();
    }

    public function getVaultData($worker_id)
    {

        $transactionId = substr(md5(uniqid(mt_rand(), true)),0, 23);
        $agencyCode = env('AGENCY_CODE');
        $securityController = new SecurityController();
        $key = "VGHJnjhgvhfGCGVBhjghh45678iHgTFgvhbjnFFGHJ87FGHJRTYUIO";
        $secretkey = $securityController->decrypt(env('LICENSE_KEY'),$key);
        // $secretkey = env('LICENSE_KEY');
        $encryptedData = $this->vaultEnc($worker_id);
        $postData =
            [
                'encData' => $encryptedData,
                'transactionId' => $transactionId,
                'agencyCode' => $agencyCode,
            ];
        $url = "https://aua.assam.gov.in/ditecapi/v2/php/get-vault-data";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json', // Set Content-Type header
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute cURL session
        $response = curl_exec($ch);


        if ($response === false) {
            $error = curl_error($ch);

            // Handle error
            return response()->json(['error' => 'Failed to send post request', 'message' => $error]);
        }
        // Close cURL session
        curl_close($ch);
        $vaultData = json_decode($response, true);

        $encResponseData = $vaultData['encResponseData'];
        return AesCipher::decrypt($secretkey, $encResponseData);

    }

}
