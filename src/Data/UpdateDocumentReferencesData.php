<?php

namespace Indigit\Invoicing\Data;

use Spatie\LaravelData\Data;

class UpdateDocumentReferencesData extends Data
{
    public function __construct(
        public string $reference_website, // ex: payment.id
        public string $reference_financial_document, // related financial document identifier (uuid)
        public string $reference_group, // financial document group identifier (uuid)
        public ?string $reference_provider = null, // moloni document identifier
        public ?string $document_label = null, // moloni document label (ex: M/22)
        public ?string $document_link = null // direct link for the pdf file
    ) {}
}
