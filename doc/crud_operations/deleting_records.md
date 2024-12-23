[⌂ Home](../../README.md)
[▲ Previous: Updating records](updating_records.md)
[▼ Next: One to one: Unidirectional](../associations/one_to_one_unidirectional.md)

### Deleting records

[**`example/crud_operations/delete_quote.php`**](../../example/crud_operations/delete_quote.php)

```php
<?php
// delete_quote.php <id>

declare(strict_types=1);

require_once __DIR__ . "/../../bootstrap.php";

$id = $argv[1];

$quote = $entityManager->find('Quote', $id);

if ($quote === null) {
    print("Quote $id does not exist.\n");
    exit(1);
}

$entityManager->remove($quote);
$entityManager->flush();

print("Deleted Quote with ID " . $id . "\n");

```

**Console**

```bash
php example/crud_operations/delete_quote.php 1
```

```
Deleted Quote with ID 1
```

**Database**

```sql
select * from quotes;
```

```
+----+--------------------------------------------------------------------+
| id | content                                                            |
+----+--------------------------------------------------------------------+
|  2 | The strongest of all warriors are these two — Time and Patience.   |
|  3 | Somewhere, something incredible is waiting to be known.            |
+----+--------------------------------------------------------------------+
2 rows in set (0,001 sec)
```
