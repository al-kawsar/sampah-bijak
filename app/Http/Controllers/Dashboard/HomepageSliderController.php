<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\HomepageSlider\StoreRequest;
use App\Http\Requests\Dashboard\HomepageSlider\UpdateRequest;
use App\Models\HomepageSlider;
use Inertia\Inertia;
use App\Traits\ApiResponse;
use App\Traits\PaginatesData;

class HomepageSliderController extends Controller
{
    use ApiResponse, PaginatesData;

    const PAGE = 'homepage_sliders';

    public function index()
    {

        return Inertia::render("App/Management/Slider/Index");
    }
    public function getData(Request $request)
    {
        try {
            $limit = $request->input('limit', 10);

            $data = HomepageSlider::query()->orderBy('id', 'desc')->paginate($limit);

            return $this->success($data->items(), "Get Search Data", pagination: $this->getPaginationData($data));

        } catch (\Exception $e) {
            return $this->internalServerError('Failed to retrieve data', 500, $e->getMessage());
        }
    }



    public function store(StoreRequest $request)
    {
        try {
            $payload = $request->validated();

            HomepageSlider::create($payload);

            return $this->success(message: 'Success Create Data');

        } catch (\Exception $e) {
            return $this->internalServerError($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(HomepageSlider $id)
    {
        return Inertia::render("App/Management/Slider/Show", [
            "slider" => $id
        ]);
    }
    public function create(HomepageSlider $id)
    {
        return Inertia::render("App/Management/Slider/Create");
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, HomepageSlider $id)
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
    public function destroy(HomepageSlider $id)
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
