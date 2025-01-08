<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Region\StoreRequest;
use App\Http\Requests\Dashboard\Region\UpdateRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\Region;
use Inertia\Inertia;
use App\Traits\ApiResponse;
use App\Traits\PaginatesData;

class RegionController extends Controller
{
    use ApiResponse, PaginatesData;

    const PAGE = 'regions';

    public function index()
    {

        return Inertia::render("App/Management/Region/Index");
    }
    public function getData(Request $request)
    {
        try {
            $count = Region::count();

            $query = $request->input('search');
            $limit = $request->input('limit', $count);
            $type = $request->input('type', 'search');

            $query = $request->input('search');
            if ($query) {
                $cacheKey = self::PAGE . '_search:' . md5($query);

                $results = Cache::remember($cacheKey, 60, function () use ($query, $limit) {
                    return Region::where('region_name', 'LIKE', "%$query%")
                        ->orderBy('id', 'desc')
                        ->paginate($limit);
                });

                return $this->success($results->items(), "Get Search Data", pagination: $this->getPaginationData($results));

            }

            if ($type === "search")
                $data = Region::query()->orderBy('region_name', 'asc')->paginate($limit);


            return $this->success($data->items(), "Get All Data", pagination: $this->getPaginationData($data));

        } catch (\Exception $e) {
            return $this->internalServerError('Failed to retrieve data', 500, $e->getMessage());
        }
    }


    public function create()
    {
        return Inertia::render("App/Management/Region/Create");
    }
    public function store(StoreRequest $request)
    {
        try {
            $payload = $request->validated();

            Region::create($payload);

            return $this->success(message: 'Success Create Data');

        } catch (\Exception $e) {
            return $this->internalServerError($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Region $id)
    {
        return Inertia::render("App/Management/Region/Show", [
            "region" => $id
        ]);
    }

    public function edit(Region $id)
    {
        return Inertia::render("App/Management/Region/Edit", [
            "region" => $id
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Region $id)
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
    public function destroy(Region $id)
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
}
