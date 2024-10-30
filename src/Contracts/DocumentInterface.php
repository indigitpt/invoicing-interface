<?php

namespace Indigit\Invoicing\Contracts;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;
use Indigit\Invoicing\Data\UpdateDocumentReferencesData;

interface DocumentInterface
{
    /**
     * Paginates documents
     */
    public function paginate(int $perPage): Paginator;

    /**
     * Registers the external document identifiers and other document metadata
     *
     * @param  Collection<int, UpdateDocumentReferencesData>  $data
     */
    public function update(Collection $data): bool;
}
