<?php
// one_to_one_unidirectional_read.php <id>

require_once __DIR__ . "/../../bootstrap.php";

$id = $argv[1];

$author = $entityManager->find('Author', $id);

if ($author === null) {
    echo ("No Author found.\n");
    exit(1);
}

$showPattern = "%s (%s %s)\n";

echo sprintf(
    $showPattern,
    $author->getPenname(),
    $author->getPersonalDetails()->getFirstName(),
    $author->getPersonalDetails()->getLastName()
);
