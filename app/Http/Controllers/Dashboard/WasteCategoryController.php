<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\WasteCategory\StoreRequest;
use App\Http\Requests\Dashboard\WasteCategory\UpdateRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\WasteCategory;
use Inertia\Inertia;
use App\Traits\ApiResponse;
use App\Traits\PaginatesData;

class WasteCategoryController extends Controller
{
    use ApiResponse, PaginatesData;

    const PAGE = 'waste_category';

    public function index()
    {
        $role = auth()->user()->role->name;

        switch ($role) {
            case 'admin':
            case 'pemerintah':
                return $this->WasteCategoryManagement();
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
                    return WasteCategory::where('username', 'LIKE', "%$query%")
                        ->orWhere('email', 'LIKE', "%$query%")
                        ->orderBy('id', 'desc')
                        ->paginate($limit);
                });

                return $this->success($results->items(), "Get Search Data", pagination: $this->getPaginationData($results));

            }

            if ($type === "search")
                $data = WasteCategory::query()->orderBy('id', 'desc')->paginate($limit);
            // if ($type === "filter")
            //     $data = WasteCategory::limit($limit)->get(['id', 'name']);


            return $this->success($data->items(), "Get Search Data", pagination: $this->getPaginationData($data));

        } catch (\Exception $e) {
            return $this->internalServerError('Failed to retrieve data', 500, $e->getMessage());
        }
    }



    public function store(StoreRequest $request)
    {
        try {
            $payload = $request->validated();

            WasteCategory::create($payload);

            return $this->success(message: 'Success Create Data');

        } catch (\Exception $e) {
            return $this->internalServerError($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(WasteCategory $id)
    {
        return Inertia::render("App/Management/WasteCategory/Show", [
            "wasteCategory" => $id
        ]);
    }
    public function edit(WasteCategory $id)
    {
        return Inertia::render("App/Management/WasteCategory/Edit", [
            "wasteCategory" => $id
        ]);
    }
    public function create()
    {
        return Inertia::render("App/Management/WasteCategory/Create");
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, WasteCategory $id)
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
    public function destroy(WasteCategory $id)
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

    public function WasteCategoryManagement()
    {
        return Inertia::render('App/Management/WasteCategory/Index');
    }
}
