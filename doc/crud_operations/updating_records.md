[⌂ Home](../../README.md)
[▲ Previous: Reading records](reading_records.md)
[▼ Next: Deleting records](deleting_records.md)

### Updating records

[**`example/crud_operations/update_quote.php`**](../../example/crud_operations/update_quote.php)

```php
<?php
// update_quote.php <id> <content>

declare(strict_types=1);

require_once __DIR__ . "/../../bootstrap.php";

$id = $argv[1];
$content = $argv[2];

$quote = $entityManager->find('Quote', $id);

if ($quote === null) {
    print("Quote $id does not exist.\n");
    exit(1);
}

$quote->setContent($content);

$entityManager->flush();

print("Updated Quote with ID " . $id . "\n");

```

**Console**

```bash
php example/crud_operations/update_quote.php 2 "The strongest of all warriors are these two — Time and Patience."
```

```
Updated Quote with ID 2
```

**Database**

```sql
select * from quotes;
```

```
+----+--------------------------------------------------------------------+
| id | content                                                            |
+----+--------------------------------------------------------------------+
|  1 | I would always rather be happy than dignified.                     |
|  2 | The strongest of all warriors are these two — Time and Patience.   |
|  3 | Somewhere, something incredible is waiting to be known.            |
+----+--------------------------------------------------------------------+
3 rows in set (0,001 sec)
```
