<?php

namespace Indigit\Invoicing\Data;

use Spatie\LaravelData\Data;

class DocumentMetaData extends Data
{
    public function __construct(
        public string $documentLabel, // document label (ex: M/22)
        public string $documentLink // direct link for the pdf file
    ) {}
}
