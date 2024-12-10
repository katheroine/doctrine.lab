<?php
// update_quote.php <id> <content> <author> <source>

require_once __DIR__ . "/../bootstrap.php";

$id = $argv[1];
$content = $argv[2];
$author = $argv[3];
$source = $argv[4];

$quote = $entityManager->find('Quote', $id);

if ($quote === null) {
    echo "Product $id does not exist.\n";
    exit(1);
}

$quote->setContent($content);
$quote->setAuthor($author);
$quote->setSource($source);

$entityManager->flush();

echo "Updated Quote with ID " . $id . "\n";
