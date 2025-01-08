<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserProfile\StoreRequest;
use App\Http\Requests\Dashboard\UserProfile\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\UserProfile;
use App\Models\User;
use App\Traits\ApiResponse;
use App\Traits\PaginatesData;

class UserProfileController extends Controller
{
    use ApiResponse;

    const PAGE = 'user_profile';


    public function getData(Request $request)
    {
        try {
         $userId = auth()->id();

         $user = User::with(['profile','region','role'])->findOrFail($userId);

         $profile = $user->profile;

         $data = [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'full_name' => $profile->full_name,
            'phone_number' => $profile->phone_number,
            'address' => $profile->address,
            'profile_picture' => $profile->profile_picture,
            'region' => $user->region->region_name,
            'role' => $user->role->name,
        ];

        return $this->success($data, "Get Data User Profile");
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
