<?php

namespace App\Http\Controllers\Api\v1;

use App\Actions\Users\UserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserAdderRequest;
use App\Http\Requests\UserUpdaterRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\InteractsWithAPI;
use Illuminate\Http\Request;
use Log;

class UsersApiController extends Controller
{
    use InteractsWithAPI;

    /**
     * Display system users
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new UserCollection(
            User::orderByDesc('id')->paginate(25)
        );
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $user = User::findOrFail($id);
        if (auth()->user()->can('view', $user)) {
            return new UserResource($user);
        }

        return $this->unauthorized();
    }

    public function create(UserAdderRequest $request)
    {
        if ($request->user()->can('create', User::class)) {
            // Some protective checking before saving
            $validatedData = $request->validated();
            try {
                $user = (new UserAction())->save($validatedData);

                return $this->success([
                    'message' => 'User '.$request->firstName.' created successfully',
                    'id' => $user->id,
                ], 201);
            } catch (\Exception $e) {
                Log::error($e->getMessage());

                return $this->failed(['error' => 'Failed to create system user. Contact sys admin']);
            }
        }

        return $this->unauthorized();
    }

    /**
     * Update specified user
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdaterRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if ($request->user()->can('update', $user)) {
            try {
                (new UserAction())->update($user, $request->validated());

                return $this->success([
                    'message' => 'User '.$user->firstName.' updated successfully',
                    'id' => $user->id,
                ]);
            } catch (\Exception $e) {
                Log::error($e->getMessage());

                return $this->failed(['error' => 'Failed to update user']);
            }
        }

        return $this->unauthorized();
    }

    /**
     * Remove the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($request->user()->can('delete', $user)) {
            try {
                (new UserAction())->delete($user);

                return $this->success(['message' => 'User '.$user->firstName.' deleted successfully']);
            } catch (\Exception $e) {
                Log::error($e->getMessage());

                return $this->failed(['error' => 'Could not delete user.']);
            }
        }

        return $this->unauthorized();
    }
}
