<?php

namespace Indigit\Invoicing\Enums;

use Flavorly\LaravelHelpers\Concerns\EnumConcern;

enum DocumentTypeEnum: string
{
    use EnumConcern;

    case Payment = 'payment';
    case Refund = 'refund';
    case Order = 'order';
    case Withdrawal = 'withdrawal';
}
