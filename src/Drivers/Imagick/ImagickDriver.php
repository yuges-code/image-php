<?php

namespace Yuges\Image\Drivers\Imagick;

use Imagick;
use Yuges\Image\Data\Area;
use Yuges\Image\Data\Size;
use Yuges\Image\Data\Flip;
use Yuges\Image\Enums\Orientation;
use Yuges\Image\Drivers\ImageDriver;
use Yuges\Image\Enums\AlignPosition;
use Yuges\Image\Enums\FlipDirection;
use Yuges\Image\Enums\ResizeConstraint;

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

    public function getImage(): Imagick
    {
        return $this->image;
    }

    public function setImage(Imagick $image): static
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



    public function resize(int $width, int $height, ?ResizeConstraint $constraints = null): static
    {
        // $resized = $this->getSize()->resize($width, $height, $constraints);

        foreach ($this->image as $image) {
            $image->scaleImage($width, $height);
        }

        return $this;
    }

    public function width(int $width, ?ResizeConstraint $constraints = ResizeConstraint::PreserveAspectRatio): static
    {
        $height = (int) round($width / $this->getSize()->aspectRatio());

        $this->resize($width, $height, $constraints);

        return $this;
    }

    public function height(int $height, ?ResizeConstraint $constraints = ResizeConstraint::PreserveAspectRatio): static
    {
        $width = (int) round($height * $this->getSize()->aspectRatio());

        $this->resize($width, $height, $constraints);

        return $this;
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
                case FlipDirection::Both:
                    $image->flipImage();
                    $image->flopImage();
                    break;
                case FlipDirection::Vertical:
                    $image->flipImage();
                    break;
                case FlipDirection::Horizontal:
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
            $background = ImagickColor::create('none');
        }

        foreach ($this->image as $image) {
            $image->rotateImage($background->getPixel(), $degrees);
            $image->setImagePage(0, 0, 0, 0);
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

    public function blur(int $blur): static
    {
        foreach ($this->image as $image) {
            $image->blurImage(0.5 * $blur, 0.1 * $blur);
        }

        return $this;
    }






    public function base64(string $format = 'png', bool $prefix = true): string
    {
        $image = clone $this->image;
        $image->setFormat($format);

        if ($prefix) {
            return 'data:image/'.$format.';base64,'.base64_encode($image->getImageBlob());
        }

        return base64_encode($image->getImageBlob());
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
