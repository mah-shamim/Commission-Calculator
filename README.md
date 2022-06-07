# Commission Calculator
## Installation
- Git clone the project repository from this link: [Commission Calculator](https://github.com/mah-shamim/Commission-Calculator.git)
- Execute this  command to install composer dependence
```bash
composer install
```
- Create an application Encryption Key using this command
```bash
php artisan key:generate
```

## Application Run
- To start the application run this command
```bash
php artisan serve --port=5005
```
- Click on this link: [Commission Calculator](http://127.0.0.1:5005) to open application

## Manual

To properly operate this application please follow these instructions: 

- Upload a deposit sample file in csv format [Example](input.csv)
- Submit the form by clicking **Calculate** button
- After file upload system will calculate commission
- System will return a table styled list of inputs and commissions.

## Input data
Operations are given in a CSV file. In each line of the file the following data is provided:
1. operation date in format `Y-m-d`
2. user's identificator, number
3. user's type, one of `private` or `business`
4. operation type, one of `deposit` or `withdraw`
5. operation amount (for example `2.12` or `3`)
6. operation currency, one of `EUR`, `USD`, `JPY`

## Interface
![Commission Calculator](commission-calculator.png)


