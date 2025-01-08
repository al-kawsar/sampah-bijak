<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\User\StoreRequest;
use App\Http\Requests\Dashboard\User\UpdateRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use App\Traits\ApiResponse;
use App\Traits\PaginatesData;

class UserController extends Controller
{
    use ApiResponse, PaginatesData;

    const PAGE = 'users';

    public function index()
    {
        return Inertia::render("App/Management/User/Index");
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
                    return User::where('username', 'LIKE', "%$query%")
                        ->orWhere('email', 'LIKE', "%$query%")
                        ->orderBy('id', 'desc')
                        ->paginate($limit);
                });

                return $this->success($results->items(), "Get Search Data", pagination: $this->getPaginationData($results));
            }

            $data = User::with(['profile', 'role','region'])->orderBy('id', 'desc')->paginate($limit);


            return $this->success($data->items(), "Get All Data", pagination: $this->getPaginationData($data));

        } catch (\Exception $e) {
            return $this->internalServerError('Failed to retrieve data', 500, $e->getMessage());
        }
    }



    public function store(StoreRequest $request)
    {
        try {
            $payload = $request->validated();

            User::create($payload);

            return $this->success(message: 'Success Create Data');

        } catch (\Exception $e) {
            return $this->internalServerError($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $id)
    {
        return Inertia::render("App/Management/User/Show", [
            "user" => $id
        ]);
    }
    public function edit(User $id)
    {
        return Inertia::render("App/Management/User/Edit", [
            "user" => $id
        ]);
    }

    public function create()
    {
        return Inertia::render("App/Management/User/Create");
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, User $id)
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
    public function destroy(User $id)
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

    public function profile()
    {
        return 'data';
    }


}
