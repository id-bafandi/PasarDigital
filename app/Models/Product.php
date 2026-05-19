<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Product extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'category_id',
        'seller_id',
        'gambar',
    ];
 
    protected $casts = [
        'harga' => 'float',
        'stok'  => 'integer',
    ];
 
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
 
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
 
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
 
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
 