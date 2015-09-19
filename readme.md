###Thumbor test

#### Requirement

- php >= 54
- thumbor server
- composer


#### Install

- configure Api VirtualHost
- move to api folder and run `composer install`

#### run

- from root folder run `make -j init` and open the browser at localhost:8000

##### VirtualHost example

```
<VirtualHost *:80>

    ServerName api.favoroute.local

    SetEnv ENV development

    ServerAdmin webmaster@localhost
    DocumentRoot /Library/WebServer/httproot/favoroute/challenge/api/public

    AliasMatch ^/lastest(.*) /Library/WebServer/httproot/favoroute/challenge/api/public/public$1

    <Directory /Library/WebServer/httproot/favoroute/challenge/api/public/>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride None
        Order allow,deny
        Allow from all

        RewriteEngine On

        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ index.php [L,QSA]

    </Directory>

    Header set Access-Control-Allow-Origin "*"

</VirtualHost>
```
