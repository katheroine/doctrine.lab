[⌂ Home](../../README.md)
[▲ Previous: Creating records](creating_records.md)
[▼ Next: Updating records](updating_records.md)

### Reading records

There must be defined appropriate accessors in the `Quote` class to make the possibility of reading `Quote` field values.

[**`src/Quote.php`**](../../entities/crud_operations/reading_records/Quote.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'quotes')]
class Quote
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\Column(type: 'string')]
    private string $content;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $content
     *
     * @return void
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}

```

#### Reading all the entities

[**`example/crud_operations/list_quotes.php`**](../../example/crud_operations/list_quotes.php)

```php
<?php
// list_quotes.php
declare(strict_types=1);


require_once __DIR__ . "/../../bootstrap.php";

$quoteRepository = $entityManager->getRepository('Quote');
$quotes = $quoteRepository->findAll();

$listPattern = "✤ \"%s\"\n\n";

foreach ($quotes as $quote) {
    printf(
        $listPattern,
        $quote->getContent()
    );
}

```

**Console**

```bash
php example/crud_operations/list_quotes.php
```

```
✤ "I would always rather be happy than dignified."

✤ "Pain and suffering are always inevitable for a large intelligence and a deep heart."

✤ "Somewhere, something incredible is waiting to be known."

```

#### Reading a single entity

[**`example/crud_operations/show_quote.php`**](../../example/crud_operations/show_quote.php)

```php
<?php
// show_query.php <id>

declare(strict_types=1);

require_once __DIR__ . "/../../bootstrap.php";

$id = $argv[1];

$quote = $entityManager->find('Quote', $id);

if ($quote === null) {
    print("No Quote found.\n");
    exit(1);
}

$showPattern = "\"%s\"\n";

printf(
    $showPattern,
    $quote->getContent()
);

```

**Console**

```bash
php example/crud_operations/show_quote.php 1
```

```
"I would always rather be happy than dignified."
```

```bash
php example/crud_operations/show_quote.php 2
```

```
"Pain and suffering are always inevitable for a large intelligence and a deep heart."
```

```bash
php example/crud_operations/show_quote.php 3
```

```
"Somewhere, something incredible is waiting to be known."
```

```bash
php example/crud_operations/show_quote.php 4
```

```
No Quote found.
```
