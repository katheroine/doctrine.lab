<?php
// create_source_with_author.php <title> <penname>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$title = $argv[1];
$penname = $argv[2];

$author = new Author();
$author->setPenname($penname);

$source = new Source();
$source->setTitle($title);
$source->addAuthor($author);

$entityManager->persist($author);
$entityManager->persist($source);
$entityManager->flush();

print("Created Author with ID " . $author->getId() . "\n");
print("Created Source with ID " . $source->getId() . "\n");
