[⌂ Home](../../README.md)
[▲ Previous: One to one: Unidirectional](../associations/one_to_one_unidirectional.md)
[▼ Next: One to many](one_to_many.md)

### One to one: Unidirectional

**`src/AuthorAutopresentation.php`**

```php
<?php

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'author_autopresentations')]
class AuthorAutopresentation
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\Column(type: 'string')]
    private string $bio;
    /**
     * @var Author
     */
    #[ORM\OneToOne(targetEntity: Author::class, inversedBy: 'autopresentation')]
    private Author $author;
}

```

**`src\Author`**

```php
<?php

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'authors')]
class Author
{
    //...
    /**
     * @var AuthorAutopresentation
     */
    #[ORM\OneToOne(targetEntity: AuthorAutopresentation::class, mappedBy: 'author')]
    private ?AuthorAutopresentation $autopresentation = null;

    // ...
}

```

**Console**

```bash
php bin/doctrine orm:schema-tool:update --force --dump-sql
```

```
CREATE TABLE author_autopresentations (id INT AUTO_INCREMENT NOT NULL, bio VARCHAR(255) NOT NULL, author_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_D1828E57F675F31B (author_id), PRIMARY KEY(id));
ALTER TABLE author_autopresentations ADD CONSTRAINT FK_D1828E57F675F31B FOREIGN KEY (author_id) REFERENCES authors (id);

 Updating database schema...

     2 queries were executed


 [OK] Database schema updated successfully!


```

**Database**

```sql
show tables;
```

```
+--------------------------+
| Tables_in_doctrinelab    |
+--------------------------+
| author_autopresentations |
| authors                  |
| personal_details         |
| quotes                   |
+--------------------------+
4 rows in set (0,001 sec)
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
describe author_autopresentations;
```

```
+-----------+--------------+------+-----+---------+----------------+
| Field     | Type         | Null | Key | Default | Extra          |
+-----------+--------------+------+-----+---------+----------------+
| id        | int(11)      | NO   | PRI | NULL    | auto_increment |
| bio       | varchar(255) | NO   |     | NULL    |                |
| author_id | int(11)      | YES  | UNI | NULL    |                |
+-----------+--------------+------+-----+---------+----------------+
3 rows in set (0,002 sec)

```

**`src/AuthorAutopresentation.php`**

```php
<?php

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'author_autopresentations')]
class AuthorAutopresentation
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

**`php example/associations/one_to_one_bidirectional_create.php`**

```php
<?php
// one_to_one_bidirectional_create.php <penname> <first_name> <last_name> <bio>

require_once __DIR__ . "/../../bootstrap.php";

$penname = $argv[1];
$firstName = $argv[2];
$lastName = $argv[3];
$bio = $argv[4];

$personalDetails = new PersonalDetails();
$personalDetails->setFirstName($firstName);
$personalDetails->setLastName($lastName);

$author = new Author();
$author->setPenname($penname);
$author->setPersonalDetails($personalDetails);

$autopresentation = new AuthorAutopresentation();
$autopresentation->setBio($bio);
$autopresentation->setAuthor($author);

$entityManager->persist($personalDetails);
$entityManager->persist($author);
$entityManager->persist($autopresentation);
$entityManager->flush();

echo "Created PersonalDetails with ID " . $personalDetails->getId() . "\n";
echo "Created Author with ID " . $author->getId() . "\n";
echo "Created AuthorAutopresentation with ID " . $autopresentation->getId() . "\n";

```

**Console**

```bash
php example/associations/one_to_one_bidirectional_create.php "Geek Duck" "Jasmine" "Argenta" "I am a compulsive tutorial creator."
```

```
Created PersonalDetails with ID 2
Created Author with ID 2
Created AuthorAutopresentation with ID 1
```

**Database**

```sql
select * from personal_details;
```

```
+----+------------+-----------+
| id | first_name | last_name |
+----+------------+-----------+
|  1 | Aleksander | Głowacki  |
|  2 | Jasmine    | Argenta   |
+----+------------+-----------+
2 rows in set (0,004 sec)
```

```sql
select * from authors;
```

```
+----+----------------+---------------------+
| id | penname        | personal_details_id |
+----+----------------+---------------------+
|  1 | Bolesław Prus  |                   1 |
|  2 | Geek Duck      |                   2 |
|  3 | Nerdine        |                   3 |
+----+----------------+---------------------+
3 rows in set (0,001 sec)
```

```sql
select * from author_autopresentations;
```

```
+----+----------------------------------------+-----------+
| id | bio                                    | author_id |
+----+----------------------------------------+-----------+
|  1 | I am a compulsive tutorial creator.    |         3 |
+----+----------------------------------------+-----------+
4 rows in set (0,000 sec)
```
