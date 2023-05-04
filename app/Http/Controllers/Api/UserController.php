<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @OA\Schema(
     *    schema="User",
     *    @OA\Property(
     *        property="name",
     *        type="string",
     *        description="User Name",
     *        example="John"
     *    ),
     *    @OA\Property(
     *        property="email",
     *        type="email",
     *        description="User Email",
     *        example="john@example.com"
     *    ),
     *    @OA\Property(
     *        property="email_verified_at",
     *        type="string",
     *        description="User email_verified_at",
     *        format="datetime",
     *        example="2023-05-03T20:37:29.000000Z"
     *    ),
     *    @OA\Property(
     *        property="created_at",
     *        type="string",
     *        description="User created_at",
     *        format="datetime",
     *        example="2023-05-03T20:37:29.000000Z"
     *    ),
     *    @OA\Property(
     *        property="updated_at",
     *        type="string",
     *        description="User updated_at",
     *        format="datetime",
     *        example="2023-05-03T20:37:29.000000Z"
     *    ),
     * )
     * @OA\Get(
     *     path="/api/user/index",
     *     tags={"Users"},
     *     summary="Mostrar listado de usuarios",
     *     @OA\Response(
     *         response=200,
     *         description="Usuarios obtenidos.",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="success",
     *                 example="True"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/User"),
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 example="Usuarios obtenidos"
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ha ocurrido un error."
     *     )
     * ) 
    **/
    public function index(){
        try {
            $response = [
                'success' => true,
                'data'    => UserResource::collection(User::get()),
                'message' => 'Usuarios obtenidos',
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data'    => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/user/show/{id}",
     *     tags={"Users"},
     *     summary="Mostrar datos de un usuario",
     *     @OA\Parameter(
     *         description="Parámetro necesario para la consulta de datos de un usuario",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         @OA\Examples(example="int", value="1", summary="Introduce un número de id de usuario.")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario obtenido.",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="success",
     *                 example="True"
     *             ),
     *             @OA\Property(property="data",ref="#/components/schemas/User"),
     *             @OA\Property(
     *                 property="message",
     *                 example="Usuario obtenido"
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ha ocurrido un error."
     *     )
     * ) 
    **/
    public function show($id){
        try {
            $response = [
                'success' => true,
                'data'    => new UserResource(User::find($id)),
                'message' => 'Usuario obtenido',
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data'    => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    
    /**
     * @OA\Schema(
     *    schema="UserStoreRequest",
     *    @OA\Property(
     *        property="name",
     *        type="string",
     *        description="User Name",
     *        nullable=false,
     *        example="John"
     *    ),
     *    @OA\Property(
     *        property="email",
     *        type="email",
     *        description="User Email",
     *        nullable=false,
     *        format="email",
     *        example="john@example.com"
     *    ),
     *    @OA\Property(
     *        property="password",
     *        type="string",
     *        description="User Password",
     *        nullable=false,
     *        format="password",
     *    ),
     *    @OA\Property(
     *        property="password_confirmation",
     *        type="string",
     *        description="User Password confirmation",
     *        nullable=false,
     *        format="password",
     *    ),
     * )
     * 
     * @OA\Post(
     *     path="/api/user/store",
     *     tags={"Users"},
     *     summary="Guardar datos de un nuevo usuario",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/UserStoreRequest"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario creado.",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="success",
     *                 type="string",
     *                 example="True"
     *             ),
     *             @OA\Property(property="data",ref="#/components/schemas/User"),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Usuario eliminado"
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(ref="#/components/schemas/Error401"),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error en el contenido",
     *         @OA\JsonContent(ref="#/components/schemas/Error422"),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ha ocurrido un error.",
     *         @OA\JsonContent(ref="#/components/schemas/Error500"),
     *     )
     * ) 
    **/
    public function store(UserStoreRequest $request){
        try {
            $user = User::create([ 
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            $response = [
                'success' => true,
                'data'    => $user,
                'message' => 'Usuario creado',
            ];
    
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data'    => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
    
    /**
     * @OA\Schema(
     *    schema="UserUpdateRequest",
     *    @OA\Property(
     *        property="name",
     *        type="string",
     *        description="User Name",
     *        nullable=true,
     *        example="John"
     *    ),
     *    @OA\Property(
     *        property="email",
     *        type="email",
     *        description="User Email",
     *        nullable=true,
     *        format="email",
     *        example="john@example.com"
     *    ),
     *    @OA\Property(
     *        property="password",
     *        type="string",
     *        description="User Password",
     *        nullable=true,
     *        format="password",
     *    ),
     *    @OA\Property(
     *        property="password_confirmation",
     *        type="string",
     *        description="User Password confirmation",
     *        nullable=true,
     *        format="password",
     *    ),
     * )
     * @OA\Put(
     *     path="/api/user/update/{id}",
     *     tags={"Users"},
     *     summary="Editar datos de un usuario",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         description="Parámetro necesario para la edición de datos de un usuario",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         @OA\Examples(example="int", value="1", summary="Introduce un número de id de usuario.")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/UserUpdateRequest"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario actualizado.",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="success",
     *                 type="string",
     *                 example="True"
     *             ),
     *             @OA\Property(property="data",ref="#/components/schemas/User"),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Usuario actualizado"
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(ref="#/components/schemas/Error401"),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error en el contenido",
     *         @OA\JsonContent(ref="#/components/schemas/Error422"),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ha ocurrido un error.",
     *         @OA\JsonContent(ref="#/components/schemas/Error500"),
     *     )
     * ) 
    **/
    public function update(UserUpdateRequest $request, $id){
        try {
            $user = User::findOrFail($id);
            $user->name = is_null($request->name) ? $user->name : $request->name;
            $user->email = is_null($request->email) ? $user->email : $request->email;
            $user->password = is_null($request->password) ? $user->password : Hash::make($request->password);
            $user->save();
    
            $response = [
                'success' => true,
                'data'    => $user,
                'message' => 'Usuario actualizado.',
            ];
    
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data'    => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    
    /**
     * @OA\Delete(
     *     path="/api/user/delete/{id}",
     *     tags={"Users"},
     *     summary="Eliminar datos de un usuario",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         description="Parámetro necesario para la eliminación de datos de un usuario",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         @OA\Examples(example="int", value="1", summary="Introduce un número de id de usuario.")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario eliminado.",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="success",
     *                 type="string",
     *                 example="True"
     *             ),
     *             @OA\Property(property="data",ref="#/components/schemas/User"),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Usuario eliminado"
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(ref="#/components/schemas/Error401"),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error en el contenido",
     *         @OA\JsonContent(ref="#/components/schemas/Error422"),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ha ocurrido un error.",
     *         @OA\JsonContent(ref="#/components/schemas/Error500"),
     *     )
     * ) 
    **/
    public function delete($id){
        try {
            if ($id == 1) {
                $response = [
                    'success' => true,
                    'data'    => 'Error',
                    'message' => 'No puede eliminar este usuario',
                ];
                return response()->json($response, 401);
            }
            $user = User::findOrFail($id)->delete();

            $response = [
                'success' => true,
                'data'    => $user,
                'message' => 'Usuario eliminado',
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'data'    => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
