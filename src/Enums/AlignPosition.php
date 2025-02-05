<?php

namespace Yuges\Image\Enums;

enum AlignPosition: string
{
    case Top = 'top';
    case TopLeft = 'topLeft';
    case TopRight = 'topRight';
    case TopCenter = 'topCenter';
    case TopMiddle = 'topMiddle';

    case Bottom = 'bottom';
    case BottomLeft = 'bottomLeft';
    case BottomRight = 'bottomRight';
    case BottomCenter = 'bottomCenter';
    case BottomMiddle = 'bottomMiddle';

    case Left = 'left';
    case LeftTop = 'leftTop';
    case LeftBottom = 'leftBottom';
    case LeftCenter = 'leftCenter';
    case LeftMiddle = 'leftMiddle';

    case Right = 'right';
    case RightTop = 'rightTop';
    case RightBottom = 'rightBottom';
    case RightCenter = 'rightCenter';
    case RightMiddle = 'rightMiddle';

    case Center = 'center';
    case CenterTop = 'centerTop';
    case CenterLeft = 'centerLeft';
    case CenterRight = 'centerRight';
    case CenterBottom = 'centerBottom';

    case Middle = 'middle';
    case MiddleTop = 'middleTop';
    case MiddleLeft = 'middleLeft';
    case MiddleRight = 'middleRight';
    case MiddleBottom = 'middleBottom';

    case CenterCenter = 'centerCenter';
    case MiddleMiddle = 'middleMiddle';

    public function unify(): AlignPositionUnified
    {
        return match ($this) {
            self::Top,
            self::TopCenter,
            self::TopMiddle,
            self::CenterTop,
            self::MiddleTop => AlignPositionUnified::Top,
            self::TopRight,
            self::RightTop => AlignPositionUnified::TopRight,
            self::Left,
            self::LeftCenter,
            self::LeftMiddle,
            self::CenterLeft,
            self::MiddleLeft => AlignPositionUnified::Left,
            self::TopLeft,
            self::LeftTop => AlignPositionUnified::TopLeft,
            self::Right,
            self::RightCenter,
            self::RightMiddle,
            self::CenterRight,
            self::MiddleRight => AlignPositionUnified::Right,
            self::BottomLeft,
            self::LeftBottom => AlignPositionUnified::BottomLeft,
            self::Bottom,
            self::BottomCenter,
            self::BottomMiddle,
            self::CenterBottom,
            self::MiddleBottom => AlignPositionUnified::Bottom,
            self::BottomRight,
            self::RightBottom => AlignPositionUnified::BottomRight,
            self::Center,
            self::Middle,
            self::CenterCenter,
            self::MiddleMiddle => AlignPositionUnified::Center,
        };
    }
}
