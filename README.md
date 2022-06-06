# Emoji Calculator

## Installation
- Git clone the project repository from this link: [Emoji Calculator](https://github.com/mah-shamim/emoji-calculator.git)
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
php artisan serve --port=5004
```
- Click on this link: [Emoji Calculator](http://127.0.0.1:5004) to open application

## Unit Test
- To unit test the application
```bash
php artisan test
```

## Manual
When you see web page is loaded on web browser. please follow this instruction to operate this application.
- Type first operand as number value only you can use any number.
- Select operator emoji icon from this available options
    1. 👽 Addition (Alien)
    2. 💀 Subtraction (Skull)
    3. 👻 Multiplication (Ghost)
    4. 😱 Division (Scream)
- Type second operand as number value only you can use any number.
- Click the "Calculate" button to get result
  System replay will have Operation to confirm which operation program
  detected and Operation explanation in human format.

## Interface
![Emoji Calculator](emoji-calculator.png)

docker run -p 5005:80 --name commission-calculator -d -v /media/hafijul233/HDD/WorkDrive/XAMPP/htdocs/Gitlab/Paysera-commission-calculator:/var/www/html/app aashakib/laravel-container:8.0
