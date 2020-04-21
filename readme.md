## Authors
- Yeasir Majumder <yeasir2148@yhotmail.com>

## Setup
Make sure you have `node`, `npm`, `php`, `composer` and `MySQL` is available in your computer. 
Clone the repo, checkout `master` branch. Run the installation.

```bash
cd [project directory]
git checkout master
cp .env.example .env
composer install
npm install

# Add encryption key
php artisan key:generate
```

Create a **fresh** database name `ydt-local` in mysql (or any db name you want). Then __supply__ your own db credentials in your `.env` file. Example:
```
DB_DATABASE=[database name]
DB_USERNAME=your-awesome-mysql-username
DB_PASSWORD=your-awesome-mysql-password
```

Run migrations
```
php artisan migrate
```

_**Open another terminal/cmd window**_ and compile assets using `npm`
```
npm run watch
```

Go back to the previous terminal and serve the project on port __5000__ (_usually defaults to port 8000, but it might already been used_)
```bash
php artisan serve --port=5000 # or you can use php -S 0.0.0.0:5000 -t ./public
```

## Setup auto-refresh
If you **hate** clicking the refresh button after you made some changes (esp. in `resources` folder) you can setup BrowserSync to autoreload the page
Since we are using laravel-mix, we have support of browser-sync out of the box, if you are using latest version of laravel.
otherwise install browser-sync npm package.


```bash
# Open another terminal then..
npm install -g browser-sync

# Make sure you have artisan serve running on port 5000
browser-sync start --port=5001 --proxy=localhost:5000 --files "./resources/**/*"
```

To make things work with browsersync:

open your .env file and add a constant named MIX_APP_URL and set it's value to your local url, like below:

```
MIX_APP_URL=[your local app url]

```
now in your webpack.mix.js file, make the following changes:

```
const hostname = process.env.MIX_APP_URL;
```
And append the below snippet in your mix configuration/definition:

```
.browserSync({
        open: 'external',
        port: 80,
        host: hostname,
        proxy: hostname,
        files: ['resources/views/**/*.php', 'app/**/*.php', 'routes/**/*.php', 'public/js/*.js', 'public/css/*.css']
    })
```

browserSync is set up to work on port 80, so make sure you are running the project on port 80

Now whenever you make some changes under `resources` folder browser-sync will detect it, auto-compile and reload your project.

## VSCode and XDebug (optional)
If you want a step debugging, Install `vscode-php-debug` extension. You can use these `.vscode/launch.json` setup.
```json
{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for XDebug",
            "type": "php",
            "request": "launch",
            "port": 9000,
            "ignore": [
                "**/vendor/**/*.php"
            ]
        },
        {
            "name": "Launch currently open script",
            "type": "php",
            "request": "launch",
            "program": "${file}",
            "cwd": "${fileDirname}",
            "port": 9000
        }
    ]
}
```

## Tests
... coming soon ..


## Docker setup
...coming soon...


## Deployment
...coming soon...

