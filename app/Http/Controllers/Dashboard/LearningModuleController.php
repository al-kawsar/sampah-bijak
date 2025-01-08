<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\LearningModule\StoreRequest;
use App\Http\Requests\Dashboard\LearningModule\UpdateRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\LearningModule;
use Inertia\Inertia;
use App\Traits\ApiResponse;
use App\Traits\PaginatesData;
class LearningModuleController extends Controller
{
    use ApiResponse, PaginatesData;

    const PAGE = 'learning_modules';

    public function index()
    {
        $role = auth()->user()->role->name;

        switch ($role) {
            case 'warga':
            case 'petugas':
                return $this->LearningModulePage();
            case 'admin':
            case 'pemerintah':
                return $this->LearningModuleManagement();
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
                    return LearningModule::where('username', 'LIKE', "%$query%")
                        ->orWhere('email', 'LIKE', "%$query%")
                        ->orderBy('id', 'desc')
                        ->paginate($limit);
                });

                return $this->success($results->items(), "Get Search Data", pagination: $this->getPaginationData($results));

            }

            if ($type === "search")
                $data = LearningModule::query()->orderBy('id', 'desc')->paginate($limit);
            // if ($type === "filter")
            //     $data = LearningModule::limit($limit)->get(['id', 'name']);


            return $this->success($data->items(), "Get Search Data", pagination: $this->getPaginationData($data));

        } catch (\Exception $e) {
            return $this->internalServerError('Failed to retrieve data', 500, $e->getMessage());
        }
    }



    public function store(StoreRequest $request)
    {
        try {
            $payload = $request->validated();

            LearningModule::create($payload);

            return $this->success(message: 'Success Create Data');

        } catch (\Exception $e) {
            return $this->internalServerError($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(LearningModule $id)
    {
        return Inertia::render("App/Management/LearningModule/Show", [
            "module" => $id
        ]);
    }
    public function create(LearningModule $id)
    {
        return Inertia::render("App/Management/LearningModule/Create");
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, LearningModule $id)
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
    public function destroy(LearningModule $id)
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

    public function LearningModulePage()
    {
        return Inertia::render('App/Citizen/LearningModules');
    }
    public function LearningModuleManagement()
    {
        return Inertia::render('App/Management/LearningModule/Index');
    }
}
