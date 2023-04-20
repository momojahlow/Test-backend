<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateProfilRequest;
use App\Http\Resources\UserResource;
use App\Models\Admin;
use App\Models\Employe;
use App\Models\Invit;
use App\Models\Societe;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function admins()
    {
        $this->authorize('admins',Auth::user());

        return UserResource::collection(Admin::all());
    }

    public function index()
    {
        if (Auth::user()->type ==="admin") {
            $users=User::orderBy('type')->get();
            
        } else {
            $users=Employe::where('societe_id',Auth::user()->societe_id)->latest()->get();
        }
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        if ($request->has('type')) {
            $user_type=$request->type;
            $validated = $request->validated();
            $validated['password'] = Hash::make($validated['password']);
            $new_user=NULL;
            switch ($user_type) {
                case 'admin':
                    $new_user=Admin::create( $validated);
                    break;  
                case 'employe':
                    $invit = Invit::where('email',$validated['email'])->first(); 
                    if (isset($invit->id)) {
                        $validated['societe_id'] = $invit->societe_id ; 
                        $new_user=Employe::create( $validated);
                        $invit->token = 'inactif';
                        $dataAccept = [$new_user->nom.': a validé l’invitation le: '.date('d/m/Y H:i:s',strtotime(now()))];
                        $notes =array_merge(json_decode($invit->note,true), $dataAccept);
                        $invit->note=json_encode($notes);
                        $invit->save();
                    }
                    break;                
                default:
                    break;
            }
            if (isset($new_user->id)) {
                return $this->success($new_user,"User added");
            } else {
                return $this->error($new_user,"User not added",403);
            }            
        }
        return $this->error(NULL,"Undefined type User",403);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user= User::findOrFail($id);
        if (isset($user->id)) {
            if ($user->societe_id === Auth::user()->societe_id || Auth::user()->type === 'admin' ) {
                return $this->success(new UserResource($user));
            } else {
                return $this->error(NULL,"access not allowed",403);
            }            
            
        } else {
            return $this->error(NULL,"User not found",404);
        }  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfilRequest $request, string $id)
    {
        $validated = $request->validated();
        $user = User::findOrFail($id);
        $isUp=$user->update($validated);
        if ($isUp) {
            return $this->success(new UserResource($user));
        } else {
            return $this->error($user,"User not updated",403);
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user= User::findOrFail($id);
        $isDeleted=$user->delete();
        if ($isDeleted) {
            return $this->success(new UserResource($user),"User deleted");
        } else {
            return $this->error($user,"User not deleted",403);
        } 
    }
}
