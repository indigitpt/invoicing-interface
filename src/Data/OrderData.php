<?php

namespace Indigit\Invoicing\Data;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class OrderData extends Data
{
    public function __construct(
        public string $reference_website, // ex: order.id or payment.id when using single payments
        /** @var Collection<int, PaymentProductData> */
        public Collection $products,
        /** @var Collection<int, string> */
        public Collection $payments, // financial document identifiers (uuids received)
        public CustomerData $customer,
        public ?string $gateway = null, // when it's an invoice, Flavorly\Gateways\Enum\PaymentGatewayEnum
        #[WithCast(DateTimeInterfaceCast::class)]
        public ?Carbon $paid_at = null, // when it's an invoice, only now we have a paid at date, so we can issue the receipt
        public ?string $reference_group = null // financial document group identifier (uuid)
    ) {}
}
