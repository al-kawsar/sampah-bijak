<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Event\StoreRequest;
use App\Http\Requests\Dashboard\Event\UpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\Event;
use Inertia\Inertia;
use App\Traits\ApiResponse;
use App\Traits\PaginatesData;

class EventController extends Controller
{
    use ApiResponse, PaginatesData;

    const PAGE = 'events';

    public function index()
    {
        $role = auth()->user()->role->name;

        switch ($role) {
            case 'warga':
            case 'petugas':
            return $this->EventPage();
            case 'pemerintah':
            case 'admin':
            return $this->EventManagement();
        }

    }
    public function getData(Request $request)
    {
        try {
            $query = $request->input('search');
            $limit = $request->input('limit', 10);
            $type = $request->input('type', 'search');

            $query = $request->input('search');
            if ($query !== "") {
                $cacheKey = self::PAGE . '_search:' . md5($query);

                $results = Cache::remember($cacheKey, 60, function () use ($query, $limit) {
                    return Event::where('title', 'LIKE', "%$query%")
                    ->orWhere('description', 'LIKE', "%$query%")
                    ->orWhere('location', 'LIKE', "%$query%")
                    ->orderBy('id', 'desc')
                    ->paginate($limit);
                });

                return $this->success($results->items(), "Get Search Data", pagination: $this->getPaginationData($results));
            }

            if ($type === "search")
                $data = Event::query()->orderBy('id', 'desc')->paginate($limit);

            return $this->success($data->items(), "Get All Data", pagination: $this->getPaginationData($data));
        } catch (\Exception $e) {
            return $this->internalServerError('Failed to retrieve data', 500, $e->getMessage());
        }
    }



    public function store(StoreRequest $request)
    {
        try {
            $payload = $request->validated();

            $payload['organizer_id'] = auth()->id();

            Event::create($payload);

            return $this->success(message: 'Success Create Data');

        } catch (\Exception $e) {
            return $this->internalServerError($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $id)
    {
        return Inertia::render("App/Management/Event/Show", [
            "event" => $id
        ]);
    }
    public function edit(Event $id)
    {
        return Inertia::render("App/Management/Event/Edit", [
            "event" => $id
        ]);
    }
    public function create()
    {
        return Inertia::render("App/Management/Event/Create");
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Event $id)
    {
        try {
            $payload = $request->validated();

            $payload['organizer_id'] = auth()->id();

            $id->updateOrFail($payload);

            return $this->success(message: 'Success Update Data');
        } catch (\Exception $e) {
            return $this->internalServerError($e->getMessage(), 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $id)
    {
        try {
            if ($id->delete()) {
                return $this->success(message: 'Success Destroy Data Event');
            }

            return $this->error('Failed Destroy Data');

        } catch (\Exception $e) {
            return $this->internalServerError($e->getMessage(), 500);
        }
    }

    public function EventPage()
    {
        return Inertia::render('App/Event/Event');
    }
    public function EventManagement()
    {
        return Inertia::render('App/Management/Event/Index');
    }
}
