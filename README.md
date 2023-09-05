# Welcome to Dragon Companion!

This is a dungeons and dragons companion application that can be used alongside your games to help you with various aspects of running the game as a dungeon master or keeping track of your character as a player.

This project has been created using:

-   [CakePHP](https://cakephp.org/)
-   [Webpack](https://webpack.js.org/)

## Installation

1. Download Docker and/or Docker Desktop
2. Run `docker compose up -d` to generate the images and start up the containers
3. Run `docker exec -it [container_id] bash` to get into the container
4. Run `bin/cake migrations migrate` to create the DB up to the latest schema
5. Run `npm run watch:dev` to watch .ts files and generate the appropriate .js files
6. Generate the CSS files from the SCSS
