<?php

namespace Indigit\Invoicing\Data;

use Spatie\LaravelData\Data;

class PaymentProductData extends Data
{
    public function __construct(
        public string $reference_product, // must be equal to the product reference in the invoicing panel
        public float $amount,
        public int $quantity = 1,
        public ?string $name = null,
    ) {}
}
