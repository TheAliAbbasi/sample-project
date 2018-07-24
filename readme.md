###What is this?
This is a sample project, which includes a minimal process for login/register users with phone number. Besides there's a small api for category and post behind this authentication

###How Can I use it?
First off you need to have git, composer and docker installed on your computer.
1. ```git clone https://github.com/TheAliAbbasi/sample-project.git```
2. ```composer install```
3. ```cp .env.example .env```
4. ```docker-compose up -d```

Now, the project is up and running on localhost:8080
you can import the postman project that is included to see all the routes and start testing

Have fun!

##CAUTION!!!
login process sends verification code in response of login request. Of course that's for the purpose of being a sample. if you want to use this in your production make sure to send verification code in another way (SMS, Email, ...)
