<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Event\StoreRequest;
use App\Http\Requests\Dashboard\Event\UpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Services\FileService;
use Inertia\Inertia;
use App\Traits\ApiResponse;
use App\Traits\PaginatesData;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    use ApiResponse, PaginatesData;

    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

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


            if ($type === "search" && $query !== null) {

                $results = Event::where('title', 'LIKE', "%$query%")
                ->orWhere('description', 'LIKE', "%$query%")
                ->orderBy('id', 'desc')
                ->paginate($limit);

                return $this->success($results->items(), "Get Search Data", pagination: $this->getPaginationData($results));
            }

            $data = Event::with('organizer:id,username')->select('id','title','description','date','location','thumbnail_url','capacity', 'organizer_id')->orderBy('updated_at', 'desc')->paginate($limit);
            $data->getCollection()->transform(function ($event) {
                $event->organizer_id = $event->organizer ? $event->organizer->username : null;
                return $event;
            });


            return $this->success($data->items(), "Get All Data", pagination: $this->getPaginationData($data));
        } catch (\Exception $e) {
            return $this->internalServerError('Failed to retrieve data', 500, $e->getMessage());
        }
    }



    public function store(StoreRequest $request)
    {
        try {
            $payload = $request->validated();

            if ($request->hasFile('thumbnail_url')) {
                $request_file = $request->file('thumbnail_url');
                $file = $this->fileService->uploadFile($request_file);
            } else {
                throw ValidationException::withMessages(['thumbnail_url' => 'Thumbnail Wajib diisi.']);
            }

            $payload['thumbnail_url'] = $file->full_path;
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
      $event = Event::with(['organizer', 'eventParticipants', 'organizer.profile'])
      ->withCount([
        'eventParticipants',
        'eventParticipants as registered_count' => function($query) {
            $query->where('status', 'registered');
        }
    ])
      ->findOrFail($id->id);

      return Inertia::render("App/Management/Event/Show", [
        "event" => array_merge($event->toArray(), [
            'participant_percentage' => $event->capacity > 0
            ? round(($event->registered_count / $event->capacity) * 100)
            : 0,
        ])
    ]);
  }

  public function create()
  {
    return Inertia::render("App/Management/Event/Create");
}


public function update(UpdateRequest $request, Event $id)
{
    try {
        $payload = $request->validated();

        if ($request->hasFile('thumbnail_url')) {
            if ($id->thumbnail_url) {
                $this->fileService->deleteFileByPath($id->thumbnail_url);
            }

            $requestFile = $request->file('thumbnail_url');
            $file = $this->fileService->uploadFile($requestFile);
            $payload['thumbnail_url'] = $file->full_path;
        }

        Cache::flush();
        $id->update($payload);

        return $this->success(message: 'Success Update Data');
    } catch (\Exception $e) {
        Log::error('Error updating event:', ['error' => $e->getMessage()]);
        return $this->internalServerError($e->getMessage(), 500);
    }
}

public function edit(Event $id)
{
    return Inertia::render("App/Management/Event/Edit", [
        "event" => $id
    ]);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $id)
    {
        try {
            if ($id->delete()) {
                Cache::flush();
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
