[⌂ Home](../README.md)
[▲ Previous: Updating records](updating_records.md)

## Deleting records

**`delete_quote.php`**

```php
<?php
// delete_quote.php <id>

require_once __DIR__ . "/../bootstrap.php";

$id = $argv[1];

$quote = $entityManager->find('Quote', $id);

if ($quote === null) {
    echo "Quote $id does not exist.\n";
    exit(1);
}

$entityManager->remove($quote);
$entityManager->flush();

echo "Deleted Quote with ID " . $id . "\n";

```

**Console**

```bash
php example/delete_quote.php 1
```

**Database**

```sql
select * from quotes;
```

```
+----+---------------------+---------------+--------------------------------------------------------------------+
| id | author              | source        | content                                                            |
+----+---------------------+---------------+--------------------------------------------------------------------+
|  2 | Leo Tolstoy         | War and Peace | The strongest of all warriors are these two — Time and Patience.   |
|  3 | Miguel de Cervantes | Don Quixote   | Somewhere, something incredible is waiting to be known.            |
+----+---------------------+---------------+--------------------------------------------------------------------+
2 rows in set (0,001 sec)
```
