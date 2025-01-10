<?php

namespace Yuges\Image\Drivers\Imagick;

use ImagickPixel;
use Yuges\Image\Drivers\Color;

class ImagickColor implements Color
{
    public ImagickPixel $pixel;

    public static function createFromRgba(
        int|float $red,
        int|float $green,
        int|float $blue,
        int|float|null $alpha = null
    ): self
    {
        $instance = new static();

        return $instance->setPixel($red, $green, $blue, $alpha);
    }

    public static function createFromString(?string $color = null): self
    {
        /** @todo rgbaFromString */

        $red = 255;
        $green = 255;
        $blue = 255;
        $alpha = null;

        $instance = new static();

        return $instance->setPixel($red, $green, $blue, $alpha);
    }

    private function setPixel(
        int|float $red,
        int|float $green,
        int|float $blue,
        int|float|null $alpha = null
    ): self
    {
        $alpha = is_null($alpha) ? 1 : $alpha;

        $this->pixel = new ImagickPixel("rgba({$red}, {$green}, {$blue}, {$alpha})");
        
        return $this;
    }

    public function getPixel(): ImagickPixel
    {
        return $this->pixel;
    }
}
