<?php

namespace LaraJS\Permission\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use LaraJS\Permission\Models\Permission;
use LaraJS\Permission\Models\Role;
use LaraJS\Permission\Requests\StoreRoleRequest;
use LaraJS\Permission\Requests\UpdateRoleRequest;
use LaraJS\Permission\Resources\RoleResource;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Role
 *
 * @authenticated
 */
class RoleController
{
    /**
     * Get Roles
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $roles = Role::with($request->get('include', []))->get();

        return RoleResource::collection($roles);
    }

    /**
     * Create Role
     *
     * @apiResource LaraJS\Permission\Resources\RoleResource status=201
     *
     * @apiResourceModel LaraJS\Permission\Models\Role
     *
     * @apiResourceAdditional message="Create successfully!"
     */
    public function store(StoreRoleRequest $request): RoleResource
    {
        $role = Role::create([...$request->validated(), 'guard_name' => config('permission.guard_name')]);

        return RoleResource::make($role)->additional([
            'message' => __('messages.create')
        ]);
    }

    /**
     * Update Role
     *
     * @apiResource LaraJS\Permission\Resources\RoleResource
     *
     * @apiResourceModel LaraJS\Permission\Models\Role
     *
     * @apiResourceAdditional message="Update successfully!"
     */
    public function update(Role $role, UpdateRoleRequest $request): RoleResource
    {
        abort_if($role->isAdmin(), Response::HTTP_FORBIDDEN, __('auth.role_not_found'));

        $viewMenu = 'VIEW_MENU';
        $input = $request->validated();
        $viewMenuPermissions = [];
        $permissions = $request->get('permissions', []);
        foreach ($permissions['menu'] as $menu) {
            $menu = strtoupper($menu);
            $name = "{$viewMenu}_$menu";
            if ($name !== $viewMenu) {
                $viewMenuPermissions[] = $name;
                Permission::findOrCreate($name, config('permission.guard_name'));
            }
        }
        $permissions = Permission::whereIn('id', $permissions['other'])
            ->get(['name'])
            ->toArray();
        $permissions = array_merge($viewMenuPermissions, $permissions);
        $role->syncPermissions($permissions);
        $role->update([
            'name' => $input['role']['name'],
            'guard_name' => config('permission.guard_name'),
            'description' => $input['role']['description'],
        ]);

        return RoleResource::make($role)->additional([
            'message' => __('messages.update')
        ]);
    }

    /**
     * Delete Role
     *
     * @response 200 {"message": "Delete successfully!"}
     */
    public function destroy(Role $role)
    {
        abort_if($role->isAdmin(), Response::HTTP_FORBIDDEN, __('auth.role_not_found'));

        $role->delete();

        return response()->json([
            'message' => __('messages.delete')
        ]);
    }
}
