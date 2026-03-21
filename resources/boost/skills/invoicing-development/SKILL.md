---
name: invoicing-development
description: Build and extend the invoicing interface package, including adding document types, creating DTOs, implementing handlers, and working with the API.
---

# Invoicing Interface Development

## When to use this skill

Use this skill when:
- Adding a new document type to the invoicing interface
- Creating or modifying Data Transfer Objects (DTOs)
- Implementing the `DocumentInterface` contract
- Working with the invoicing API routes
- Writing tests for invoicing functionality

## Package Structure

```
src/
├── Invoicing.php                    # Main service (entry point)
├── InvoicingServiceProvider.php     # Package registration
├── Contracts/
│   └── DocumentInterface.php        # Contract for document handlers
├── Enums/
│   └── DocumentTypeEnum.php         # Document type routing enum
├── Http/Middleware/
│   └── Authenticate.php             # Bearer token auth
└── Data/                            # DTOs (Spatie Laravel Data)
    ├── CustomerData.php
    ├── OrderData.php
    ├── OrderPaymentData.php
    ├── PaymentData.php
    ├── PaymentProductData.php
    ├── RefundData.php
    └── UpdateDocumentReferencesData.php
```

## Adding a New Document Type

1. Add a case to `DocumentTypeEnum`:

```php
enum DocumentTypeEnum: string
{
    use EnumConcern;

    case Payment = 'payment';
    case Refund = 'refund';
    case Order = 'order';
    case Withdrawal = 'withdrawal';
    case NewType = 'new_type'; // Add here
}
```

2. Add a constructor parameter and match arms in `Invoicing.php`:

```php
public function __construct(
    protected Contracts\DocumentInterface $payments,
    protected Contracts\DocumentInterface $refunds,
    protected Contracts\DocumentInterface $orders,
    protected Contracts\DocumentInterface $withdrawals,
    protected Contracts\DocumentInterface $newTypes, // Add here
) {}
```

3. Create a corresponding DTO in `src/Data/` extending `Spatie\LaravelData\Data`.

4. Add tests covering pagination and update for the new type.

## Creating a DTO

DTOs extend `Spatie\LaravelData\Data` and use constructor property promotion:

```php
<?php

namespace Indigit\Invoicing\Data;

use Spatie\LaravelData\Data;

class ExampleData extends Data
{
    public function __construct(
        public string $reference_website,
        public float $amount,
        public ?string $optional_field = null,
    ) {}
}
```

For dates, use the `WithCast` attribute:

```php
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;

#[WithCast(DateTimeInterfaceCast::class)]
public ?Carbon $paid_at = null,
```

For collections of nested DTOs, use PHPDoc generics:

```php
/** @var Collection<int, PaymentProductData> */
public Collection $products,
```

## Implementing DocumentInterface

The consuming application must provide implementations:

```php
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;
use Indigit\Invoicing\Contracts\DocumentInterface;
use Indigit\Invoicing\Data\UpdateDocumentReferencesData;

class PaymentDocumentHandler implements DocumentInterface
{
    public function paginate(int $perPage): Paginator
    {
        return Payment::query()->simplePaginate($perPage);
    }

    /** @param Collection<int, UpdateDocumentReferencesData> $data */
    public function update(Collection $data): bool
    {
        // Update document references in your database
        $data->each(function (UpdateDocumentReferencesData $item) {
            Payment::where('id', $item->reference_website)
                ->update([
                    'financial_document_id' => $item->reference_financial_document,
                    'provider_id' => $item->reference_provider,
                    'document_label' => $item->document_label,
                    'document_link' => $item->document_link,
                ]);
        });

        return true;
    }
}
```

## Testing Patterns

Tests use Pest PHP with a `DocumentHandler` test double:

```php
use Illuminate\Pagination\Paginator;
use Indigit\Invoicing\Data\UpdateDocumentReferencesData;
use Indigit\Invoicing\Enums\DocumentTypeEnum;
use Indigit\Invoicing\Invoicing;
use Indigit\Invoicing\Tests\TestSupport\DocumentHandler;

beforeEach(function (): void {
    $this->handler = new DocumentHandler;
    $this->invoicing = new Invoicing(
        $this->handler, // payments
        $this->handler, // refunds
        $this->handler, // orders
        $this->handler, // withdrawals
    );
});

it('can paginate documents', function (): void {
    $this->handler->data = new Paginator(['doc1'], 10, 1);

    $result = $this->invoicing->paginate(DocumentTypeEnum::Payment);
    expect($result)->toBeInstanceOf(Paginator::class)
        ->and($result->count())->toBe(1);
});
```
