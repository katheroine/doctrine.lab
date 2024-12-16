<?php
// one_to_one_unidirectional_create.php <penname> <first_name> <last_name>

require_once __DIR__ . "/../../bootstrap.php";

$penname = $argv[1];
$firstName = $argv[2];
$lastName = $argv[3];

$personalDetails = new PersonalDetails();
$personalDetails->setFirstName($firstName);
$personalDetails->setLastName($lastName);

$author = new Author();
$author->setPenname($penname);
$author->setPersonalDetails($personalDetails);

$entityManager->persist($personalDetails);
$entityManager->persist($author);
$entityManager->flush();

echo "Created PersonalDetails with ID " . $personalDetails->getId() . "\n";
echo "Created Author with ID " . $author->getId() . "\n";
