<?php

namespace Indigit\Invoicing;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Indigit\Invoicing\Data\UpdateDocumentReferencesData;
use Indigit\Invoicing\Enums\DocumentTypeEnum;

final class Invoicing
{
    public function __construct(
        protected Contracts\DocumentInterface $payments,
        protected Contracts\DocumentInterface $refunds,
        protected Contracts\DocumentInterface $orders,
    ) {}

    /**
     * Paginates documents
     */
    public function paginate(DocumentTypeEnum $type): Paginator
    {
        return match ($type) {
            DocumentTypeEnum::Payment => $this->payments->paginate(),
            DocumentTypeEnum::Refund => $this->refunds->paginate(),
            DocumentTypeEnum::Order => $this->orders->paginate(),
        };
    }

    /**
     * Registers the external document identifier
     */
    public function update(DocumentTypeEnum $type, UpdateDocumentReferencesData $data): JsonResponse
    {
        $result = match ($type) {
            DocumentTypeEnum::Payment => $this->payments->update($data),
            DocumentTypeEnum::Refund => $this->refunds->update($data),
            DocumentTypeEnum::Order => $this->orders->update($data),
        };

        return response()->json([
            'status' => $result ? 'ok' : 'failed',
        ], status: $result ? 200 : 404);
    }
}
