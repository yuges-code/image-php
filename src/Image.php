<?php

namespace Yuges\Image;

use Yuges\Image\Data\Flip;
use Yuges\Image\Enums\Orientation;
use Yuges\Image\Enums\FlipDirection;
use Yuges\Image\Drivers\Gd\GdDriver;
use Yuges\Image\Drivers\ImageDriver;
use Yuges\Image\Enums\ResizeConstraint;
use Yuges\Image\Factories\ImageDriverFactory;
use Yuges\Image\Drivers\Imagick\ImagickDriver;
use Yuges\Image\Exceptions\InvalidImageDriver;
use Yuges\Image\Enums\ImageDriver as ImageDriverEnum;

class Image
{
    protected ImageDriver $driver;

    public function __construct(?string $path = null)
    {
        if (! $path) {
            return;
        }

        $this->driver = ImageDriverFactory::create(ImageDriverEnum::Imagick)->loadFile($path);
    }

    public static function open(string $path): static
    {
        return self::load($path);
    }

    public static function load(string $path): static
    {
        if (! file_exists($path)) {

            // throw CouldNotLoadImage::fileDoesNotExist($pathToImage);
        }

        return new static($path);
    }

    public function loadFile(string $path): static
    {
        $this->driver->loadFile($path);

        return $this;
    }

    public static function useDriver(ImageDriverEnum|string $driver): static
    {
        if (is_string($driver)) {
            $driver = ImageDriverEnum::tryFrom($driver) ?? throw InvalidImageDriver::driver($driver);
        }

        $image = new static;
        $image->driver = match ($driver) {
            ImageDriverEnum::Gd => new GdDriver,
            ImageDriverEnum::Imagick => new ImagickDriver,
        };

        return $image;
    }



    public function resize(int $width, int $height, ?ResizeConstraint $constraints = null): static
    {
        $this->driver->resize($width, $height, $constraints);

        return $this;
    }

    public function width(int $width, ?ResizeConstraint $constraints = ResizeConstraint::PreserveAspectRatio): static
    {
        $this->driver->width($width, $constraints);

        return $this;
    }

    public function height(int $height, ?ResizeConstraint $constraints = ResizeConstraint::PreserveAspectRatio): static
    {
        $this->driver->height($height, $constraints);

        return $this;
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

    public function blur(int $blur): self
    {
        $this->driver->blur($blur);

        return $this;
    }





    public function base64(string $format = 'png', bool $prefix = true): string
    {
        return $this->driver->base64($format, $prefix);
    }

    public function save(?string $path = null): static
    {
        $this->driver->save($path);

        return $this;
    }
}
