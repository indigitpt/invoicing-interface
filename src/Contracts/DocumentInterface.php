<?php

namespace Indigit\Invoicing\Contracts;

use Illuminate\Contracts\Pagination\Paginator;
use Indigit\Invoicing\Data\UpdateDocumentReferencesData;

interface DocumentInterface
{
    /**
     * Paginates documents
     */
    public function paginate(): Paginator;

    /**
     * Registers the external document identifiers and other document metadata
     */
    public function update(UpdateDocumentReferencesData $data): bool;
}
