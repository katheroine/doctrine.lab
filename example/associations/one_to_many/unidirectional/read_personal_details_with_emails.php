<?php
// read_personal_details_with_emails.php <id>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

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

$showPattern = "✤ %s\n";

foreach($personalDetails->getEmails() as $email) {
    printf(
        $showPattern,
        $email->get()
    );
}
