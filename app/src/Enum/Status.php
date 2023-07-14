<?php

namespace App\Enum;

enum Status: int
{
    case Unknown = 0;
    case New = 1;
    case Sent = 2;
    case Viewed = 3;

    public static function FromString(string $str): Status
    {
        return match ($str) {
            'Новая'                 => Status::New,
            'Отправлена клиенту'    => Status::Sent,
            'Просмотрена клиентом'  => Status::Viewed,
            'Неизвестен'            => Status::Unknown,
        };
    }
}
