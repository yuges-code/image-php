<?php

namespace Yuges\Image\Data;

class Size
{
    public function __construct(
        public int $width,
        public int $height,
    ) {
    }

    public function aspectRatio(): float
    {
        return $this->width / $this->height;
    }
}
