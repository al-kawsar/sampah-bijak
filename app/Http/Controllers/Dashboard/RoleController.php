<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Role\StoreRequest;
use App\Http\Requests\Dashboard\Role\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\Role;
use Inertia\Inertia;
use App\Traits\ApiResponse;
use App\Traits\PaginatesData;

class RoleController extends Controller
{
    use ApiResponse, PaginatesData;

    const PAGE = 'roles';

    public function index()
    {

        return Inertia::render("App/Management/Role/Index");
    }
    public function getData(Request $request)
    {
        try {
            $data = Role::query()->orderBy('id', 'desc')->get();

            return $this->success($data, "Get All Data");

        } catch (\Exception $e) {
            return $this->internalServerError('Failed to retrieve data', 500, $e->getMessage());
        }
    }



    public function store(StoreRequest $request)
    {
        try {
            $payload = $request->validated();

            Role::create($payload);

            return $this->success(message: 'Success Create Data');

        } catch (\Exception $e) {
            return $this->internalServerError($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $id)
    {
        return Inertia::render("App/Detail", [
            "student" => $id
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Role $id)
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
    public function destroy(Role $id)
    {
        try {
            if ($id->delete()) {
                Cache::flush();
                return $this->success(message: 'Success Destroy Data');
            }

            return $this->error('Failed Destroy Data');

        } catch (\Exception $e) {
            return $this->internalServerError($e->getMessage(), 500);
        }
    }
}
