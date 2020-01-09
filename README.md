# Submission: Lumen framework setup steps
It is photos app for managing user's draft & published photos.

Framework - Lumen (https://lumen.laravel.com/docs/6.2)
1) Setup local dev environment taking reference of above link (PHP >= 7.1.3 & MySQL > 5.6)
2) Copy .env.example to .env file & use your configuration (Create database & provide required details) update into .env files
3) Execute "composer update" in terminal to download project specific dependencies (vendor folder, Reach to you poject folder for executing this cmd)
4) Execute "php artisan migrate:fresh" in terminal to setup tables (Reach to you poject folder for executing this cmd)
5) Created below set of api given set of features:
    - For Guest User:
        - Register (/api/register)
        - Login (/api/login)
        - Get All Users (/api/users)
        - Get User Profile (/api/users/1)
        - Get All Photos (Published only) (/api/photos?order=desc&user_id=1) [-- With sorting on published date & filter of user]
        - Get Photo Detail (/api/photos/profile/1)

    - For Authenticated User:
        - Upload Photo (/api/photos/upload)
        - Save Photo (/api/photos) [ -- status = Draft/ Published]
        - Update Photo Caption (/api/photos/update-caption)
        - Publish Photo (/api/photos/publish)
        - Get All My Photos (Published + Draft) (/api/photos/self) 
        - Get All My Photos (Draft) (/api/photos/self/drafts) 

6) Technical implementation details:
    - Created Migrations consists of below table schemas (/database/migrations/)
        - users
        - photos

    - Created Controllers (/app/Http/Controllers) (Can also injected Repositories for communication with DB - Decoupled database layer from Controller)
        - AuthController
        - UserController
        - PhotoController

    - Created Models (/app/Models) 
        - User.php
        - Photo.php

    - Created Middleware (/app/Http/Middleware) - For checking access control on the prepared routes through valid set authentication guard
        - Authenticate.php

    - Defined required set of routes (/routes/) - For defining appropriate control flow after receiveing requests & used associated http verbs for api methods.
        - web.php

