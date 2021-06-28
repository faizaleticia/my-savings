# My Savings Project

My Savings is an online finance management platform, which allows its users to have access to all their active accounts, whether bank or not, from anywhere in Brazil and the world, free of charge. Thus, the platform is useful not only for spending less, but also for saving and investing more and more money.

## Environment design

## Server

The server API was develop using PHP as language and Laravel as framework.

## Web

The web application was develop using Javascript as language and Vue.js as framework.

## Operation System

The system operation used in:

- **Github Actions:** the latest version of Ubuntu
- **Docker files:**
  - **Web:** the latest version of Ubuntu
  - **Server:** the latest version of Ubuntu
  - **Database:** the latest version of Ubuntu
- **Server:** Ubuntu version 20.04.2 LTS

## Database

My Savings project use MySql as database. The MySQL Database is the most popular open source database of the world, because it has consistency, high performance, reliability and it's easy to use.

## Change control tools

To organize and prioritize the tasks, was used from Github Projects tool. In this tool, it was elaborated an adapted Kanban board for the workflow of the project. The created columns are:

- **Backlog:** In this column are available the tasks in the form of an idea, that is, Nessa coluna são disponibilizadas as tarefas na forma de ideia, ou seja, the tasks that have not yet been approved for development and will be discussed in a meeting.
- **To do:** In this column are placed the tasks that must be done. The order of tasks is carried out by delivery priority, so the most urgent will always appear at the top of the list.
- **Doing:** This column lists the tasks that are in progress in the project.
- **Waiting:** This column displays tasks that are waiting for some action, such as client validation.
- **Done:** In this column are all the tasks already completed for the project. The order of tasks is carried out by completion, so the last finished will be at the top of the list.

## Integration tool

## Test tools

The Laravel framework is built to support testing with PHPUnit, it is already set up for the application.

### Running Tests

To run the tests, use phpunit:

```sh
./vendor/bin/phpunit
```

or:

```sh
php artisan test
```

## Other tools
