# Miniature Asset Manager

a small asset-manager for the basic needs  
Manage your assets and your licenses for multiple locations

## Technology

- REST-API done with the mezzio framework.
- Efficient search with PostgreSQL GIN-index. Shortcomings of the index are avoided via trigger functions and shadow tables.
- No ORM was used in this Project to have more flexible search results

### Requirements

- PHP >=7.4
- PostgreSQL >=12

### Installation
- Use [Composer](https://getcomposer.org/) to install dependencies via `composer install`
- Insert the the database schema `migrations/asset-schema.sql` into your PostgreSQL Installation.
- Copy `config/autoload/local.php.dist` to `config/autoload/local.php` and edit to add the database connection to the return array. E.g.
```
    'database' => [
        'host' => 'localhost',
        'type' => 'pgsql',
        'name' => 'assets',
        'password' => 'magicdockerpostgres',
        'database' => 'assets'
    ]
```


## ToDo's

- [ ] Codeception tests no longer reflect the current state of the API. This needs to be repaired
- [ ] Rename CITRIX on all places with software-license
- [ ] Add GitHub actions for automateded CI
- [ ] Add openAPI specification for the endpoints
