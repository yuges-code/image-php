<?php

namespace Yuges\Image\Drivers;

use Yuges\Image\Data\Flip;
use Yuges\Image\Enums\Orientation;
use Yuges\Image\Enums\FlipDirection;

interface ImageDriver
{
    public static function create(int $width, int $height, ?string $backgroundColor = null): static;

    public function loadFile(string $path): static;

    public function getName(): string;

    public function getImage(): mixed;

    public function getWidth(): int;

    public function getHeight(): int;

    public function isAnimated(): bool;


    public function flip(Flip|FlipDirection|null $flip = null): static;

    public function crop(int $width, int $height, ?int $x = null, ?int $y = null): static;

    public function rotate(?float $degrees = null): static;

    public function orientate(?Orientation $orientation = null): static;


    public function save(?string $path = null): static;
}
