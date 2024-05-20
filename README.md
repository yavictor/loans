## Loans API

Overview

The Loans API is a RESTful service designed to manage loans. It provides endpoints to process loan applications.
Features

-   Loan Application Processing: Submit and process loan information.

Installation

Clone the repository:

    git clone https://github.com/yavictor/loans.git

Navigate to the project directory:
    
    cd loans

Install dependencies:
    
    composer install

Set up the environment variables:
Create a .env file in the root directory and add your configuration:
    
    PORT=3000
    DB_CONNECTION_STRING=your_database_connection_string

Start your loacal or remote server

API Endpoints
Loans commands

    POST /loans/add: Submit a new loan.
    GET /loans/all: Retrieve all loans.
    GET /loans/:id: Retrieve a specific loan by ID.
    PUT /loans/:id: Update a loan amount_paid by ID.
    DELETE /loans/:id: Delete a loan by ID.

Usage

Use an API client like Postman or cURL to interact with the API. For example, to submit a new loan application:

    bash

    curl -X POST http://localhost:3000/api/loans -H "Content-Type: application/json" -d '{
    "clientId": "12345",
    "amount": 1000,
    "term": 12,
    "interestRate": 5
    }'

Contributing

Fork the repository.
Create a new branch (git checkout -b feature-branch).
Make your changes.
Commit your changes (git commit -am 'Add new feature').
Push to the branch (git push origin feature-branch).
Create a new Pull Request.

License

This project is licensed under the MIT License - see the LICENSE file for details.

