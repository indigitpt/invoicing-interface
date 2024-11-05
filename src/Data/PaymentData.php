<?php

namespace Indigit\Invoicing\Data;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class PaymentData extends Data
{
    public function __construct(
        public string $reference_website, // ex: payment.id
        public CustomerData $customer,
        /** @var Collection<int, PaymentProductData> */
        public Collection $products,
        public string $gateway, // Flavorly\Gateways\Enum\PaymentGatewayEnum
        #[WithCast(DateTimeInterfaceCast::class)]
        public ?Carbon $paid_at = null, // when it's an invoice, we don't have a paid at date yet
        public ?string $reference_group = null // financial document group identifier (uuid)
    ) {}
}
