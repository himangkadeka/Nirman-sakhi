<?php

namespace App\Services;

use App\Models\VaultAccessLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class VaultAuditService
{
    /**
     * Log vault access actions using PHP 8+ features.
     */
    public function log(
        string $actionType,
        ?string $workerId = null,
        ?int $familyId = null,
        ?string $source = null,
        ?string $moduleName = null,
        ?string $transactionId = null
    ): void {
        try {
            $user = Auth::user();

            // Using the nullsafe operator (?->) for clean access
            $exists = VaultAccessLog::where('worker_id', $workerId)
                ->where('user_id', $user?->id)
                ->where('action_type', $actionType)
                ->where('created_at', '>=', now()->subSeconds(5))
                ->exists();

            if (! $exists) {
                VaultAccessLog::create([
                    'worker_id'      => $workerId,
                    'family_id'      => $familyId,
                    'user_id'        => $user?->id,
                    'username'       => $user?->username,
                    'role_id'        => $user?->role_id,
                    'role_name'      => $user?->role_name,
                    'office_code'    => $user?->office_code,
                    'designation'    => $user?->designation,
                    'module_name'    => $moduleName,
                    'action_type'    => $actionType,
                    'source'         => $source,
                    'transaction_id' => $transactionId,
                    'ip_address'     => request()->getClientIp(),
                    'user_agent'     => request()->userAgent(),
                    'session_id'     => session()->getId(),
                    'accessed_at'    => now(),
                ]);
            }
        } catch (Throwable $e) {
            // Using the 'match' expression or improved error reporting is also possible in PHP 8
            Log::error('Vault Audit Failed', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
        }
    }
}