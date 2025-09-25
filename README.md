# Notes Application

A simple note-taking app built with Laravel and Livewire.

## Features

- Create and manage notes
- Pin important notes
- Search functionality
- Public note sharing
- API access with tokens

## Requirements

- PHP >= 8.2
- Composer
- Database (SQLite or MySQL)
- Node.js & NPM

## Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd task-for-sandro
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Setup

Copy the environment file and configure your settings:

```bash
cp .env.example .env
```

Update these variables in `.env`:

```env
APP_NAME=Notes
APP_URL=https://your-domain.com

# For SQLite (default - no additional setup needed)
DB_CONNECTION=sqlite

# For MySQL (uncomment and configure)
# DB_CONNECTION=mysql
# DB_DATABASE=your_database
# DB_USERNAME=your_username
# DB_PASSWORD=your_password
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Install API Support (Laravel Sanctum)

```bash
php artisan install:api
```

### 7. Build Assets

```bash
# For development
npm run dev

# For production
npm run build
```

### 8. Start the Application

```bash
# Using Laravel's built-in server
php artisan serve

# Or configure your web server (Apache/Nginx) to point to the public directory
```

## API Documentation

The Notes API provides programmatic access to manage your notes.

### Base URL

```
https://your-domain.com/api
```

### Authentication

The API uses Bearer token authentication. You can obtain an API token in two ways:

#### Option 1: Via Web Interface

1. Log in to your account at `https://your-domain.com/login`
2. Click on your profile dropdown (top right)
3. Navigate to "API Tokens"
4. Click "Create Token"
5. Enter a descriptive name (e.g., "Mobile App", "Desktop Client")
6. Copy the token immediately (it will only be shown once)

#### Option 2: Via API Login Endpoint

```bash
POST /api/login
Content-Type: application/json

{
  "email": "your@email.com",
  "password": "your-password",
  "token_name": "My API Client" // optional, defaults to "API Token"
}
```

**Response:**
```json
{
  "token": "1|Gp7cBRi8efEFvjKpwpQIk5KSmYagdQ4IMQvhIvdA5fb882eb",
  "token_name": "My API Client",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "message": "Login successful"
}
```

### Using the Token

Include the token in the Authorization header for all authenticated requests:

```bash
Authorization: Bearer YOUR_TOKEN_HERE
```

### API Endpoints

#### 1. Create Note

**Endpoint:** `POST /api/notes`
**Authentication:** Required

```bash
curl -X POST https://your-domain.com/api/notes \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "My Note Title",
    "content": "Note content here",
    "is_published": false,
    "is_pinned": true
  }'
```

**Request Body:**
- `title` (string, required): Note title (max 255 characters)
- `content` (string, optional): Note content
- `is_published` (boolean, optional): Whether the note is publicly accessible (default: false)
- `is_pinned` (boolean, optional): Whether the note is pinned (default: false)
- `image_path` (string, optional): Path to associated image

**Response:**
```json
{
  "data": {
    "id": 1,
    "title": "My Note Title",
    "content": "Note content here",
    "slug": null,
    "is_published": false,
    "is_pinned": true,
    "image_path": null,
    "created_at": "2025-09-25T10:00:00.000000Z",
    "updated_at": "2025-09-25T10:00:00.000000Z"
  },
  "message": "Note created successfully"
}
```

**Note:** When a note is published (`is_published: true`), a unique slug is automatically generated for public access.

#### 2. List Notes

**Endpoint:** `GET /api/notes`
**Authentication:** Required

Returns all notes belonging to the authenticated user, with pinned notes appearing first.

```bash
curl -X GET https://your-domain.com/api/notes \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Query Parameters:**
- `is_pinned` (boolean, optional): Filter to show only pinned notes

**Example with Filter:**
```bash
curl -X GET "https://your-domain.com/api/notes?is_pinned=true" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Response:**
```json
{
  "data": [
    {
      "id": 15,
      "title": "Important Note",
      "content": "This is pinned and will appear first",
      "slug": "important-note",
      "is_published": true,
      "is_pinned": true,
      "image_path": null,
      "created_at": "2025-09-25T10:00:00.000000Z",
      "updated_at": "2025-09-25T10:00:00.000000Z"
    },
    {
      "id": 4,
      "title": "Regular Note",
      "content": "This is not pinned",
      "slug": null,
      "is_published": false,
      "is_pinned": false,
      "image_path": null,
      "created_at": "2025-09-25T09:00:00.000000Z",
      "updated_at": "2025-09-25T09:00:00.000000Z"
    }
  ],
  "total": 2
}
```

#### 3. Get Published Note (Public)

**Endpoint:** `GET /api/published/{slug}`
**Authentication:** Not required (public endpoint)

This endpoint allows anyone to access published notes without authentication.

```bash
curl -X GET https://your-domain.com/api/published/my-public-note
```

**Response:**
```json
{
  "data": {
    "id": 1,
    "title": "My Public Note",
    "content": "This note is publicly accessible",
    "slug": "my-public-note",
    "is_published": true,
    "is_pinned": false,
    "image_path": null,
    "created_at": "2025-09-25T10:00:00.000000Z",
    "updated_at": "2025-09-25T10:00:00.000000Z",
    "author": {
      "id": 1,
      "name": "John Doe"
    }
  }
}
```

**Note:** Returns 404 if the slug doesn't exist or the note is not published.

### Error Responses

The API returns standard HTTP status codes:

- `200 OK`: Request successful
- `201 Created`: Resource created successfully
- `401 Unauthorized`: Authentication required or invalid token
- `404 Not Found`: Resource not found
- `422 Unprocessable Entity`: Validation errors

**Example Error Response:**
```json
{
  "message": "Validation failed",
  "errors": {
    "title": ["The title field is required."]
  }
}
```


### Examples

```bash
# Login
curl -X POST https://your-domain.com/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password"}'

# Create note
curl -X POST https://your-domain.com/api/notes \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"title":"My Note","content":"Note content"}'

# Get notes
curl -X GET https://your-domain.com/api/notes \
  -H "Authorization: Bearer YOUR_TOKEN"
```

## Usage

### Web Interface

- Create, edit, and manage notes
- Pin important notes
- Search and filter notes
- Publish notes for public sharing
- Manage API tokens from profile menu
- Update account settings

## Security

- API tokens are hashed and shown only once
- All endpoints require authentication except public notes
- Users can only access their own notes
- Passwords are securely hashed

## Troubleshooting

1. **"Unauthenticated" error**: Check your Bearer token in the Authorization header
2. **Token not working**: Tokens are user-specific
3. **Can't see notes**: Verify you're authenticated correctly
4. **Published note not accessible**: Make sure the note is published with a valid slug

## Development

### Running Tests

```bash
php artisan test
```

### Code Style

```bash
# Format code
./vendor/bin/pint

# Check code style
./vendor/bin/pint --test
```

### Development Server

```bash
# Start all services
npm run dev

# Or manually:
php artisan serve
npm run watch
```

## Production Deployment

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false` in `.env`
3. Run `composer install --optimize-autoloader --no-dev`
4. Run `npm run build`
5. Run `php artisan config:cache`
6. Run `php artisan route:cache`
7. Run `php artisan view:cache`

## License

Made by Egnate ❤️ From Tbilisi