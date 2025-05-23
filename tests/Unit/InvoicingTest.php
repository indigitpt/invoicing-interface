<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\Paginator;
use Indigit\Invoicing\Data\UpdateDocumentReferencesData;
use Indigit\Invoicing\Enums\DocumentTypeEnum;
use Indigit\Invoicing\Invoicing;
use Indigit\Invoicing\Tests\TestSupport\DocumentHandler;

beforeEach(function () {
    $this->paymentDocuments = new DocumentHandler;
    $this->invoiceDocuments = new DocumentHandler;
    $this->refundDocuments = new DocumentHandler;
    $this->withdrawalDocuments = new DocumentHandler;

    $this->invoicing = new Invoicing(
        $this->paymentDocuments,
        $this->refundDocuments,
        $this->invoiceDocuments,
        $this->withdrawalDocuments
    );
});

it('can paginate payments', function () {
    $this->paymentDocuments->data = new Paginator([], 10, 1);

    $result = $this->invoicing->paginate(DocumentTypeEnum::Payment);
    expect($result)->toBeInstanceOf(Paginator::class)
        ->and($result->count())->toBe(0);
});

it('can paginate refunds', function () {
    $this->refundDocuments->data = new Paginator(['refund1', 'refund2'], 10, 1);

    $result = $this->invoicing->paginate(DocumentTypeEnum::Refund);
    expect($result)->toBeInstanceOf(Paginator::class)
        ->and($result->count())->toBe(2)
        ->and($result->items())->toBe(['refund1', 'refund2']);
});

it('can paginate orders', function () {
    $this->invoiceDocuments->data = new Paginator(['order1', 'order2', 'order3'], 10, 1);

    $result = $this->invoicing->paginate(DocumentTypeEnum::Order);
    expect($result)->toBeInstanceOf(Paginator::class)
        ->and($result->count())->toBe(3)
        ->and($result->items())->toBe(['order1', 'order2', 'order3']);
});

it('can paginate withdrawals', function () {
    $this->withdrawalDocuments->data = new Paginator(['withdrawal1', 'withdrawal2', 'withdrawal3'], 10, 1);

    $result = $this->invoicing->paginate(DocumentTypeEnum::Withdrawal);
    expect($result)->toBeInstanceOf(Paginator::class)
        ->and($result->count())->toBe(3)
        ->and($result->items())->toBe(['withdrawal1', 'withdrawal2', 'withdrawal3']);
});

it('can update payment identifier', function () {
    $updateData = collect([new UpdateDocumentReferencesData('payment123', 'external456')]);
    $this->paymentDocuments->updateResult = true;

    $result = $this->invoicing->update(DocumentTypeEnum::Payment, $updateData);
    expect($result)->toBeInstanceOf(JsonResponse::class)
        ->and($result->getData()->status)->toBe('ok');
});

it('can update refund identifier', function () {
    $updateData = collect([new UpdateDocumentReferencesData('refund789', 'external101')]);
    $this->refundDocuments->updateResult = true;

    $result = $this->invoicing->update(DocumentTypeEnum::Refund, $updateData);
    expect($result)->toBeInstanceOf(JsonResponse::class)
        ->and($result->getData()->status)->toBe('ok');
});

it('handles failed invoice identifier update', function () {
    $updateData = collect([new UpdateDocumentReferencesData('invoice555', 'external999')]);
    $this->invoiceDocuments->updateResult = false;

    $result = $this->invoicing->update(DocumentTypeEnum::Order, $updateData);
    expect($result)->toBeInstanceOf(JsonResponse::class)
        ->and($result->getData()->status)->toBe('failed');
});

it('handles failed withdrawal identifier update', function () {
    $updateData = collect([new UpdateDocumentReferencesData('withdrawal555', 'external999')]);
    $this->invoiceDocuments->updateResult = false;

    $result = $this->invoicing->update(DocumentTypeEnum::Withdrawal, $updateData);
    expect($result)->toBeInstanceOf(JsonResponse::class)
        ->and($result->getData()->status)->toBe('failed');
});
