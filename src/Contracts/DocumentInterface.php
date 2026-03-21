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
    #[\NoDiscard('Paginator result must be returned to the client')]
    public function paginate(int $perPage): Paginator;

    /**
     * Registers the external document identifiers and other document metadata
     *
     * @param  Collection<int, UpdateDocumentReferencesData>  $data
     */
    #[\NoDiscard('Update result must be checked for success/failure')]
    public function update(Collection $data): bool;
}
