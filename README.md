# the-iconic-product-api
A PHP console app to consume The Iconic's product API, decorate it with functionalities and write to std output

# Requirements
* Composer
* PHP7

# Installation
1. Clone the repo
- `$ git clone https://github.com/victorliafook/the-iconic-product-api.git `
2. cd into the app's directory
- `$ cd the-iconic-product-api`
3. Install PHP dependencies
- `$ composer install`

# Usage
The file get-products.php is an executable file. Executing it will show a default help menu

`$ ./get-products.php`

To show the instructions for a command, type help command e.g.:

`$ ./get-products.php help dump`

The main command is dump.

The command dump accepts 4 options: --page --page-size --gender --sort

`$ ./get-products.php dump --page=5 --page-size=10 --gender=female --sort=popularity`

You can use standard piping to write to a file, e.g.:

`$ ./get-products.php dump --page=5 --page-size=10 --gender=female --sort=popularity > jsonoutput.json`

# Maintaining
This project uses phpunit. To run unit tests and check code coverage run

`$ vendor/bin/phpunit --debug  --coverage-text`
