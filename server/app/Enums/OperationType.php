<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Subtraction()
 * @method static static Sum()
 */
final class OperationType extends Enum
{
    const Subtraction = 0;
    const Sum         = 1;
}
