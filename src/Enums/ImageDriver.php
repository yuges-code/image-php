<?php

namespace Yuges\Image\Enums;

enum ImageDriver: string
{
    case Gd = 'gd';
    case Imagick = 'imagick';
}
