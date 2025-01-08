<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\WasteReminder\StoreRequest;
use App\Http\Requests\Dashboard\WasteReminder\UpdateRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\WasteReminder;
use Inertia\Inertia;
use App\Traits\ApiResponse;
use App\Traits\PaginatesData;
class WasteReminderController extends Controller
{
    use ApiResponse, PaginatesData;

    const PAGE = 'waste_reminder';

    public function index()
    {

        // return Inertia::render("App/Data");
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
                    return WasteReminder::where('username', 'LIKE', "%$query%")
                        ->orWhere('email', 'LIKE', "%$query%")
                        ->orderBy('id', 'desc')
                        ->paginate($limit);
                });

                return $this->success($results->items(), "Get Search Data", pagination: $this->getPaginationData($results));

            }

            if ($type === "search")
                $data = WasteReminder::query()->orderBy('id', 'desc')->paginate($limit);
            // if ($type === "filter")
            //     $data = WasteReminder::limit($limit)->get(['id', 'name']);


            return $this->success($data->items(), "Get Search Data", pagination: $this->getPaginationData($data));

        } catch (\Exception $e) {
            return $this->internalServerError('Failed to retrieve data', 500, $e->getMessage());
        }
    }



    public function store(StoreRequest $request)
    {
        try {
            $payload = $request->validated();

            WasteReminder::create($payload);

            return $this->success(message: 'Success Create Data');

        } catch (\Exception $e) {
            return $this->internalServerError($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(WasteReminder $id)
    {
        return Inertia::render("App/Detail", [
            "student" => $id
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, WasteReminder $id)
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
    public function destroy(WasteReminder $id)
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
