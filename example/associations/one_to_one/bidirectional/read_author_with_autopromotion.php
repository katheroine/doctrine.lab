<?php
// read_author_with_autopromotion.php <id>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$id = $argv[1];

$author = $entityManager->find('Author', $id);

if ($author === null) {
    print("No Author found.\n");
    exit(1);
}

$showPattern = "%s\n%s\n";

printf(
    $showPattern,
    $author->getPenname(),
    $author->getAutopromotion()?->getBio()
);
