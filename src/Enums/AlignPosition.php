<?php

namespace Yuges\Image\Enums;

enum AlignPosition: string
{
    case Top = 'top';
    case TopLeft = 'top-left';
    case TopRight = 'top-right';
    case TopCenter = 'top-center';
    case TopMiddle = 'top-middle';

    case Bottom = 'bottom';
    case BottomLeft = 'bottom-left';
    case BottomRight = 'bottom-right';
    case BottomCenter = 'bottom-center';
    case BottomMiddle = 'bottom-middle';

    case Left = 'left';
    case LeftTop = 'left-top';
    case LeftBottom = 'left-bottom';
    case LeftCenter = 'left-center';
    case LeftMiddle = 'left-middle';

    case Right = 'right';
    case RightTop = 'right-top';
    case RightBottom = 'right-bottom';
    case RightCenter = 'right-center';
    case RightMiddle = 'right-middle';

    case Center = 'center';
    case CenterTop = 'center-top';
    case CenterLeft = 'center-left';
    case CenterRight = 'center-right';
    case CenterBottom = 'center-bottom';

    case Middle = 'middle';
    case MiddleTop = 'middle-top';
    case MiddleLeft = 'middle-left';
    case MiddleRight = 'middle-right';
    case MiddleBottom = 'middle-bottom';

    case CenterCenter = 'center-center';
    case MiddleMiddle = 'middle-middle';

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
