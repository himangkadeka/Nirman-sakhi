<?php

namespace App\Http\Controllers\Admin\MISData;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\Office;
use App\Models\User;
use App\Models\PfcKioskDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;

class PortalUserController extends Controller
{
    public function index()
    {

        $users = User::where('role_id', '<>', 6)->orderBY('id')->get();
        $designations = Designation::orderBy('id')->get();
        $offices = Office::get();
        $roles = Role::where('id', '<>', 6)->get();
        $pfcdata = PfcKioskDetail::orderBy('id')->get();
        return view('admin.mis-data.portal-user-data.index', compact('users', 'designations', 'offices', 'roles', 'pfcdata'));
    }
}
