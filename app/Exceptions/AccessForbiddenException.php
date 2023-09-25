<?php

namespace App\Exceptions;

use Exception;

class AccessForbiddenException extends Exception
{
    private $foo;

    public function __construct($foo){
        $this->foo = $foo;
    }

    public function render($request)
    {
        return response()->json([
            'success' => false,
            'data' => NULL,
            'error' => [
                'code' => 'E001',
                'message' => 'Access Forbidden',
                'details' => [
                    'foo' => $this->foo
                ]
            ]
        ], 403);
    }

    public function context()
    {
        return ['foo' => $this->foo];
    }
}
