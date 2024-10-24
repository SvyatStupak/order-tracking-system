<?php
namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="Order",
 *     type="object",
 *     title="Order",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="product_name", type="string"),
 *     @OA\Property(property="amount", type="number"),
 *     @OA\Property(property="status", type="string"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Order extends Model {
    use HasFactory;
    protected $fillable = ['product_name', 'amount', 'status', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
