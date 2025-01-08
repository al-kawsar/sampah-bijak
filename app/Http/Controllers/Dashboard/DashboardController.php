<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\FAQ;
use App\Models\File;
use App\Models\HomepageSlider;
use App\Models\LearningModule;
use App\Models\Notification;
use App\Models\PickupSchedule;
use App\Models\Region;
use App\Models\Role;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\WasteCategory;
use App\Models\WasteItem;
use App\Models\WasteLocation;
use App\Models\WasteReminder;
use App\Models\WasteReport;


class DashboardController extends Controller
{

    public function __invoke()
    {
        $role = auth()->user()->role->name;
        // dd($role);
        switch ($role) {
            case 'warga':
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
        $data['totalUsers'] = User::count() ;
        $data['totalReports'] = WasteReport::count() ;
        $data['totalEvents'] = Event::count() ;
        $data['totalModules'] = LearningModule::count() ;

        return Inertia::render('App/Admin/Dashboard',[
            'data' => $data
        ]);

    }
}
