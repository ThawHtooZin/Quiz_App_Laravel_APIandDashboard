# 📚 Quiz App API Endpoint Documentation

All endpoints are prefixed with `/api`.
Authentication uses Laravel Sanctum (token-based).
All protected endpoints require the `Authorization: Bearer <token>` header.

---

## Auth Endpoints

### Register
- **POST** `/api/register`
- **Body:**
  ```json
  {
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }
  ```
- **Response:**
  - `201 Created`
  - Returns: `{ user, token }`

---

### Login
- **POST** `/api/login`
- **Body:**
  ```json
  {
    "email": "john@example.com",
    "password": "password123"
  }
  ```
- **Response:**
  - `200 OK`
  - Returns: `{ user, token }`

---

### Profile (Get current user)
- **GET** `/api/profile`
- **Headers:** `Authorization: Bearer <token>`
- **Response:** `{ user }`

---

### Logout
- **POST** `/api/logout`
- **Headers:** `Authorization: Bearer <token>`
- **Response:** `{ message }`

---

## Quiz Endpoints

### List Quizzes
- **GET** `/api/quizzes`
- **Headers:** `Authorization: Bearer <token>`
- **Response:**
  ```json
  [
    {
      "id": 1,
      "title": "General Knowledge",
      "description": "A fun quiz",
      "time_limit": 60,
      "questions_count": 10,
      "created_at": "...",
      "updated_at": "..."
    },
    ...
  ]
  ```

---

### Quiz Details (No correct answers)
- **GET** `/api/quizzes/{quiz_id}`
- **Headers:** `Authorization: Bearer <token>`
- **Response:**
  ```json
  {
    "id": 1,
    "title": "General Knowledge",
    "description": "A fun quiz",
    "time_limit": 60,
    "questions_count": 10,
    "questions": [
      {
        "id": 101,
        "question_text": "What is 2+2?",
        "options": [
          { "id": 1, "text": "3" },
          { "id": 2, "text": "4" },
          { "id": 3, "text": "5" }
        ]
      },
      ...
    ],
    "created_at": "...",
    "updated_at": "..."
  }
  ```

---

### Submit Quiz
- **POST** `/api/quizzes/{quiz_id}/submit`
- **Headers:** `Authorization: Bearer <token>`
- **Body:**
  ```json
  {
    "answers": [
      { "question_id": 101, "selected_option_id": 2 },
      { "question_id": 102, "selected_option_id": 5 }
    ],
    "time_taken": 45
  }
  ```
- **Response:**
  - `201 Created`
  - Returns: `{ message, result: { id, score, total_questions, percentage, time_taken } }`

---

## Quiz Results Endpoints

### List My Quiz Results
- **GET** `/api/results`
- **Headers:** `Authorization: Bearer <token>`
- **Response:**
  ```json
  [
    {
      "id": 1,
      "quiz": { "id": 1, "title": "General Knowledge", "description": "..." },
      "score": 8,
      "total_questions": 10,
      "percentage": 80,
      "time_taken": 45,
      "formatted_time": "00:45",
      "attempted_at": "2024-07-15T08:40:00Z"
    },
    ...
  ]
  ```

---

### Get Quiz Result Details
- **GET** `/api/results/{result_id}`
- **Headers:** `Authorization: Bearer <token>`
- **Response:**
  ```json
  {
    "id": 1,
    "quiz": { "id": 1, "title": "General Knowledge", "description": "..." },
    "score": 8,
    "total_questions": 10,
    "percentage": 80,
    "time_taken": 45,
    "formatted_time": "00:45",
    "attempted_at": "2024-07-15T08:40:00Z",
    "questions": [
      {
        "id": 101,
        "question_text": "What is 2+2?",
        "selected_answer": { "id": 2, "text": "4", "is_correct": true },
        "correct_answer": { "id": 2, "text": "4" },
        "is_correct": true
      },
      ...
    ]
  }
  ```

---

## Error Responses

- Standard Laravel validation errors:
  ```json
  { "message": "The given data was invalid.", "errors": { ... } }
  ```
- Unauthorized:
  ```json
  { "message": "Unauthenticated." }
  ```
- Banned user:
  ```json
  { "message": "Your account has been banned." }
  ```

---

## Notes

- All times are in UTC.
- All endpoints return JSON.
- All protected endpoints require a valid Sanctum token.
- Quiz details never expose correct answers.
- Quiz submission is allowed only once per quiz per user. 