<?php

namespace App\Http\Controllers\Societe;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSocieteRequest;
use App\Http\Resources\SocieteResource;
use App\Models\Societe;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocieteController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->type ==="admin") {
            $societes=Societe::all(); 
        } else {
            $societes=Societe::where('id',Auth::user()->societe_id)->get();   
        }
        return SocieteResource::collection($societes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSocieteRequest $request)
    {
        $validated = $request->validated();
        $new=Societe::create($validated);

        if (isset($new->id)) {
            return $this->success(new SocieteResource($new),"Societe added");
        } else {
            return $this->error($new,"Societe not added",403);
        } 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $societe=Societe::with('employes')->findOrFail($id);
        if (isset($societe->id)) {
            return $this->success(new SocieteResource($societe),"Societe founded");
        } else {
            return $this->error($societe,"Societe not founded",403);
        } 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $societe= Societe::with('employes')->findOrFail($id);
        $this->authorize('delete',$societe);
        
        if ($societe?->employes->count()) {
            return $this->error($societe,"Societe not allow to be deleted",403);
        } else {
            $isDeleted=$societe->delete();
            if ($isDeleted) {
                return $this->success(new SocieteResource($societe),"Societe deleted");
            } else {
                return $this->error($societe,"Societe not deleted",404);
            } 
        }       
        
    }
}
