# Project README #

This is a custom theme for wordpress. The theme uses webpack 4 to run hot reload and build tasks for SCSS and javascript. This works best when the development environment is setup in MAMP, XAMPP or LocalWP, and the `vhosts` are enabled in case of MAMP or XAMPP or similar local dev environments.

## Environment Dependencies

This theme will run in a local dev environment with [LocalWp](https://localwp.com/), [MAMP](https://www.mamp.info/), etc where vhosts can be enabled to have domain name with the `port 80` to run the pages. For the rest of the documentation let us consider that our project will run on the URL `example.site`. Please configure your vhosts accordingly to ensure that the domain names can be used in the browser for local dev.
Please ensure that Node v12 is the current version. To easily switch between node versions consider using [nvm](https://github.com/nvm-sh/nvm) and can be installed globally by homebrew.

## Installation

Please follow the steps below to run the site locally -

1. Install the latest version of wordpress to your project directory.
2. Once the installation is complete, delete `wp-content` directory.
3. Clone the repo to the root of project. The project will pull the `wp-content` directory without the `uploads` folder. The repo does not track the `wp-config.php` file as well.
4. Download the SQL dump from the server. Replace the project URLs in the sql dump with your local project URL.
5. Replace the database installed with the new database dump. Please be careful about the credentials in `wp-config.php` and the `table_prefix`. If any change in the table_prefix update the wp-config.php accodingly.
6. Go to `wp-content/themes/wp-framework/config/local.js`. Update the values for `host` and `proxy` in the json as per your project.
7. Open the terminal and browse to the theme directory to run the task commands. Install the dependencies listed in `package.json` by running `npm ci`. Once all the dependencies are installed run `npm run build` to create an initial build of the theme. This would create a new directory under the `themes` directory called `shady-theme` if everything goes well.
8. Download the `wp-content/uploads` directory from the server and add to the project.
9. To run the website in the dev mode with hot reload of the css and javascript run `npm run start` from inside the `wp-framework`.

## Notes on the theme

1. All development should be done in the wp-framework directory.
2. To install a new dependency from by npm, please stop and restart the webpack using `npm run start`.
3. All javascript and SCSS are to kept inside `wp-framework/src`.
4. The `app.scss` is for the theme frontend styles while `admin.scss` for the theme backend custom pages visible only in the wp-admin sections.
5. Similarly the `index.js` is for the theme frontend javascript while `admin.js` for the theme backend custom pages visible only in the wp-admin sections.
6. The custom font files if any and images go inside the `wp-framework/static/assets/` into their respective directories.
7. To create a production build run `npm run build` and replace the entire `shady-theme` directory in the remote server.

## License

Its a shadystuffs stuff with loads of love!
