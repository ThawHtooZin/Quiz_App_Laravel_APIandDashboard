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
  - Returns: `{ message, user, token }`
  ```json
  {
    "message": "User registered successfully",
    "user": {
      "id": 9,
      "name": "John Doe",
      "email": "john@example.com"
    },
    "token": "3|6jHdZ9dDHiijzwHKeRZOvvfIYVGybcg54dNuTmTZ638ff3b9"
  }
  ```

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
  - Returns: `{ message, user, token }`
  ```json
  {
    "message": "Login successful",
    "user": {
      "id": 9,
      "name": "John Doe",
      "email": "john@example.com"
    },
    "token": "3|6jHdZ9dDHiijzwHKeRZOvvfIYVGybcg54dNuTmTZ638ff3b9"
  }
  ```

---

### Profile (Get current user)
- **GET** `/api/profile`
- **Headers:** `Authorization: Bearer <token>`
- **Response:** `{ user }`
  ```json
  {
    "user": {
      "id": 9,
      "name": "John Doe",
      "email": "john@example.com"
    }
  }
  ```

---

### Logout
- **POST** `/api/logout`
- **Headers:** `Authorization: Bearer <token>`
- **Response:** `{ message }`
  ```json
  {
    "message": "Logged out successfully"
  }
  ```

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
      "question_limit": 5,
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
    "question_limit": 5,
    "questions_count": 5,
    "questions": [
      {
        "id": 101,
        "question_text": "What is 2+2?",
        "options": [
          { "id": 4, "text": "4" },
          { "id": 2, "text": "3" },
          { "id": 1, "text": "5" },
          { "id": 3, "text": "2" }
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

## New Features

### Question Pooling & Limit Per Quiz
- **Purpose:** Instead of every user answering the same set of questions, quizzes can have a large pool of questions with a limit on how many are shown per attempt.
- **Implementation:** 
  - Set `question_limit` when creating/editing a quiz
  - If `question_limit` is set and there are more questions available, the API randomly selects `question_limit` questions per attempt
  - If `question_limit` is null, all questions are shown
- **Example:** A quiz with 20 questions and `question_limit: 10` will randomly show 10 different questions each time

### Shuffled Options (ABCD Randomised)
- **Purpose:** Prevent answer memorization by randomizing option order for each attempt.
- **Implementation:**
  - Options are shuffled at runtime for each quiz attempt
  - Frontend should display options as A/B/C/D based on shuffled array index
  - Submit `selected_option_id` (not "A" or "C") when answering
- **Example:** 
  ```json
  // Question 1 options (shuffled)
  "options": [
    { "id": 4, "text": "Correct Answer" },
    { "id": 2, "text": "Wrong Answer" },
    { "id": 1, "text": "Wrong Answer" },
    { "id": 3, "text": "Wrong Answer" }
  ]
  ```

### Quiz Retakes
- **Purpose:** Allow users to retake quizzes multiple times for practice and improvement.
- **Implementation:**
  - Removed the "one attempt per quiz" restriction
  - Users can now submit the same quiz multiple times
  - Each attempt creates a new quiz result record
  - All attempts are tracked in the results history

---

## Notes

- All times are in UTC.
- All endpoints return JSON.
- All protected endpoints require a valid Sanctum token.
- Quiz details never expose correct answers.
- Quiz submission is allowed multiple times per quiz per user (retakes enabled).
- Questions are randomly selected from the pool if `question_limit` is set.
- Options are shuffled for each attempt to prevent answer memorization. 