<?php
declare(strict_types=1);

namespace App\Enums;

enum JourneyType: int {
    case DIRECT = 0;
    case CONNECTING = 1;
}
