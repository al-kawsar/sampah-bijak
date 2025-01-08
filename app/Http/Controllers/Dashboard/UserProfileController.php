<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserProfile\StoreRequest;
use App\Http\Requests\Dashboard\UserProfile\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\UserProfile;
use App\Traits\ApiResponse;
use App\Traits\PaginatesData;

class UserProfileController extends Controller
{
    use ApiResponse, PaginatesData;

    const PAGE = 'user_profile';


    public function getData(Request $request)
    {
        try {
            $limit = $request->input('limit', 10);

            $data = UserProfile::query()->orderBy('id', 'desc')->paginate($limit);

            return $this->success($data->items(), "Get Search Data", pagination: $this->getPaginationData($data));

        } catch (\Exception $e) {
            return $this->internalServerError('Failed to retrieve data', 500, $e->getMessage());
        }
    }



    public function store(StoreRequest $request)
    {
        try {
            $payload = $request->validated();

            UserProfile::create($payload);

            return $this->success(message: 'Success Create Data');

        } catch (\Exception $e) {
            return $this->internalServerError($e->getMessage(), 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, UserProfile $id)
    {
        try {
            $payload = $request->validated();

            $id->updateOrFail($payload);

            return $this->success(message: 'Success Update Data');
        } catch (\Exception $e) {
            return $this->internalServerError($e->getMessage(), 500);

        }
    }

}
