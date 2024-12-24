<?php
// read_autopromotion_with_author.php <id>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$id = $argv[1];

$autopromotion = $entityManager->find('Autopromotion', $id);

if ($autopromotion === null) {
    print("No Autopromotion found.\n");
    exit(1);
}

$showPattern = "%s\n%s\n";

printf(
    $showPattern,
    $autopromotion->getAuthor()->getPenname(),
    $autopromotion->getBio()
);
