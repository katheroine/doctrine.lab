# Doctrine.lab

Laboratory of Doctrine.

## Preparing

**composer.json**

```composer
{
    "require": {
        "doctrine/orm": "^3.1",
        "symfony/cache": "^7.0"
    }
}

```

**Dependencies installing**

`$ composer install`

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
    'driver' => 'pdo_mysql', // for MySQL database
    'dbname' => 'doctrinelab',
    'user' => 'doctrinelab',
    'password' => 'doctrinelab_password',
    'host' => '127.0.0.1',
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
$ php bin/doctrine orm:schema-tool:create


 [OK] No Metadata Classes to process.


```
