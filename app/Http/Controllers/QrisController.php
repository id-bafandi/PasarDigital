<?php

namespace App\Http\Controllers;

use App\Helpers\QrisHelper;
use App\Models\Order;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QrisController extends Controller
{
    public function generate(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        $qrisStatis = config('services.qris.statis');
        $qrisDinamis = QrisHelper::toDinamis($qrisStatis, (int) $order->total_price);

        $qrCode = new QrCode($qrisDinamis);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        return response($result->getString(), 200)
            ->header('Content-Type', 'image/png');
    }
}