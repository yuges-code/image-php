<?php

namespace Yuges\Image\Drivers;

interface Color
{
    public static function createFromRgba(
        int|float $red,
        int|float $green,
        int|float $blue,
        int|float|null $alpha = null
    ): static;
}
