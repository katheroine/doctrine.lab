<?php
// create_quote.php <content> <author> <source>

require_once __DIR__ . "/../../bootstrap.php";

$content = $argv[1];
$author = $argv[2];
$source = $argv[3];

$quote = new Quote();
$quote->setContent($content);
$quote->setAuthor($author);
$quote->setSource($source);

$entityManager->persist($quote);
$entityManager->flush();

echo "Created Quote with ID " . $quote->getId() . "\n";
