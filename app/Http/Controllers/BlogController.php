<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogStoreRequest;
use App\Http\Requests\BlogUpdateRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;

class BlogController extends Controller
{
    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return BlogResource::collection(Blog::filter()
            ->paginate(request()->get('per_page', 12)));
    }

    public function store(BlogStoreRequest $request): BlogResource
    {
        return BlogResource::make(auth()->user()->blogs()->create($request->validated()));
    }

    public function show(Blog $blog): BlogResource
    {
        return BlogResource::make($blog->loadMissing('user'));
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(BlogUpdateRequest $request, Blog $blog): BlogResource
    {
        $this->authorize('update', $blog);
        $blog->update($request->validated());

        return BlogResource::make($blog->refresh());
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Blog $blog): \Illuminate\Http\JsonResponse
    {
        $this->authorize('delete', $blog);
        $blog->delete();

        return response()->json(['message' => 'Ok'], 204);
    }
}
