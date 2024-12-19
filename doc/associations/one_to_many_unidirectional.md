[⌂ Home](../../README.md)
[▲ Previous: One to one: Bidirectional](../associations/one_to_one_bidirectional.md)
[▼ Next: One to many](one_to_many.md)

### One to many: Bidirectional

**`src/Email.php`**

```php
<?php

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
    #[ORM\Column(type: 'bool', name: 'is_login')]
    private $isLogin;
}

```

**`src/PersonalDetails.php`**

```php
<?php

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

**Console**

```bash
php bin/doctrine orm:schema-tool:update --force --dump-sql
```

```
CREATE TABLE emails (id INT AUTO_INCREMENT NOT NULL, localPart VARCHAR(255) NOT NULL, domain VARCHAR(255) NOT NULL, is_login TINYINT(1) NOT NULL, PRIMARY KEY(id));
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
+--------------------------+
| Tables_in_doctrinelab    |
+--------------------------+
| author_autopresentations |
| authors                  |
| emails                   |
| personal_details         |
| personal_details_emails  |
| quotes                   |
| sources                  |
+--------------------------+
7 rows in set (0,001 sec)
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
| is_login   | tinyint(1)   | NO   |     | NULL    |                |
+------------+--------------+------+-----+---------+----------------+
4 rows in set (0,002 sec)
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
