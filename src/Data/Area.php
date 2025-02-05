<?php

namespace Yuges\Image\Data;

use Yuges\Image\Enums\Position;
use Yuges\Image\Enums\AlignPosition;
use Yuges\Image\Enums\AlignPositionUnified;

class Area
{
    public ?Area $canvas = null;

    public Position $position = Position::Absolute;

    public function __construct(
        public Size $size,
        public Point $pivot = new Point,
    ) {
    }

    public static function create(int $width, int $height, ?int $x = null, ?int $y = null): self
    {
        return new self(
            new Size($width, $height),
            new Point($x ?? 0, $y ?? 0),
        );
    }

    public function setCanvas(Area $area): self
    {
        $this->canvas = $area;

        return $this;
    }

    public function setPosition(Position $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function alignPivot(AlignPosition $position, int $offsetX = 0, int $offsetY = 0): self
    {
        [$x, $y] = match ($position->unify()) {
            AlignPositionUnified::Top => [
                ($this->size->width / 2) + $offsetX,
                0 + $offsetY,
            ],
            AlignPositionUnified::TopRight => [
                $this->size->width - $offsetX,
                0 + $offsetY,
            ],
            AlignPositionUnified::Left => [
                0 + $offsetX,
                ($this->size->height / 2) + $offsetY,
            ],
            AlignPositionUnified::TopLeft => [
                0 + $offsetX,
                0 + $offsetY,
            ],
            AlignPositionUnified::Right => [
                $this->size->width - $offsetX,
                ($this->size->height / 2) + $offsetY,
            ],
            AlignPositionUnified::BottomLeft => [
                0 + $offsetX,
                $this->size->height - $offsetY,
            ],
            AlignPositionUnified::Bottom => [
                ($this->size->width / 2) + $offsetX,
                $this->size->height - $offsetY,
            ],
            AlignPositionUnified::BottomRight => [
                $this->size->width - $offsetX,
                $this->size->height - $offsetY,
            ],
            AlignPositionUnified::Center => [
                ($this->size->width / 2) + $offsetX,
                ($this->size->height / 2) + $offsetY,
            ],
        };

        $this->pivot->setCoordinates(
            (int) $x,
            (int) $y,
        );

        return $this;
    }

    public function align(AlignPosition $position, int $offsetX = 0, int $offsetY = 0): self
    {
        $this->canvas->alignPivot($position);

        $this
            ->alignPivot($position)
            ->calculateRelativeCoordinates();

        return $this;
    }

    public function calculateRelativeCoordinates(): self
    {
        if ($this->position === Position::Relative) {
            return $this;
        }

        $this->position = Position::Relative;

        $this->pivot->setCoordinates(
            $this->canvas->pivot->x - $this->pivot->x,
            $this->canvas->pivot->y - $this->pivot->y,
        );

        return $this;
    }
}
