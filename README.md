### Composer

The fastest way to install Phinx bundle is to add it to your project using Composer (http://getcomposer.org/).

1. Install Composer:

    ```
    curl -sS https://getcomposer.org/installer | php
    ```

1. Require Phinx bundle as a dependency using Composer:

    ```
    php composer.phar require mvrhov/phinx-bundle
    ```

1. Install bundle:

    ```
    php composer.phar install
    ```
    
2. Add bundle to `app/AppKernel.php`

    ```php
        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            // ...

            if ('dev' === $this->getEnvironment()) {
                // ...
                $bundles[] = new \mvrhov\PhinxBundle\mvrhovPhinxBundle();
            }
        }
    ```
    
3. Add bundle config to `app/config/config_dev.yml`
   Example:
   
   ```yml
   mvrhov_phinx:
       adapters:
           mysql: Phinx\Db\Adapter\MysqlAdapter
   environment:
       connection:        
           adapter: mysql
           host: '%database_host%'
           port: '%database_port%'
           name: '%database_name%'
           user: '%database_user%'
           pass: '%database_password%'
           charset: UTF8
   ```
   See `DependencyInjection/Configuration.php` for full list of available options.
