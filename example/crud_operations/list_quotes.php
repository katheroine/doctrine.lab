<?php
// list_quotes.php

require_once __DIR__ . "/../../bootstrap.php";

$quoteRepository = $entityManager->getRepository('Quote');
$quotes = $quoteRepository->findAll();

$listPattern = "✤ %s\n -- %s, \"%s\"\n\n";

foreach ($quotes as $quote) {
    echo sprintf(
        $listPattern,
        $quote->getContent(),
        $quote->getAuthor(),
        $quote->getSource()
    );
}
