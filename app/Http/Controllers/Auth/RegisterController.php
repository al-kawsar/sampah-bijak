<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Models\UserProfile;
use Inertia\Inertia;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use App\Services\FileService;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    use ApiResponse;

    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }


    public function showRegisterForm()
    {
        return Inertia::render('Auth/Register');
    }
    public function doRegister(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {

            $payload = $request->validated();

            $payload['role_id'] = 3;

            $user = User::create($payload);

            if ($request->hasFile('profile_picture')) {
                $request_file = $request->file('profile_picture');
                $file = $this->fileService->uploadFile($request_file);
            } else {
                $file = null;
            }
            UserProfile::create([
                'user_id' => $user->id,
                'full_name' => $request->full_name,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'profile_picture' => $file ? $file->full_path : 'https://thumbs.dreamstime.com/b/vector-illustration-avatar-dummy-logo-collection-image-icon-stock-isolated-object-set-symbol-web-137160339.jpg', // Assuming you handle file upload separately
            ]);

            auth()->login($user);

            DB::commit();

            return $this->success(null, 'Registration successful! You can now log in.', 201); // Created

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->internalServerError('Terjadi kesalahan saat mendaftar. Silakan coba lagi.', 500, $e->getMessage());
        }
    }
}
