<?php

namespace Yuges\Image\Drivers\Gd;

use GdImage;
use Yuges\Image\Data\Area;
use Yuges\Image\Data\Flip;
use Yuges\Image\Data\Size;
use Yuges\Image\Enums\Orientation;
use Yuges\Image\Enums\FlipDirection;
use Yuges\Image\Drivers\ImageDriver;
use Yuges\Image\Enums\ResizeConstraint;

class GdDriver implements ImageDriver
{
    const string NAME = 'gd';

    protected GdImage $image;

    protected array $exif = [];

    protected int $quality = -1;

    public static function create(int $width, int $height, ?string $backgroundColor = null): static
    {
        return new static;
    }

    public function loadFile(string $path): static
    {
        return $this;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getImage(): GdImage
    {
        return $this->image;
    }

    public function setImage(GdImage $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getArea(): Area
    {
        return new Area($this->getSize());
    }

    public function getSize(): Size
    {
        return new Size($this->getWidth(), $this->getHeight());
    }

    public function getWidth(): int
    {
        return imagesx($this->image);
    }

    public function getHeight(): int
    {
        return imagesy($this->image);
    }




    public function resize(int $width, int $height, ?ResizeConstraint $constraints = null): static
    {
        return $this;
    }

    public function width(int $width, ?ResizeConstraint $constraints = ResizeConstraint::PreserveAspectRatio): static
    {
        return $this;
    }

    public function height(int $height, ?ResizeConstraint $constraints = ResizeConstraint::PreserveAspectRatio): static
    {
        return $this;
    }

    public function flip(Flip|FlipDirection|null $flip = null): static
    {
        return $this;
    }

    public function crop(int $width, int $height, ?int $x = null, ?int $y = null): static
    {
        return $this;
    }

    public function rotate(?float $degrees = null, ?string $background = null): static
    {
        return $this;
    }

    public function orientate(?Orientation $orientation = null): static
    {
        return $this;
    }

    public function blur(int $blur): static
    {
        return $this;
    }




    public function base64(string $format = 'png', bool $prefix = true): string
    {
        ob_start();

        switch (strtolower($format)) {
            case 'jpg':
            case 'jpeg':
            case 'jfif':
                \imagejpeg($this->image, null, $this->quality);
                break;
            case 'png':
                \imagepng($this->image, null, $this->quality);
                break;
            case 'gif':
                \imagegif($this->image, null);
                break;
            case 'webp':
                \imagewebp($this->image, null);
                break;
            case 'avif':
                \imageavif($this->image, null);
                break;
            default:
                // throw UnsupportedImageFormat::make($format);
        }

        $imageData = ob_get_contents();
        ob_end_clean();

        if ($prefix) {
            return 'data:image/'.$format.';base64,'.base64_encode($imageData);
        }

        return base64_encode($imageData);
    }

    public function save(?string $path = null): static
    {
        return $this;
    }
}