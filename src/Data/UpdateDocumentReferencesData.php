<?php

namespace Indigit\Invoicing\Data;

use Spatie\LaravelData\Data;

class UpdateDocumentReferencesData extends Data
{
    public function __construct(
        public string $id,
        public string $externalId,
        public ?DocumentMetaData $meta = null
    ) {}
}
