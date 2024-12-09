<?php
// show_query.php <id>

require_once "bootstrap.php";

$id = $argv[1];

$quote = $entityManager->find('Quote', $id);

if ($quote === null) {
    echo ("No quote found.\n");
    exit(1);
}

$showPattern = "%s\n -- %s, \"%s\"\n";

echo sprintf(
    $showPattern,
    $quote->getContent(),
    $quote->getAuthor(),
    $quote->getSource()
);
