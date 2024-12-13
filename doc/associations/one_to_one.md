[⌂ Home](../../README.md)
[▲ Previous: Deleting records](../crud_operations/deleting_records.md)
[▼ Next: One to many](one_to_many.md)

### One to one

#### Unidirectional

**`src/PersonalDetails`**

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
    #[ORM\Column(type: 'string')]
    private string $firstName;
    #[ORM\Column(type: 'string')]
    private string $lastName;
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
+-----------+--------------+------+-----+---------+----------------+
| Field     | Type         | Null | Key | Default | Extra          |
+-----------+--------------+------+-----+---------+----------------+
| id        | int(11)      | NO   | PRI | NULL    | auto_increment |
| firstName | varchar(255) | NO   |     | NULL    |                |
| lastName  | varchar(255) | NO   |     | NULL    |                |
+-----------+--------------+------+-----+---------+----------------+
3 rows in set (0,002 sec)
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
