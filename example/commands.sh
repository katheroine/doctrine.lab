# CRUD operations

## Creating records

php example/crud_operations/create_quote.php "I would always rather be happy than dignified."
php example/crud_operations/create_quote.php "Pain and suffering are always inevitable for a large intelligence and a deep heart."
php example/crud_operations/create_quote.php "Somewhere, something incredible is waiting to be known."

## Reading records

php example/crud_operations/list_quotes.php
php example/crud_operations/show_quote.php 1
php example/crud_operations/show_quote.php 2
php example/crud_operations/show_quote.php 3

## Updating records

php example/crud_operations/update_quote.php 2 "The strongest of all warriors are these two — Time and Patience."

## Deleting records

php example/crud_operations/delete_quote.php 1

# Associations

## One to one: Bidirectional

php example/associations/one_to_one/bidirectional/create_author_with_autopromotion.php "Anne Maroon" "Romantic gardens of words."
php example/associations/one_to_one/bidirectional/read_author_with_autopromotion.php 1
php example/associations/one_to_one/bidirectional/read_autopromotion_with_author.php 1

## One to one: Unidirectional

php example/associations/one_to_one/unidirectional/create_author_with_personal_details.php "Bolesław Prus" "Aleksander" "Głowacki"
php example/associations/one_to_one/unidirectional/read_author_with_personal_details.php 2

## One to many: Bidirectional

php example/associations/one_to_many/bidirectional/create_quote_with_source.php "De contemptu mundi" "Stat rosa pristina nomine, nomina nuda tenemus."
php example/associations/one_to_many/bidirectional/read_quote_with_source.php 4
php example/associations/one_to_many/bidirectional/read_source_with_quotes.php 1

## One to many: Unidirectional

php example/associations/one_to_many/unidirectional/create_personal_details_with_email.php Florence Wood florence.wood@scribes.com
php example/associations/one_to_many/unidirectional/read_personal_details_with_emails.php 2

## Many to many: Bidirectional

php example/associations/many_to_many/bidirectional/create_source_with_author.php "Il pendolo di Foucault" "Umberto Eco"
php example/associations/many_to_many/bidirectional/read_source_with_authors.php 2
php example/associations/many_to_many/bidirectional/read_author_with_sources.php 3

## Many to many: Unidirectional

php example/associations/many_to_many/unidirectional/create_personal_details_with_address.php Ginger Irving "121 Main St" Springfield IL 62701
php example/associations/many_to_many/unidirectional/read_personal_details_with_address.php 3
