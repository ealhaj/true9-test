# Payrolls App

This is the README file for the `payrolls-app` project.

## Getting Started

### Prerequisites

Make sure you have the following tools installed:

- [Docker Desktop](https://www.docker.com/products/docker-desktop)
- [Node.js](https://nodejs.org/)

### Running the API

To run the API using Docker, follow these steps inside the api folder:

1. Build the Docker image (use `--no-cache` to ensure a clean build) <sup>`(required)`</sup>:

    ```bash
    docker compose build --no-cache
    ```

2. Start the containers in the background and wait for them to be ready <sup>`(required)`</sup>:

    ```bash
    docker compose up -d --wait
    ```

3. Install the dependencies using Composer <sup>`(required)`</sup>:

    ```bash
    docker exec -t payrolls-app composer install
    ```
   
4. Copy `.env` for local environment <sup>`(optional)`</sup>:
   ```
   docker cp .env .env.local
   ```

### Running Unit Tests for the API

To run the unit tests for the API, use the following command:

```bash
docker exec -t payrolls-app ./bin/phpunit
```

### OpenAPI Schema

The OpenAPI schema is available at `./openapi/payrolls.yaml`. You can refer to this file to explore existing endpoints and required parameters.

### Running the Frontend Portal

To run the frontend portal, navigate to the `portal` folder and execute the following commands:

1. Install dependencies:

    ```bash
    yarn install
    ```

2. Start the React application:

    ```bash
    yarn start
    ```

This will start the React application on port 3000.

### Running Frontend Tests

To run tests for the frontend application, use the following command:

```bash
yarn test
```
