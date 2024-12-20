<?php
// one_to_many_unidirectional_create.php <first_name> <last_name> <email>

require_once __DIR__ . "/../../bootstrap.php";

$firstName = $argv[1];
$lastName = $argv[2];
$emailAddress = $argv[3];

$email = new Email();
$email->set($emailAddress);

$personalDetails = new PersonalDetails();
$personalDetails->setFirstName($firstName);
$personalDetails->setLastName($lastName);
$personalDetails->setEmail($email);

$entityManager->persist($email);
$entityManager->persist($personalDetails);
$entityManager->flush();

echo "Created Email with ID " . $email->getId() . "\n";
echo "Created PersonalDetails with ID " . $personalDetails->getId() . "\n";
