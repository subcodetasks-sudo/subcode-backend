# Laravel RESTful API Documentation

This document outlines the comprehensive RESTful API that has been automatically generated for all models in your Laravel project.

## 🚀 Overview

A complete RESTful API has been created for all 17 models in your project, following Laravel's resource controller conventions and utilizing the existing `ApiResponse` trait for consistent response formatting.

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── API/
│   │       └── V1/
│   │           ├── BaseController.php          # Base controller with common functionality
│   │           ├── AboutUsController.php
│   │           ├── AdminController.php
│   │           ├── AdvantageProjectController.php
│   │           ├── BlogController.php
│   │           ├── CategoryController.php
│   │           ├── DepartmentController.php
│   │           ├── FeatureController.php
│   │           ├── FeaturePackageController.php
│   │           ├── FQController.php
│   │           ├── PackageController.php
│   │           ├── PartnerSuccessController.php
│   │           ├── ProjectController.php
│   │           ├── ReviewProjectController.php
│   │           ├── ServiceController.php
│   │           ├── SettingController.php
│   │           ├── TestimonialController.php
│   │           └── UserController.php
│   └── Requests/
│       └── API/
│           ├── AboutUsRequest.php
│           ├── BlogRequest.php
│           ├── CategoryRequest.php
│           ├── DepartmentRequest.php
│           ├── FQRequest.php
│           ├── PackageRequest.php
│           ├── ProjectRequest.php
│           ├── ServiceRequest.php
│           ├── SettingRequest.php
│           ├── TestimonialRequest.php
│           └── UserRequest.php
└── Traits/
    └── ApiResponse.php                         # Your existing response trait
```

## 🔧 Features Implemented

### 1. **BaseController with Common Functionality**
- Automatic model detection based on controller name
- Standardized CRUD operations
- Built-in search functionality
- Pagination support
- Consistent error handling
- Transaction management for data integrity
- Soft delete support

### 2. **Laravel Resource Controllers**
All controllers implement the standard Laravel resource methods:
- `index()` - List all resources with pagination
- `store()` - Create a new resource
- `show($id)` - Display a specific resource
- `update($id)` - Update a specific resource
- `destroy($id)` - Delete a specific resource

### 3. **Validation Request Classes**
- Form request classes for proper validation
- Separate rules for create and update operations
- Consistent error response formatting
- Support for translatable fields (Arabic/English)

### 4. **Consistent API Responses**
All endpoints use the `ApiResponse` trait providing:
```json
{
    "status": true,
    "message": "Success message",
    "data": { /* Your data */ }
}
```

For paginated responses:
```json
{
    "status": true,
    "message": "Success message",
    "data": { /* Paginated data */ },
    "pagination": {
        "currentPage": 1,
        "lastPage": 5,
        "perPage": 15,
        "total": 75
    }
}
```

## 📋 API Routes

All routes are prefixed with `/api/v1/` and follow RESTful conventions:

### Public Routes (No Authentication)
```php
GET    /api/v1/users                    # List all users
POST   /api/v1/users                    # Create new user
GET    /api/v1/users/{id}              # Show specific user
PUT    /api/v1/users/{id}              # Update specific user
DELETE /api/v1/users/{id}              # Delete specific user

GET    /api/v1/blogs                    # List all blogs
POST   /api/v1/blogs                    # Create new blog
GET    /api/v1/blogs/{id}              # Show specific blog
PUT    /api/v1/blogs/{id}              # Update specific blog
DELETE /api/v1/blogs/{id}              # Delete specific blog
GET    /api/v1/blogs/slug/{slug}       # Get blog by slug

GET    /api/v1/categories               # List all categories
POST   /api/v1/categories               # Create new category
GET    /api/v1/categories/{id}         # Show specific category
PUT    /api/v1/categories/{id}         # Update specific category
DELETE /api/v1/categories/{id}         # Delete specific category
GET    /api/v1/categories/slug/{slug}  # Get category by slug

# Similar patterns for all other models:
# - projects, departments, packages, services, testimonials
# - fqs, about-us, settings, features, feature-packages
# - advantage-projects, partner-successes, review-projects
```

### Protected Routes (Authentication Required)
```php
GET    /api/v1/admins                   # List all admins (read-only)
GET    /api/v1/admins/{id}             # Show specific admin (read-only)
```

## 🔍 Search & Filtering

### Search Parameters
Most endpoints support search functionality:
```
GET /api/v1/blogs?search=laravel
GET /api/v1/categories?search=web development
```

### Pagination Parameters
```
GET /api/v1/blogs?per_page=20&page=2
```

### Filtering Parameters
```
GET /api/v1/blogs?category_id=1&status=1
GET /api/v1/projects?department_id=2
GET /api/v1/features?service_id=1
```

## 📝 Example Usage

### Complete Blog Controller Template

```php
<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Blog;
use App\Http\Requests\API\BlogRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends BaseController
{
    public function __construct()
    {
        $this->model = new Blog();
        $this->modelName = 'Blog';
    }

    /**
     * Display a listing of blogs with relationships
     */
    public function index(Request $request): JsonResponse
    {
        // Automatic pagination, search, and filtering
        // Uses the BaseController's index method with enhancements
    }

    /**
     * Store a newly created blog
     */
    public function store(BlogRequest $request): JsonResponse
    {
        // Validation handled by BlogRequest
        // Uses BaseController's store method with transaction support
    }

    /**
     * Display specific blog with relationships
     */
    public function show($id): JsonResponse
    {
        // Includes category and author relationships
        // Consistent error handling
    }

    // ... update and destroy methods
}
```

### Example API Calls

#### Create a new blog:
```bash
POST /api/v1/blogs
Content-Type: application/json

{
    "title": {
        "en": "Laravel Best Practices",
        "ar": "أفضل ممارسات Laravel"
    },
    "description": {
        "en": "Learn the best practices for Laravel development",
        "ar": "تعلم أفضل ممارسات تطوير Laravel"
    },
    "category_id": 1,
    "auther_id": 1,
    "is_active": true
}
```

#### Get paginated blogs with search:
```bash
GET /api/v1/blogs?search=Laravel&per_page=10&page=1
```

#### Update a blog:
```bash
PUT /api/v1/blogs/1
Content-Type: application/json

{
    "title": {
        "en": "Updated Laravel Best Practices"
    },
    "is_active": false
}
```

## 🔒 Security Features

1. **Input Validation**: All inputs are validated using Form Request classes
2. **SQL Injection Protection**: Uses Eloquent ORM and parameterized queries
3. **Authentication**: Sanctum middleware for protected routes
4. **Data Sanitization**: Automatic casting and validation
5. **Error Handling**: Consistent error responses without exposing sensitive data

## 🌍 Multi-language Support

The API fully supports the existing translatable fields:
- **Blogs**: title, description, slug
- **Categories**: name, slug  
- **Projects**: name, description, caption, long_description, technologies
- **Departments**: name, slug
- **Packages**: name, description, features
- **And more...**

## 🔄 Response Examples

### Success Response:
```json
{
    "status": true,
    "message": "Data retrieved successfully",
    "data": {
        "id": 1,
        "title": {
            "en": "Laravel Best Practices",
            "ar": "أفضل ممارسات Laravel"
        },
        "created_at": "2023-10-01T10:00:00.000000Z"
    }
}
```

### Error Response:
```json
{
    "status": false,
    "message": "Validation failed",
    "data": {
        "title.en": ["The English title is required"],
        "category_id": ["The selected category does not exist"]
    }
}
```

### Paginated Response:
```json
{
    "status": true,
    "message": "Data retrieved successfully",
    "data": {
        "current_page": 1,
        "data": [/* Your items */],
        "first_page_url": "http://example.com/api/v1/blogs?page=1",
        "last_page": 5,
        "per_page": 15,
        "total": 75
    },
    "pagination": {
        "currentPage": 1,
        "lastPage": 5,
        "perPage": 15,
        "total": 75
    }
}
```

## 🚀 Getting Started

1. **Test the API**: All endpoints are ready to use immediately
2. **Authentication**: Use existing Sanctum tokens for protected routes
3. **Validation**: Send data according to the validation rules in request classes
4. **Explore**: Use tools like Postman to explore all available endpoints

## ⚡ Performance Optimizations

- **Eager Loading**: Related models are automatically loaded where appropriate
- **Query Optimization**: Efficient database queries with proper indexing
- **Pagination**: Built-in pagination to handle large datasets
- **Caching**: Ready for Redis/Memcached implementation
- **Transaction Management**: Ensures data integrity during write operations

This API provides a complete, production-ready foundation for your Laravel application with consistent, secure, and scalable endpoints for all your models.
