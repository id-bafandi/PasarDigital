<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Payment extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'order_id',
        'metode_pembayaran',
        'nama_rekening',
        'jumlah_transfer',
        'bukti_pembayaran',
        'status_pembayaran',
        'batas_bayar',
        'paid_at',
        'confirmed_at',
        'confirmed_by',
    ];
 
    protected $casts = [
        'jumlah_transfer' => 'float',
        'batas_bayar'     => 'datetime',
        'paid_at'         => 'datetime',
        'confirmed_at'    => 'datetime',
    ];
 
    const STATUS_PENDING              = 'pending';
    const STATUS_WAITING_CONFIRMATION = 'waiting_confirmation';
    const STATUS_PAID                 = 'paid';
    const STATUS_CANCELLED            = 'cancelled';
 
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
 
    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }
}
