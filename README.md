# Event Management API

A robust RESTful API built with Laravel 12 for managing events and attendees. This application provides comprehensive event management capabilities including user authentication, event CRUD operations, attendee management, and automated event reminders.

<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Laravel Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/badge/PHP-8.2+-blue" alt="PHP Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Features

- 🔐 **User Authentication** - Secure authentication using Laravel Sanctum
- 📅 **Event Management** - Full CRUD operations for events
- 👥 **Attendee Management** - Track and manage event attendees
- 🔔 **Automated Reminders** - Send notifications to attendees before events
- 🛡️ **Policy-Based Authorization** - Fine-grained access control
- 🚦 **Rate Limiting** - API throttling to prevent abuse
- 📊 **API Resources** - Clean and consistent API responses
- 🧪 **Testing Ready** - PHPUnit test structure included

## Technology Stack

- **Framework:** Laravel 12
- **PHP Version:** 8.2+
- **Authentication:** Laravel Sanctum
- **Database:** MySQL/PostgreSQL (configurable)
- **API:** RESTful API with JSON responses

## Prerequisites

Before you begin, ensure you have the following installed:

- PHP >= 8.2
- Composer
- MySQL or PostgreSQL
- Node.js & NPM (for frontend assets)

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/aboulkassm/event-management.git
   cd event-management
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure Database**
   
   Edit your `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=event_management
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run Migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed Database (Optional)**
   ```bash
   php artisan db:seed
   ```

8. **Start the Development Server**
   ```bash
   php artisan serve
   ```

   The API will be available at `http://localhost:8000`

## Database Schema

### Events Table
- `id` - Primary key
- `name` - Event name
- `description` - Event description
- `start_time` - Event start date and time
- `end_time` - Event end date and time
- `user_id` - Foreign key to users table (event creator)
- `created_at`, `updated_at` - Timestamps

### Attendees Table
- `id` - Primary key
- `user_id` - Foreign key to users table
- `event_id` - Foreign key to events table
- `created_at`, `updated_at` - Timestamps

### Users Table
- `id` - Primary key
- `name` - User's name
- `email` - User's email (unique)
- `password` - Hashed password
- `email_verified_at` - Email verification timestamp
- `created_at`, `updated_at` - Timestamps

## API Endpoints

### Authentication

#### Login
```http
POST /api/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password"
}
```

#### Logout
```http
POST /api/logout
Authorization: Bearer {token}
```

#### Get Authenticated User
```http
GET /api/user
Authorization: Bearer {token}
```

### Events

#### List All Events
```http
GET /api/events
```

#### Get Single Event
```http
GET /api/events/{id}
```

#### Create Event (Authenticated)
```http
POST /api/events
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Tech Conference 2026",
  "description": "Annual technology conference",
  "start_time": "2026-06-15 09:00:00",
  "end_time": "2026-06-15 18:00:00"
}
```

#### Update Event (Authenticated & Owner)
```http
PUT /api/events/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Updated Event Name",
  "description": "Updated description"
}
```

#### Delete Event (Authenticated & Owner)
```http
DELETE /api/events/{id}
Authorization: Bearer {token}
```

### Attendees

#### List Event Attendees
```http
GET /api/events/{event_id}/attendees
```

#### Get Single Attendee
```http
GET /api/events/{event_id}/attendees/{id}
```

#### Register for Event (Authenticated)
```http
POST /api/events/{event_id}/attendees
Authorization: Bearer {token}
```

#### Remove Attendee (Authenticated & Owner/Event Creator)
```http
DELETE /api/events/{event_id}/attendees/{id}
Authorization: Bearer {token}
```

## API Resources

The API uses Laravel API Resources for consistent response formatting:

- `EventResource` - Event data transformation
- `AttendeeResource` - Attendee data transformation
- `UserResource` - User data transformation

## Authorization Policies

- **EventPolicy** - Controls access to event operations
  - Users can update/delete only their own events
  
- **AttendeePolicy** - Controls access to attendee operations
  - Users can remove their own attendance
  - Event creators can manage all attendees

## Console Commands

### Send Event Reminders
```bash
php artisan app:send-event-reminders
```

This command sends reminder notifications to attendees for upcoming events. Can be scheduled in the task scheduler.

## Rate Limiting

API endpoints are rate-limited to prevent abuse:
- Public endpoints: Standard rate limiting
- Authenticated endpoints: 60 requests per minute

## Testing

Run the test suite:

```bash
php artisan test
```

Or with PHPUnit directly:

```bash
./vendor/bin/phpunit
```

## Code Quality

### Run Laravel Pint (Code Formatter)
```bash
./vendor/bin/pint
```

## Project Structure

```
app/
├── Console/Commands/       # Artisan commands
├── Http/
│   ├── Controllers/Api/   # API controllers
│   ├── Resources/         # API resources
│   └── Traits/            # Reusable traits
├── Models/                # Eloquent models
├── Notifications/         # Notification classes
├── Policies/              # Authorization policies
└── Providers/             # Service providers

database/
├── factories/             # Model factories
├── migrations/            # Database migrations
└── seeders/              # Database seeders

routes/
├── api.php               # API routes
├── web.php               # Web routes
└── console.php           # Console routes

tests/
├── Feature/              # Feature tests
└── Unit/                 # Unit tests
```

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a new branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Security

If you discover any security-related issues, please email abdo.a.26498@hotmail.com instead of using the issue tracker.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Author

**Aboulkassm**
- GitHub: [@aboulkassm](https://github.com/aboulkassm)


## Acknowledgments

- Built with [Laravel](https://laravel.com)
- Authentication via [Laravel Sanctum](https://laravel.com/docs/sanctum)

---

⭐ If you find this project useful, please consider giving it a star!
