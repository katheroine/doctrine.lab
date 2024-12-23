<?php
// show_query.php <id>

declare(strict_types=1);

require_once __DIR__ . "/../../bootstrap.php";

$id = $argv[1];

$quote = $entityManager->find('Quote', $id);

if ($quote === null) {
    print("No Quote found.\n");
    exit(1);
}

$showPattern = "\"%s\"\n";

printf(
    $showPattern,
    $quote->getContent()
);
