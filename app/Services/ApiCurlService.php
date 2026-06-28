<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiCurlService
{
    public function sendPostRequest($url, $data)
    {
        $options = [
            CURLOPT_URL            => $url,
            CURLOPT_POST           => 1,
            CURLOPT_POSTFIELDS     => http_build_query($data),
            CURLOPT_RETURNTRANSFER => true,
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        return json_decode($response);
    }
    public function fetchDataFromApi(Request $request)
    {
        $url = 'http://localhost/labour_old/api/getOneUser.php';

        $data = [
            'id_card' => $request->worker_id,
        ];

        try {
            $response = Http::post($url, $data);

            if ($response->successful()) {
                $apiResponse = $response->json();
                return response()->json($apiResponse);
            } else {

                return response()->json(['error' => 'API request failed'], $response->status());
            }
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

