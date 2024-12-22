<?php
// one_to_one_bidirectional_read.php <entity> <id>

require_once __DIR__ . "/../../bootstrap.php";

$entity = strtolower($argv[1]);
$id = $argv[2];

switch($entity) {
    case 'quote':
        readQuote($id, $entityManager);
        break;
    case 'source':
        readSource($id, $entityManager);
        break;
}

function readQuote(int $id, $entityManager)
{
    $quote = $entityManager->find('Quote', $id);

    if ($quote === null) {
        echo ("No Quote found.\n");
        exit(1);
    }

    $showPattern = "\"%s\"\n-- \"%s\"\n\n";

    echo sprintf(
        $showPattern,
        $quote->getContent(),
        $quote->getSource()?->getTitle()
    );
}

function readSource(int $id, $entityManager)
{
    $source = $entityManager->find('Source', $id);

    if ($source === null) {
        echo ("No Source found.\n");
        exit(1);
    }

    $showPattern = "\"%s\"\n\n";

    echo sprintf(
        $showPattern,
        $source->getTitle()
    );

    foreach ($source->getQuotes() as $quote) {
        sprintf("* \"%s\"\n", $quote->getContent());
    }
}
