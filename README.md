**Motivation**

1. In many cases there is no possibility to access logs via console in prod environment
2. Databases provides easy filtering and search
3. Web provides more human readable look

**Installation**

`composer require webjaros/symfony-log-reader-bundle "0.*"`

**Enable the Bundle**

```
// app/AppKernel.php
// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...
            new WebJaros\SymfonyLogReaderBundle\WebJarosSymfonyLogReaderBundle(),
        ];
        // ...
    }
    // ...
}
```

**Migration**

Run
```
bin/console doctrine:migration:generate
php bin/console doctrine:schema:update --dump-sql
```

Copy
```
CREATE TABLE webjaros_symfony_log_record ....
```

Include this query to your newly generated migrations file and run
```
bin/console doctrine:migration:migrate
```

**Schedule**

Use your favorite cron manager
```
* * * * * $pathToTheApp/bin/console webjaros:symfony-log
```

**Sonata Admin**

Default action is just to import services.yml from the bundle:
```
// app/config/services.yml
- { resource: '@WebJarosSymfonyLogReaderBundle/Resources/config/services.yml' }
//...
```

Extend `WebJaros\SymfonyLogReaderBundle\Admin\RecordAdmin` and define your own service for advanced actions.
