# WordPress Events GraphQL API

This project sets up a WordPress environment using Docker and Docker Compose to manage a WordPress backend with a MySQL database and phpMyAdmin interface. It includes a custom plugin (`event-plugin`) that registers an "Online Event" post type and exposes it via WPGraphQL.

## Features

- **WordPress Setup**: The backend runs on WordPress, with WPGraphQL for exposing content via a GraphQL API.
- **MySQL Database**: MySQL is used to store all WordPress data, including the custom post type.
- **phpMyAdmin**: A web-based interface to manage and view the database.
- **GraphQL API**: WPGraphQL is installed to expose the "Online Events" custom post type.

## Prerequisites

Ensure you have Docker and Docker Compose installed on your machine.

- [Docker Installation Guide](https://docs.docker.com/get-docker/)
- [Docker Compose Installation Guide](https://docs.docker.com/compose/install/)

## Setup

### Step 1: Clone the Repository

Clone this repository to your local machine:

```bash
git clone https://github.com/joshbarros/wordpress-events-api.git
cd wordpress-events-api
```

### Step 2: Run Docker Compose
To start the WordPress, MySQL, and phpMyAdmin containers, run the following command in the root directory of the project:

```bash
docker-compose up -d
```

This will:

- Start WordPress on [http://localhost:8080](http://localhost:8080)
- Start phpMyAdmin on [http://localhost:8081](http://localhost:8081)

WordPress will be configured with the following:

- **Database Host**: `db`
- **Database Name**: `wordpress`
- **Database User**: `wordpress`
- **Database Password**: `wordpress`

## Step 3: Access WordPress

Once Docker Compose has set up the containers, go to [http://localhost:8080](http://localhost:8080) in your browser to complete the WordPress setup.

## Step 4: Access phpMyAdmin

You can access phpMyAdmin at [http://localhost:8081](http://localhost:8081). Log in using:

- **Username**: `root`
- **Password**: `rootpassword`

## Step 5: Activate Plugins

1. **WPGraphQL**: After setting up WordPress, log in to the admin dashboard ([http://localhost:8080/wp-admin](http://localhost:8080/wp-admin)), go to **Plugins**, and activate **WPGraphQL**.
2. **Event Plugin**: Activate the custom `event-plugin` in the same **Plugins** section.

## Step 6: Test the GraphQL API

Once WPGraphQL is activated, go to [http://localhost:8080/graphql](http://localhost:8080/graphql) and query the online events using the following GraphQL query:

```graphql
{
  onlineEvents {
    nodes {
      id
      title
      onlineEventDate
      onlineEventDescription
    }
  }
}
```

## Preserving WordPress Data

By default, Docker volumes are used to store persistent data in the MySQL database. This means that after setting up WordPress the first time, the next time you run `docker-compose up`, your WordPress installation and data (including plugins, custom post types, etc.) will still be there.

If you want to **reset** WordPress (delete all data and start fresh), you can remove the Docker volumes by running:

```bash
docker compose down -v
```

This will stop the containers and delete the MySQL database volume. You will need to set up WordPress again by completing the installation steps after restarting the containers.

## Creating an Online Event

To create a new "Online Event" item in WordPress:

1. Log in to your WordPress Admin Dashboard at [http://localhost:8080/wp-admin](http://localhost:8080/wp-admin).
2. In the left-hand sidebar, look for the "Online Events" option.
3. Click on **Add New** under the "Online Events" section to create a new event.
4. Enter the **Title**, **Date**, and **Description** for the event.
5. Publish the event, and it will be available via the GraphQL API.

You can then query the event using the GraphQL endpoint at [http://localhost:8080/graphql](http://localhost:8080/graphql).
