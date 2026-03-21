<?php

use Illuminate\Pagination\Paginator;
use Indigit\Invoicing\Tests\TestSupport\DocumentHandler;

beforeEach(function (): void {
    $handler = new DocumentHandler;
    $handler->data = new Paginator([], 50, 1);
    $handler->updateResult = true;

    $this->app->when(\Indigit\Invoicing\Invoicing::class)
        ->needs(\Indigit\Invoicing\Contracts\DocumentInterface::class)
        ->give(fn () => $handler);
});

it('returns 401 when no api key is configured', function (): void {
    config()->set('invoicing.api-key', null);

    $this->getJson('/invoicing-interface/api/payment')
        ->assertStatus(401);
});

it('returns 403 when bearer token is invalid', function (): void {
    config()->set('invoicing.api-key', 'valid-key');

    $this->getJson('/invoicing-interface/api/payment', [
        'Authorization' => 'Bearer wrong-key',
    ])->assertStatus(403);
});

it('returns 403 when no bearer token is provided', function (): void {
    config()->set('invoicing.api-key', 'valid-key');

    $this->getJson('/invoicing-interface/api/payment')
        ->assertStatus(403);
});

it('allows access with valid bearer token', function (): void {
    config()->set('invoicing.api-key', 'valid-key');

    $this->getJson('/invoicing-interface/api/payment', [
        'Authorization' => 'Bearer valid-key',
    ])->assertStatus(200);
});

it('returns 404 for invalid document type', function (): void {
    config()->set('invoicing.api-key', 'valid-key');

    $this->getJson('/invoicing-interface/api/invalid', [
        'Authorization' => 'Bearer valid-key',
    ])->assertStatus(404);
});
