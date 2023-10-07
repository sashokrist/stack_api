<?php

namespace App\Http\Controllers;

use App\Models\StackItem;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class StackController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/stack/add",
     *     tags={"Stack"},
     *     summary="Add an item to the stack",
     *     description="Add an item to the stack",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="content", type="string", example="Hello World")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Item added successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Item added to the stack")
     *         )
     *     )
     * )
     */
    public function addItem(Request $request)
    {
        $content = $request->input('content');

        $stackItem = new StackItem();
        $stackItem->content = $content;
        $stackItem->save();

        return response()->json(['message' => 'Item added to the stack']);
    }

    /**
     * @OA\Get(
     *     path="/api/stack/get",
     *     tags={"Stack"},
     *     summary="Get the top item from the stack",
     *     description="Get the top item from the stack and remove it from the stack",
     *     @OA\Response(
     *         response=200,
     *         description="Item retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="item", type="string", example="Hello World")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Stack is empty",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Stack is empty")
     *         )
     *     )
     * )
     */
    public function getItem()
    {
        $stackItem = StackItem::latest()->first();

        if ($stackItem) {
            $stackItem->delete(); // Remove the item from the stack
            return response()->json(['item' => $stackItem->content]);
        }

        return response()->json(['message' => 'Stack is empty']);
    }
}
