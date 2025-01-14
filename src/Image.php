<?php

namespace Yuges\Image;

use Yuges\Image\Data\Flip;
use Yuges\Image\Enums\Orientation;
use Yuges\Image\Enums\FlipDirection;
use Yuges\Image\Drivers\ImageDriver;
use Yuges\Image\Drivers\Imagick\ImagickDriver;

class Image
{
    protected ImageDriver $driver;

    public function __construct(?string $path = null)
    {
        if (! $path) {
            return;
        }

        $this->driver = (new ImagickDriver)->loadFile($path);
    }

    public static function load(string $path): static
    {
        if (! file_exists($path)) {

            // throw CouldNotLoadImage::fileDoesNotExist($pathToImage);
        }

        return new static($path);
    }






    public function flip(Flip|FlipDirection|null $flip = null): self
    {
        $this->driver->flip($flip);

        return $this;
    }

    public function crop(int $width, int $height, ?int $x = null, ?int $y = null): self
    {
        $this->driver->crop($width, $height, $x, $y);

        return $this;
    }

    public function rotate(?float $degrees = null, ?string $background = null): self
    {
        $this->driver->rotate($degrees, $background);

        return $this;
    }

    public function orientate(?Orientation $orientation = null): self
    {
        $this->driver->orientate($orientation);

        return $this;
    }






    public function save(?string $path = null): static
    {
        $this->driver->save($path);

        return $this;
    }
}
