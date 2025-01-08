<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\WasteLocation\StoreRequest;
use App\Http\Requests\Dashboard\WasteLocation\UpdateRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\WasteLocation;
use Inertia\Inertia;
use App\Traits\ApiResponse;
use App\Traits\PaginatesData;

class WasteLocationController extends Controller
{
    use ApiResponse, PaginatesData;

    const PAGE = 'waste_location';

    public function index()
    {

        $role = auth()->user()->role->name;

        switch ($role) {
            case 'warga':
            case 'petugas':
                return $this->WasteLocationPage();
            case 'admin':
            case 'pemerintah':
                return $this->WasteLocationManagement();
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
                    return WasteLocation::where('username', 'LIKE', "%$query%")
                        ->orWhere('email', 'LIKE', "%$query%")
                        ->orderBy('id', 'desc')
                        ->paginate($limit);
                });

                return $this->success($results->items(), "Get Search Data", pagination: $this->getPaginationData($results));

            }

            if ($type === "search")
                $data = WasteLocation::query()->orderBy('id', 'desc')->paginate($limit);
            // if ($type === "filter")
            //     $data = WasteLocation::limit($limit)->get(['id', 'name']);


            return $this->success($data->items(), "Get Search Data", pagination: $this->getPaginationData($data));

        } catch (\Exception $e) {
            return $this->internalServerError('Failed to retrieve data', 500, $e->getMessage());
        }
    }



    public function store(StoreRequest $request)
    {
        try {
            $payload = $request->validated();

            WasteLocation::create($payload);

            return $this->success(message: 'Success Create Data');

        } catch (\Exception $e) {
            return $this->internalServerError($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(WasteLocation $id)
    {
        return Inertia::render("App/Management/WasteLocation/Show", [
            "wasteLocation" => $id
        ]);
    }
    public function create(WasteLocation $id)
    {
        return Inertia::render("App/Management/WasteLocation/Create");
    }
    public function edit(WasteLocation $id)
    {
        return Inertia::render("App/Management/WasteLocation/Edit", [
            "wasteLocation" => $id
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, WasteLocation $id)
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
    public function destroy(WasteLocation $id)
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

    public function WasteLocationPage()
    {
        return Inertia::render("App/Management/WasteLocation/Index");
    }
    public function WasteLocationManagement()
    {
        return Inertia::render("App/Management/WasteLocation/Index");
    }

}
