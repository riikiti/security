<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CodeGeneratorRequest;
use Illuminate\Http\Request;
use Teckwei1993\Otp\Otp;
use function Laravel\Prompts\password;

class PasswordGenController extends Controller
{

    private array $passwords;
    private int $count;
    private int $length;
    private int $expires;
    private string $format;
    private string $repeated;


    public function __construct()
    {
        $this->passwords = [];
        $this->count = 10;
        $this->length = 8;
        $this->expires = 60;
        $this->format = 'string';
        $this->repeated = false;
    }

    public function index(CodeGeneratorRequest $request)
    {
        $this->checkRequest($request);
        for ($i = 1; $i <= $this->count; $i++) {
            $this->passwords[$i] = (new \Teckwei1993\Otp\Otp)->generate('identifier-key-here', [
                'length' => $this->length,
                'format' => $this->format,
                'expires' => $this->expires,
                'repeated' => $this->repeated
            ]);
        }
        return response()->json(['status' => 'success', 'passwords' => $this->passwords]);
    }

    public function checkRequest($request)
    {
        $this->count = $request->count ?? $this->count;
        $this->length = $request->length ?? $this->length;
        $this->expires = $request->expires ?? $this->expires;
        $this->format = $request->format ?? $this->format;
        $this->repeated = $request->repeated ?? $this->repeated;
    }
}
