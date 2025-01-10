<?php
// read_author_with_sources.php <id>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$id = $argv[1];

$author = $entityManager->find('Author', $id);

if ($author === null) {
    print("No Author found.\n");
    exit(1);
}

$showPattern = "%s\n";

printf(
    $showPattern,
    $author->getPenname()
);

$sources = $author->getSources();

$showPattern = "✤ \"%s\"\n";

foreach($sources as $source) {
    printf(
        $showPattern,
        $source->getTitle()
    );
}
