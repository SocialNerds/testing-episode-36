# Database schema

## Books
- id -> UUID | Primary
- title -> String
- description -> Long text
- isb -> String | Unique
- created_at -> Timestamp
- updated_at -> Timestamp

## Users
- id -> UUID | Primary
- name -> String
- email -> String | Unique
- password -> String
- remember_token -> String
- created_at -> Timestamp
- updated_at -> Timestamp

## Favorites 
- user_id
- book_id

# Categories
- id -> UUID | Primary
- title -> String
