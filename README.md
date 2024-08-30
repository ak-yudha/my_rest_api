# Construction Project Management System

This is a simple RESTful API for Construction Project Management System

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
    - [Create a Project](#create-a-project)
    - [Get a Project](#get-a-project)
    - [Update a Project](#update-a-project)
    - [Delete a Project](#delete-a-project)
- [License](#license)

## Installation

1. Clone the repository:
    ```bash
    git https://github.com/ak-yudha/my_rest_api
    cd my_rest_api
    ```

2. Install dependencies:
    ```bash
    composer install
    ```

3. Run migrations:
    ```bash
    php bin/console doctrine:migrations:migrate
    ```

4. Start the server:
    ```bash
    symfony server:start
    ```

## Usage

### Create a Project

To create a new project, use the following `curl` command:

```bash
curl -X POST http://localhost:8000/project/create \
-H "Content-Type: application/json" \
-d '{
    "name": "New Project",
    "location": "New York",
    "stage": "Planning",
    "category": "Residential",
    "constructionStartDate": "2024-09-01",
    "description": "This is a new residential project in New York.",
    "creatorId": "123456"
}'

curl -X GET http://localhost:8000/project/

curl -X GET http://localhost:8000/project/1

curl -X PUT http://localhost:8000/project/1/edit \
-H "Content-Type: application/json" \
-d '{
    "name": "Updated Project Name",
    "location": "San Francisco",
    "stage": "Construction",
    "category": "Commercial",
    "constructionStartDate": "2024-10-01",
    "description": "Updated project description.",
    "creatorId": "654321"
}'

curl -X DELETE http://localhost:8000/project/1/delete

