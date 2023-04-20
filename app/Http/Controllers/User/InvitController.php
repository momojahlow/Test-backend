<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvitRequest;
use App\Http\Resources\InvitResource;
use App\Jobs\ProcessInvitMail;
use App\Models\Invit;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InvitController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->type ==="admin") {
            $invits=Invit::with('societe')->get(); 
            return InvitResource::collection($invits);
        }
        
        return $this->error(NULL,"Not authorized",403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvitRequest $request)
    {
        $validated = $request->validated();
        $validated['token'] = Str::random(10);
        $validated['note'] = json_encode([Auth::user()->nom.': a envoyé l’invitation le: '.date('d/m/Y H:i:s',strtotime(now()))]);

        $new=Invit::create($validated);

        if (isset($new->id)) {
            ProcessInvitMail::dispatch($new);   
            $invit=Invit::with('societe')->findOrFail($new->id);       
            return $this->success(new InvitResource($invit),"Invitation added");
        } else {
            return $this->error($new,"Invitation not added",500);
        } 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invit=Invit::with('societe')->findOrFail($id);
        $this->authorize('view',$invit);
        if (isset($invit->id)) {
            return $this->success(new InvitResource($invit),"Invitation founded");
        } else {
            return $this->error($invit,"Invitation not founded",500);
        } 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $invit=Invit::with('societe')->findOrFail($id);
        if ($invit->token =='inactif') {
            return $this->error($invit,"Invitation not allow to be updated",403);
        } else {
            $invit->token="annuller";
            $dataAnnul = [Auth::user()->nom.': a annulé l’invitation le: '.date('d/m/Y H:i:s',strtotime(now()))];
            $notes =array_merge(json_decode($invit->note,true) , $dataAnnul);
            $invit->note=json_encode($notes);
            $invit->save();
            return $this->success(new InvitResource($invit),"Invitation updated");
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {       
        $invit= Invit::findOrFail($id);
        $this->authorize('delete',$invit);
        if ($invit->token =='inactif') {
            return $this->error($invit,"Invitation not allow to be deleted",403);
        } else {
            $isDeleted=$invit->delete();
            if ($isDeleted) {
                return $this->success(new InvitResource($invit),"Invitation deleted");
            } else {
                return $this->error($invit,"Invitation not deleted",500);
            } 
        }
        
        
    }

    public function getInvit(string $token)
    {
        $invit=Invit::with('societe')->where('token',$token)->first();
        if (isset($invit->id)) {
            return $this->success(new InvitResource($invit),"Invitation ok");
        } else {
            return $this->error(NULL,"Invitation not found",500);
        }
        
        
    }
}
