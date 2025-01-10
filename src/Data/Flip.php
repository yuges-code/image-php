<?php

namespace Yuges\Image\Data;

use Yuges\Image\Enums\FlipDirection;

class Flip
{
    public function __construct(
        public bool $vertical,
        public bool $horizontal,
    ) {
    }

    public function getEnum(): ?FlipDirection
    {
        if ($this->vertical && $this->horizontal) {
            return FlipDirection::BOTH;
        } elseif ($this->vertical) {
            return FlipDirection::VERTICAL;
        } elseif ($this->horizontal) {
            return FlipDirection::HORIZONTAL;
        }

        return null;
    }
}
