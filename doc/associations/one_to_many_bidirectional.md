[⌂ Home](../../README.md)
[▲ Previous: One to many: Unidirectional](one_to_many_unidirectional.md)
[▼ Next: Many to many](many_to_many.md)

### One to many: Bidirectional

**`src\Source.php`**

```php
<?php

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

**`src\Quote.php`**

```php
<?php

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

**Console**

```bash
php bin/doctrine orm:schema-tool:update --force
```

```
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
| quotes                |
| sources               |
+-----------------------+
2 rows in set (0,060 sec)
```

```sql
describe quotes;
```

```
+-----------+--------------+------+-----+---------+----------------+
| Field     | Type         | Null | Key | Default | Extra          |
+-----------+--------------+------+-----+---------+----------------+
| id        | int(11)      | NO   | PRI | NULL    | auto_increment |
| author    | varchar(255) | NO   |     | NULL    |                |
| content   | varchar(255) | NO   |     | NULL    |                |
| source_id | int(11)      | YES  | MUL | NULL    |                |
+-----------+--------------+------+-----+---------+----------------+
4 rows in set (0,015 sec)
```

```sql
describe sources;
```

```
+-------------------------+--------------+------+-----+---------+----------------+
| Field                   | Type         | Null | Key | Default | Extra          |
+-------------------------+--------------+------+-----+---------+----------------+
| id                      | int(11)      | NO   | PRI | NULL    | auto_increment |
| author                  | varchar(255) | NO   |     | NULL    |                |
| title                   | varchar(255) | NO   |     | NULL    |                |
| description             | varchar(255) | NO   |     | NULL    |                |
| originalPublicationDate | datetime     | NO   |     | NULL    |                |
+-------------------------+--------------+------+-----+---------+----------------+
5 rows in set (0,019 sec)
```

**`src\Source.php`**

```php
<?php

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

**`src\Quote.php`**

```php
<?php

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'quotes')]
class Quote
{
    // ...

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

**`php example/associations/one_to_many_bidirectional_create.php`**

```php
<?php
// one_to_many_bidirectional_create.php <title> <content>
require_once __DIR__ . "/../../bootstrap.php";

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

echo "Created Source with ID " . $source->getId() . "\n";
echo "Created Quote with ID " . $quote->getId() . "\n";

```

**Console**

```bash
php example/associations/one_to_many_bidirectional_create.php "De contemptu mundi" "Stat rosa pristina nomine, nomina nuda tenemus."
```

```
Created Source with ID 2
Created Quote with ID 4
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
3 rows in set (0,014 sec)
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
1 row in set (0,001 sec)
```

**`src\Source.php`**

```php
<?php

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

**`src\Quote.php`**

```php
<?php

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'quotes')]
class Quote
{
    // ...

    /**
     * @return Source
     */
    public function getSource()
    {
        return $this->source;
    }
}

```

**`example/associations/one_to_many_bidirectional_read.php`**

```php

```

```php
php example/associations/one_to_many_bidirectional_read.php quote 4
```
