<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use App\Traits\ApiResponse;
use App\Traits\PaginatesData;

class SettingController extends Controller
{
    public function profilePage(){
        return Inertia::render("App/Management/Setting/Profile");
    }
    public function updateProfile(){
        return 'data';
    }
    public function accountPage(){
        return Inertia::render("App/Management/Setting/Account");
    }
    public function updateAccount(){
        return 'data';
    }
}