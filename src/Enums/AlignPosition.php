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
            AlignPosition::Top,
            AlignPosition::TopCenter,
            AlignPosition::TopMiddle,
            AlignPosition::CenterTop,
            AlignPosition::MiddleTop => AlignPositionUnified::Top,
            AlignPosition::TopRight,
            AlignPosition::RightTop => AlignPositionUnified::TopRight,
            AlignPosition::Left,
            AlignPosition::LeftCenter,
            AlignPosition::LeftMiddle,
            AlignPosition::CenterLeft,
            AlignPosition::MiddleLeft => AlignPositionUnified::Left,
            AlignPosition::TopLeft,
            AlignPosition::LeftTop => AlignPositionUnified::TopLeft,
            AlignPosition::Right,
            AlignPosition::RightCenter,
            AlignPosition::RightMiddle,
            AlignPosition::CenterRight,
            AlignPosition::MiddleRight => AlignPositionUnified::Right,
            AlignPosition::BottomLeft,
            AlignPosition::LeftBottom => AlignPositionUnified::BottomLeft,
            AlignPosition::Bottom,
            AlignPosition::BottomCenter,
            AlignPosition::BottomMiddle,
            AlignPosition::CenterBottom,
            AlignPosition::MiddleBottom => AlignPositionUnified::Bottom,
            AlignPosition::BottomRight,
            AlignPosition::RightBottom => AlignPositionUnified::BottomRight,
            AlignPosition::Center,
            AlignPosition::Middle,
            AlignPosition::CenterCenter,
            AlignPosition::MiddleMiddle => AlignPositionUnified::Center,
        };
    }
}
