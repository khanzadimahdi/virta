# Electric vehicle charging station management system

## Summary
This is an application to manage Electric vehicle chargning stations.
It also provides the ability to find multiple stations that belogs to different companies.

## Features Overview
* Fully isolated and dockerized application
* Infrastructure level logs(Web server logs)
* Quality assured by having different test types (Feature/Unit)
* Descriptive API documentation powered by Swagger

## Installation guide
There are two ways to run the application. Both of them start by cloning the repository into your local machine.

### Clone the project
Clone this repository to your local machine using the following command:

```bash
git clone git@github.com:khanzadimahdi/virta.git
```

### Environment variables
There is a `.env.example` file in the project root directory containing OS level environment variables that are used for deploying the whole application.
Every single variable inside the file has a default value, so you do not need to change them; But you can also override your own variables. First copy the example file to the `.env` file:

```bash
cd /path-to-project
cp .env.example .env
```
Then open your favorite text editor like `vim` or `nano` and change the variables.

### Setting up project in your local environment
For the first time you need to do some initial setup. It can be done by running following command:

```bash
make setup
```

then (by default configs) the API will be exposed on http://127.0.0.1:80 and swagger document is available on http://127.0.0.1:8080
you can also take a look at `wiki/swagger.yaml` for API details.

there is a **simple UI (api consumer)** and by default exposes on http://127.0.0.1:8000

### Running containers via native docker APIs
Open `Terminal` and type the following command:

```bash
make up
```

or

```bash
docker-compose up -d
```

#### Installing the dependencies
Make a ssh connection to the `web` container using one of these ways:  

1. ```
   make bash
   ```  
  
2. ```
   docker-compose exec web bash
   ```

#### Generating swagger documentation:
Connect to the `web` container via ssh as described in the step above.
Run the following command to generate swagger documentation:

Inside container:

```bash
openapi ./app -o wiki/swagger.yaml
```

Outside container:

```bash
make openapi
```

## Technical discussions (Images/Containers)
This project includes seven docker containers as follows.
It is under development, So the source code is mounted from the host to containers. On production environment you should remove these volumes.

`web`
php:8.0.14-apache

`mysql`
mysql:8.0.27

`redis`
redis:6.2.6-alpine3.15

`mailhog`
mailhog/mailhog:latest

`swagger`
swaggerapi/swagger-ui

## Author
[Mahdi Khanzadi](https://github.com/khanzadimahdi/)

## Licence
[MIT](https://choosealicense.com/licenses/mit/)
