<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\Api\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class UsersApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserResource(User::with(['role', 'roles', 'class'])->get());
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'gender' => 'required',
            'birthday' => 'required',
            'status' => 'required',
            'phone' => 'required|numeric',
        ];
        $messages = [
            'name.required' => 'The Name field is required.',
            'email.required' => 'The Email field is required.',
            'email.unique:users' => 'The Email all ready exist.',
            'password.required' => 'The Password field is required.',
            'gender.required' => 'The Gender field is required.',
            'birthday.required' => 'The Birthday field is required.',
            'phone.required' => 'The Phone number field is required.',
            'status.required' => 'The Status field required(Approved,Pending,Inactive)',

        ];
        $validator = Validator::make($request->all(), $rules, $messages); 
        if($validator->fails()){
            return response()->json([
                'status'    => 0,
                'message'   => $validator->getMessageBag()->first(),
               
            ]);
        }
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'gender' => $request->input('gender'),
            'birthday' => $request->input('birthday'),
            'role_id' => 2,
            'roles' => 2,
            'status' => $request->input('status'), //Pending,Approved,Inactive
            'phone' => $request->input('phone'),
        ]);
        $user->roles()->sync($request->input('roles'));
        return response(["status"=>1,"message"=>"User is successfully register"])->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserResource($user->load(['role', 'roles', 'class']));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        if ($request->input('profile_picture', false)) {
            if (!$user->profile_picture || $request->input('profile_picture') !== $user->profile_picture->file_name) {
                if ($user->profile_picture) {
                    $user->profile_picture->delete();
                }

                $user->addMedia(storage_path('tmp/uploads/' . $request->input('profile_picture')))->toMediaCollection('profile_picture');
            }
        } elseif ($user->profile_picture) {
            $user->profile_picture->delete();
        }

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
