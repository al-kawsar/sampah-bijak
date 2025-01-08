<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Inertia\Inertia;


class DashboardController extends Controller
{

    public function __invoke()
    {
        $role = auth()->user()->role->name;
        // dd($role);
        switch ($role) {
            case 'warga':
                // return 'anjay';
                return $this->CitizenDashboard();
            case 'petugas':
                return $this->OfficerDashboard();
            case 'pemerintah':
                return $this->GovermentDashboard();
            case 'admin':
                return $this->AdminDashboard();
        }
    }

    public function CitizenDashboard()
    {
        return Inertia::render('App/Citizen/Dashboard');
    }
    public function OfficerDashboard()
    {
        return Inertia::render('App/Officer/Dashboard');
    }
    public function GovermentDashboard()
    {
        return Inertia::render('App/Government/Dashboard');
    }
    public function AdminDashboard()
    {
        return Inertia::render('App/Admin/Dashboard');

    }
}
