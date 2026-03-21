<?php

namespace Indigit\Invoicing\Tests\TestSupport;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;
use Indigit\Invoicing\Contracts\DocumentInterface;

class DocumentHandler implements DocumentInterface
{
    public Paginator $data;

    public bool $updateResult = false;

    public ?int $lastPerPage = null;

    public ?Collection $lastUpdateData = null;

    public function paginate(int $perPage): Paginator
    {
        $this->lastPerPage = $perPage;

        return $this->data;
    }

    public function update(Collection $data): bool
    {
        $this->lastUpdateData = $data;

        return $this->updateResult;
    }
}
