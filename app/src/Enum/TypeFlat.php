<?php

namespace App\Enum;

enum TypeFlat: int
{
    case Unknown = 0;
    case Studio = 1;
    case OneRoom = 2;
    case TwoRoom = 3;
    case ThreeRoom = 4;
    case OneRoomEuro = 5;
    case TwoRoomEuro = 6;
    case ThreeRoomEuro = 7;

    public static function FromString(string $str): TypeFlat
    {
        return match ($str) {
            'Студия'        => TypeFlat::Studio,
            'Однокомнатная' => TypeFlat::OneRoom,
            'Двушка'        => TypeFlat::TwoRoom,
            'Трёшка'        => TypeFlat::ThreeRoom,
            'Еврооднушка'   => TypeFlat::OneRoomEuro,
            'Евродвушка'    => TypeFlat::TwoRoomEuro,
            'Евротрёшка'    => TypeFlat::ThreeRoomEuro,
            default         => TypeFlat::Unknown,
        };
    }
}
