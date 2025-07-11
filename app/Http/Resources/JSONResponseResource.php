<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JSONResponseResource 
{
    protected string $status;
    protected int $statusCode;
    protected string $message;
    protected mixed $data;

    public function __construct($status,$statusCode,$message,$data)
    {
       $this->status = $status;
       $this->statusCode = $statusCode;
       $this->message = $message;
       $this->data = $data;
    }

    public function response()
    {
        return response()->json([
            'status'=>$this->status ? 'Success' :'Error',
            'message'=>$this->message,
            'data'=>$this->status ? $this->data : null
        ],$this->statusCode);
    }
}
