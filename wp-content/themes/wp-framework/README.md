# README #

This is a custom starter theme for wordpress. The theme uses webpack 4 to run hot reload and build tasks for SCSS and javascript. This works best when the development environment is setup in MAMP, XAMPP or LocalWP, and the `vhosts` are enabled in case of MAMP or XAMPP or similar local dev environments.

## Environment Dependencies

This theme will run in a local dev environment with [LocalWp](https://localwp.com/), [MAMP](https://www.mamp.info/), etc where vhosts can be enabled to have domain name with the `port 80` to run the pages. For the rest of the documentation let us consider that our project will run on the URL `example.site`. Please configure your vhosts accordingly to ensure that the domain names can be used in the browser for local dev.
Please ensure that Node v12 is the current version. To easily switch between node versions consider using [nvm](https://github.com/nvm-sh/nvm) and can be installed globally by homebrew. 

## Installation

Please follow the steps below to run the site locally -

1. Clone the repo to the `./wp-content/themes/`. The dev theme directory is called `wp-framework`. 
2. Go to `wp-framework/config/local.js`. Update the values for `host` and `proxy` in the json.
3. Open the terminal and browse to the theme directory to run the task commands. Install the dependencies listed in `package.json` by running `npm ci`. Once all the dependencies are installed run `npm run build` to create an initial build of the theme. This would create a new directory under the `themes` directory called `jtlb-theme` if everything goes well.
4. Login to the wordpress admin and go to `Appearances > Themes`. Activate the `Aguadulce Wp Theme` and follow steps as mentioned in the admin.
5. To run the website in the dev mode with hot reload of the css and javascript run `npm run start` from inside the `wp-framework`.
6. Move the `.gitignore` file to the root of the wordpress installation and remove git from the theme directory to have the entire wordpress installation under version control.


## Notes on the theme

1. All development should be done in the wp-framework directory.
2. To install a new dependency from by npm, please stop and restart the webpack using `npm run start`.
3. All javascript and SCSS are to kept inside `wp-framework/src`. 
4. The `app.scss` is for the theme frontend styles while `admin.scss` for the theme backend custom pages visible only in the wp-admin sections.
5. Similarly the `index.js` is for the theme frontend javascript while `admin.js` for the theme backend custom pages visible only in the wp-admin sections.
6. The custom font files if any and images go inside the `wp-framework/static/assets/` into their respective directories.
7. To create a production build run `npm run build` and replace the entire `jtlb-theme` directory in the remote server.


## License

Its a Aguadulce stuff with loads of love!