## E-LMS

## Steps to install the E-LMS

- Clone the repo
- Extract the file to your desired path
- Required PHP version 8.0
- Install composer
- Install nodejs
- Start XAMPP Control Panel
- Open PHPMYADMIN
- Create a database 'stem'
- Open the project to cmd. Example if your project located at C:\Users\Downloads\stem-mobile copy the path and type in them cmd cd $path
- Once done, run the following commands
- composer update
- npm install
- php artisan key:generate
- php artisan migrate:fresh --seed

## Default Credentials

<b>Admin</b>
<b>Username: </b> admin
<b>Password: </b> password

<b>Teacher</b>
<b>Username: </b> 202300123
<b>Password: </b> password

<b>Student</b>
<b>Username: </b> 202300123
<b>Password: </b> password

## How to run the project

Command

<i>php artisan serve</i>

You can also specify an IP Address <i>php artisan serve --host=your_ip_address</i>