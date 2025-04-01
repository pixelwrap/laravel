# PixelWrap for Laravel

**PixelWrap** allows you to quickly build dynamic front-end of your application using simple YAML schemas. No need to write individual HTML components—just define your UI structure in a YAML file, and let **PixelWrap** do the rest of thw work for you. It will handle creation the layouts, related components, and user interactions for you.

With built-in support for **Tailwind CSS**, **PixelWrap** streamlines the process of building user interfaces, saving developers time and effort.
PixelWrap ensures that the final product is both visually appealing and highly functional, without sacrificing design integrity or user interaction quality. Perfect for developers who want to move quickly and efficiently.

### More information can be found at [PixelWrap](https://github.com/pixelwrap/pixelwrap)

## Installation

Install **PixelWrap** via Composer by running the following command:

```bash
composer require pixelwrap/laravel
````
## Publish the Assets
Once the package is installed, you need to publish the necessary assets, such as configuration files and views.

Run the following Artisan command to publish the assets:
```shell
php artisan vendor:publish --provider="PixelWrap\Laravel\PixelWrapServiceProvider"
```
This will publish the configuration file into your Laravel application.

## Add the PixelWrap Container
In your main layout Blade file (example `resources/views/layouts/app.blade.php` or a similar location), add the following code where you’d like to display the generated UI content:
```bladehtml
<main class="mt-6">
    @yield('pixelwrap-container')
</main>
```

## Configuration
Configure the behavior of PixelWrap by modifying the `config/pixelwrap.php` file. Set the blade html template file to `page-root`. For example if my template is `app.blade.php` set it to 'app' as show below.
```php
return [

    /*
    |--------------------------------------------------------------------------
    | PixelWrap configuration
    |--------------------------------------------------------------------------
    |
    | PixelWrap offers different types of frontends
    | The default frontend framework is defined below.
    |
    */

    'theme' => "tailwind",
    'page-root' => 'app',
];

```

You can modify these settings based on your project’s design requirements.

## Integrating Tailwind CSS
### Add PixelWrap and YAML File Paths to Tailwind Configuration
To ensure live reloading when editing the `yaml` templated and avoid purging the required CSS during production builds, you need to update the content array in your `tailwind.config.js` file. This will ensure Tailwind picks up the package and YAML files correctly.
```js
module.exports = {
    darkMode: 'class', // Dark mode support.
    content: [
        /* Your existing config */
        // Our config next
        './vendor/pixelwrap/laravel/resources/**/*.php',
        './resources/**/*.yaml',
        // Add any other paths where your content lives
    ],
}
```

### Tailwind dark mode and light mode support.

Where you have your javascript files include this in your imports.

```
import '../../vendor/pixelwrap/laravel/resources/js/tailwind.js'
```

Optionally, Add this inline in `head` tag to avoid FOUC

```js
if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
} else {
    document.documentElement.classList.remove('dark')
}
```

## Getting Started

Once you have installed PixelWrap, you can start creating your YAML schema to define your UI. Here’s a step-by-step guide:

### 1. Create Your First YAML Schema
All schemas files should go under `resources\pixelwrap\` directory
You can define your UI structure in a YAML file. Below is an example schema:
Lets call is ```account.yaml```
```yaml
type: Grid
cols: 3
nodes:
    - type: Input
      id: name
      label: 'Full Name'
      fieldType: text
    - type: Input
      id: email
      label: 'Email Address'
      fieldType: email
    - type: Select
      id: role
      label: 'User Role'
      options:
          admin: 'Administrator'
          user:  'Accountant'
          customer: 'Customer'
```
This schema will generate a grid with three columns, containing an input for name, email, and a dropdown for user roles.

Now create a rew route in `web.php` and navigate your browser to your web application `/`

```php
use Illuminate\Support\Facades\Route;
use PixelWrap\Laravel\Facades\PixelWrapRenderer;

Route::get('/', function (PixelWrapRenderer $res) {
    return $res->render('test');
});

```

## Documentation

For a detailed guide on how to create and customize your YAML schemas, as well as more examples of UI components, visit the official [PixelWrap Documentation](https://github.com/pixelwrap/pixelwrap).

# Contributing
To set up your development environment and contribute to the project.

## 1. Create a New Laravel Project

First, you need to create a new Laravel project. If you don’t have Laravel installed globally, install it via Composer:

```shell
composer global require laravel/installer
```

Once Laravel is installed, create a new Laravel project by running:

```shell
laravel new pixelwrap-project
cd pixelwrap-project
```
Alternatively, you can use Composer to create the Laravel project:

```shell
composer create-project --prefer-dist laravel/laravel pixelwrap-project
cd pixelwrap-project
```

## 2. Setup the `packages/pixelwrap` directory

Create the directory
```shell
mkdir -p packages/pixelwrap
```

Clone this repository locally
```shell
git clone git@github.com:pixelwrap/laravel.git packages/pixelwrap/laravel
```
### 3. Add the Repository to `composer.json` of the newly created project.
```json
"repositories": [
    {
        "type": "path",
        "url": "packages/pixelwrap/laravel"
    }
]
```

### 4. Install the local dependency via Composer
```shell
composer require pixelwrap/laravel
```
This will install the `pixelwrap/laravel` package from your local directory.

### 5. Working on your new feature
Create a New Branch for Your Work
```shell
git checkout -b your-feature-branch
```
Make your changes in this branch.
All changes made are done inside the `packages/pixelwrap/laravel` directory. You can use the laravel project created to test the new features you are working on. 

### 6. Submit a Pull Request
Once you’re ready to submit your changes:
- Push your branch to your forked repository `git push origin your-feature-branch`
- Open a pull request to the main repository’s main branch.

Thank you for contributing! We appreciate your help in improving the PixelWrap.

If you have any questions or run into issues, feel free to ask for help in the issues section of this repository.
