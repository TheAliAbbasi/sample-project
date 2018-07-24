<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\VerifyCode;
use App\Transformers\VerificationTransformer;
use App\Transformers\UserTransformer;
use App\Http\Requests\Auth\VerifyRequest;
use App\Http\Requests\Auth\LoginRequest;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'verify', 'refresh']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $r)
    {
      $input = $r->only('mobile');
      $user = User::firstOrCreate($input);

      $input['code'] = mt_rand(100000, 999999);
      $verification = VerifyCode::create($input);

      return fractal($verification, new VerificationTransformer())->respond();
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(VerifyRequest $r)
    {
        $input = $r->only(['mobile', 'code']);

        $verification = VerifyCode::whereMobile($input['mobile'])
          ->whereCode($input['code'])
          ->notExpired()
          ->first();

          if($verification) {
            $user = User::whereMobile($verification->mobile)
              ->first();

            $verification->delete();
            if (! $token = auth()->login($user)) {
              throw new UnauthorizedHttpException('token', 'Unauthorized');
            }
            return $this->respondWithToken($token);
          }
          throw new UnauthorizedHttpException('token', 'Unauthorized');
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
