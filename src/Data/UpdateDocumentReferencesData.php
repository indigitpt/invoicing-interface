<?php

namespace Indigit\Invoicing\Data;

use Spatie\LaravelData\Data;

class UpdateDocumentReferencesData extends Data
{
    public function __construct(
        public string $reference_website, // ex: payment.id
        public string $reference_financial_document, // related financial document identifier (uuid)
        public ?DocumentMetaData $meta = null
    ) {}
}
