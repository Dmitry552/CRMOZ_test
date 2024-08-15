<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class BadRequestException extends Exception
{
    protected $message;
    protected $code;

    public function __construct(string $message = "Bad request", int $code = 400)
    {
        $this->message = $message;
        $this->code = $code;

        parent::__construct($this->message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->message
        ], $this->code);
    }
}
