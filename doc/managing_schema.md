[⌂ Home](../README.md)
[▲ Previous: Preparing](preparing.md)
[▼ Next: Creating records](crud_operations/creating_records.md)

## Managing schema

**Database**

```mariadb
MariaDB [(none)]> show databases;
+--------------------+
| Database           |
+--------------------+
| information_schema |
| mysql              |
| performance_schema |
| test               |
+--------------------+
4 rows in set (0,001 sec)

```

### Creating schema

[**`src/Quote.php`**](../entities/managing_schema/Quote.php)

```php
<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'quotes')]
class Quote
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\Column(type: 'string')]
    private string $content;
}
```

That's all we need to create a simple table with no association.

**Database**

```sql
create database doctrinelab;
```

```
Query OK, 1 row affected (0,016 sec)
```

```sql
show databases;
```

```
+--------------------+
| Database           |
+--------------------+
| doctrinelab        |
| information_schema |
| mysql              |
| performance_schema |
| test               |
+--------------------+
5 rows in set (0,011 sec)
```

**Console**

```bash
php bin/doctrine orm:schema-tool:create
```

```

 !
 ! [CAUTION] This operation should not be executed in a production environment!
 !

 Creating database schema...


 [OK] Database schema created successfully!


```

**Database**

```sql
use doctrinelab;
```

```
Database changed
```

```sql
show tables;
```

```
+-----------------------+
| Tables_in_doctrinelab |
+-----------------------+
| quotes                |
+-----------------------+
1 row in set (0,001 sec)
```

```sql
describe quotes;
```

```
+---------+--------------+------+-----+---------+----------------+
| Field   | Type         | Null | Key | Default | Extra          |
+---------+--------------+------+-----+---------+----------------+
| id      | int(11)      | NO   | PRI | NULL    | auto_increment |
| content | varchar(255) | NO   |     | NULL    |                |
+---------+--------------+------+-----+---------+----------------+
2 rows in set (0,005 sec)
```

### Deleting schema

**Console**

```bash
php bin/doctrine orm:schema-tool:drop --force
```

```
 Dropping database schema...


 [OK] Database schema dropped successfully!


```

**Database**

```mariadb
MariaDB [doctrinelab]> show databases;
+--------------------+
| Database           |
+--------------------+
| doctrinelab        |
| information_schema |
| mysql              |
| performance_schema |
| test               |
+--------------------+
5 rows in set (0,001 sec)

```

Database still exists but all the existing tables would be removed.

### Updating Schema

**Console**

```bash
php bin/doctrine orm:schema-tool:update --force --dump-sql
```

```

 [OK] Nothing to update - your database is already in sync with the current entity metadata.


```

Specifying both flags `--force` and `--dump-sql` will cause the DDL statements to be executed and then printed to the screen.

-- https://www.doctrine-project.org/projects/doctrine-orm/en/current/tutorials/getting-started.html

