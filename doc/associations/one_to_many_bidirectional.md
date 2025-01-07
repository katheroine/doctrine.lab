[⌂ Home](../../README.md)
[▲ Previous: One to one: Unidirectional](../associations/one_to_one_unidirectional.md)
[▼ Next: One to many: Unidirectional](../associations/one_to_many_unidirectional.md)

### One to many: Bidirectional

[**`src\Quote.php`**](../../entities/associations/one_to_many/unidirectional/Quote.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'quotes')]
class Quote
{
    // ...
    /**
     * @var Source|null
     */
    #[ORM\ManyToOne(targetEntity: Source::class, inversedBy: 'quotes')]
    private ?Source $source = null;

    // ...
}

```

[**`src\Source.php`**](../../entities/associations/one_to_many/unidirectional/Source.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'sources')]
class Source
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\Column(type: 'string')]
    private string $title;
    /**
     * @var Collection<int, Quote>
     */
    #[ORM\OneToMany(targetEntity: Quote::class, mappedBy: 'source')]
    private Collection $quotes;
}

```

**Console**

```bash
php bin/doctrine orm:schema-tool:update --force --dump-sql
```

```
CREATE TABLE sources (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id));
ALTER TABLE quotes ADD source_id INT DEFAULT NULL;
ALTER TABLE quotes ADD CONSTRAINT FK_A1B588C5953C1C61 FOREIGN KEY (source_id) REFERENCES sources (id);
CREATE INDEX IDX_A1B588C5953C1C61 ON quotes (source_id);

 Updating database schema...

     4 queries were executed


 [OK] Database schema updated successfully!



```

**Database**

```sql
show tables;
```

```
+-----------------------+
| Tables_in_doctrinelab |
+-----------------------+
| authors               |
| autopromotions        |
| personal_details      |
| quotes                |
| sources               |
+-----------------------+
5 rows in set (0,001 sec)
```

```sql
describe quotes;
```

```
+-----------+--------------+------+-----+---------+----------------+
| Field     | Type         | Null | Key | Default | Extra          |
+-----------+--------------+------+-----+---------+----------------+
| id        | int(11)      | NO   | PRI | NULL    | auto_increment |
| content   | varchar(255) | NO   |     | NULL    |                |
| source_id | int(11)      | YES  | MUL | NULL    |                |
+-----------+--------------+------+-----+---------+----------------+
3 rows in set (0,002 sec)
```

```sql
describe sources;
```

```
+-------+--------------+------+-----+---------+----------------+
| Field | Type         | Null | Key | Default | Extra          |
+-------+--------------+------+-----+---------+----------------+
| id    | int(11)      | NO   | PRI | NULL    | auto_increment |
| title | varchar(255) | NO   |     | NULL    |                |
+-------+--------------+------+-----+---------+----------------+
2 rows in set (0,002 sec)
```

[**`src\Quote.php`**](../../entities/associations/one_to_many/unidirectional/Quote.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'quotes')]
class Quote
{
    // ...

    /**
     * @param Source $source
     *
     * @return void
     */
    public function setSource(Source $source)
    {
        $this->source = $source;
    }
}

```

[**`src\Source.php`**](../../entities/associations/one_to_many/unidirectional/Source.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'sources')]
class Source
{
    // ...

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $title
     *
     * @return void
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }
}

```

[**`example/associations/one_to_many/bidirectional/create_quote_with_source.php`**](../../example/associations/one_to_many/bidirectional/create_quote_with_source.php)

```php
<?php
// create_quote_with_source.php <title> <content>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$title = $argv[1];
$content = $argv[2];

$source = new Source();
$source->setTitle($title);

$quote = new Quote();
$quote->setContent($content);
$quote->setSource($source);

$entityManager->persist($source);
$entityManager->persist($quote);
$entityManager->flush();

print("Created Quote with ID " . $quote->getId() . "\n");
print("Created Source with ID " . $source->getId() . "\n");

```

**Console**

```bash
php example/associations/one_to_many/bidirectional/create_quote_with_source.php "De contemptu mundi" "Stat rosa pristina nomine, nomina nuda tenemus."
```

```
Created Quote with ID 4
Created Source with ID 1
```

**Database**


```sql
select * from quotes;
```

```
+----+--------------------------------------------------------------------+-----------+
| id | content                                                            | source_id |
+----+--------------------------------------------------------------------+-----------+
|  2 | The strongest of all warriors are these two — Time and Patience.   |      NULL |
|  3 | Somewhere, something incredible is waiting to be known.            |      NULL |
|  4 | Stat rosa pristina nomine, nomina nuda tenemus.                    |         1 |
+----+--------------------------------------------------------------------+-----------+
3 rows in set (0,001 sec)
```

```sql
select * from sources;
```

```
+----+--------------------+
| id | title              |
+----+--------------------+
|  1 | De contemptu mundi |
+----+--------------------+
1 row in set (0,004 sec)
```

[**`src\Quote.php`**](../../entities/associations/one_to_many/unidirectional/Quote.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'quotes')]
class Quote
{
    // ...

    /**
     * @return Source
     */
    public function getSource(): Source
    {
        return $this->source;
    }
}

```

[**`src\Source.php`**](../../entities/associations/one_to_many/unidirectional/Source.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'sources')]
class Source
{
    // ...

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}

```

[**`example/associations/one_to_many/bidirectional/read_quote_with_source.php`**](../../example/associations/one_to_many/bidirectional/read_quote_with_source.php)

```php
<?php
// read_quote_with_source.php <id>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$id = $argv[1];

$quote = $entityManager->find('Quote', $id);

if ($quote === null) {
    print("No Quote found.\n");
    exit(1);
}

$showPattern = "%s\n-- \"%s\"\n";

printf(
    $showPattern,
    $quote->getContent(),
    $quote->getSource()?->getTitle()
);

```

**Console**

```bash
php example/associations/one_to_many/bidirectional/read_quote_with_source.php 4
```

```
Stat rosa pristina nomine, nomina nuda tenemus.
-- "De contemptu mundi"
```

[**`example/associations/one_to_one/unidirectional/read_source_with_quotes.php`**](../../example/associations/one_to_many/bidirectional/read_source_with_quotes.php.php)

```php
<?php
// read_source_with_quotes.php <id>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$id = $argv[1];

$source = $entityManager->find('Source', $id);

if ($source === null) {
    print("No Source found.\n");
    exit(1);
}

$quotes = $source->getQuotes();

$showPattern = "%s\n-- \"%s\"\n\n";

foreach($quotes as $quote) {
    printf(
        $showPattern,
        $quote->getContent(),
        $quote->getSource()?->getTitle()
    );
}

```

**Console**

```bash
php example/associations/one_to_many/bidirectional/read_source_with_quotes.php 1
```

```
Stat rosa pristina nomine, nomina nuda tenemus.
-- "De contemptu mundi"

```
