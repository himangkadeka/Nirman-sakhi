<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Controllers\SecurityController;
use Illuminate\Support\Facades\DB;
use App\Services\AesCipher;

class VaultData extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'Worker.vault_data';

    protected $fillable = [
        'worker_id',
        'vault_token',
        'enc_data'
    ];

    public static function getDecryptedAadhaarDataByWorkerId($workerId)
    {
        $encData = self::where('worker_id', $workerId)->value('enc_data');

        if (!$encData) {
            return [];
        }

        $uidData = ['encResponseData' => $encData];

        $security = new SecurityController();
        $salt = DB::table('Masterdata.key_values')->where('key', 'SALT_VALUE')->value('value');
        $licenseKeyEnc = DB::table('Masterdata.key_values')->where('key', 'LICENSE_KEY')->value('value');
        $licenseKey = $security->decrypt($licenseKeyEnc, $salt);

        $encryptedData = $uidData['encResponseData'] ?? null;
        return json_decode(AesCipher::decrypt($licenseKey, $encryptedData), true) ?? [];
    }
}
