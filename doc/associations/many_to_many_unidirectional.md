[⌂ Home](../../README.md)
[▲ Previous: Many to many: Bidirectional](../associations/many_to_many_bidirectional.md)

### Many to many: Unidirectional

[**`src/Address`**](../../entities/associations/many_to_many/unidirectional/Address.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'addresses')]
class Address
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\Column(type: 'string')]
    private string $street;
    #[ORM\Column(type: 'string')]
    private string $city;
    #[ORM\Column(type: 'string')]
    private string $state;
    #[ORM\Column(type: 'string')]
    private string $postalCode;
}

```

[**`src/PersonalDetails`**](../../entities/associations/many_to_many/unidirectional/PersonalDetails.php)


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
     * @var Collection<int, Address>
     */
    #[ORM\ManyToMany(targetEntity: Address::class)]
    #[ORM\JoinTable(name: 'personal_details_addresses')]
    #[ORM\JoinColumn(name: 'personal_details_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'address_id', referencedColumnName: 'id')]
    private Collection $addresses;

    // ...
}

```

**Console**

```bash
php bin/doctrine orm:schema-tool:update --force --dump-sql
```

```
CREATE TABLE addresses (id INT AUTO_INCREMENT NOT NULL, street VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, postalCode VARCHAR(255) NOT NULL, PRIMARY KEY(id));
CREATE TABLE personal_details_addresses (personal_details_id INT NOT NULL, address_id INT NOT NULL, INDEX IDX_4499AC91FBCAA082 (personal_details_id), INDEX IDX_4499AC91F5B7AF75 (address_id), PRIMARY KEY(personal_details_id, address_id));
ALTER TABLE personal_details_addresses ADD CONSTRAINT FK_4499AC91FBCAA082 FOREIGN KEY (personal_details_id) REFERENCES personal_details (id);
ALTER TABLE personal_details_addresses ADD CONSTRAINT FK_4499AC91F5B7AF75 FOREIGN KEY (address_id) REFERENCES addresses (id);

 Updating database schema...

     4 queries were executed


 [OK] Database schema updated successfully!


```

**Database**

```sql
show tables;
```

```
+----------------------------+
| Tables_in_doctrinelab      |
+----------------------------+
| addresses                  |
| authors                    |
| autopromotions             |
| emails                     |
| personal_details           |
| personal_details_addresses |
| personal_details_emails    |
| quotes                     |
| sources                    |
| sources_authors            |
+----------------------------+
10 rows in set (0,001 sec)
```

```sql
describe addresses;
```

```
+------------+--------------+------+-----+---------+----------------+
| Field      | Type         | Null | Key | Default | Extra          |
+------------+--------------+------+-----+---------+----------------+
| id         | int(11)      | NO   | PRI | NULL    | auto_increment |
| street     | varchar(255) | NO   |     | NULL    |                |
| city       | varchar(255) | NO   |     | NULL    |                |
| state      | varchar(255) | NO   |     | NULL    |                |
| postalCode | varchar(255) | NO   |     | NULL    |                |
+------------+--------------+------+-----+---------+----------------+
5 rows in set (0,002 sec)
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
3 rows in set (0,010 sec)
```

```sql
describe personal_details_addresses;
```

```
+---------------------+---------+------+-----+---------+-------+
| Field               | Type    | Null | Key | Default | Extra |
+---------------------+---------+------+-----+---------+-------+
| personal_details_id | int(11) | NO   | PRI | NULL    |       |
| address_id          | int(11) | NO   | PRI | NULL    |       |
+---------------------+---------+------+-----+---------+-------+
2 rows in set (0,002 sec)
```

[**`src/Address`**](../../entities/associations/many_to_many/unidirectional/Address.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'addresses')]
class Address
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
     * @param string $street
     *
     * @return void
     */
    public function setStreet(string $street)
    {
        $this->street = $street;
    }

    /**
     * @param string $city
     *
     * @return void
     */
    public function setCity(string $city)
    {
        $this->city = $city;
    }

    /**
     * @param string $state
     *
     * @return void
     */
    public function setState(string $state)
    {
        $this->state = $state;
    }

    /**
     * @param string $postalCode
     *
     * @return void
     */
    public function setPostalCode(string $postalCode)
    {
        $this->postalCode = $postalCode;
    }
}

```

[**`src/PersonalDetails`**](../../entities/associations/many_to_many/unidirectional/PersonalDetails.php)

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
     * @param Address $address
     *
     * @return void
     */
    public function addAddress(Address $address)
    {
        $this->addresses->add($address);
    }
}

```

[**`example/associations/many_to_many/unidirectional/create_personal_details_with_address.php`**](../../example/associations/many_to_many/unidirectional/create_personal_details_with_address.php)

```php
<?php
// create_personal_details_with_address.php <first_name> <last_name> <street> <city> <state> <postal_code>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$firstName = $argv[1];
$lastName = $argv[2];
$street = $argv[3];
$city = $argv[4];
$state = $argv[5];
$postalCode = $argv[6];

$address = new Address();
$address->setStreet($street);
$address->setCity($city);
$address->setState($state);
$address->setPostalCode($postalCode);

$personalDetails = new PersonalDetails();
$personalDetails->setFirstName($firstName);
$personalDetails->setLastName($lastName);
$personalDetails->addAddress($address);

$entityManager->persist($address);
$entityManager->persist($personalDetails);
$entityManager->flush();

print("Created PersonalDetails with ID " . $personalDetails->getId() . "\n");
print("Created Address with ID " . $address->getId() . "\n");

```

**Console**

```bash
php example/associations/many_to_many/unidirectional/create_personal_details_with_address.php Ginger Irving "121 Main St" Springfield IL 62701
```

```
Created PersonalDetails with ID 3
Created Address with ID 1
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
|  3 | Ginger     | Irving    |
+----+------------+-----------+
3 rows in set (0,114 sec)
```

```sql
select * from addresses;
```

```
+----+-------------+-------------+-------+------------+
| id | street      | city        | state | postalCode |
+----+-------------+-------------+-------+------------+
|  1 | 121 Main St | Springfield | IL    | 62701      |
+----+-------------+-------------+-------+------------+
1 row in set (0,004 sec)
```

```sql
select * from personal_details_addresses;
```

```
+---------------------+------------+
| personal_details_id | address_id |
+---------------------+------------+
|                   3 |          1 |
+---------------------+------------+
1 row in set (0,001 sec)
```

[**`src/Address`**](../../entities/associations/many_to_many/unidirectional/Address.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'addresses')]
class Address
{
    // ...

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    // ...

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    // ...

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    // ...

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }
}

```

[**`src/PersonalDetails`**](../../entities/associations/many_to_many/unidirectional/PersonalDetails.php)

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
     * @return Collection
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }
}

```

[**`example/associations/many_to_many/unidirectional/read_personal_details_with_addresses.php`**](../../example/associations/many_to_many/unidirectional/read_personal_details_with_addresses.php)

```php
<?php
// read_personal_details_with_addresses.php <id>

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

$showPattern = "✤ %s %s, %s %s\n";

foreach($personalDetails->getAddresses() as $address) {
    printf(
        $showPattern,
        $address->getStreet(),
        $address->getCity(),
        $address->getState(),
        $address->getPostalCode()
    );
}

```

**Console**

```bash
php example/associations/many_to_many/unidirectional/read_personal_details_with_addresses.php 3
```

```
Ginger Irving
✤ 121 Main St Springfield, IL 62701
```
