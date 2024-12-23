[⌂ Home](../../README.md)
[▲ Previous: Managing schema](../managing_schema.md)
[▼ Next: Reading records](reading_records.md)

### Creating records

There must be defined appropriate accessors in the `Quote` class to make the possibility of defining `Quote` field values and eventually retrieving the ID of the newly created `quotes` record.

[**`src/Quote.php`**](../../entities/crud_operations/creating_records/Quote.php)

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
}

```

[**`example/crud_operations/create_quote.php`**](../../example/crud_operations/create_quote.php)

```php
<?php
// create_quote.php <content>

declare(strict_types=1);

require_once __DIR__ . "/../../bootstrap.php";

$content = $argv[1];

$quote = new Quote();
$quote->setContent($content);

$entityManager->persist($quote);
$entityManager->flush();

print("Created Quote with ID " . $quote->getId() . "\n");

```

**Console**

```bash
php example/crud_operations/create_quote.php "I would always rather be happy than dignified."
```

```
Created Quote with ID 1
```

```bash
php example/crud_operations/create_quote.php "Pain and suffering are always inevitable for a large intelligence and a deep heart."
```

```
Created Quote with ID 2
```

```bash
php example/crud_operations/create_quote.php "Somewhere, something incredible is waiting to be known."
```

```
Created Quote with ID 3
```

**Database**

```sql
select * from quotes;
```

```
+----+-------------------------------------------------------------------------------------+
| id | content                                                                             |
+----+-------------------------------------------------------------------------------------+
|  1 | I would always rather be happy than dignified.                                      |
|  2 | Pain and suffering are always inevitable for a large intelligence and a deep heart. |
|  3 | Somewhere, something incredible is waiting to be known.                             |
+----+-------------------------------------------------------------------------------------+
3 rows in set (0,053 sec)
```
