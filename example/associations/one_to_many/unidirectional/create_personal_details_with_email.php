<?php
// create_personal_details_with_email.php <first_name> <last_name> <email>

declare(strict_types=1);

require_once __DIR__ . "/../../../../bootstrap.php";

$firstName = $argv[1];
$lastName = $argv[2];
$emailAddress = $argv[3];

$email = new Email();
$email->set($emailAddress);

$personalDetails = new PersonalDetails();
$personalDetails->setFirstName($firstName);
$personalDetails->setLastName($lastName);
$personalDetails->addEmail($email);

$entityManager->persist($email);
$entityManager->persist($personalDetails);
$entityManager->flush();

print("Created Personal Details with ID " . $personalDetails->getId() . "\n");
print("Created Email with ID " . $email->getId() . "\n");
