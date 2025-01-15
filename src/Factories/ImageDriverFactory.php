<?php

namespace Yuges\Image\Factories;

use Yuges\Image\Drivers\Gd\GdDriver;
use Yuges\Image\Drivers\ImageDriver;
use Yuges\Image\Drivers\Imagick\ImagickDriver;
use Yuges\Image\Enums\ImageDriver as ImageDriverEnum;

class ImageDriverFactory
{
    public static function create(ImageDriverEnum $driver): ImageDriver
    {
        return match ($driver) {
            ImageDriverEnum::Gd => new GdDriver,
            ImageDriverEnum::Imagick => new ImagickDriver,
        };
    }
}
