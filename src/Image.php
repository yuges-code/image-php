<?php

namespace Yuges\Image;

class Image
{
    public function __construct(?string $path = null)
    {
        
    }

    public static function load(string $path): static
    {
        return new static($path);
    }
}
