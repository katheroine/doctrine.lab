<?php
// list_quotes.php

declare(strict_types=1);

require_once __DIR__ . "/../../bootstrap.php";

$quoteRepository = $entityManager->getRepository('Quote');
$quotes = $quoteRepository->findAll();

$listPattern = "✤ \"%s\"\n\n";

foreach ($quotes as $quote) {
    printf(
        $listPattern,
        $quote->getContent()
    );
}
