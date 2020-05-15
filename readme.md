## Authors
- Yeasir Majumder <majumder2148@gmail.com>

## Setup
Make sure you have `node`, `npm`, `php`, `composer` and `MySQL` installed on your computer. 
Clone the repo. Then:

```bash
cd [project directory]
cp .env.example .env
composer install
npm install
```

Set database configurations in the .env file according to your local setting.

````
# Add encryption key
php artisan key:generate
````


Run migrations
```
php artisan migrate
```

_**Open another terminal/cmd window**_ and compile assets using `npm`
```
npm run watch
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



