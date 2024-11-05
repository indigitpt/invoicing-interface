<?php

namespace Indigit\Invoicing\Data;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class RefundData extends Data
{
    public function __construct(
        public string $reference_website, // ex: payment.id
        public string $reference_related_document, // this is the financial document identifier (uuid)
        public CustomerData $customer,
        #[WithCast(DateTimeInterfaceCast::class)]
        public Carbon $refunded_at,
        public ?float $amount = null, // leave empty for full refund
        public ?string $reference_group = null // financial document group identifier (uuid)
    ) {}
}
