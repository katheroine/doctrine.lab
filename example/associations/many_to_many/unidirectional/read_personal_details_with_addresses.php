<?php
// read_personal_details_with_addresses.php <id>

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

$showPattern = "✤ %s %s, %s %s\n";

foreach($personalDetails->getAddresses() as $address) {
    printf(
        $showPattern,
        $address->getStreet(),
        $address->getCity(),
        $address->getState(),
        $address->getPostalCode()
    );
}
