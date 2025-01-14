<?php

namespace Yuges\Image\Drivers\Imagick;

use Imagick;
use Yuges\Image\Data\Flip;
use Yuges\Image\Data\Area;
use Yuges\Image\Data\Size;
use Yuges\Image\Enums\Orientation;
use Yuges\Image\Drivers\ImageDriver;
use Yuges\Image\Enums\AlignPosition;
use Yuges\Image\Enums\FlipDirection;

class ImagickDriver implements ImageDriver
{
    const string NAME = 'imagick';

    protected Imagick $image;

    protected array $exif = [];

    public static function create(int $width, int $height, ?string $backgroundColor = null): static
    {
        $image = new Imagick;
        $color = ImagickColor::createFromString($backgroundColor);

        $image->newImage($width, $height, $color->getPixel(), 'png');
        $image->setType(Imagick::IMGTYPE_UNDEFINED);
        $image->setImageType(Imagick::IMGTYPE_UNDEFINED);
        $image->setColorspace(Imagick::COLORSPACE_UNDEFINED);

        return (new self)->setImage($image);
    }

    public function loadFile(string $path): static
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
        return self::NAME;
    }

    public function getArea(): Area
    {
        return new Area($this->getSize());
    }

    public function getSize(): Size
    {
        return new Size($this->getWidth(), $this->getHeight());
    }

    public function setImage(Imagick $image): static
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



    public function flip(Flip|FlipDirection|null $flip = null): static
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

    public function crop(int $width, int $height, ?int $x = null, ?int $y = null): static
    {
        $area = Area::create($width, $height, $x, $y);

        if (is_null($x) && is_null($y)) {
            $canvas = $this->getArea();

            $area
                ->setCanvas($canvas)
                ->align(AlignPosition::Center);
        }

        foreach ($this->image as $image) {
            $image->cropImage($area->size->width, $area->size->height, $area->pivot->x, $area->pivot->y);
            $image->setImagePage(0, 0, 0, 0);
        }

        return $this;
    }

    public function rotate(?float $degrees = null, ?string $background = null): static
    {
        if (! $background) {
            $background = ImagickColor::createFromString('none');
        }

        foreach ($this->image as $image) {
            $image->rotateImage($background->getPixel(), $degrees);
        }

        return $this;
    }

    public function orientate(?Orientation $orientation = null): static
    {
        if (is_null($orientation)) {
            // $orientation = $this->getOrientationFromExif($this->exif);
        }

        return $this->rotate($orientation->degrees());
    }



    public function save(?string $path = null): static
    {
        if ($this->isAnimated()) {
            $image = $this->image->deconstructImages();
            $image->writeImages($path, true);
        } else {
            $this->image->writeImage($path);
        }

        return $this;
    }
}
