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
php bin/doctrine orm:schema-tool:update --force
```

### Creating table

**`bootstrap.php`**

```php
<?php
require_once 'vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

// Configuration
$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . '/src'],
    isDevMode: true,
);

// Conection
$connection = DriverManager::getConnection([
    'driver' => 'pdo_mysql',
    'dbname' => 'doctrinelab',
    'user' => 'doctrinelab',
    'password' => 'doctrinelab_password',
    'host' => '127.0.0.1',
    'serverVersion' => '10.5.8-MariaDB'
], $config);

// Entity Manager
// "Doctrine's public interface is through the EntityManager.
// This class provides access points to the complete lifecycle management for your entities,
// and transforms entities from and back to persistence.
// You have to configure and create it to use your entities with Doctrine ORM."
// -- https://www.doctrine-project.org/projects/doctrine-orm/en/current/tutorials/getting-started.html
$entityManager = new EntityManager($connection, $config);

```

**`src/Quote.php`**

```php
<?php

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
    private ?string $author = null;
    #[ORM\Column(type: 'string')]
    private ?string $source = null;
    #[ORM\Column(type: 'string')]
    private string $content;
}

```

That's all we need to create a simple table with no association.

**Console**

```bash
php bin/doctrine orm:schema-tool:update --force --dump-sql
```

```

 Updating database schema...

     1 query was executed


 [OK] Database schema updated successfully!


```

Specifying both flags `--force` and `--dump-sql` will cause the DDL statements to be executed and then printed to the screen.

-- https://www.doctrine-project.org/projects/doctrine-orm/en/current/tutorials/getting-started.html

