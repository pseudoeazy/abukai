## ABUKAI ENGINEERING PROJECT EXERCISE/TEST

A platform for creating Customers, looking up customer via email, a web calculator controlled via Iframes and screen sharing application.

## Tasks

- Customer Information Entry Form
- Customer Information Review Page based on email lookup
- Mini Pocket Calculator as part of customer information review page
- Screen share utility on customer information page
  
## Pages

- `Customer Information Entry Form page ` - https://extension.gosheny.org
- `Customer Information Review Page based on email lookup` - https://extension.gosheny.org/index.php?route=customer/review
- `screen-share app (simulated)` - https://extension.gosheny.org/app/assets/screen-share.html



## Setup Locally
- `install xampp`
- `clone repo`
- `put repo htdocs directory`
- `repo directory should be named abukai`
- `composer require`
- `create database and upload the SQL file`
- `open app/config.php and update if directory/host differs`
- `open app/classes/Models/Iconnect.php and update DB connection details`
- `type http://localhost/abukai in the browser to view app`

## RUN Test Locally
Run the following commands on the terminal
- `npm install` 
- `npm run test`
- `./vendor/bin/phpunit`
