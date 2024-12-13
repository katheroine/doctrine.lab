[⌂ Home](../README.md)
[▲ Previous: Creating table](creating_table.md)
[▼ Next: Reading records](reading_records.md)

## Creating records

There must be defined appropriate accessors in the `Quote` class to make the possibility of defining `Quote` field values and eventually retrieving the ID of the newly created `quotes` record.

**`src/Quote.php`**

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
     * @param string $author
     *
     * @return void
     */
    public function setAuthor(string $author)
    {
        $this->author = $author;
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
}

```

**`example/create_quote.php`**

```php
<?php
// create_quote.php <content> <author> <source>

require_once __DIR__ . "/../bootstrap.php";

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
php example/create_quote.php "I would always rather be happy than dignified." "Charlotte Brontë" "Jane Eyre"
```

```
Created Quote with ID 1
```

```bash
php example/create_quote.php "Pain and suffering are always inevitable for a large intelligence and a deep heart." "Fyodor Dostoevsky" "Crime and Punishment"
```

```
Created Quote with ID 2
```

```bash
php example/create_quote.php "Somewhere, something incredible is waiting to be known." "Miguel de Cervantes" "Don Quixote"
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
