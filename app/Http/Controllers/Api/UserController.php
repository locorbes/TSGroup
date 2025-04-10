<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Visualización de la lista de usuarios.",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},      
     *     @OA\Response(
     *         response=200,
     *         description="Visualización de la lista de usuarios.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Pepe Pérez"),
     *                 @OA\Property(property="email", type="string", example="pepe@example.com"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-04-09T14:52:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-04-09T14:52:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="El token no es válido.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="El token no es válido.")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(User::all());
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Visualización de los detalles de un usuario.",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},      
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario.",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Visualización de los detalles de un usuario.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Pepe Pérez"),
     *             @OA\Property(property="email", type="string", example="pepe@example.com"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-04-09T14:52:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-04-09T14:52:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Recurso no encontrado.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No encontrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="El token no es válido.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="El token no es válido.")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => __('http.404')], 404);
        }

        return response()->json($user);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Actualización de datos del usuario.",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},      
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario.",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={},
     *             @OA\Property(property="name", type="string", maxLength=255, example="Pepe Actualizado"),
     *             @OA\Property(property="email", type="string", format="email", example="nuevo@mail.com"),
     *             @OA\Property(property="password", type="string", format="password", minLength=6, example="nuevopassword1234")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Actualización de datos del usuario.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Pepe Actualizado"),
     *             @OA\Property(property="email", type="string", example="nuevo@mail.com"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-04-09T14:52:00Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-04-09T15:10:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Recurso no encontrado.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="No encontrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Errores de validación.",
     *         )
     *     ), 
     *     @OA\Response(
     *         response=401,
     *         description="El token no es válido.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="El token no es válido.")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => __('http.404')], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'     => 'sometimes|string|max:255',
            'email'    => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->update([
            'name'     => $request->name ?? $user->name,
            'email'    => $request->email ?? $user->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return response()->json($user);
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Eliminación de un usuario.",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},      
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario a eliminar.",
     *         @OA\Schema(type="integer", example=1)
     *     ), 
     *     @OA\Response(
     *         response=200,
     *         description="Eliminación de un usuario.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Recurso eliminado correctamente.")
     *         )
     *     ), 
     *     @OA\Response(
     *         response=404,
     *         description="Recurso no encontrado.",
     *     ), 
     *     @OA\Response(
     *         response=401,
     *         description="El token no es válido.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="El token no es válido.")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => __('http.404')], 404);
        }

        $user->delete();

        return response()->json(['message' => __('messages.resource_deleted')]);
    }
}

