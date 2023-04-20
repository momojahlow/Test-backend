<?php
namespace App\Traits;
 
trait HttpResponses
{
    protected function success($data,$message=null,$code=200){
        return response()->json([
            'status' => 'request OK',
            'message'=>$message,
            'data'=>$data
        ],$code);
    }

    protected function error($data,$message=null,$code){
        return response()->json([
            'status' => 'request KO il y a une erreur',
            'message'=>$message,
            'data'=>$data
        ],$code);
    }
    
}
