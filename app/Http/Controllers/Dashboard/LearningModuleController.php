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
use App\Services\FileService;
use Illuminate\Validation\ValidationException;


class LearningModuleController extends Controller
{
    use ApiResponse, PaginatesData;

    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }
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
            $id = $request->input('id');

            if ($id) {
                return $this->getDetailData($id);
            }

            if ($query) {
                $cacheKey = self::PAGE . '_search:' . md5($query);

                $results = Cache::remember($cacheKey, 60, function () use ($query, $limit) {
                    return LearningModule::where('title', 'LIKE', "%$query%")
                    ->orWhere('thumbnail', 'LIKE', "%$query%")
                    ->orderBy('updated_at', 'desc')
                    ->paginate($limit);
                });

                return $this->success($results->items(), "Get Search Data", pagination: $this->getPaginationData($results));

            }

            if ($type === "search")
                $data = LearningModule::query()->orderBy('updated_at', 'desc')->paginate($limit);


            return $this->success($data->items(), "Get All Data", pagination: $this->getPaginationData($data));

        } catch (\Exception $e) {
            return $this->internalServerError('Failed to retrieve data', 500, $e->getMessage());
        }
    }

    public function getDetailData($id)
    {
        try {
        // Mencari modul pembelajaran berdasarkan ID
            $module = LearningModule::findOrFail($id);

        // Mengembalikan data modul dalam format sukses
            return $this->success($module, "Get Module Detail Data");
        } catch (ModelNotFoundException $e) {
            return $this->notFound('Module not found', 404);
        } catch (\Exception $e) {
            return $this->internalServerError('Failed to retrieve data', 500, $e->getMessage());
        }
    }



    public function store(StoreRequest $request)
    {
        try {
            $payload = $request->validated();

            if ($request->hasFile('thumbnail')) {
                $request_file = $request->file('thumbnail');
                $file = $this->fileService->uploadFile($request_file);
            } else {
                throw ValidationException::withMessages(['profile_picture' => 'Thumbnail Wajib diisi.']);
            }

            $payload['thumbnail'] = $file->full_path;

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
    public function edit(LearningModule $id)
    {
        return Inertia::render("App/Management/LearningModule/Edit", [
            "module" => $id
        ]);
    }
    public function create()
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

            // if ($request->hasFile('thumbnail')) {
            //     $request_file = $request->file('thumbnail');
            //     $file = $this->fileService->uploadFile($request_file);
            //     $payload['thumbnail'] = $file->full_path;
            //     $msg = "update";
            // }else {
            $msg = " update";
            $payload['thumbnail'] = $id->thumbnail;
            // }

            // $msg = "non update";
            $id->update($payload);

            return $this->success(message: 'Success Update Data' . $msg);
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
