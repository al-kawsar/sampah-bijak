<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ContactMessage\StoreRequest;
use App\Http\Requests\Dashboard\ContactMessage\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Inertia\Inertia;
use App\Traits\ApiResponse;
use App\Traits\PaginatesData;

class ContactMessageController extends Controller
{
    use ApiResponse, PaginatesData;

    const PAGE = 'contact_messages';

    public function index()
    {
        return Inertia::render("App/Management/Contact/Index");
    }
    public function getData(Request $request)
    {
        try {
            $limit = $request->input('limit', 10);

            $data = ContactMessage::query()->orderBy('id', 'desc')->paginate($limit);

            return $this->success($data->items(), "Get Search Data", pagination: $this->getPaginationData($data));

        } catch (\Exception $e) {
            return $this->internalServerError('Failed to retrieve data', 500, $e->getMessage());
        }
    }



    public function store(StoreRequest $request)
    {
        try {
            $payload = $request->validated();

            ContactMessage::create($payload);

            return $this->success(message: 'Success Create Data');

        } catch (\Exception $e) {
            return $this->internalServerError($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactMessage $id)
    {
        return Inertia::render("App/Management/Contact/Show", [
            "contact" => $id
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, ContactMessage $id)
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
    public function destroy(ContactMessage $id)
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
