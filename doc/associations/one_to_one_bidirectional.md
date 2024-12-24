[⌂ Home](../../README.md)
[▲ Previous: One to one: Unidirectional](../associations/one_to_one_unidirectional.md)
[▼ Next: One to many: Unidirectional](one_to_many_unidirectional.md)

### One to one: Unidirectional

[**`src\Author`**](../../entities/associations/one_to_one/bidirectional/Author.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

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
     * @var Autopromotion
     */
    #[ORM\OneToOne(targetEntity: Autopromotion::class, mappedBy: 'author')]
    private ?Autopromotion $autopromotion = null;
}

```

[**`src/Autopromotion.php`**](../../entities/associations/one_to_one/bidirectional/Autopromotion.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'autopromotions')]
class Autopromotion
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $bio = null;
    /**
     * @var Author
     */
    #[ORM\OneToOne(targetEntity: Author::class, inversedBy: 'autopromotion')]
    #[ORM\JoinColumn(name: "author_id", referencedColumnName: "id", nullable: false)]
    private Author $author;
}

```

**Console**

```bash
php bin/doctrine orm:schema-tool:update --force --dump-sql
```

```
CREATE TABLE autopromotions (id INT AUTO_INCREMENT NOT NULL, bio VARCHAR(255) DEFAULT NULL, author_id INT NOT NULL, UNIQUE INDEX UNIQ_8A435838F675F31B (author_id), PRIMARY KEY(id));
CREATE TABLE authors (id INT AUTO_INCREMENT NOT NULL, penname VARCHAR(255) NOT NULL, PRIMARY KEY(id));
ALTER TABLE autopromotions ADD CONSTRAINT FK_8A435838F675F31B FOREIGN KEY (author_id) REFERENCES authors (id);

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
| autopromotions        |
| quotes                |
+-----------------------+
3 rows in set (0,001 sec)
```

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
2 rows in set (0,002 sec)
```


```sql
describe autopromotions;
```

```
+-----------+--------------+------+-----+---------+----------------+
| Field     | Type         | Null | Key | Default | Extra          |
+-----------+--------------+------+-----+---------+----------------+
| id        | int(11)      | NO   | PRI | NULL    | auto_increment |
| bio       | varchar(255) | YES  |     | NULL    |                |
| author_id | int(11)      | NO   | UNI | NULL    |                |
+-----------+--------------+------+-----+---------+----------------+
3 rows in set (0,003 sec)
```

[**`src\Author`**](../../entities/associations/one_to_one/bidirectional/Author.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'authors')]
class Author
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
     * @param string $penname
     *
     * @return void
     */
    public function setPenname(string $penname)
    {
        $this->penname = $penname;
    }
}

```

[**`src/Autopromotion.php`**](../../entities/associations/one_to_one/bidirectional/Autopromotion.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'autopromotions')]
class Autopromotion
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
     * @param string $bio
     *
     * @return void
     */
    public function setBio(string $bio)
    {
        $this->bio = $bio;
    }

    /**
     * @param Author $author
     *
     * @return void
     */
    public function setAuthor(Author $author)
    {
        $this->author = $author;
    }
}

```

[**`example/associations/one_to_one/bidirectional/create_author_with_autopromotion.php`**](../../example/associations/one_to_one/bidirectional/create_author_with_autopresentation.php)

```php
<?php
<?php
// create_author_with_autopromotion.php <penname> <bio>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$penname = $argv[1];
$bio = $argv[2];

$author = new Author();
$author->setPenname($penname);

$autopromotion = new Autopromotion();
$autopromotion->setBio($bio);
$autopromotion->setAuthor($author);

$entityManager->persist($author);
$entityManager->persist($autopromotion);
$entityManager->flush();

print("Created Author with ID " . $author->getId() . "\n");
print("Created Autopromotion with ID " . $autopromotion->getId() . "\n");

```

**Console**

```bash
php example/associations/one_to_one/bidirectional/create_author_with_autopromotion.php "Anne Maroon" "Romantic gardens of words."
```

```
Created Author with ID 1
Created Autopromotion with ID 1
```

**Database**

```sql
select * from authors;
```

```
+----+-------------+
| id | penname     |
+----+-------------+
|  1 | Anne Maroon |
+----+-------------+
1 row in set (0,017 sec)
```

```sql
select * from autopromotions;
```

```
+----+----------------------------+-----------+
| id | bio                        | author_id |
+----+----------------------------+-----------+
|  1 | Romantic gardens of words. |         1 |
+----+----------------------------+-----------+
1 row in set (0,000 sec)
```

[**`src\Author`**](../../entities/associations/one_to_one/bidirectional/Author.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'authors')]
class Author
{
    // ...

    /**
     * @return string
     */
    public function getPenname(): string
    {
        return $this->penname;
    }

    /**
     * @return Autopromotion
     */
    public function getAutopromotion(): Autopromotion
    {
        return $this->autopromotion;
    }
}

```

[**`src/Autopromotion.php`**](../../entities/associations/one_to_one/bidirectional/Autopromotion.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'autopromotions')]
class Autopromotion
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $bio = null;
    /**
     * @var Author
     */
    #[ORM\OneToOne(targetEntity: Author::class, inversedBy: 'autopromotion')]
    #[ORM\JoinColumn(name: "author_id", referencedColumnName: "id", nullable: false)]
    private Author $author;

    // ...

    /**
     * @return string
     */
    public function getBio()
    {
        return $this->bio;
    }

    // ...
}

```

[**`example/associations/one_to_one/bidirectional/read_author_with_autopromotion.php`**](../../example/associations/one_to_one/bidirectional/read_author_with_autopresentation.php)

```php
<?php
// read_author_with_autopromotion.php <id>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$id = $argv[1];

$author = $entityManager->find('Author', $id);

if ($author === null) {
    print("No Author found.\n");
    exit(1);
}

$showPattern = "%s\n%s\n";

printf(
    $showPattern,
    $author->getPenname(),
    $author->getAutopromotion()?->getBio()
);

```

**Console**

```bash
php example/associations/one_to_one/bidirectional/read_author_with_autopromotion.php 1
```

```
Anne Maroon
Romantic gardens of words.
```

[**`example/associations/one_to_one/bidirectional/read_autopromotion_with_author.php`**](../../example/associations/one_to_one/bidirectional/read_autopromotion_with_author.php)

```php
<?php
// read_autopromotion_with_author.php <id>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$id = $argv[1];

$autopromotion = $entityManager->find('Autopromotion', $id);

if ($autopromotion === null) {
    print("No Autopromotion found.\n");
    exit(1);
}

$showPattern = "%s\n%s\n";

printf(
    $showPattern,
    $autopromotion->getAuthor()->getPenname(),
    $autopromotion->getBio()
);
```

**Console**

```bash
php example/associations/one_to_one/bidirectional/read_autopromotion_with_author.php 1
```

```
Anne Maroon
Romantic gardens of words.
```
