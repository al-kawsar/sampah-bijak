<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\PickupSchedule\StoreRequest;
use App\Http\Requests\Dashboard\PickupSchedule\UpdateRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\PickupSchedule;
use Inertia\Inertia;
use App\Traits\ApiResponse;
use App\Traits\PaginatesData;
class PickupScheduleController extends Controller
{
    use ApiResponse, PaginatesData;

    const PAGE = 'pickup_schedules';

    public function index()
    {

        $role = auth()->user()->role->name;

        switch ($role) {
            case 'warga':
            return $this->CitizenPickup();
            case 'petugas':
            return $this->OfficerPickup();
            case 'admin':
            case 'pemerintah':
            return $this->ManagementPickup();
            default:
            abort(404);
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
                    return PickupSchedule::where('username', 'LIKE', "%$query%")
                    ->orWhere('email', 'LIKE', "%$query%")
                    ->orderBy('id', 'desc')
                    ->paginate($limit);
                });

                return $this->success($results->items(), "Get Search Data", pagination: $this->getPaginationData($results));

            }

            if ($type === "search")
                $data = PickupSchedule::with(['user.profile'])->orderBy('id', 'desc')->paginate($limit);


            return $this->success($data->items(), "Get Search Data", pagination: $this->getPaginationData($data));

        } catch (\Exception $e) {
            return $this->internalServerError('Failed to retrieve data', 500, $e->getMessage());
        }
    }



    public function store(StoreRequest $request)
    {
        try {
            $payload = $request->validated();

            PickupSchedule::create($payload);

            return $this->success(message: 'Success Create Data');

        } catch (\Exception $e) {
            return $this->internalServerError($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PickupSchedule $id)
    {
        return Inertia::render("App/Detail", [
            "student" => $id
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, PickupSchedule $id)
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
    public function destroy(PickupSchedule $id)
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

    public function CitizenPickup()
    {
        return Inertia::render('App/Citizen/PickupSchedule');
    }
    public function OfficerPickup()
    {
        return Inertia::render('App/Officer/PickupSchedule');
    }
    public function ManagementPickup()
    {
        return Inertia::render('App/Management/PickupSchedule/Index');
    }
}
