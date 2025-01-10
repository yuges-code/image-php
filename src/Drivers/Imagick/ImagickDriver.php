<?php

namespace Yuges\Image\Drivers\Imagick;

use Imagick;
use Yuges\Image\Data\Flip;
use Yuges\Image\Enums\Orientation;
use Yuges\Image\Drivers\ImageDriver;
use Yuges\Image\Enums\FlipDirection;

class ImagickDriver implements ImageDriver
{
    protected Imagick $image;

    protected array $exif = [];

    private string $name = 'imagick';

    public static function create(int $width, int $height, ?string $backgroundColor = null): self
    {
        $image = new Imagick;
        $color = ImagickColor::createFromString($backgroundColor);

        $image->newImage($width, $height, $color->getPixel(), 'png');
        $image->setType(Imagick::IMGTYPE_UNDEFINED);
        $image->setImageType(Imagick::IMGTYPE_UNDEFINED);
        $image->setColorspace(Imagick::COLORSPACE_UNDEFINED);

        return (new self)->setImage($image);
    }

    public function loadFile(string $path): self
    {
        $this->image = new Imagick($path);
        $this->exif = $this->image->getImageProperties('exif:*');

        if ($this->isAnimated()) {
            $this->image = $this->image->coalesceImages();
        }

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setImage(Imagick $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImage(): Imagick
    {
        return $this->image;
    }

    public function getWidth(): int
    {
        return $this->image->getImageWidth();
    }

    public function getHeight(): int
    {
        return $this->image->getImageHeight();
    }

    public function isAnimated(): bool
    {
        return $this->image->count() > 1;
    }



    public function flip(Flip|FlipDirection|null $flip = null): self
    {
        if ($flip instanceof Flip) {
            $flip = $flip->getEnum();
        }

        if (! $flip) {
            return $this;
        }

        foreach ($this->image as $image) {
            switch ($flip) {
                case FlipDirection::VERTICAL:
                    $image->flipImage();
                    break;
                case FlipDirection::HORIZONTAL:
                    $image->flopImage();
                    break;
                case FlipDirection::BOTH:
                    $image->flipImage();
                    $image->flopImage();
                    break;
            }
        }

        return $this;
    }

    public function crop(int $width, int $height, ?int $x = null, ?int $y = null): self
    {
        foreach ($this->image as $image) {
            $image->cropImage($width, $height, $x, $y);
            $image->setImagePage(0, 0, 0, 0);
        }

        return $this;
    }

    public function rotate(?float $degrees = null, ?string $background = null): self
    {
        if (! $background) {
            $background = ImagickColor::createFromString('none');
        }

        foreach ($this->image as $image) {
            $image->rotateImage($background->getPixel(), $degrees);
        }

        return $this;
    }

    public function orientate(?Orientation $orientation = null): self
    {
        if (is_null($orientation)) {
            // $orientation = $this->getOrientationFromExif($this->exif);
        }

        return $this->rotate($orientation->degrees());
    }



    public function save(?string $path = null): self
    {
        $this->image->writeImage($path);

        return $this;
    }
}
