# Welcome to Dragon Companion!

This is my full-stack project, showcasing:

-   [CakePHP](https://cakephp.org/) for the backend
-   [VueJS 3](https://vuejs.org/) for the UI
-   [Tailwind CSS](https://tailwindcss.com/) for styling
-   [MySQL](https://webpack.js.org/) for the database

This is a roll-playing game companion application that can be used offline alongside your games to help you with various aspects of running the game as a dungeon master or keeping track of your character as a player.

## Installation

1. Download Docker and/or Docker Desktop
2. Run `docker compose up -d` to generate the images and start up the containers
3. Run `docker exec -it [container_id] bash` to get into the container
4. Run `bin/cake migrations migrate` to create the DB up to the latest schema
5. Run `npm run watch:dev` to watch .ts files and generate the appropriate .js files

For issues for around importing when using Microsoft VSCode in Vue files, follow instructions on: [Volar takeover mode](https://vuejs.org/guide/typescript/overview.html#volar-takeover-mode)

## Testings

### Unit Tests

To run the PHPUnit tests, exec onto the container and then run the command:

```
$ docker exec -it [container id] bash

$ vendor/bin/phpunit
```

### Mutation Testing

To run the mutation tests, provided by Infection, exec onto the container and then run the command:

```
$ docker exec -it [container id] bash

$ vendor/bin/infection --threads=10
```
