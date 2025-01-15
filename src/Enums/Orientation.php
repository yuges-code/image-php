<?php

namespace Yuges\Image\Enums;

enum Orientation: int
{
    case Rotate0 = 0;
    case Rotate30 = 30;
    case Rotate45 = 45;
    case Rotate60 = 60;
    case Rotate90 = 90;
    case Rotate120 = 120;
    case Rotate135 = 135;
    case Rotate150 = 150;
    case Rotate180 = 180;
    case Rotate210 = 210;
    case Rotate225 = 225;
    case Rotate240 = 240;
    case Rotate270 = 270;

    public function degrees(): int
    {
        return $this->value;
    }
}
