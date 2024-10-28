<?php

namespace Indigit\Invoicing\Tests\TestSupport;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;
use Indigit\Invoicing\Contracts\DocumentInterface;

class DocumentHandler implements DocumentInterface
{
    public Paginator $data;

    public bool $updateResult = false;

    public function paginate(): Paginator
    {
        return $this->data;
    }

    public function update(Collection $data): bool
    {
        return $this->updateResult;
    }
}
