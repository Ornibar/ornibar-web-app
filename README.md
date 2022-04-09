# Ornibar

## Description 

Ornibar Wep App (Admin Panel + Api php);

## API : 

### Methods : 

GET, POST, PUT, DELETE

### Routes :

Base url '/api/' : 

'auth' : 
  - /login (POST)
      - Params : 
        - username: String
        - email: Email
  - /register (POST)
      - Params :
        - firstname: String,
        - lastname: String,
        - username: String
        - email: Email,
        - password: String,
        - password_confirmation: String
  - /reset-password (POST)

'user' : 

  - /profile (GET)
  - /update-profile/{user:id} (PUT)
      - Params: 
        - username: String
        - email: Email
  - /update-score/{user:id} (PUT)
      - Params: 
        - score: Integer
  - /update-profile-image/{user:id} (PUT)
      - Params: 
        - file: File
  - /destroy/{user:id} (DELETE)

'question' : 

  - /question/questions (POST)
      - Params: 
          numberQuestions: Integer


## COMMANDS

Create the database 'ornibar_web_app'.

Install the modules with

```console
    npm install
```

```console
    composer install
```

Create a key for the .env

```console
    php artisan key:generate
```

Start the migration : 

```console
    php artisan migrate
```

Then run the project with it

```console
    php artisan serve
```


  
  
  
  
  
