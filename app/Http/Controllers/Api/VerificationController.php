<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MainWorkerForm;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    public function verify(Request $request)
    {
        // Sanctum has already authenticated the service user
        $serviceUser = $request->user();

        // Log the verification attempt (AUDIT LOG)
        Log::info('ID verification request', [
            'service_user' => $serviceUser->username, // from User.users table
            'id_card'   => $request->id_card,
            'ip_address'   => $request->ip(),
            'timestamp'    => now()->toDateTimeString(),
        ]);

        // Validate request
        $request->validate([
            'id_card' => 'required|string|max:50',
        ]);

        // Business logic
        $worker = MainWorkerForm::where('id_card', $request->id_card)->first();

        if (!$worker) {
            return response()->json([
                'success' => false,
                'message' => 'BOCW ID Card not found in Nirman Sakhi',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'BOCW ID Card verified successfully',
        ]);
    }
}
