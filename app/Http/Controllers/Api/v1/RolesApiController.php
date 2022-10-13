<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\Roles\RoleAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleAdderRequest;
use App\Http\Requests\RoleUpdaterRequest;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Traits\InteractsWithAPI;
use Illuminate\Http\Request;
use Log;

class RolesApiController extends Controller
{
    use InteractsWithAPI;

    /**
     * Display roles listings
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new RoleCollection(
            Role::orderByDesc('id')->paginate(10)
        );
    }

    /**
     * Display the specified role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $role = Role::findOrFail($id);
        if (auth()->user()->can('view', $role)) {
            return new RoleResource($role);
        }
        return $this->unauthorized();
    }

    public function create(RoleAdderRequest $request)
    {
        if ($request->user()->can('create', Role::class)) {
            $validatedData = $request->validated();
            try {
                $role = (new RoleAction())->save($validatedData);
                return $this->success([
                    'message' => 'Role ' . $request->name . ' created successfully',
                    'id' => $role->id
                ], 201);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return $this->failed(['error' => 'Failed, contact sys admin']);
            }
        }
        return $this->unauthorized();
    }

    /**
     * Update specified role
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdaterRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        if ($request->user()->can('update', $role)) {
            try {
                (new RoleAction())->update($role, $request->validated());
                return $this->success([
                    'message' => 'Role ' . $role->name . ' updated successfully',
                    'id' => $role->id
                ]);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return $this->failed(['error' => 'Failed to update role']);
            }
        }
        return $this->unauthorized();
    }

    /**
     * Remove the specified role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        if ($request->user()->can('delete', $role)) {
            try {
                (new RoleAction())->delete($role);
                return $this->success(['message' => 'Role ' . $role->name . ' deleted successfully']);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return $this->failed(['error' => 'Could not delete role.']);
            }
        }
        return $this->unauthorized();
    }
}
