[⌂ Home](../README.md)
[▲ Previous: Creating records](creating_records.md)
[▼ Next: Updating records](updating_records.md)

## Retrieving records

There must be defined appropriate accessors in the `Quote` class to make the possibility of reading `Quote` field values.

```php
<?php

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
    private ?string $author = null;
    #[ORM\Column(type: 'string')]
    private ?string $source = null;
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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $author
     *
     * @return void
     */
    public function setAuthor(string $author)
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $source
     *
     * @return void
     */
    public function setSource(string $source)
    {
        $this->source = $source;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }
}

```

### Retrieving all the entities

**`example/list_quotes.php`**

```php
<?php
// list_quotes.php

require_once __DIR__ . "/../bootstrap.php";

$quoteRepository = $entityManager->getRepository('Quote');
$quotes = $quoteRepository->findAll();

$listPattern = "✤ %s\n -- %s, \"%s\"\n\n";

foreach ($quotes as $quote) {
    echo sprintf(
        $listPattern,
        $quote->getContent(),
        $quote->getAuthor(),
        $quote->getSource()
    );
}

```

**Console**

```bash
php example/list_quotes.php
```

```
✤ I would always rather be happy than dignified.
 -- Charlotte Brontë, "Jane Eyre"

✤ Pain and suffering are always inevitable for a large intelligence and a deep heart.
 -- Fyodor Dostoevsky, "Crime and Punishment"

✤ Somewhere, something incredible is waiting to be known.
 -- Miguel de Cervantes, "Don Quixote"
```

### Retrieving a single entity

**`example/show_quote.php`**

```php
<?php
// show_query.php <id>

require_once __DIR__ . "/../bootstrap.php";

$id = $argv[1];

$quote = $entityManager->find('Quote', $id);

if ($quote === null) {
    echo ("No quote found.\n");
    exit(1);
}

$showPattern = "%s\n -- %s, \"%s\"\n";

echo sprintf(
    $showPattern,
    $quote->getContent(),
    $quote->getAuthor(),
    $quote->getSource()
);

```

**Console**

```bash
php example/show_quote.php 1
```

```
I would always rather be happy than dignified.
 -- Charlotte Brontë, "Jane Eyre"
```

```bash
php example/show_quote.php 2
```

```
Pain and suffering are always inevitable for a large intelligence and a deep heart.
 -- Fyodor Dostoevsky, "Crime and Punishment"
```

```bash
php example/show_quote.php 3
```

```
Somewhere, something incredible is waiting to be known.
 -- Miguel de Cervantes, "Don Quixote"
```

```bash
php example/show_quote.php 4
```

```
No quote found.
```
