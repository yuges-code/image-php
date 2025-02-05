<?php

namespace Yuges\Image\Drivers;

use Yuges\Image\Data\Area;
use Yuges\Image\Data\Size;
use Yuges\Image\Data\Flip;
use Yuges\Image\Enums\Orientation;
use Yuges\Image\Enums\FlipDirection;
use Yuges\Image\Enums\ResizeConstraint;

interface ImageDriver
{
    public static function create(int $width, int $height, ?string $backgroundColor = null): static;

    public function loadFile(string $path): static;

    public function getName(): string;

    public function getImage(): mixed;

    public function getArea(): Area;

    public function getSize(): Size;

    public function getWidth(): int;

    public function getHeight(): int;




    public function resize(int $width, int $height, ?ResizeConstraint $constraints = null): static;

    public function width(int $width, ?ResizeConstraint $constraints = ResizeConstraint::PreserveAspectRatio): static;

    public function height(int $height, ?ResizeConstraint $constraints = ResizeConstraint::PreserveAspectRatio): static;

    public function flip(Flip|FlipDirection|null $flip = null): static;

    public function crop(int $width, int $height, ?int $x = null, ?int $y = null): static;

    public function rotate(?float $degrees = null, ?string $background = null): static;

    public function orientate(?Orientation $orientation = null): static;

    public function blur(int $blur): static;




    public function base64(string $format = 'png', bool $prefix = true): string;

    public function save(?string $path = null): static;
}
