[⌂ Home](../README.md)
[▼ Next: Managing schema](managing_schema.md)

## Preparing

**System (Debian-based Linux)**

```bash
sudo aptitude install php8.3-mysql
```

**Database (MySQL/MariaDB)**

```
create database doctrinelab;
create user 'doctrinelab'@'127.0.0.1' identified by 'doctrinelab_password';
grant all on doctrinelab.* to 'doctrinelab'@'127.0.0.1';
flush privileges;
```

**composer.json**

```composer
{
    "require": {
        "doctrine/orm": "^3",
        "doctrine/dbal": "^4",
        "symfony/cache": "^7"
    },
    "autoload": {
        "psr-0": {"": "src/"}
    }
}
```

**Dependencies installing**

```bash
composer install
```

**bootsprap.php**

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
    'driver' => 'pdo_mysql', // for MySQL or MariaDB database
    'dbname' => 'doctrinelab',
    'user' => 'doctrinelab',
    'password' => 'doctrinelab_password',
    'host' => '127.0.0.1',
    'serverVersion' => '10.5.8-MariaDB'// for MariaDB databas
], $config);

// Entity Manager
$entityManager = new EntityManager($connection, $config);

```

**bin/doctrine**

```php
#!/usr/bin/env php**
<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

require __DIR__ . '/../bootstrap.php';

ConsoleRunner::run(
    new SingleManagerProvider($entityManager)
);

```

**Testing bin script**

```bash
mkdir src
php bin/doctrine orm:schema-tool:create
```

```

 [OK] No Metadata Classes to process.


```

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
