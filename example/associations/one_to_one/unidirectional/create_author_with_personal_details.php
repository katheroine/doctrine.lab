<?php
// create_author_with_personal_details.php <penname> <first_name> <last_name>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

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

print("Created Author with ID " . $author->getId() . "\n");
print("Created Personal Details with ID " . $personalDetails->getId() . "\n");
