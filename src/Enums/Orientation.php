<?php

namespace Yuges\Image\Enums;

enum Orientation: int
{
    case ROTATE0 = 0;
    case ROTATE30 = 30;
    case ROTATE45 = 45;
    case ROTATE60 = 60;
    case ROTATE90 = 90;
    case ROTATE120 = 120;
    case ROTATE135 = 135;
    case ROTATE150 = 150;
    case ROTATE180 = 180;
    case ROTATE210 = 210;
    case ROTATE225 = 225;
    case ROTATE240 = 240;
    case ROTATE270 = 270;

    public function degrees(): int
    {
        return $this->value;
    }
}
