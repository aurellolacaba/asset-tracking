<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class AccessForbiddenException extends Exception
{
    private $foo;

    public function __construct($foo = ''){
        $this->foo = $foo;
    }

    public function render($request)
    {
        return response()->json([
            'message' => 'error',
            'error' => [
                'code' => 'E001',
                'message' => 'Access Forbidden',
            ],
            'data' => [],
        ], Response::HTTP_FORBIDDEN);
    }

    public function context()
    {
        return ['foo' => $this->foo];
    }
}
