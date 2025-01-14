<?php

namespace Yuges\Image\Data;

class Point
{
    public function __construct(
        public int $x = 0,
        public int $y = 0
    ) {
    }

    public function setCoordinates(int $x, int $y): self
    {
        $this->x = $x;
        $this->y = $y;

        return $this;
    }
}
