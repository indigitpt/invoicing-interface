<?php

namespace Indigit\Invoicing\Data;

use Spatie\LaravelData\Data;

class OrderPaymentData extends Data
{
    public function __construct(
        public string $invoice_document_reference,
        public ?string $invoice_document_refund_reference,
        public float $amount,
        public float $amount_refunded,
    ) {}
}
