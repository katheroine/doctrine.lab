<?php
// delete_quote.php <id>

require_once __DIR__ . "/../bootstrap.php";

$id = $argv[1];

$quote = $entityManager->find('Quote', $id);

if ($quote === null) {
    echo "Quote $id does not exist.\n";
    exit(1);
}

$entityManager->remove($quote);
$entityManager->flush();

echo "Deleted Quote with ID " . $id . "\n";
