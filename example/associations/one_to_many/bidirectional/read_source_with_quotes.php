<?php
// read_source_with_quotes.php <id>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$id = $argv[1];

$source = $entityManager->find('Source', $id);

if ($source === null) {
    print("No Source found.\n");
    exit(1);
}

$quotes = $source->getQuotes();

$showPattern = "%s\n-- \"%s\"\n\n";

foreach($quotes as $quote) {
    printf(
        $showPattern,
        $quote->getContent(),
        $quote->getSource()?->getTitle()
    );
}
