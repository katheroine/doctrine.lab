[⌂ Home](../../README.md)
[▲ Previous: Deleting records](../crud_operations/deleting_records.md)
[▼ Next: One to one: Bidirectional](../associations/one_to_one_bidirectional.md)

### One to one: Unidirectional

**`src/PersonalDetails.php`**

```php
<?php

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

**`src\Author.php`**

```php
<?php

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
     * @var PersonalDetails
     */
    #[ORM\OneToOne(targetEntity: PersonalDetails::class)]
    #[ORM\JoinColumn(name: 'personal_details_id', referencedColumnName: 'id')]
    private PersonalDetails $personalDetails;
}

```

**Console**

```bash
php bin/doctrine orm:schema-tool:update --force --dump-sql
```

```
CREATE TABLE authors (id INT AUTO_INCREMENT NOT NULL, penname VARCHAR(255) NOT NULL, personal_details_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_8E0C2A51FBCAA082 (personal_details_id), PRIMARY KEY(id));
CREATE TABLE personal_details (id INT AUTO_INCREMENT NOT NULL, firstName VARCHAR(255) NOT NULL, lastName VARCHAR(255) NOT NULL, PRIMARY KEY(id));
ALTER TABLE authors ADD CONSTRAINT FK_8E0C2A51FBCAA082 FOREIGN KEY (personal_details_id) REFERENCES personal_details (id);

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
| personal_details      |
| quotes                |
+-----------------------+
3 rows in set (0,001 sec)
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
3 rows in set (0,011 sec)
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
3 rows in set (0,003 sec)
```

**`src/PersonalDetails.php`**

```php
<?php

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

**`src\Author.php`**

```php
<?php

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

**`example/associations/one_to_one_unidirectional_create.php`**

```php
<?php
// one_to_one_unidirectional_create.php <penname> <first_name> <last_name>

require_once __DIR__ . "/../../bootstrap.php";

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

echo "Created PersonalDetails with ID " . $personalDetails->getId() . "\n";
echo "Created Author with ID " . $author->getId() . "\n";

```

**Console**

```bash
php example/associations/one_to_one_unidirectional_create.php "Bolesław Prus" "Aleksander" "Głowacki"
```

```
Created PersonalDetails with ID 1
Created Author with ID 1
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
|  1 | Bolesław Prus  |                   1 |
+----+----------------+---------------------+
1 row in set (0,001 sec)
```

**`src/PersonalDetails.php`**

```php
<?php

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

**`src\Author.php`**

```php
<?php

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'authors')]
class Author
{
    // ...

    /**
     * @return string
     */
    public function getPenname()
    {
        return $this->penname;
    }

    // ...

    /**
     * @return PersonalDetails
     */
    public function getPersonalDetails()
    {
        return $this->personalDetails;
    }
}

```

**`example/associations/one_to_one_unidirectional_read.php`**

```php
<?php
// one_to_one_unidirectional_read.php <id>

require_once __DIR__ . "/../../bootstrap.php";

$id = $argv[1];

$author = $entityManager->find('Author', $id);

if ($author === null) {
    echo ("No Author found.\n");
    exit(1);
}

$showPattern = "%s (%s %s)\n";

echo sprintf(
    $showPattern,
    $author->getPenname(),
    $author->getPersonalDetails()->getFirstName(),
    $author->getPersonalDetails()->getLastName()
);

```

```bash
php example/associations/one_to_one_unidirectional_read.php 1
```

```
Bolesław Prus (Aleksander Głowacki)
```
