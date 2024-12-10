[⌂ Home](../README.md)
[▲ Previous: Retrieving records](retrieving_records.md)

## Updating records

**`update_quote.php`**

```php
<?php
// update_quote.php <id> <content> <author> <source>

require_once __DIR__ . "/../bootstrap.php";

$id = $argv[1];
$content = $argv[2];
$author = $argv[3];
$source = $argv[4];

$quote = $entityManager->find('Quote', $id);

if ($quote === null) {
    echo "Product $id does not exist.\n";
    exit(1);
}

$quote->setContent($content);
$quote->setAuthor($author);
$quote->setSource($source);

$entityManager->flush();

echo "Updated Quote with ID " . $id . "\n";

```

**Console**

```bash
php example/update_quote.php 2 "The strongest of all warriors are these two — Time and Patience." "Leo Tolstoy" "War and Peace"
```

**Database**

```sql
select * from quotes;
```

```
+----+---------------------+---------------+--------------------------------------------------------------------+
| id | author              | source        | content                                                            |
+----+---------------------+---------------+--------------------------------------------------------------------+
|  1 | Charlotte Brontë    | Jane Eyre     | I would always rather be happy than dignified.                     |
|  2 | Leo Tolstoy         | War and Peace | The strongest of all warriors are these two — Time and Patience.   |
|  3 | Miguel de Cervantes | Don Quixote   | Somewhere, something incredible is waiting to be known.            |
+----+---------------------+---------------+--------------------------------------------------------------------+
3 rows in set (0,001 sec)
```

