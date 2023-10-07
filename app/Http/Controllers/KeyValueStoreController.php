<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use OpenApi\Annotations as OA;


class KeyValueStoreController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/key-value/add",
     *     tags={"Key-Value Store"},
     *     summary="Add a key-value pair to the store",
     *     description="Add a key-value pair to the store with an optional time-to-live (TTL) duration.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="key", type="string", example="name"),
     *             @OA\Property(property="value", type="string", example="John"),
     *             @OA\Property(property="ttl", type="integer", format="int64", example=3600, description="Optional TTL in seconds")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Key added successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Key added to the store")
     *         )
     *     )
     * )
     */
    public function addKey(Request $request)
    {
        $key = $request->input('key');
        $value = $request->input('value');
        $ttl = $request->input('ttl'); // Optional TTL

        if ($ttl) {
            Cache::put($key, $value, $ttl);
        } else {
            Cache::put($key, $value);
        }

        return response()->json(['message' => 'Key added to the store']);
    }

    /**
     * @OA\Get(
     *     path="/api/key-value/get",
     *     tags={"Key-Value Store"},
     *     summary="Get the value for a key",
     *     description="Get the value for a key from the store, respecting the TTL if provided.",
     *     @OA\Parameter(
     *         name="key",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", example="name"),
     *         description="Key to retrieve the value"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Value retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="value", type="string", example="John")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Key not found in the store",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Key not found in the store")
     *         )
     *     )
     * )
     */
    public function getKey(Request $request)
    {
        $key = $request->input('key');
        $value = Cache::get($key);

        return response()->json(['value' => $value]);
    }

    /**
     * @OA\Delete(
     *     path="/api/key-value/delete",
     *     tags={"Key-Value Store"},
     *     summary="Delete a key from the store",
     *     description="Delete a key and its associated value from the store.",
     *     @OA\Parameter(
     *         name="key",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", example="name"),
     *         description="Key to delete from the store"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Key deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Key deleted from the store")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Key not found in the store",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Key not found in the store")
     *         )
     *     )
     * )
     */
    public function deleteKey(Request $request)
    {
        $key = $request->input('key');
        Cache::forget($key);

        return response()->json(['message' => 'Key deleted from the store']);
    }
}
