[⌂ Home](../../README.md)
[▲ Previous: One to one: Unidirectional](../associations/one_to_one_unidirectional.md)
[▼ Next: One to many: Bidirectional](one_to_many_bidirectional.md)

### One to one: Unidirectional

[**`src\Author.php`**](../../entities/associations/one_to_one/unidirectional/Author.php)

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
    // ...
    /**
     * @var PersonalDetails
     */
    #[ORM\OneToOne(targetEntity: PersonalDetails::class)]
    #[ORM\JoinColumn(name: 'personal_details_id', referencedColumnName: 'id')]
    private ?PersonalDetails $personalDetails;

    // ...
}

```

[**`src/PersonalDetails.php`**](../../entities/associations/one_to_one/unidirectional/PersonalDetails.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'personal_details')]
class PersonalDetails
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\Column(type: 'string', name: 'first_name')]
    private string $firstName;
    #[ORM\Column(type: 'string', name: 'last_name')]
    private string $lastName;
}
```

**Console**

```bash
php bin/doctrine orm:schema-tool:update --force --dump-sql
```

```
CREATE TABLE personal_details (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id));
ALTER TABLE authors ADD personal_details_id INT DEFAULT NULL;
ALTER TABLE authors ADD CONSTRAINT FK_8E0C2A51FBCAA082 FOREIGN KEY (personal_details_id) REFERENCES personal_details (id);
CREATE UNIQUE INDEX UNIQ_8E0C2A51FBCAA082 ON authors (personal_details_id);

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
+-----------------------+
4 rows in set (0,001 sec)S
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
3 rows in set (0,008 sec)
```

```sql
describe personal_details;
```

```
+------------+--------------+------+-----+---------+----------------+
| Field      | Type         | Null | Key | Default | Extra          |
+------------+--------------+------+-----+---------+----------------+
| id         | int(11)      | NO   | PRI | NULL    | auto_increment |
| first_name | varchar(255) | NO   |     | NULL    |                |
| last_name  | varchar(255) | NO   |     | NULL    |                |
+------------+--------------+------+-----+---------+----------------+
3 rows in set (0,003 sec)
```

[**`src\Author.php`**](../../entities/associations/one_to_one/unidirectional/Author.php)

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
     * @param PersonalDetails $personalDetails
     *
     * @return void
     */
    public function setPersonalDetails(PersonalDetails $personalDetails)
    {
        $this->personalDetails = $personalDetails;
    }
}

```

[**`src/PersonalDetails.php`**](../../entities/associations/one_to_one/unidirectional/PersonalDetails.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'personal_details')]
class PersonalDetails
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
     * @param string $firstName
     *
     * @return void
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @param string $lastName
     *
     * @return void
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }
}

```

[**`example/associations/one_to_one/unidirectional/create_author_with_personal_details.php`**](../../example/associations/one_to_one/unidirectional/create_author_with_personal_details.php)

```php
<?php
// create_author_with_personal_details.php <penname> <first_name> <last_name>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$penname = $argv[1];
$firstName = $argv[2];
$lastName = $argv[3];

$personalDetails = new PersonalDetails();
$personalDetails->setFirstName($firstName);
$personalDetails->setLastName($lastName);

$author = new Author();
$author->setPenname($penname);
$author->setPersonalDetails($personalDetails);

$entityManager->persist($personalDetails);
$entityManager->persist($author);
$entityManager->flush();

print("Created Author with ID " . $author->getId() . "\n");
print("Created Personal Details with ID " . $personalDetails->getId() . "\n");

```

**Console**

```bash
php example/associations/one_to_one/unidirectional/create_author_with_personal_details.php "Bolesław Prus" "Aleksander" "Głowacki"
```

```
Created Author with ID 2
Created Personal Details with ID 1
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
+----+------------+-----------+
1 row in set (0,004 sec)
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
+----+----------------+---------------------+
2 rows in set (0,001 sec)

```

[**`src\Author.php`**](../../entities/associations/one_to_one/unidirectional/Author.php)

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
     * @return PersonalDetails
     */
    public function getPersonalDetails(): PersonalDetails
    {
        return $this->personalDetails;
    }
}

```

[**`src/PersonalDetails.php`**](../../entities/associations/one_to_one/unidirectional/PersonalDetails.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'personal_details')]
class PersonalDetails
{
    // ...

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    // ...

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }
}

```

[**`example/associations/one_to_one/unidirectional/read_author_with_personal_details.php`**](../../example/associations/one_to_one/unidirectional/read_author_with_personal_details.php)

```php
<?php
// read_author_with_personal_details.php <id>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$id = $argv[1];

$author = $entityManager->find('Author', $id);

if ($author === null) {
    print("No Author found.\n");
    exit(1);
}

$showPattern = "%s (%s %s)\n";

printf(
    $showPattern,
    $author->getPenname(),
    $author->getPersonalDetails()->getFirstName(),
    $author->getPersonalDetails()->getLastName()
);

```

```bash
php example/associations/one_to_one/unidirectional/read_author_with_personal_details.php 2
```

```
Bolesław Prus (Aleksander Głowacki)
```
