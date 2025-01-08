<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\WasteReport\StoreRequest;
use App\Http\Requests\Dashboard\WasteReport\UpdateRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\WasteReport;
use Inertia\Inertia;
use App\Traits\ApiResponse;
use App\Traits\PaginatesData;
class WasteReportController extends Controller
{
    use ApiResponse, PaginatesData;

    const PAGE = 'waste_report';

    public function index()
    {

        $role = auth()->user()->role->name;

        switch ($role) {
            case 'warga':
            case 'petugas':
                return $this->WasteReportPage();
            case 'admin':
            case 'pemerintah':
                return $this->WasteReportManagement();
        }
    }
    public function getData(Request $request)
    {
        try {
            $query = $request->input('search');
            $limit = $request->input('limit', 10);
            $type = $request->input('type', 'search');

            $query = $request->input('search');
            if ($query) {
                $cacheKey = self::PAGE . '_search:' . md5($query);

                $results = Cache::remember($cacheKey, 60, function () use ($query, $limit) {
                    return WasteReport::where('username', 'LIKE', "%$query%")
                        ->orWhere('email', 'LIKE', "%$query%")
                        ->orderBy('id', 'desc')
                        ->paginate($limit);
                });

                return $this->success($results->items(), "Get Search Data", pagination: $this->getPaginationData($results));

            }

            $data = WasteReport::with([
                'user:id,email',                      // Relasi user
                'user.profile',                      // Relasi bersarang: role dari user
                'location:id,name,address',              // Relasi location
                'category:id,name'                       // Relasi category
            ])
                ->orderBy('category_id', 'desc')->paginate($limit);


            return $this->success($data->items(), "Get All Data", pagination: $this->getPaginationData($data));

        } catch (\Exception $e) {
            return $this->internalServerError('Failed to retrieve data', 500, $e->getMessage());
        }
    }



    public function store(StoreRequest $request)
    {
        try {
            $payload = $request->validated();

            WasteReport::create($payload);

            return $this->success(message: 'Success Create Data');

        } catch (\Exception $e) {
            return $this->internalServerError($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(WasteReport $id)
    {
        return Inertia::render("App/Management/WasteReport/Show", [
            "waste_report" => $id
        ]);
    }

    public function create()
    {
        return Inertia::render("App/Management/WasteReport/Create");
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, WasteReport $id)
    {
        try {
            $payload = $request->validated();

            $id->updateOrFail($payload);

            return $this->success(message: 'Success Update Data');
        } catch (\Exception $e) {
            return $this->internalServerError($e->getMessage(), 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WasteReport $id)
    {
        try {
            if ($id->delete()) {
                return $this->success(message: 'Success Destroy Data');
            }

            return $this->error('Failed Destroy Data');

        } catch (\Exception $e) {
            return $this->internalServerError($e->getMessage(), 500);
        }
    }

    public function WasteReportManagement()
    {
        return Inertia::render('App/Management/WasteReport/Index');
    }
    public function WasteReportPage()
    {
        return Inertia::render('App/Citizen/WasteReport');
    }
}
