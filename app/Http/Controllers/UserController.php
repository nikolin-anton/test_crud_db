<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return UserResource::collection(User::filter()->get());
    }

    public function show(User $user): UserResource
    {
        return UserResource::make($user->loadMissing('blogs'));
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        $this->authorize('update', $user);
        $user->update($request->validated());

        return UserResource::make($user->refresh());
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user): \Illuminate\Http\JsonResponse
    {
        $this->authorize('delete', $user);
        $user->delete();

        return response()->json(['message' => 'Ok'], 204);
    }
}
