<?php

use Illuminate\Support\Facades\Route;
use Indigit\Invoicing\Data\UpdateDocumentReferencesData;
use Indigit\Invoicing\Enums\DocumentTypeEnum;
use Indigit\Invoicing\Http\Middleware\Authenticate;
use Indigit\Invoicing\Invoicing;

Route::middleware(Authenticate::class)
    ->prefix('invoicing-interface/api')
    ->group(function () {
        // Returns a paginator with the documents
        Route::get('{type}', fn (Invoicing $service, string $type) => $service->paginate(DocumentTypeEnum::from($type)))
            ->whereIn('type', DocumentTypeEnum::toValues());

        // Registers the external document identifier
        Route::put('{type}', fn (Invoicing $service, string $type, UpdateDocumentReferencesData $data) => $service->update(DocumentTypeEnum::from($type), $data))
            ->whereIn('type', DocumentTypeEnum::toValues());
    });
