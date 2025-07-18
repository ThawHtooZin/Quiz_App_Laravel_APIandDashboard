# 📚 Quiz App API Documentation

## 🚀 **Base Information**
- **Base URL:** `https://your-domain.com/api`
- **Authentication:** Laravel Sanctum (Bearer Token)
- **Content-Type:** `application/json`
- **All protected endpoints require:** `Authorization: Bearer <token>` header

## 📋 **Quick Start**
1. Register user: `POST /api/register`
2. Login: `POST /api/login` 
3. Use returned token in all subsequent requests
4. Get quizzes: `GET /api/quizzes`
5. Take quiz: `GET /api/quizzes/{id}`
6. Submit answers: `POST /api/quizzes/{id}/submit`
7. View results: `GET /api/results`

---

## 🔐 **Authentication Endpoints**

### Register User
- **Endpoint:** `POST /api/register`
- **Description:** Create a new user account
- **Headers:** `Content-Type: application/json`
- **Request Body:**
  ```json
  {
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }
  ```
- **Validation Rules:**
  - `name`: required, string, max 255 characters
  - `email`: required, email, unique
  - `password`: required, string, min 8 characters
  - `password_confirmation`: required, must match password
- **Success Response:** `201 Created`
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
- **Error Response:** `422 Unprocessable Entity`
  ```json
  {
    "message": "The given data was invalid.",
    "errors": {
      "email": ["The email has already been taken."],
      "password": ["The password confirmation does not match."]
    }
  }
  ```

---

### Login User
- **Endpoint:** `POST /api/login`
- **Description:** Authenticate user and get access token
- **Headers:** `Content-Type: application/json`
- **Request Body:**
  ```json
  {
    "email": "john@example.com",
    "password": "password123"
  }
  ```
- **Validation Rules:**
  - `email`: required, email
  - `password`: required, string
- **Success Response:** `200 OK`
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
- **Error Response:** `401 Unauthorized`
  ```json
  {
    "message": "Invalid credentials"
  }
  ```

---

### Get User Profile
- **Endpoint:** `GET /api/profile`
- **Description:** Get current authenticated user information
- **Headers:** `Authorization: Bearer <token>`
- **Success Response:** `200 OK`
  ```json
  {
    "user": {
      "id": 9,
      "name": "John Doe",
      "email": "john@example.com"
    }
  }
  ```
- **Error Response:** `401 Unauthorized`
  ```json
  {
    "message": "Unauthenticated."
  }
  ```

---

### Logout User
- **Endpoint:** `POST /api/logout`
- **Description:** Invalidate current access token
- **Headers:** `Authorization: Bearer <token>`
- **Success Response:** `200 OK`
  ```json
  {
    "message": "Logged out successfully"
  }
  ```
- **Error Response:** `401 Unauthorized`
  ```json
  {
    "message": "Unauthenticated."
  }
  ```

---

## 🎯 **Quiz Endpoints**

### List Available Quizzes
- **Endpoint:** `GET /api/quizzes`
- **Description:** Get all published quizzes available to take
- **Headers:** `Authorization: Bearer <token>`
- **Query Parameters:** None
- **Success Response:** `200 OK`
  ```json
  [
    {
      "id": 1,
      "title": "General Knowledge Quiz",
      "description": "Test your general knowledge with various topics",
      "time_limit": 15,
      "question_limit": 5,
      "questions_count": 20,
      "created_at": "2024-07-15T08:00:00Z",
      "updated_at": "2024-07-15T08:00:00Z"
    },
    {
      "id": 2,
      "title": "Math Quiz",
      "description": "Test your mathematical skills",
      "time_limit": 10,
      "question_limit": null,
      "questions_count": 8,
      "created_at": "2024-07-15T09:00:00Z",
      "updated_at": "2024-07-15T09:00:00Z"
    }
  ]
  ```
- **Response Fields:**
  - `id`: Unique quiz identifier
  - `title`: Quiz title
  - `description`: Quiz description
  - `time_limit`: Time limit in minutes (null = no limit)
  - `question_limit`: Questions shown per attempt (null = all questions)
  - `questions_count`: Total questions in quiz pool
  - `created_at`, `updated_at`: Timestamps

---

### Get Quiz Questions
- **Endpoint:** `GET /api/quizzes/{quiz_id}`
- **Description:** Get quiz details and questions for taking the quiz
- **Headers:** `Authorization: Bearer <token>`
- **URL Parameters:**
  - `quiz_id`: ID of the quiz to take
- **Success Response:** `200 OK`
  ```json
  {
    "id": 1,
    "title": "General Knowledge Quiz",
    "description": "Test your general knowledge with various topics",
    "time_limit": 15,
    "question_limit": 5,
    "questions_count": 5,
    "questions": [
      {
        "id": 101,
        "question_text": "What is the capital of France?",
        "options": [
          { "id": 401, "text": "London" },
          { "id": 402, "text": "Paris" },
          { "id": 403, "text": "Berlin" },
          { "id": 404, "text": "Madrid" }
        ]
      },
      {
        "id": 102,
        "question_text": "Which planet is known as the Red Planet?",
        "options": [
          { "id": 405, "text": "Venus" },
          { "id": 406, "text": "Mars" },
          { "id": 407, "text": "Jupiter" },
          { "id": 408, "text": "Saturn" }
        ]
      }
    ],
    "created_at": "2024-07-15T08:00:00Z",
    "updated_at": "2024-07-15T08:00:00Z"
  }
  ```
- **Response Fields:**
  - `id`: Quiz identifier
  - `title`, `description`: Quiz information
  - `time_limit`: Time limit in minutes (null = no limit)
  - `question_limit`: Questions shown per attempt (null = all questions)
  - `questions_count`: Actual number of questions shown (respects question_limit)
  - `questions`: Array of questions with options
  - `questions[].id`: Question identifier
  - `questions[].question_text`: Question text
  - `questions[].options`: Array of answer options
  - `options[].id`: Option identifier (use this for submission)
  - `options[].text`: Option text
- **Important Notes:**
  - Questions are randomly selected if `question_limit` is set
  - Options are in consistent order (A, B, C, D)
  - Correct answers are NOT included (security)
- **Error Response:** `404 Not Found`
  ```json
  {
    "message": "Quiz not found or not published."
  }
  ```

---

### Submit Quiz Answers
- **Endpoint:** `POST /api/quizzes/{quiz_id}/submit`
- **Description:** Submit answers and get immediate results
- **Headers:** 
  - `Authorization: Bearer <token>`
  - `Content-Type: application/json`
- **URL Parameters:**
  - `quiz_id`: ID of the quiz being submitted
- **Request Body:**
  ```json
  {
    "answers": [
      { "question_id": 101, "selected_option_id": 402 },
      { "question_id": 102, "selected_option_id": 406 }
    ],
    "time_taken": 45
  }
  ```
- **Validation Rules:**
  - `answers`: required, array
  - `answers[].question_id`: required, exists in questions table
  - `answers[].selected_option_id`: required, exists in options table
  - `time_taken`: optional, integer, minimum 0 (seconds)
- **Success Response:** `201 Created`
  ```json
  {
    "message": "Quiz submitted successfully",
    "result": {
      "id": 123,
      "score": 2,
      "total_questions": 2,
      "percentage": 100.0,
      "time_taken": 45
    }
  }
  ```
- **Response Fields:**
  - `result.id`: Quiz result identifier
  - `result.score`: Number of correct answers
  - `result.total_questions`: Questions answered (respects question_limit)
  - `result.percentage`: Score percentage (0-100)
  - `result.time_taken`: Time taken in seconds
- **Error Response:** `422 Unprocessable Entity`
  ```json
  {
    "message": "The given data was invalid.",
    "errors": {
      "answers": ["The answers field is required."],
      "answers.0.question_id": ["The selected question id is invalid."]
    }
  }
  ```
- **Error Response:** `404 Not Found`
  ```json
  {
    "message": "Quiz not found or not published."
  }
  ```

---

## 📊 **Quiz Results Endpoints**

### List My Quiz Results
- **Endpoint:** `GET /api/results`
- **Description:** Get paginated list of user's quiz attempts
- **Headers:** `Authorization: Bearer <token>`
- **Query Parameters:**
  - `page`: Page number (default: 1)
  - `per_page`: Items per page (default: 10, max: 50)
- **Success Response:** `200 OK`
  ```json
  {
    "data": [
      {
        "id": 1,
        "quiz": { 
          "id": 1, 
          "title": "General Knowledge Quiz", 
          "description": "Test your general knowledge with various topics" 
        },
        "score": 2,
        "total_questions": 2,
        "percentage": 100.0,
        "time_taken": 45,
        "formatted_time": "00:45",
        "attempted_at": "2024-07-15T08:40:00Z"
      },
      {
        "id": 2,
        "quiz": { 
          "id": 2, 
          "title": "Math Quiz", 
          "description": "Test your mathematical skills" 
        },
        "score": 6,
        "total_questions": 8,
        "percentage": 75.0,
        "time_taken": 320,
        "formatted_time": "05:20",
        "attempted_at": "2024-07-15T09:15:00Z"
      }
    ],
    "links": {
      "first": "https://api.example.com/api/results?page=1",
      "last": "https://api.example.com/api/results?page=5",
      "prev": null,
      "next": "https://api.example.com/api/results?page=2"
    },
    "meta": {
      "current_page": 1,
      "from": 1,
      "last_page": 5,
      "per_page": 10,
      "to": 10,
      "total": 50
    }
  }
  ```
- **Response Fields:**
  - `data[].id`: Result identifier
  - `data[].quiz`: Quiz information (id, title, description)
  - `data[].score`: Correct answers count
  - `data[].total_questions`: Questions answered (respects question_limit)
  - `data[].percentage`: Score percentage (0-100)
  - `data[].time_taken`: Time taken in seconds
  - `data[].formatted_time`: Human-readable time (MM:SS)
  - `data[].attempted_at`: Attempt timestamp
- **Important Notes:**
  - Results are paginated (10 per page by default)
  - `total_questions` reflects actual questions answered (respects question_limit)
  - Results are sorted by most recent first

---

### Get Quiz Result Details
- **Endpoint:** `GET /api/results/{result_id}`
- **Description:** Get detailed analysis of a specific quiz attempt
- **Headers:** `Authorization: Bearer <token>`
- **URL Parameters:**
  - `result_id`: ID of the quiz result to view
- **Success Response:** `200 OK`
  ```json
  {
    "id": 1,
    "quiz": { 
      "id": 1, 
      "title": "General Knowledge Quiz", 
      "description": "Test your general knowledge with various topics" 
    },
    "score": 1,
    "total_questions": 2,
    "percentage": 50.0,
    "time_taken": 45,
    "formatted_time": "00:45",
    "attempted_at": "2024-07-15T08:40:00Z",
    "questions": [
      {
        "id": 101,
        "question_text": "What is the capital of France?",
        "selected_answer": { 
          "id": 402, 
          "text": "Paris", 
          "is_correct": true 
        },
        "correct_answer": { 
          "id": 402, 
          "text": "Paris" 
        },
        "is_correct": true
      },
      {
        "id": 102,
        "question_text": "Which planet is known as the Red Planet?",
        "selected_answer": { 
          "id": 405, 
          "text": "Venus", 
          "is_correct": false 
        },
        "correct_answer": { 
          "id": 406, 
          "text": "Mars" 
        },
        "is_correct": false
      }
    ]
  }
  ```
- **Response Fields:**
  - `id`: Result identifier
  - `quiz`: Quiz information (id, title, description)
  - `score`: Correct answers count
  - `total_questions`: Questions answered (respects question_limit)
  - `percentage`: Score percentage (0-100)
  - `time_taken`: Time taken in seconds
  - `formatted_time`: Human-readable time (MM:SS)
  - `attempted_at`: Attempt timestamp
  - `questions`: Array of answered questions with analysis
  - `questions[].id`: Question identifier
  - `questions[].question_text`: Question text
  - `questions[].selected_answer`: User's selected answer
  - `questions[].correct_answer`: Correct answer
  - `questions[].is_correct`: Whether user answered correctly
- **Important Notes:**
  - `total_questions` reflects actual questions answered (respects question_limit)
  - `questions` array only contains questions that were actually answered
  - Correct answers are now visible (for learning purposes)
- **Error Response:** `403 Forbidden`
  ```json
  {
    "message": "Unauthorized access to result."
  }
  ```
- **Error Response:** `404 Not Found`
  ```json
  {
    "message": "Result not found."
  }
  ```

---

## ⚠️ **Error Responses**

### Common HTTP Status Codes
- **200 OK**: Request successful
- **201 Created**: Resource created successfully
- **400 Bad Request**: Invalid request data
- **401 Unauthorized**: Authentication required or invalid
- **403 Forbidden**: Access denied
- **404 Not Found**: Resource not found
- **422 Unprocessable Entity**: Validation errors

### Standard Error Response Format
```json
{
  "message": "Error description",
  "errors": {
    "field_name": ["Specific error message"]
  }
}
```

### Authentication Errors
```json
{
  "message": "Unauthenticated."
}
```

### Validation Errors
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required."],
    "password": ["The password must be at least 8 characters."]
  }
}
```

### Resource Not Found
```json
{
  "message": "Quiz not found or not published."
}
```

### Access Denied
```json
{
  "message": "Unauthorized access to result."
}
```

---

## 🆕 **Special Features**

### Question Pooling & Limit Per Quiz
- **Purpose:** Instead of every user answering the same set of questions, quizzes can have a large pool of questions with a limit on how many are shown per attempt.
- **Implementation:** 
  - Set `question_limit` when creating/editing a quiz
  - If `question_limit` is set and there are more questions available, the API randomly selects `question_limit` questions per attempt
  - If `question_limit` is null, all questions are shown
  - **Percentage calculation is based on actual questions shown, not total questions in quiz**
- **Example:** A quiz with 20 questions and `question_limit: 10` will randomly show 10 different questions each time. If user gets 5 correct out of 10 shown, percentage = 50% (not 25%)

### Consistent Option Order
- **Purpose:** Provide predictable option layout for better user experience.
- **Implementation:**
  - Options are always in the same order (A, B, C, D)
  - Frontend should display options as A/B/C/D based on array index
  - Submit `selected_option_id` (not "A" or "C") when answering
- **Example:** 
  ```json
  // Question 1 options (consistent order)
  "options": [
    { "id": 401, "text": "London" },
    { "id": 402, "text": "Paris" },
    { "id": 403, "text": "Berlin" },
    { "id": 404, "text": "Madrid" }
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

## 📝 **Important Notes**

### General Information
- **Timezone:** All times are in UTC
- **Content Type:** All endpoints return JSON
- **Authentication:** All protected endpoints require a valid Sanctum token
- **Rate Limiting:** Standard Laravel rate limiting applies

### Quiz Security
- **Correct Answers:** Never exposed in quiz questions (only in results)
- **Question Limits:** Randomly selected if `question_limit` is set
- **Option Order:** Consistent A/B/C/D order (no shuffling)

### Data Accuracy
- **Percentage Calculation:** Based on actual questions shown, not total quiz questions
- **Question Count:** Reflects questions answered, respects `question_limit`
- **Results:** Only show questions that were actually answered

### User Experience
- **Quiz Retakes:** Users can retake quizzes multiple times
- **Progress Tracking:** All attempts are saved and trackable
- **Immediate Feedback:** Results available immediately after submission

## 🚀 **Development Tips**

### For Flutter Developers
1. **Store Token:** Save the authentication token securely
2. **Handle Pagination:** Use the pagination links for results
3. **Error Handling:** Implement proper error handling for all endpoints
4. **Offline Support:** Cache quiz data for offline access
5. **Real-time Updates:** Consider implementing pull-to-refresh for results

### Best Practices
- Always include the `Authorization: Bearer <token>` header for protected endpoints
- Handle network errors gracefully
- Implement loading states for better UX
- Validate data on both client and server side
- Use proper HTTP status codes for error handling 