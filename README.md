# Zamat OAuth2 Server Bundle

OAuth2 Server Bundle for Symfony 2, built on the [oauth2-server-php](https://github.com/bshaffer/oauth2-server-php) library.

## Getting Started

For documentation specific to this bundle, continue reading below.

## Bundle Overview

The following grant types are supported out the box:

- Client Credentials
- Authorization Code
- Refresh Token
- User Credentials (see below)

1)
Password Grant Type ( Get access token for given user )

POST /oauth/v2/token
Content-Type : application/x-www-form-urlencoded
grant_type=password&client_id=api&client_secret=api&username=admin&password=admin&scope=profile

2)
Client Credentials( Get access token for given client with scope )
POST /oauth/v2/token
Content-Type : application/x-www-form-urlencoded
grant_type=client_credentials&client_id=api&client_secret=api&scope=profile

3) 
AuthorizationCode ( get access token by autorization code)
POST /oauth/v2/token
Content-Type : application/x-www-form-urlencoded
grant_type=authorization_code&client_id=api&client_secret=api&code=f6808b9b6c4db1ddf89ffd1b6e425cd9c44effc1

4) Authorization Flow : 
GET /oauth/v2/auth?client_id={api}&response_type={code}&scope=profile&state={state}&redirect_url={http://google.pl}

## Installation

### Step 1: Install Standard Symfony Application
composer create-project symfony/framework-standard-edition my_project_name 

### Step 2: Install Packages
Use composer to add the requirement and download it by running the command:
composer require zamat/zamat-oauth2-server dev-master;  
``` bash
$ php composer.phar require zamat/zamat-oauth2-server dev-master; 
```

### Step 3: Register Bundles
   new Zamat\Bundle\OAuth2ServerBundle\ZamatOAuth2ServerBundle(), 
   new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle()

### Step 4: Add routes

You'll need to add the following to your routing.yml

``` yaml
# app/config/routing.yml

   zamat_oauth2:
     resource: "@ZamatOAuth2ServerBundle/Controller/"    
     type:     annotation
```

### Step 5: Change Security Configuration

You'll need to add the following to your security.yml

``` yaml
# app/config/security.yml

security:
    encoders:
        Zamat\Bundle\OAuth2ServerBundle\Entity\User: bcrypt
    providers:    
        zamat_database_provider:
            id: zamat_oauth2.user_manager
    role_hierarchy:
        ROLE_ADMIN:       [ROLE_GUARD]
        ROLE_GUARD:       [ROLE_USER,ROLE_ACCOUNT_SWITCH]
    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false
        oauth_firewall:
            pattern:    ^/oauth
            anonymous: ~  
            form_login:
                provider : zamat_database_provider
                login_path : _oauth_authorize_login
                check_path : _oauth_authorize_login_check   
            logout:
                path:   _oauth_authorize_logout
                target: /            
    access_control:
        - { path: ^/oauth/v2/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }        
        - { path: ^/oauth/v2/token, roles: IS_AUTHENTICATED_ANONYMOUSLY }        
        - { path: ^/oauth/v2/me, roles: IS_AUTHENTICATED_ANONYMOUSLY }        
        - { path: ^/, roles: IS_AUTHENTICATED_FULLY }
```
### Step 6: Run Command

   - php bin/console doctrine:database:create
   - php bin/console doctrine:schema:update --force
   - php bin/console doctrine:fixtures:load

