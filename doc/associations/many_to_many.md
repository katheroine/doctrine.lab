[⌂ Home](../../README.md)
[▲ Previous: One to many](one_to_many.md)

### Many to many

**`src\Author.php`**

```php
<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'authors')]
class Author
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\Column(type: 'string')]
    private string $penname;
    /**
     * @var Collection<int, Product>
     */
    #[ORM\ManyToMany(targetEntity: Source::class, mappedBy: 'authors')]
    private Collection $sources;
}

```

**`src\Source`**

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
    #[ORM\Column(type: 'datetime')]
    private ?DateTime $originalPublicationDate;
    /**
     * @var Collection<int, Product>
     */
    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'sources')]
    private Collection $authors;
}

```

There is **many-to-many** association between the `Source` and `Author` entities. One `Source` can have *many* `Authors` and one `Author` can have *many* `Sources`.

**Console**

```bash
php bin/doctrine orm:schema-tool:update --force
```

```
 Updating database schema...

     3 queries were executed


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
| quotes                |
| source_author         |
| sources               |
+-----------------------+
4 rows in set (0,001 sec)
```

There is an associative `source_author` table.

```sql
describe authors;
```

```
+---------+--------------+------+-----+---------+----------------+
| Field   | Type         | Null | Key | Default | Extra          |
+---------+--------------+------+-----+---------+----------------+
| id      | int(11)      | NO   | PRI | NULL    | auto_increment |
| penname | varchar(255) | NO   |     | NULL    |                |
+---------+--------------+------+-----+---------+----------------+
2 rows in set (0,009 sec)
```

```sql
describe sources;
```

```
+-------------------------+--------------+------+-----+---------+----------------+
| Field                   | Type         | Null | Key | Default | Extra          |
+-------------------------+--------------+------+-----+---------+----------------+
| id                      | int(11)      | NO   | PRI | NULL    | auto_increment |
| title                   | varchar(255) | NO   |     | NULL    |                |
| description             | varchar(255) | NO   |     | NULL    |                |
| originalPublicationDate | datetime     | NO   |     | NULL    |                |
+-------------------------+--------------+------+-----+---------+----------------+
4 rows in set (0,007 sec)
```

```sql
describe source_author;
```

```
+-----------+---------+------+-----+---------+-------+
| Field     | Type    | Null | Key | Default | Extra |
+-----------+---------+------+-----+---------+-------+
| source_id | int(11) | NO   | PRI | NULL    |       |
| author_id | int(11) | NO   | PRI | NULL    |       |
+-----------+---------+------+-----+---------+-------+
2 rows in set (0,006 sec)
```
