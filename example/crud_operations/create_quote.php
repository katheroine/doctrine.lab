<?php
// create_quote.php <content>

declare(strict_types=1);

require_once __DIR__ . "/../../bootstrap.php";

$content = $argv[1];

$quote = new Quote();
$quote->setContent($content);

$entityManager->persist($quote);
$entityManager->flush();

print("Created Quote with ID " . $quote->getId() . "\n");
