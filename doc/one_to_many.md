[⌂ Home](../../README.md)
[⬆ Up: Associations](README.md)
[▲ Previous: One to one](one_to_one.md)

### One to many

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
    #[ORM\Column(type: 'string')]
    private string $description;
    /**
     * @var Collection<int, Quote>
     */
    #[ORM\OneToMany(targetEntity: Quote::class, mappedBy: 'source')]
    private Collection $quotes;
    #[ORM\Column(type: 'datetime')]
    private ?DateTime $originalPublicationDate;
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
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\Column(type: 'string')]
    private ?string $author = null;
    /**
     * @var Source|null
     */
    #[ORM\ManyToOne(targetEntity: Source::class, inversedBy: 'quotes')]
    private ?Source $source = null;
    #[ORM\Column(type: 'string')]
    private string $content;

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
