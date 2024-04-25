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
], $config);

// Entity Manager
// "Doctrine's public interface is through the EntityManager.
// This class provides access points to the complete lifecycle management for your entities,
// and transforms entities from and back to persistence.
// You have to configure and create it to use your entities with Doctrine ORM."
// -- https://www.doctrine-project.org/projects/doctrine-orm/en/current/tutorials/getting-started.html
$entityManager = new EntityManager($connection, $config);
