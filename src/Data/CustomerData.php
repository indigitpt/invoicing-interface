<?php

namespace Indigit\Invoicing\Data;

use Spatie\LaravelData\Data;

class CustomerData extends Data
{
    public function __construct(
        public string $reference_website, // ex: user.id
        public string $name,
        public string $address,
        public string $city,
        public ?string $country = null, // in iso_3166_1 (ex: pt, br, gb, fr, etc
        public ?string $zip_code = null,
        public ?string $vat_number = null, // leave as null if not required
        public ?string $email = null,
        public ?string $website = null,
        public ?string $phone = null
    ) {}
}
