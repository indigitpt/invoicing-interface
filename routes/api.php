<?php

use Illuminate\Support\Facades\Route;
use Indigit\Invoicing\Data\UpdateDocumentReferencesData;
use Indigit\Invoicing\Enums\DocumentTypeEnum;
use Indigit\Invoicing\Http\Middleware\Authenticate;
use Indigit\Invoicing\Invoicing;

Route::middleware(Authenticate::class)
    ->prefix('invoicing-interface/api')
    ->group(function () {
        Route::get('{type}', fn (Invoicing $service, DocumentTypeEnum $type) => $service->paginate($type));
        Route::put('{type}', fn (Invoicing $service, DocumentTypeEnum $type, UpdateDocumentReferencesData $data) => $service->update($type, $data));
    });
