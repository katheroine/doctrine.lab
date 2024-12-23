<?php
// update_quote.php <id> <content>

declare(strict_types=1);

require_once __DIR__ . "/../../bootstrap.php";

$id = $argv[1];
$content = $argv[2];

$quote = $entityManager->find('Quote', $id);

if ($quote === null) {
    print("Quote $id does not exist.\n");
    exit(1);
}

$quote->setContent($content);

$entityManager->flush();

print("Updated Quote with ID " . $id . "\n");
