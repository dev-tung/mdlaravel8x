<?php

namespace App\Enums;

final class EnumOptions
{
    // Import statuses
    const IMPORT_PENDING   = 'pending';
    const IMPORT_RECEIVED  = 'received';
    const IMPORT_CANCELLED = 'cancelled';

    // Export statuses
    const EXPORT_PENDING   = 'pending';
    const EXPORT_DELIVERED = 'delivered';
    const EXPORT_CANCELLED = 'cancelled';

    // Payments
    const PAYMENT_PENDING       = 'pending';
    const PAYMENT_CASH          = 'cash';
    const PAYMENT_BANK_TRANSFER = 'bank_transfer';
    const PAYMENT_CARD          = 'card';

    // ===== Labels =====
    public static function importStatuses(): array
    {
        return [
            self::IMPORT_PENDING   => 'Chờ nhập',
            self::IMPORT_RECEIVED  => 'Đã nhập kho',
            self::IMPORT_CANCELLED => 'Đã hủy nhập',
        ];
    }

    public static function exportStatuses(): array
    {
        return [
            self::EXPORT_PENDING   => 'Chờ xuất',
            self::EXPORT_DELIVERED => 'Đã xuất kho',
            self::EXPORT_CANCELLED => 'Đã hủy xuất',
        ];
    }

    public static function payments(): array
    {
        return [
            self::PAYMENT_PENDING       => 'Chưa thanh toán',
            self::PAYMENT_CASH          => 'Tiền mặt',
            self::PAYMENT_BANK_TRANSFER => 'Chuyển khoản',
            self::PAYMENT_CARD          => 'Thẻ',
        ];
    }

    // ===== Keys =====
    public static function importStatusKeys(): array
    {
        return array_keys(self::importStatuses());
    }

    public static function exportStatusKeys(): array
    {
        return array_keys(self::exportStatuses());
    }

    public static function paymentKeys(): array
    {
        return array_keys(self::payments());
    }
}
