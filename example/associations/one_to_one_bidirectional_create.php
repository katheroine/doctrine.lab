<?php
// one_to_one_bidirectional_create.php <penname> <first_name> <last_name> <bio>

require_once __DIR__ . "/../../bootstrap.php";

$penname = $argv[1];
$firstName = $argv[2];
$lastName = $argv[3];
$bio = $argv[4];

$personalDetails = new PersonalDetails();
$personalDetails->setFirstName($firstName);
$personalDetails->setLastName($lastName);

$author = new Author();
$author->setPenname($penname);
$author->setPersonalDetails($personalDetails);

$autopresentation = new AuthorAutopresentation();
$autopresentation->setBio($bio);
$autopresentation->setAuthor($author);

$entityManager->persist($personalDetails);
$entityManager->persist($author);
$entityManager->persist($autopresentation);
$entityManager->flush();

echo "Created PersonalDetails with ID " . $personalDetails->getId() . "\n";
echo "Created Author with ID " . $author->getId() . "\n";
echo "Created AuthorAutopresentation with ID " . $autopresentation->getId() . "\n";
