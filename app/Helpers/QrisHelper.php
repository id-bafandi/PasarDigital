<?php

namespace App\Helpers;

class QrisHelper
{
    /**
     * Konversi QRIS statis menjadi QRIS dinamis dengan nominal tertentu.
     * Mengikuti standar EMVCo QR Code Specification for Payment Systems
     * yang dipakai Bank Indonesia untuk QRIS.
     *
     * @param string $qrisStatis  String QRIS statis (diawali "000201...")
     * @param int    $nominal     Nominal pembayaran dalam Rupiah
     * @return string             String QRIS dinamis siap di-generate jadi QR image
     */
    public static function toDinamis(string $qrisStatis, int $nominal): string
    {
        // 1. Hapus 4 karakter CRC terakhir beserta tag "6304"-nya
        $qris = substr($qrisStatis, 0, -8);

        // 2. Ubah Point of Initiation Method dari statis (11) ke dinamis (12)
        $qris = str_replace('010211', '010212', $qris);

        // 3. Pisahkan berdasarkan tag negara "5802ID" untuk sisipkan tag nominal (54)
        $parts = explode('5802ID', $qris);

        if (count($parts) < 2) {
            throw new \InvalidArgumentException('Format QRIS statis tidak valid (tag negara 5802ID tidak ditemukan).');
        }

        // 4. Bangun tag 54 (Transaction Amount)
        $nominalStr = (string) $nominal;
        $tag54 = '54' . str_pad((string) strlen($nominalStr), 2, '0', STR_PAD_LEFT) . $nominalStr;

        // 5. Gabungkan kembali: [bagian sebelum] + tag54 + "5802ID" + [bagian sesudah]
        $qrisBaru = $parts[0] . $tag54 . '5802ID' . $parts[1];

        // 6. Tambahkan tag CRC kosong, lalu hitung ulang checksum CRC16
        $qrisBaru .= '6304';
        $crc = self::hitungCRC16($qrisBaru);

        return $qrisBaru . $crc;
    }

    /**
     * Hitung checksum CRC16-CCITT (False) sesuai standar QRIS.
     */
    private static function hitungCRC16(string $data): string
    {
        $crc = 0xFFFF;
        $len = strlen($data);

        for ($i = 0; $i < $len; $i++) {
            $crc ^= (ord($data[$i]) << 8);
            for ($j = 0; $j < 8; $j++) {
                if (($crc & 0x8000) !== 0) {
                    $crc = (($crc << 1) ^ 0x1021) & 0xFFFF;
                } else {
                    $crc = ($crc << 1) & 0xFFFF;
                }
            }
        }

        return strtoupper(str_pad(dechex($crc), 4, '0', STR_PAD_LEFT));
    }
}