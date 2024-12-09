[⌂ Home](../README.md)
[▲ Previous: Data definition](data_definition.md)
[▼ Next: Data query](data_query.md)

## Data manipulation

### Creating

**`create_quote.php`**

```php
<?php
// create_quote.php <content> <author> <source>

require_once "bootstrap.php";

$content = $argv[1];
$author = $argv[2];
$source = $argv[3];

$quote = new Quote();
$quote->setContent($content);
$quote->setAuthor($author);
$quote->setSource($source);

$entityManager->persist($quote);
$entityManager->flush();

echo "Created Quote with ID " . $quote->getId() . "\n";

```

**Console**

```bash
php create_quote.php "I would always rather be happy than dignified." "Charlotte Brontë" "Jane Eyre"
```

```
Created Quote with ID 1
```

```bash
php create_quote.php "Pain and suffering are always inevitable for a large intelligence and a deep heart." "Fyodor Dostoevsky" "Crime and Punishment"
```

```
Created Quote with ID 2
```

```bash
php create_quote.php "Somewhere, something incredible is waiting to be known." "Miguel de Cervantes" "Don Quixote"
```

```
Created Quote with ID 3
```

**Database**

```sql
select * from quotes;
```

```
+----+---------------------+----------------------+-------------------------------------------------------------------------------------+
| id | author              | source               | content                                                                             |
+----+---------------------+----------------------+-------------------------------------------------------------------------------------+
|  1 | Charlotte Brontë    | Jane Eyre            | I would always rather be happy than dignified.                                      |
|  2 | Fyodor Dostoevsky   | Crime and Punishment | Pain and suffering are always inevitable for a large intelligence and a deep heart. |
|  3 | Miguel de Cervantes | Don Quixote          | Somewhere, something incredible is waiting to be known.                             |
+----+---------------------+----------------------+-------------------------------------------------------------------------------------+
3 rows in set (0,004 sec)
```

### Updating

**`update_quote.php`**

```php
<?php
// update_quote.php <id> <content> <author> <source>

require_once "bootstrap.php";

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
php update_quote.php 2 "The strongest of all warriors are these two — Time and Patience." "Leo Tolstoy" "War and Peace"
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
