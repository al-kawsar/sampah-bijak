<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\FAQ\StoreRequest;
use App\Http\Requests\Dashboard\FAQ\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\FAQ;
use Inertia\Inertia;
use App\Traits\ApiResponse;
use App\Traits\PaginatesData;

class FAQController extends Controller
{
    use ApiResponse, PaginatesData;

    const PAGE = 'faqs';

    public function index()
    {

        return Inertia::render("App/Management/FAQ/Index");
    }
    public function getData(Request $request)
    {
        try {
            $limit = $request->input('limit', 10);

            $data = FAQ::query()->orderBy('order_number', 'asc')->paginate($limit);

            return $this->success($data->items(), "Get Search Data", pagination: $this->getPaginationData($data));

        } catch (\Exception $e) {
            return $this->internalServerError('Failed to retrieve data', 500, $e->getMessage());
        }
    }



    public function store(StoreRequest $request)
    {
        try {
            $payload = $request->validated();

            FAQ::create($payload);

            return $this->success(message: 'Success Create Data');

        } catch (\Exception $e) {
            return $this->internalServerError($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FAQ $id)
    {
        return Inertia::render("App/Management/Slider/Show", [
            "faq" => $id
        ]);
    }
    public function create()
    {
        return Inertia::render("App/Management/Slider/Create");
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, FAQ $id)
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
    public function destroy(FAQ $id)
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
