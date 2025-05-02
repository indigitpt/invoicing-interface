<?php

namespace Indigit\Invoicing;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Indigit\Invoicing\Data\UpdateDocumentReferencesData;
use Indigit\Invoicing\Enums\DocumentTypeEnum;

final class Invoicing
{
    public function __construct(
        protected Contracts\DocumentInterface $payments,
        protected Contracts\DocumentInterface $refunds,
        protected Contracts\DocumentInterface $orders,
        protected Contracts\DocumentInterface $withdrawals
    ) {}

    /**
     * Paginates documents
     */
    public function paginate(DocumentTypeEnum $type, ?int $perPage = null): Paginator
    {
        $perPage = $perPage ?? 50;

        return match ($type) {
            DocumentTypeEnum::Payment => $this->payments->paginate($perPage),
            DocumentTypeEnum::Refund => $this->refunds->paginate($perPage),
            DocumentTypeEnum::Order => $this->orders->paginate($perPage),
            DocumentTypeEnum::Withdrawal => $this->withdrawals->paginate($perPage),
        };
    }

    /**
     * Registers the external document identifier
     *
     * @param  Collection<int, UpdateDocumentReferencesData>  $data
     */
    public function update(DocumentTypeEnum $type, Collection $data): JsonResponse
    {
        $result = match ($type) {
            DocumentTypeEnum::Payment => $this->payments->update($data),
            DocumentTypeEnum::Refund => $this->refunds->update($data),
            DocumentTypeEnum::Order => $this->orders->update($data),
            DocumentTypeEnum::Withdrawal => $this->withdrawals->update($data),
        };

        return response()->json([
            'status' => $result ? 'ok' : 'failed',
        ], status: $result ? 200 : 404);
    }
}
