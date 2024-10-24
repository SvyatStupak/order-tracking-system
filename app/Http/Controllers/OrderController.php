<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Notifications\OrderStatusChanged;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Filters\OrderFilter;

class OrderController extends Controller
{
    use AuthorizesRequests;

    /**
     * @OA\Get(
     *     path="/api/orders",
     *     summary="Get a list of orders",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filter by order status",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="shipped"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="amount_min",
     *         in="query",
     *         description="Filter by minimum order amount",
     *         required=false,
     *         @OA\Schema(
     *             type="number",
     *             format="float",
     *             example=50.00
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="amount_max",
     *         in="query",
     *         description="Filter by maximum order amount",
     *         required=false,
     *         @OA\Schema(
     *             type="number",
     *             format="float",
     *             example=200.00
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="created_from",
     *         in="query",
     *         description="Filter orders created from a specific date (YYYY-MM-DD)",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="date",
     *             example="2024-01-01"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="created_to",
     *         in="query",
     *         description="Filter orders created up to a specific date (YYYY-MM-DD)",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             format="date",
     *             example="2024-12-31"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of orders",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Order"))
     *     ),
     *     security={{"sanctum":{}}}
     * )
     */
    public function index(Request $request)
    {
        $query = Order::where('user_id', auth()->id());

        $filter = new OrderFilter($request);
        $filteredQuery = $filter->apply($query);

        return $filteredQuery->paginate(10);
    }

    /**
     * @OA\Post(
     *     path="/api/orders",
     *     summary="Create a new order",
     *     tags={"Orders"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="product_name", type="string", example="Product 1"),
     *             @OA\Property(property="amount", type="number", example=100.50)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="The order has been created",
     *         @OA\JsonContent(ref="#/components/schemas/Order")
     *     ),
     *     security={{"sanctum":{}}}
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'amount' => 'required|numeric',
        ]);

        $order = Order::create([
            'product_name' => $validated['product_name'],
            'amount' => $validated['amount'],
            'user_id' => auth()->id(),
            'status' => 'new',
        ]);

        return response()->json($order, 201);
    }

    /**
     * @OA\Patch(
     *     path="/api/orders/{order}",
     *     summary="Update order status",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="order",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="shipped")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order status updated",
     *         @OA\JsonContent(ref="#/components/schemas/Order")
     *     ),
     *     security={{"sanctum":{}}}
     * )
     */
    public function update(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $order->update($request->only('status'));

        $order->user->notify(new OrderStatusChanged($order));

        return response()->json($order, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/orders/{order}",
     *     summary="Get order details",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="order",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order details",
     *         @OA\JsonContent(ref="#/components/schemas/Order")
     *     ),
     *     security={{"sanctum":{}}}
     * )
     */
    public function show(Order $order)
    {
        if (!$order) {
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        }

        return response()->json($order, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/orders/{order}",
     *     summary="Delete order",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="order",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="The order has been deleted"
     *     ),
     *     security={{"sanctum":{}}}
     * )
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json(null, 204);
    }
}
