# Project

## Requirements

- PHP 8.3
- MySQL 8.x
- Composer >= 2.0
- Node 20.x (run `nvm use` in project root)


### Laravel

- Run: `composer install`
    - When asked to log in with Satis credentials, you may abort by entering twice to fall back to use SSH.
        - Make sure you've cloned the project with SSH and your local device has SSH access to your GitHub as well.
        - You must have access to the Artcore Society organization on GitHub for cloning our custom packages.
    - If cloning packages through SSH doesn't work please refer to the [Satis wiki guide](https://my.wearecelestial.group/wiki/satis-project-setup).
- Create an environment file and fill in the details: `cp .env.example .env`
    - You may find API keys and credentials for services inside Laravel Forge. (see deployment below)
    - Note that all credentials should always be stored in the correct project.
    - Archive or delete cards when data is redundant.
- Create a virtual host to run the project:
    - The recommended approach is using [Laravel Valet](https://laravel.com/docs/valet).
    - When the site does not run on your default PHP version, please see Valet's [site isolation](https://laravel.com/docs/valet#php-versions).
    - Prefix `php`, `artisan` and `composer` commands with `valet` to use the correct PHP version.
    - Add your local url is added to `/etc/hosts` (macOS) for your localhost IP Address when the site should communicate with other local sites.
- Generate an app key: `php artisan key:generate`.
- Migrate databases: `php artisan migrate:fresh --seed`.
    - Laravel will suggest to automatically create the DB when it doesn't exist yet.
- Run `php artisan storage:link`.
- Run `yarn install` followed by `yarn build`.

### Queue

Run the following command to start queue workers

```sh
php artisan queue:work --queue=default
```

### Tinkerwell

When the project does not run on your default PHP version, you'll need to use the correct PHP Binary for Tinkerwell. For example, you can find the PHP binary in: `/usr/local/opt/php@8.x/bin` for Brew installed versions.

## Migrations

- During initial development, migrations are held in one file per database table.
- Database entities must have seeders providing test data with Faker.
- Locally, `php artisan migrate:fresh --seed` can be run.
- After deployment database updates are made through individual migrations.
- Migrations can be cleaned up in the future by using the [schema:drop](https://github.com/laravel/framework/pull/32275) Artisan command.

## Development

Git flow is used for local development:
- Features start out as `feature/feature-name` from the `master` branch.
- Bugs and small changes/improvements start out as `hotfix/name` from the `master` branch.
- The production environment is maintained with the latest commit of `master`. The master branch must always work to be deployed at any moment!

When using [Redis](https://laravel.com/docs/redis), please always use accessors for using keys while working with data. For example, see the `accessRequestsKey` accessor inside the `Project` model.
