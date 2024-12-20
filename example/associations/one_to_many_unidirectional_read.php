<?php
// one_to_one_bidirectional_read.php <id>

require_once __DIR__ . "/../../bootstrap.php";

$id = $argv[1];

$personalDetails = $entityManager->find('PersonalDetails', $id);

if ($personalDetails === null) {
    echo ("No Personal Details found.\n");
    exit(1);
}

$showPattern = "%s %s\n";

echo sprintf(
    $showPattern,
    $personalDetails->getFirstName(),
    $personalDetails->getLastName()
);

foreach($personalDetails->getEmails() as $email) {
    print($email->get() . "\n");
}
