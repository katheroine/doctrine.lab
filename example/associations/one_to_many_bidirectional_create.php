<?php
// one_to_many_bidirectional_create.php <title> <content>
require_once __DIR__ . "/../../bootstrap.php";

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

echo "Created Source with ID " . $source->getId() . "\n";
echo "Created Quote with ID " . $quote->getId() . "\n";
