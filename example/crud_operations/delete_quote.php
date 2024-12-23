<?php
// delete_quote.php <id>

declare(strict_types=1);

require_once __DIR__ . "/../../bootstrap.php";

$id = $argv[1];

$quote = $entityManager->find('Quote', $id);

if ($quote === null) {
    print("Quote $id does not exist.\n");
    exit(1);
}

$entityManager->remove($quote);
$entityManager->flush();

print("Deleted Quote with ID " . $id . "\n");
