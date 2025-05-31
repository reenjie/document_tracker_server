<?php

namespace App\Http\Controllers\RBAC;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreRequest;
use App\Http\Requests\Roles\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\Roles;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Roles::all();
        return response()->json(['message' => 'List of roles', 'data' => $roles]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $storeRequest)
    {
        $role = Roles::create($storeRequest->all());
        return response()->json(['message' => 'Role created successfully', 'data' => $role], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Roles::find($id);
        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }
        return response()->json(['message' => 'Role details retrieved', 'data' => $role]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $updateRequest, string $id)
    {
        $role = Roles::findOrFail($id);
        $role->update($updateRequest->all());
        return response()->json(['message' => 'Role updated successfully', 'data' => $role]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Roles::findOrFail($id);
        $role->delete();
        return response()->json(['message' => 'Role deleted successfully']);
    }
}
