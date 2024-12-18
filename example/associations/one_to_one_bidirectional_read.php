<?php
// one_to_one_bidirectional_read.php <entity> <id>

require_once __DIR__ . "/../../bootstrap.php";

$entity = strtolower($argv[1]);
$id = $argv[2];

$showPattern = "%s (%s %s)\n%s\n\n";

switch($entity) {
    case 'author':
        readAuthor($id, $entityManager, $showPattern);
        break;
    case 'autopresentation':
        readAutopresentation($id, $entityManager, $showPattern);
        break;
}

function readAuthor(int $id, $entityManager, $showPattern)
{
    $author = $entityManager->find('Author', $id);

    if ($author === null) {
        echo ("No Author found.\n");
        exit(1);
    }

    echo sprintf(
        $showPattern,
        $author->getPenname(),
        $author->getPersonalDetails()->getFirstName(),
        $author->getPersonalDetails()->getLastName(),
        $author->getAutopresentation()?->getBio()
    );
}

function readAutopresentation(int $id, $entityManager, $showPattern)
{
    $autopresentation = $entityManager->find('AuthorAutopresentation', $id);

    if ($autopresentation === null) {
        echo ("No Autopresentation found.\n");
        exit(1);
    }

    echo sprintf(
        $showPattern,
        $autopresentation->getAuthor()->getPenname(),
        $autopresentation->getAuthor()->getPersonalDetails()->getFirstName(),
        $autopresentation->getAuthor()->getPersonalDetails()->getLastName(),
        $autopresentation->getBio()
    );
}
