# Submission: Lumen framework setup steps
It is photos app for managing user's draft & published photos.

Framework - Lumen (https://lumen.laravel.com/docs/6.2)
1) Setup local dev environment taking reference of above link (PHP >= 7.1.3 & MySQL > 5.6)
2) Copy .env.example to .env file & use your configuration (Create database & provide required details) update into .env files
3) Execute "composer update" in terminal to download project specific dependencies (vendor folder, Reach to you poject folder for executing this cmd)
4) Execute "php artisan migrate:fresh" in terminal to setup tables (Reach to you poject folder for executing this cmd)
5) Created below set of api given set of features:
5.1) For Guest User:
5.1.1) Register (/api/register)
5.1.2) Login (/api/login)
5.1.3) Get All Users (/api/users)
5.1.4) Get User Profile (/api/users/1)
5.1.5) Get All Photos (Published only) (/api/photos?order=desc&user_id=1) [-- With sorting on published date & filter of user]
5.1.6) Get Photo Detail (/api/photos/profile/1)

5.2) For Authenticated User:
5.2.1) Upload Photo (/api/photos/upload)
5.2.2) Save Photo (/api/photos) [ -- status = Draft/ Published]
5.2.3) Update Photo Caption (/api/photos/update-caption)
5.2.4) Publish Photo (/api/photos/publish)
5.2.5) Get All My Photos (Published + Draft) (/api/photos/self) 
5.2.6) Get All My Photos (Draft) (/api/photos/self/drafts) 

6) Technical implementation details:
6.1) Created Migrations consists of below table schemas (/database/migrations/)
6.1.1) users
6.1.2) photos

6.2) Created Controllers (/app/Http/Controllers) (Can also injected Repositories for communication with DB - Decoupled database layer from Controller)
6.2.1) AuthController
6.2.2) UserController
6.2.3) PhotoController

6.3) Created Models (/app/Models) 
6.2.1) User.php
6.2.2) Photo.php

6.3) Created Middleware (/app/Http/Middleware) - For checking access control on the prepared routes through valid set authentication guard
6.3.1) Authenticate.php

6.4) Deoned required set of routes (/routes/) - For defining appropriate control flow after receiveing requests & used associated http verbs for api methods.
6.3.1) web.php

