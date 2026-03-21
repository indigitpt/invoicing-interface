<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\Paginator;
use Indigit\Invoicing\Data\UpdateDocumentReferencesData;
use Indigit\Invoicing\Enums\DocumentTypeEnum;
use Indigit\Invoicing\Invoicing;
use Indigit\Invoicing\Tests\TestSupport\DocumentHandler;

beforeEach(function (): void {
    $this->paymentDocuments = new DocumentHandler;
    $this->refundDocuments = new DocumentHandler;
    $this->orderDocuments = new DocumentHandler;
    $this->withdrawalDocuments = new DocumentHandler;

    $this->invoicing = new Invoicing(
        $this->paymentDocuments,
        $this->refundDocuments,
        $this->orderDocuments,
        $this->withdrawalDocuments
    );
});

it('can paginate payments', function (): void {
    $this->paymentDocuments->data = new Paginator([], 10, 1);

    $result = $this->invoicing->paginate(DocumentTypeEnum::Payment);
    expect($result)->toBeInstanceOf(Paginator::class)
        ->and($result->count())->toBe(0);
});

it('can paginate refunds', function (): void {
    $this->refundDocuments->data = new Paginator(['refund1', 'refund2'], 10, 1);

    $result = $this->invoicing->paginate(DocumentTypeEnum::Refund);
    expect($result)->toBeInstanceOf(Paginator::class)
        ->and($result->count())->toBe(2)
        ->and($result->items())->toBe(['refund1', 'refund2']);
});

it('can paginate orders', function (): void {
    $this->orderDocuments->data = new Paginator(['order1', 'order2', 'order3'], 10, 1);

    $result = $this->invoicing->paginate(DocumentTypeEnum::Order);
    expect($result)->toBeInstanceOf(Paginator::class)
        ->and($result->count())->toBe(3)
        ->and($result->items())->toBe(['order1', 'order2', 'order3']);
});

it('can paginate withdrawals', function (): void {
    $this->withdrawalDocuments->data = new Paginator(['withdrawal1', 'withdrawal2', 'withdrawal3'], 10, 1);

    $result = $this->invoicing->paginate(DocumentTypeEnum::Withdrawal);
    expect($result)->toBeInstanceOf(Paginator::class)
        ->and($result->count())->toBe(3)
        ->and($result->items())->toBe(['withdrawal1', 'withdrawal2', 'withdrawal3']);
});

it('uses default perPage of 50', function (): void {
    $this->paymentDocuments->data = new Paginator([], 50, 1);

    $result = $this->invoicing->paginate(DocumentTypeEnum::Payment);
    expect($result)->toBeInstanceOf(Paginator::class)
        ->and($this->paymentDocuments->lastPerPage)->toBe(50);
});

it('uses custom perPage when provided', function (): void {
    $this->paymentDocuments->data = new Paginator([], 25, 1);

    $result = $this->invoicing->paginate(DocumentTypeEnum::Payment, 25);
    expect($result)->toBeInstanceOf(Paginator::class)
        ->and($this->paymentDocuments->lastPerPage)->toBe(25);
});

it('can update payment identifier', function (): void {
    $updateData = collect([new UpdateDocumentReferencesData('payment123', 'external456')]);
    $this->paymentDocuments->updateResult = true;

    $result = $this->invoicing->update(DocumentTypeEnum::Payment, $updateData);
    expect($result)->toBeInstanceOf(JsonResponse::class)
        ->and($result->getData()->status)->toBe('ok')
        ->and($result->getStatusCode())->toBe(200)
        ->and($this->paymentDocuments->lastUpdateData)->toBe($updateData);
});

it('can update refund identifier', function (): void {
    $updateData = collect([new UpdateDocumentReferencesData('refund789', 'external101')]);
    $this->refundDocuments->updateResult = true;

    $result = $this->invoicing->update(DocumentTypeEnum::Refund, $updateData);
    expect($result)->toBeInstanceOf(JsonResponse::class)
        ->and($result->getData()->status)->toBe('ok')
        ->and($result->getStatusCode())->toBe(200)
        ->and($this->refundDocuments->lastUpdateData)->toBe($updateData);
});

it('can update order identifier', function (): void {
    $updateData = collect([new UpdateDocumentReferencesData('order123', 'external789')]);
    $this->orderDocuments->updateResult = true;

    $result = $this->invoicing->update(DocumentTypeEnum::Order, $updateData);
    expect($result)->toBeInstanceOf(JsonResponse::class)
        ->and($result->getData()->status)->toBe('ok')
        ->and($result->getStatusCode())->toBe(200)
        ->and($this->orderDocuments->lastUpdateData)->toBe($updateData);
});

it('can update withdrawal identifier', function (): void {
    $updateData = collect([new UpdateDocumentReferencesData('withdrawal123', 'external789')]);
    $this->withdrawalDocuments->updateResult = true;

    $result = $this->invoicing->update(DocumentTypeEnum::Withdrawal, $updateData);
    expect($result)->toBeInstanceOf(JsonResponse::class)
        ->and($result->getData()->status)->toBe('ok')
        ->and($result->getStatusCode())->toBe(200)
        ->and($this->withdrawalDocuments->lastUpdateData)->toBe($updateData);
});

it('handles failed payment identifier update', function (): void {
    $updateData = collect([new UpdateDocumentReferencesData('payment555', 'external999')]);
    $this->paymentDocuments->updateResult = false;

    $result = $this->invoicing->update(DocumentTypeEnum::Payment, $updateData);
    expect($result)->toBeInstanceOf(JsonResponse::class)
        ->and($result->getData()->status)->toBe('failed')
        ->and($result->getStatusCode())->toBe(404);
});

it('handles failed refund identifier update', function (): void {
    $updateData = collect([new UpdateDocumentReferencesData('refund555', 'external999')]);
    $this->refundDocuments->updateResult = false;

    $result = $this->invoicing->update(DocumentTypeEnum::Refund, $updateData);
    expect($result)->toBeInstanceOf(JsonResponse::class)
        ->and($result->getData()->status)->toBe('failed')
        ->and($result->getStatusCode())->toBe(404);
});

it('handles failed order identifier update', function (): void {
    $updateData = collect([new UpdateDocumentReferencesData('order555', 'external999')]);
    $this->orderDocuments->updateResult = false;

    $result = $this->invoicing->update(DocumentTypeEnum::Order, $updateData);
    expect($result)->toBeInstanceOf(JsonResponse::class)
        ->and($result->getData()->status)->toBe('failed')
        ->and($result->getStatusCode())->toBe(404);
});

it('handles failed withdrawal identifier update', function (): void {
    $updateData = collect([new UpdateDocumentReferencesData('withdrawal555', 'external999')]);
    $this->withdrawalDocuments->updateResult = false;

    $result = $this->invoicing->update(DocumentTypeEnum::Withdrawal, $updateData);
    expect($result)->toBeInstanceOf(JsonResponse::class)
        ->and($result->getData()->status)->toBe('failed')
        ->and($result->getStatusCode())->toBe(404);
});
