<?php
// read_source_with_authors.php <id>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$id = $argv[1];

$source = $entityManager->find('Source', $id);

if ($source === null) {
    print("No Source found.\n");
    exit(1);
}

$showPattern = "\"%s\"\n";

printf(
    $showPattern,
    $source->getTitle()
);

$authors = $source->getAuthors();

$showPattern = "✤ %s\n";

foreach($authors as $author) {
    printf(
        $showPattern,
        $author->getPenname()
    );
}
