[⌂ Home](../README.md)
[▲ Previous: Data manipulation](data_manipulation.md)

## Data query

### Querying for all the entities

**`list_quotes.php`**

```php
<?php
// list_quotes.php

require_once "bootstrap.php";

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
php list_quotes.php
```

```
✤ I would always rather be happy than dignified.
 -- Charlotte Brontë, "Jane Eyre"

✤ Pain and suffering are always inevitable for a large intelligence and a deep heart.
 -- Fyodor Dostoevsky, "Crime and Punishment"

✤ Somewhere, something incredible is waiting to be known.
 -- Miguel de Cervantes, "Don Quixote"
```
