<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Auth"},
     *     summary="Login para uso de apis",
     *     description="Login User Here",
     *     @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email", "password"},
     *               @OA\Property(property="email", type="email"),
     *               @OA\Property(property="password", type="password")
     *            ),
     *        ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Login Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * ) 
    **/
    public function login(Request $request){
        try {
            $validator = $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            if (!auth()->attempt($validator)) {
                return response()->json([
                    'success' => false,
                    'data'    => 'Error',
                    'message' => 'Unauthorised'
                ], 401);
            } else {
                $user = User::where('email', $request->email)->first();
                $user->tokens()->delete();
                return response()->json([
                    'success' => true,
                    'data'    => $user->createToken("token")->plainTextToken,
                    'message' => 'User Logged In Successfully',
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data'    => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
