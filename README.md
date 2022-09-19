## Table of Contents
- [Current Scope](#current-scope)
- [Project Status](#project-status)
- [Installation and Setup Instructions](#installation-and-setup-instructions)
  - [Requirements](#requirements)
  - [Getting The Codebase](#getting-the-codebase)
  - [Installation & Configuration](#installation&configuration)
- [Available Scripts](#available-scripts)
  - [composer dump-autoload](#composer-dump-autoload)
  - [composer test](#composer-test)
- [License](#license)

## Current Scope

An API used to manipulate products.

## Project Status

This project is currently in development. Users now can Add new product, List products, and Mass delete existing ones.

## Installation and Setup Instructions

You need the following requirements installed globally on your machine.

## Requirements
- PHP >= 7.4.0
- MySQL Server version 5.6 or higher.
- Composer: 2.3.10 or higher.
- Web Server: Apache2 or preferably NGINX in case of creating virtual host instead of the PHP lightweight simple server that listens on a specific port rather than the default port 80.

### Getting The Codebase:

The simplest way to obtain the code is using the github .zip feature. Click [here](https://github.com/ahmadSaeedGoda/scandiweb-backend/archive/refs/heads/master.zip) to get the latest stable version as a .zip compressed file.

The recommended way is using `git`. You'll need to make sure `git version ~2.34.1` is installed on your machine. Use a terminal or Power Shell to visit the directory where you'd like to have the source code, then type in:
```sh
$ git clone https://github.com/ahmadSaeedGoda/scandiweb-backend.git
```

### Installation & Configuration:
- <b>Step 1:</b> Get the code. "As explained [above](#getting-the-codebase)".
- <b>Step 2:</b> Use Composer to install dependencies. Navigate to the root directory of the project you cloned or downloaded then run the following command to install required dependencies.
```sh
$ composer install
```
- <b>Step 3:</b> Create & Configure your database.<br>
If successfully the first two steps have been finished, now you can create the database on your database server(MySQL). Refer to this path in the project `src/Database/migration/create_schema.sql`, open the file, copy the contents of this file then paste into your preferred DB console. A MYSQL Wrokbench or something similar would be a perfect tool. Please note that there is no need to previously create a database as this file takes care of that by creating a new DB called `scandiweb`. In case that name is taken you can change the DB name in the file before importing it or even create your DB after commenting out that very first line of the file.
Also change the second line to match your created DB name.

- <b>Step 4:</b> Set the Environment Variables. Find the file named `.env.example` in the root directory of the project. Copy the file then rename the new one `.env` then set the environment variables listed below with values accroding to your environment respectively:
    - MYSQL_DB_DRIVER
    - MYSQL_DB_HOST
    - MYSQL_DB_PORT
    - MYSQL_DB_DATABASE
    - MYSQL_DB_USERNAME
    - MYSQL_DB_PASSWORD
    - DEBUG=TRUE (or FALSE)
    - APP_ENV=development  (or `production` while hosting).
    Please note that this project uses `Dotenv` lib to handle loading those vars during development. While hosting the project kindly consult your respective hosting provider to figure out how&where to set those vars with respective values.

Finally refer to the [Available Scripts](#Available-Scripts) section for more info.

## Available Scripts

In the project directory, you can run:

### `composer dump-autoload`

Fixing the autoloaded files as well as namespaces. Troubleshooting slowness of performance.<br>

Open [http://www.your-virtual-host.local](http://www.your-virtual-host.local) or simply however you specify to run the app to visit the endpoints in an API client such as `postman`, `insomnia` or even `curl`.

<br>Note: A shared postman collection is included in the source code root directory, this can be imported and ready to use after changing the `url` as per your env.

### `composer test`

Launches the test runner in the interactive watch mode.

## License
This is free software distributed under the terms of the WTFPL license along with MIT license as dual-licensed, You can choose whatever works for you. Please review the LICENSE.md file included for this purpose.