<?php
// create_author_with_autopromotion.php <penname> <bio>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$penname = $argv[1];
$bio = $argv[2];

$author = new Author();
$author->setPenname($penname);

$autopromotion = new Autopromotion();
$autopromotion->setBio($bio);
$autopromotion->setAuthor($author);

$entityManager->persist($author);
$entityManager->persist($autopromotion);
$entityManager->flush();

print("Created Author with ID " . $author->getId() . "\n");
print("Created Autopromotion with ID " . $autopromotion->getId() . "\n");
