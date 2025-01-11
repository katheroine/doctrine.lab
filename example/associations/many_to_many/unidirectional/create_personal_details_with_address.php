<?php
// create_personal_details_with_address.php <first_name> <last_name> <street> <city> <state> <postal_code>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$firstName = $argv[1];
$lastName = $argv[2];
$street = $argv[3];
$city = $argv[4];
$state = $argv[5];
$postalCode = $argv[6];

$address = new Address();
$address->setStreet($street);
$address->setCity($city);
$address->setState($state);
$address->setPostalCode($postalCode);

$personalDetails = new PersonalDetails();
$personalDetails->setFirstName($firstName);
$personalDetails->setLastName($lastName);
$personalDetails->addAddress($address);

$entityManager->persist($address);
$entityManager->persist($personalDetails);
$entityManager->flush();

print("Created PersonalDetails with ID " . $personalDetails->getId() . "\n");
print("Created Address with ID " . $address->getId() . "\n");
