<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Order extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'user_id',
        'order_number',
        'total_price',
        'status',
        'metode_pembayaran',
        'alamat_pengiriman',
        'catatan',
    ];
 
    protected $casts = [
        'total_harga'     => 'float',
        'tanggal_pesanan' => 'datetime',
    ];
 
    // Status constants
    const STATUS_PENDING    = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED    = 'shipped';
    const STATUS_DELIVERED  = 'delivered';
    const STATUS_CANCELLED  = 'cancelled';
 
    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }
 
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
 
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
