[⌂ Home](../../README.md)
[▲ Previous: One to many: Bidirectional](../associations/one_to_many_bidirectional.md)

### One to many: Unidirectional

*A unidirectional one-to-many association can be mapped through a join table. From Doctrine's point of view, it is simply mapped as a unidirectional many-to-many whereby a unique constraint on one of the join columns enforces the one-to-many cardinality.*

-- [Doctrine Tutorial](https://www.doctrine-project.org/projects/doctrine-orm/en/3.3/reference/association-mapping.html#one-to-many-unidirectional-with-join-table)

[**`src/PersonalDetails.php`**](../../entities/associations/one_to_many/unidirectional/PersonalDetails.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'personal_details')]
class PersonalDetails
{
    // ...
    /**
     * @var Collection<int, Email>
     */
    #[ORM\ManyToMany(targetEntity: Email::class)]
    #[ORM\JoinTable(name: 'personal_details_emails')]
    #[ORM\JoinColumn(name: 'personal_details_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'email_id', referencedColumnName: 'id', unique: true)]
    private Collection $emails;

    // ...
}

```

[**`src/Email.php`**](../../entities/associations/one_to_many/unidirectional/Email.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'emails')]
class Email
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\Column(type: 'string', name: 'local_part')]
    private $localPart;
    #[ORM\Column(type: 'string')]
    private $domain;
}

```

**Console**

```bash
php bin/doctrine orm:schema-tool:update --force --dump-sql
```

```
CREATE TABLE emails (id INT AUTO_INCREMENT NOT NULL, local_part VARCHAR(255) NOT NULL, domain VARCHAR(255) NOT NULL, PRIMARY KEY(id));
CREATE TABLE personal_details_emails (personal_details_id INT NOT NULL, email_id INT NOT NULL, INDEX IDX_1A1C2E72FBCAA082 (personal_details_id), UNIQUE INDEX UNIQ_1A1C2E72A832C1C9 (email_id), PRIMARY KEY(personal_details_id, email_id));
ALTER TABLE personal_details_emails ADD CONSTRAINT FK_1A1C2E72FBCAA082 FOREIGN KEY (personal_details_id) REFERENCES personal_details (id);
ALTER TABLE personal_details_emails ADD CONSTRAINT FK_1A1C2E72A832C1C9 FOREIGN KEY (email_id) REFERENCES emails (id);

 Updating database schema...

     4 queries were executed


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
+-------------------------+
7 rows in set (0,015 sec)
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
3 rows in set (0,002 sec)
```

```sql
describe emails;
```

```
+------------+--------------+------+-----+---------+----------------+
| Field      | Type         | Null | Key | Default | Extra          |
+------------+--------------+------+-----+---------+----------------+
| id         | int(11)      | NO   | PRI | NULL    | auto_increment |
| local_part | varchar(255) | NO   |     | NULL    |                |
| domain     | varchar(255) | NO   |     | NULL    |                |
+------------+--------------+------+-----+---------+----------------+
3 rows in set (0,002 sec)
```

```sql
describe personal_details_emails;
```

```
+---------------------+---------+------+-----+---------+-------+
| Field               | Type    | Null | Key | Default | Extra |
+---------------------+---------+------+-----+---------+-------+
| personal_details_id | int(11) | NO   | PRI | NULL    |       |
| email_id            | int(11) | NO   | PRI | NULL    |       |
+---------------------+---------+------+-----+---------+-------+
2 rows in set (0,002 sec)
```

[**`src/PersonalDetails.php`**](../../entities/associations/one_to_many/unidirectional/PersonalDetails.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\Table(name: 'personal_details')]
class PersonalDetails
{
    // ...
    public function __construct()
    {
        $this->emails = new ArrayCollection();
    }

    // ...

    /**
     * @param Email $email
     *
     * @return void
     */
    public function addEmail(Email $email)
    {
        $this->emails->add($email);
    }
}

```

[**`src/Email.php`**](../../entities/associations/one_to_many/unidirectional/Email.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'emails')]
class Email
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
     * @param string $email
     *
     * @return void
     */
    public function set(string $email)
    {
        list($this->localPart, $this->domain) = explode('@', $email);
    }
}

```

[**`example/associations/one_to_many/unidirectional/create_personal_details_with_email.php`**](../../example/associations/one_to_many/unidirectional/create_personal_details_with_email.php)

```php
<?php
// create_personal_details_with_email.php <first_name> <last_name> <email>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$firstName = $argv[1];
$lastName = $argv[2];
$emailAddress = $argv[3];

$email = new Email();
$email->set($emailAddress);

$personalDetails = new PersonalDetails();
$personalDetails->setFirstName($firstName);
$personalDetails->setLastName($lastName);
$personalDetails->addEmail($email);

$entityManager->persist($email);
$entityManager->persist($personalDetails);
$entityManager->flush();

print("Created Personal Details with ID " . $personalDetails->getId() . "\n");
print("Created Email with ID " . $email->getId() . "\n");

```

**Console**

```bash
php example/associations/one_to_many/unidirectional/create_personal_details_with_email.php Florence Wood florence.wood@scribes.com
```

```
Created Personal Details with ID 2
Created Email with ID 1
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
|  2 | Florence   | Wood      |
+----+------------+-----------+
2 rows in set (0,001 sec)
```

```sql
select * from emails;
```

```
+----+---------------+-------------+
| id | local_part    | domain      |
+----+---------------+-------------+
|  1 | florence.wood | scribes.com |
+----+---------------+-------------+
1 row in set (0,001 sec)
```

```sql
select * from personal_details_emails;
```

```
+---------------------+----------+
| personal_details_id | email_id |
+---------------------+----------+
|                   2 |        1 |
+---------------------+----------+
1 row in set (0,001 sec)
```

[**`src/PersonalDetails.php`**](../../entities/associations/one_to_many/unidirectional/PersonalDetails.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\Table(name: 'personal_details')]
class PersonalDetails
{
    // ...

    /**
     * @return ArrayCollection
     */
    public function getEmails()
    {
        return $this->emails;
    }
}

```

[**`src/Email.php`**](../../entities/associations/one_to_many/unidirectional/Email.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'emails')]
class Email
{
    // ...

    /**
     * @return string
     */
    public function get()
    {
        return
            $this->localPart
            . '@'
            . $this->domain;
    }
}

```

[**`example/associations/one_to_many/unidirectional/read_personal_details_with_emails.php`**](../../example/associations/one_to_many/unidirectional/read_personal_details_with_emails.php)

```php
<?php
// read_personal_details_with_emails.php <id>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$id = $argv[1];

$personalDetails = $entityManager->find('PersonalDetails', $id);

if ($personalDetails === null) {
    echo ("No Personal Details found.\n");
    exit(1);
}

$showPattern = "%s %s\n";

echo sprintf(
    $showPattern,
    $personalDetails->getFirstName(),
    $personalDetails->getLastName()
);

$showPattern = "✤ %s\n";

foreach($personalDetails->getEmails() as $email) {
    printf(
        $showPattern,
        $email->get()
    );
}

```

**Console**

```bash
php example/associations/one_to_many/unidirectional/read_personal_details_with_emails.php 2
```

```
Florence Wood
✤ florence.wood@scribes.com
```
