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
            return FlipDirection::Both;
        } elseif ($this->vertical) {
            return FlipDirection::Vertical;
        } elseif ($this->horizontal) {
            return FlipDirection::Horizontal;
        }

        return null;
    }
}
