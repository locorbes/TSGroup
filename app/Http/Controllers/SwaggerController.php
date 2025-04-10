<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="Prueba Técnica TSG",
 *         description="Documentación de la API",
 *         version="1.0.0",
 *         @OA\Contact(
 *             name="Orbes Carlos",
 *             email="mail@orbescarlos.com.ar",
 *             url="https://orbescarlos.com.ar"
 *         ),
 *     ),
 *     @OA\Tag(name="Auth", description="Operaciones de autenticación y creación de usuario"),
 *     @OA\Tag(name="Users", description="Gestión de usuarios"),
 *     @OA\Tag(name="Posts", description="Gestión de posts")
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class SwaggerController {}
