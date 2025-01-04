<?php
// read_author_with_personal_details.php <id>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$id = $argv[1];

$author = $entityManager->find('Author', $id);

if ($author === null) {
    print("No Author found.\n");
    exit(1);
}

$showPattern = "%s (%s %s)\n";

printf(
    $showPattern,
    $author->getPenname(),
    $author->getPersonalDetails()->getFirstName(),
    $author->getPersonalDetails()->getLastName()
);
