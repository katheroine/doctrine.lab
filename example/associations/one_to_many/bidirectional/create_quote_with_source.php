<?php
// create_quote_with_source.php <title> <content>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$title = $argv[1];
$content = $argv[2];

$source = new Source();
$source->setTitle($title);

$quote = new Quote();
$quote->setContent($content);
$quote->setSource($source);

$entityManager->persist($source);
$entityManager->persist($quote);
$entityManager->flush();

print("Created Quote with ID " . $quote->getId() . "\n");
print("Created Source with ID " . $source->getId() . "\n");
