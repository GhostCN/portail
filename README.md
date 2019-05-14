

REQUIREMENTS
=============
Memory requirements
-------------------
Minimum required memory size is `64MB`.
However, while these values may be sufficient for a default Drupal installation, a production site with a number of commonly used modules enabled could require more memory. Typically `128 MB` or `256 MB` are found in production systems.

  **php.ini** (choosen method)

  * Locate the php.ini file used by your web server
  * Edit the `memory_limit` parameter :
  ```config
  memory_limit = 64M ; Maximum amount of memory a script may consume (64MB)
  ```
  **php.ini in the Drupal root folder**

  Add the following line to a php.ini file in your Drupal root folder:
```
memory_limit = 64M
```
This will only work if PHP is running as CGI/FastCGI.

**.htaccess**

Edit the .htaccess file in the Drupal root directory. Look for the section:
```
# Override PHP settings. More in sites/default/settings.php # but the following cannot be changed at runtime.
``` 
and immediately after this add the following line:
```
php_value memory_limit 64M
```
Extensions
----------

Composer
--------
Get Composer in https://getcomposer.org/download/.

Run the command below from the drupal root folder:
```
composer install
```
Settings.php
------------
Copy `sites/default/default.settings.php` file and rename it to `settings.php`.
Find the **database** variable and change the properties with your own.

  * **Disable cache in local development** :
  
     Add these instructions in the settings.php file :
     ```php
     if (file_exists($app_root . '/' . $site_path . '/settings.local.php')) {
       include $app_root . '/' . $site_path . '/settings.local.php';
    }```
  All configurations can be overrided by local development (`settings.local.php`) if available.
  

Database
--------
Create portail database and import BDD/portail.sql file
```
source path/to/portail/BDD/portail.sql
```


AUTOMATED TESTS
===============
The testing framework PHPUnit was added to Drupal 8. SimpleTest is supported but is deprecated.
 * Create a directory called `simpletest` in **sites/default**
 * Make sure that it it is writable by the web server. It's okay to make this directory "world-writeable" : 
   ```
     chmod 777 sites/default/simpletest
   ```
**Unit Tests**

Run the unit tests with the following command :
```
vendor/phpunit/phpunit/phpunit  -c phpunit.xml --testsuite unit
``` 
 * With JUnit report :
 ```
  --log-junit 'reports/unitreport.xml'
 ```
 * With Clover coverage :
 ```
 --coverage-clover 'reports/coverreport.xml'
 ```
**Functional tests**
