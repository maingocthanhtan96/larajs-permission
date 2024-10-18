<?php

namespace LaraJS\Permission\Controllers;

use Illuminate\Http\Request;
use LaraJS\Permission\Models\Permission;
use LaraJS\Permission\Requests\StorePermissionRequest;
use LaraJS\Permission\Resources\PermissionResource;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Permission
 *
 * @authenticated
 */
class PermissionController
{
    /**
     * Get Permissions
     */
    public function index(Request $request)
    {
        $keyword = $request->get('keyword', '');

        $permissions = Permission::query()
            ->when($keyword, fn ($q) => $q->where('name', 'LIKE', "%$keyword%"))
            ->paginate($request->get('limit', 25));

        return PermissionResource::collection($permissions);
    }

    /**
     * Create Permission
     *
     * @apiResource LaraJS\Permission\Resources\PermissionResource status=201
     *
     * @apiResourceModel LaraJS\Permission\Models\Permission
     *
     * @apiResourceAdditional message="Create successfully!"
     */
    public function store(StorePermissionRequest $request)
    {
        $permission = Permission::create($request->validated());

        return PermissionResource::make($permission)->additional([
            'message' => __('messages.create')
        ])->response(Response::HTTP_CREATED);
    }

    /**
     * Update Permission
     *
     * @apiResource LaraJS\Permission\Resources\PermissionResource
     *
     * @apiResourceModel LaraJS\Permission\Models\Permission
     *
     * @apiResourceAdditional message="Update successfully!"
     */
    public function update(Permission $permission, StorePermissionRequest $request): JsonResponse
    {
        $permission->fill([...$request->validated(), 'guard_name' => config('permission.guard_name')]);
        $permission->save();

        return PermissionResource::make($permission)->additional([
            'message' => __('messages.update')
        ]);
    }

    /**
     * Delete Permission
     *
     * @response 200 {"message": "Delete successfully!"}
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return response()->json([
            'message' => __('messages.delete')
        ]);
    }
}
