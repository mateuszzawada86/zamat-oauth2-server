# Zamat OAuth2 Server Bundle
OAuth2 Server Bundle for Symfony 3, built on the [oauth2-server-php](https://github.com/bshaffer/oauth2-server-php) library.

## Getting Started
For documentation specific to this bundle, continue reading below.

## Bundle Overview
The following grant types are supported out the box:

1) User Credentials Grant Type ( Get access token for given user )
```ini
POST /oauth/v2/token
Content-Type : application/x-www-form-urlencoded
grant_type=password&client_id={api}&client_secret={api}&username={admin}&password={admin}&scope={profile}
```

2) Client Credentials ( Get access token for given client with scope )
```ini
POST /oauth/v2/token
Content-Type : application/x-www-form-urlencoded
grant_type=client_credentials&client_id={api}&client_secret={api}&scope={profile}
```

3) AuthorizationCode ( Get access token by authorization code)
```ini
POST /oauth/v2/token
Content-Type : application/x-www-form-urlencoded
grant_type=authorization_code&client_id={api}&client_secret={api}&code={code}&redirect_uri={uri}
```

4) Authorization Flow for 3part application : 
```ini
GET /oauth/v2/authorize?client_id={api}&response_type={code}&scope={profile}&state={state}&redirect_uri={uri}
```

5) UserInfo endpoint
You can get userinfo for given access token. 
```ini
GET /oauth/v2/me
-h Authorization: Bearer {token}
```

## Installation

### Step 1: Install Standard Symfony Application 
``` bash
$ composer create-project symfony/framework-standard-edition my_project_name 
```

### Step 2: Install Zamat Packages
Use composer to add the requirement and download it by running the command:
``` bash
$ composer require zamat/zamat-oauth2-server dev-master; 
```

### Step 3: Register Bundles
``` php
<?php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
         new Zamat\Bundle\OAuth2ServerBundle\ZamatOAuth2ServerBundle(), 
    );
}
```

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

Create or update database Schema.
``` bash
   php bin/console doctrine:database:create
   php bin/console doctrine:schema:update --force
```
or
``` bash
   php bin/console doctrine:schema:update --force
```


### Step 7: Use Doctrine Fixture Bundle
You can use Doctrine Fixture Bundle to load some entity into database

``` php
<?php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
         new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle() 
    );
}
```
``` bash
   php bin/console doctrine:fixtures:load
```

### Step 8: Override service configuration for oauth server
You can override service providers by adding service name into configuration params:
``` yaml
# app/config/config.yml
zamat_oauth2_server:
    zamat_oauth_user_provider: custom.zamat_oauth.user.provider
    zamat_oauth_client_provider: custom.zamat_oauth.client.provider
    zamat_oauth_scope_provider: custom.zamat_oauth.scope.provider
    zamat_oauth_authorization_code_provider: custom.zamat_oauth.authorization.code.provider
    zamat_oauth_access_token_provider: custom.zamat_oauth.access.token.provider
    zamat_oauth_refresh_token_provider: custom.zamat_oauth.refresh.token.provider    
    zamat_oauth_client_publickey_provider: custom.zamat_oauth.client.publickey.provider
```

