<?php

namespace App\Enums;

class SmsStatus
{
    const FAILED = 1;
    const SUCCESS = 2;

    /**
     * Get the label for the status.
     *
     * @param int $status
     * @return string
     */
    public static function getLabel(int $status): string
    {
        switch ($status) {
            case self::FAILED:
                return 'Failed';
            case self::SUCCESS:
                return 'Success';
            default:
                return 'Unknown';
        }
    }
}
