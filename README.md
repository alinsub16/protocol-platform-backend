# Protocol Platform API

## Overview

Protocol Platform is a content-driven discussion platform inspired by community forums and knowledge-sharing websites. Users can create and explore wellness, healing, and instructional protocols, discuss them through threads, leave reviews, and engage through voting and comments.

This project was built as a full-stack technical assessment using Laravel as the backend API and Typesense for search functionality.

---

# Features

## Protocol Management

* Create, update, view, and delete protocols
* Categorize protocols using tags
* Track ratings, reviews, and votes

## Discussion Threads

* Create threads under protocols
* Associate discussions with specific protocols
* Track comments and votes

## Nested Comments

* Support threaded replies
* Unlimited comment nesting
* Vote on comments

## Reviews

* Users can rate protocols
* Optional textual feedback
* One review per user per protocol

## Voting System

* Upvote / Downvote threads
* Upvote / Downvote comments
* One vote per user per entity

## Search (Typesense)

* Search protocols by title and tags
* Search threads by title and content

---

# Tech Stack

## Backend

* Laravel 12
* SQLite (Development)
* Eloquent ORM
* Laravel API Resources
* Laravel Factories & Seeders
* Laravel Scout
* Typesense

## Frontend (Planned)

* React.js
* TypeScript
* Tailwind CSS
* Axios

---

# Project Structure

```text
app/
│
└── Domain/
    │
    ├── Protocols/
    │   ├── Models/
    │   ├── Controllers/
    │   ├── Resources/
    │   └── Requests/
    │
    ├── Threads/
    │   ├── Models/
    │   ├── Controllers/
    │   ├── Resources/
    │   └── Requests/
    │
    ├── Comments/
    │   ├── Models/
    │   ├── Controllers/
    │   ├── Resources/
    │   └── Requests/
    │
    ├── Reviews/
    │   ├── Models/
    │   ├── Controllers/
    │   ├── Resources/
    │   └── Requests/
    │
    └── Votes/
        ├── Models/ 
        ├── Controllers/
        ├── Resources/
        └── Requests/
```

---

# Database Entities

## Protocol

| Field         | Type    |
| ------------- | ------- |
| id            | bigint  |
| user_id       | bigint  |
| title         | string  |
| content       | text    |
| tags          | json    |
| avg_rating    | decimal |
| votes_count   | integer |
| reviews_count | integer |

---

## Thread

| Field          | Type    |
| -------------- | ------- |
| id             | bigint  |
| protocol_id    | bigint  |
| user_id        | bigint  |
| title          | string  |
| body           | text    |
| tags           | json    |
| votes_count    | integer |
| comments_count | integer |

---

## Comment

| Field       | Type            |
| ----------- | --------------- |
| id          | bigint          |
| thread_id   | bigint          |
| user_id     | bigint          |
| parent_id   | bigint nullable |
| body        | text            |
| votes_count | integer         |

---

## Review

| Field       | Type          |
| ----------- | ------------- |
| id          | bigint        |
| protocol_id | bigint        |
| user_id     | bigint        |
| rating      | integer       |
| feedback    | text nullable |

---

## Vote

| Field        | Type    |
| ------------ | ------- |
| id           | bigint  |
| user_id      | bigint  |
| votable_id   | bigint  |
| votable_type | string  |
| value        | integer |

---

# Installation

## Clone Repository

```bash
git clone https://github.com/alinsub16/protocol-platform-backend.git
cd protocol-platform
```

## Install Dependencies

```bash
composer install
```

## Environment Setup

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

---

# Database Setup

Run migrations:

```bash
php artisan migrate
```

Run seeders:

```bash
php artisan db:seed
```

Or refresh and seed:

```bash
php artisan migrate:fresh --seed
```

---

# Factories & Seeders

The project includes realistic mock data generation:

### Protocols

* 12+ seeded protocols

### Threads

* 10+ seeded threads

### Comments

* Nested discussion comments

### Reviews

* Ratings and feedback

### Votes

* Upvotes and downvotes for threads and comments

---

# API Resources

Implemented Resources:

* ProtocolResource
* ThreadResource
* CommentResource
* ReviewResource
* VoteResource

---

# Controllers

Implemented Controllers:

* ProtocolController
* ThreadController
* CommentController
* ReviewController
* VoteController

---

# API Endpoints

## Protocols

```http
GET /api/protocols
GET /api/protocols/{id}
PUT /api/protocols/{id}
```

---

## Threads

```http
GET /api/threads
GET /api/threads/{id}
POST /api/threads
PUT /api/threads/{id}
```

---

## Comments

```http
GET /api/comments
GET /api/comments/{id}
POST /api/comments
PUT /api/comments/{id}
```

---

## Reviews

```http
GET /api/reviews
GET /api/reviews/{id}
POST /api/reviews
```

---

## Votes

```http
POST /api/votes
DELETE /api/votes/{id}
```

---

# Typesense Configuration

Add the following variables to your `.env` file:

```env
SCOUT_DRIVER=typesense

TYPESENSE_HOST=
TYPESENSE_PORT=443
TYPESENSE_PROTOCOL=https

TYPESENSE_API_KEY=
```

### Notes

* Admin API Key is used by Laravel for indexing.
* Search-only API Key is used by the frontend.
* Typesense integration requires an active Typesense Cloud cluster.

---

# Search Features

Protocols:

* Search by title
* Search by tags
* Sort by reviews
* Sort by votes

Threads:

* Search by title
* Sort by votes
* Sort by newest

---

# Development Notes

Implemented:

* Domain-driven architecture
* Models and relationships
* Migrations
* Factories
* Seeders
* API Resources
* Controllers
* Polymorphic voting system

Pending:

* Typesense cluster provisioning
* Scout indexing
* Frontend implementation
* Authentication (optional)
* Deployment

---

# Author

Christopher Alinsub
