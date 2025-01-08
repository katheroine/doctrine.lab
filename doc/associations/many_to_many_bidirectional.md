[⌂ Home](../../README.md)
[▲ Previous: One to many: Unidirectional](../associations/one_to_many_unidirectional.md)

### Many to many: Bidirectional

[**`src/Source`**](../../entities/associations/many_to_many/bidirectional/Source.php)

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
     * @var Collection<int, Author>
     */
    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'sources')]
    #[ORM\JoinTable(name: 'sources_authors')]
     #[ORM\JoinColumn(name: 'source_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'author_id', referencedColumnName: 'id')]
    private Collection $authors;

    // ...
}

```

[**`src/Author.php`**](../../entities/associations/many_to_many/bidirectional/Author.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'authors')]
class Author
{
    // ...
    /**
     * @var Collection<int, Source>
     */
    #[ORM\ManyToMany(targetEntity: Source::class, mappedBy: 'authors')]
    private Collection $sources;

    // ...
}

```

There is **many-to-many** association between the `Source` and `Author` entities. One `Source` can have *many* `Authors` and one `Author` can have *many* `Sources`.

**Console**

```bash
php bin/doctrine orm:schema-tool:update --force --dump-sql
```

```
CREATE TABLE sources_authors (source_id INT NOT NULL, author_id INT NOT NULL, INDEX IDX_B50FD2E953C1C61 (source_id), INDEX IDX_B50FD2EF675F31B (author_id), PRIMARY KEY(source_id, author_id));
ALTER TABLE sources_authors ADD CONSTRAINT FK_B50FD2E953C1C61 FOREIGN KEY (source_id) REFERENCES sources (id) ON DELETE CASCADE;
ALTER TABLE sources_authors ADD CONSTRAINT FK_B50FD2EF675F31B FOREIGN KEY (author_id) REFERENCES authors (id) ON DELETE CASCADE;

 Updating database schema...

     3 queries were executed


 [OK] Database schema updated successfully!


```

**Database**

```sql
show tables;
```

```
+-------------------------+
| Tables_in_doctrinelab   |
+-------------------------+
| authors                 |
| autopromotions          |
| emails                  |
| personal_details        |
| personal_details_emails |
| quotes                  |
| sources                 |
| sources_authors         |
+-------------------------+
8 rows in set (0,001 sec)
```

There is an associative `sources_authors` table.

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

```sql
describe authors;
```

```
+---------------------+--------------+------+-----+---------+----------------+
| Field               | Type         | Null | Key | Default | Extra          |
+---------------------+--------------+------+-----+---------+----------------+
| id                  | int(11)      | NO   | PRI | NULL    | auto_increment |
| penname             | varchar(255) | NO   |     | NULL    |                |
| personal_details_id | int(11)      | YES  | UNI | NULL    |                |
+---------------------+--------------+------+-----+---------+----------------+
3 rows in set (0,002 sec)
```

```sql
describe sources_authors;
```

```
+-----------+---------+------+-----+---------+-------+
| Field     | Type    | Null | Key | Default | Extra |
+-----------+---------+------+-----+---------+-------+
| author_id | int(11) | NO   | PRI | NULL    |       |
| source_id | int(11) | NO   | PRI | NULL    |       |
+-----------+---------+------+-----+---------+-------+
2 rows in set (0,003 sec)
```

[**`src/Source`**](../../entities/associations/many_to_many/bidirectional/Source.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\Table(name: 'sources')]
class Source
{
    // ...

    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }

    // ...

    /**
     * @param Author $author
     *
     * @return void
     */
    public function addAuthor(Author $author)
    {
        $this->authors->add($author);
    }
}

```

[**`example/associations/many_to_many/bidirectional/create_source_with_author.php`**](../../example/associations/many_to_many/bidirectional/create_source_with_author.php)

```php
<?php
// create_source_with_author.php <title> <penname>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$title = $argv[1];
$penname = $argv[2];

$author = new Author();
$author->setPenname($penname);

$source = new Source();
$source->setTitle($title);
$source->addAuthor($author);

$entityManager->persist($author);
$entityManager->persist($source);
$entityManager->flush();

print("Created Author with ID " . $author->getId() . "\n");
print("Created Source with ID " . $source->getId() . "\n");

```

**Console**

```bash
php example/associations/many_to_many/bidirectional/create_source_with_author.php "Il pendolo di Foucault" "Umberto Eco"
```

```
Created Author with ID 3
Created Source with ID 2
```

**Database**

```sql
select * from sources;
```

```
+----+------------------------+
| id | title                  |
+----+------------------------+
|  1 | De contemptu mundi     |
|  2 | Il pendolo di Foucault |
+----+------------------------+
2 rows in set (0,001 sec)
```

```sql
select * from authors;
```

```
+----+----------------+---------------------+
| id | penname        | personal_details_id |
+----+----------------+---------------------+
|  1 | Anne Maroon    |                NULL |
|  2 | Bolesław Prus  |                   1 |
|  3 | Umberto Eco    |                NULL |
+----+----------------+---------------------+
3 rows in set (0,001 sec)
```

```sql
select * from sources_authors;
```

```
+-----------+-----------+
| source_id | author_id |
+-----------+-----------+
|         2 |         3 |
+-----------+-----------+
1 row in set (0,001 sec)
```

[**`src/Source`**](../../entities/associations/many_to_many/bidirectional/Source.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\Table(name: 'sources')]
class Source
{
    // ...

    /**
     * @return ArrayCollection
     */
    public function getAuthors()
    {
        return $this->authors;
    }
}

```

[**`example/associations/many_to_many/bidirectional/read_source_with_authors.php`**](../../example/associations/many_to_many/bidirectional/read_source_with_authors.php)


```php
<?php
// read_source_with_authors.php <id>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$id = $argv[1];

$source = $entityManager->find('Source', $id);

if ($source === null) {
    print("No Source found.\n");
    exit(1);
}

$showPattern = "\"%s\"\n";

printf(
    $showPattern,
    $source->getTitle()
);

$authors = $source->getAuthors();

$showPattern = "✤ %s\n";

foreach($authors as $author) {
    printf(
        $showPattern,
        $author->getPenname()
    );
}

```

**Console**

```bash
php example/associations/many_to_many/bidirectional/read_source_with_authors.php 2
```

```
"Il pendolo di Foucault"
✤ Umberto Eco
```
