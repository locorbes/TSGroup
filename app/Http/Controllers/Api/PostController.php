<?php
namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Visualización de la lista de posts.",
     *     tags={"Posts"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Visualización de la lista de posts.",         
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Post::all());
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     summary="Visualización de los detalles de un post.",
     *     tags={"Posts"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del post",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Visualización de los detalles de un post.",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Recurso no encontrado."
     *     )
     * )
     */
    public function show($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['error' => __('http.404')], 404);
        }

        return response()->json($post);
    }

    /**
     * @OA\Post(
     *     path="/api/posts",
     *     summary="Creación de un post.",
     *     tags={"Posts"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "body"},
     *             @OA\Property(property="title", type="string", example="Título"),
     *             @OA\Property(property="body", type="string", example="Contenido")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Post creado exitosamente.",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación."
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado."
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => Auth::id(),
        ]);

        return response()->json($post, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/posts/{id}",
     *     summary="Actualización de un post.",
     *     tags={"Posts"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del post a actualizar.",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Nuevo título"),
     *             @OA\Property(property="body", type="string", example="Nuevo contenido")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post actualizado correctamente.",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Recurso no encontrado."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Errores de validación."
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['error' => __('http.404')], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'body' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post->update($request->only(['title', 'body']));

        return response()->json($post);
    }

    /**
     * @OA\Delete(
     *     path="/api/posts/{id}",
     *     summary="Eliminación de un post.",
     *     tags={"Posts"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del post a eliminar.",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Eliminación de un post.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Recurso eliminado correctamente.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Recurso no encontrado."
     *     )
     * )
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['error' => __('http.404')], 404);
        }

        $post->delete();

        return response()->json(['message' => __('messages.resource_deleted')]);
    }

}

