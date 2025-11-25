Hive Workshop Community Platform
A Laravel-based community platform for sharing and discovering Warcraft III resources, maps, models, and tools.

https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white
https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white

🚀 Features
🔐 User Authentication - Secure registration and login system

📁 Resource Management - Upload, browse, and download resources

🗂️ Category System - Organized by Maps, Models, Skins, Tools, Icons, Scripts

⭐ Rating & Reviews - Community feedback system

🔍 Advanced Search - Filter by category, tags, and keywords

📊 Analytics - Download tracking and view statistics

🎨 Modern UI - Responsive design with Tailwind CSS

👥 User Roles - Admin, Moderator, and User permissions

🏷️ Tagging System - Flexible resource categorization

🛠️ Tech Stack
Backend: Laravel 10

Frontend: Tailwind CSS, Blade Templates

Database: MySQL / SQLite

Authentication: Laravel Breeze

Icons: Font Awesome

Deployment Ready: Optimized for production

📦 Installation
Prerequisites
PHP 8.1+

Composer

Node.js & NPM

MySQL or SQLite

Step-by-Step Setup
Clone the repository

bash
git clone https://github.com/your-username/hive-workshop.git
cd hive-workshop
Install PHP dependencies

bash
composer install
Install frontend dependencies

bash
npm install
npm run build
Environment setup

bash
cp .env.example .env
php artisan key:generate
Configure database
Edit .env file:

env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hive_workshop
DB_USERNAME=root
DB_PASSWORD=

# Or use SQLite for development
# DB_CONNECTION=sqlite
Run migrations and seeders

bash
php artisan migrate --seed
Start development server

bash
php artisan serve
Visit http://localhost:8000 to see the application.

👤 Default Accounts
After seeding, you can login with these accounts:

Role	Email	Password	Access
Admin	admin@hiveworkshop.com	password	Full access
Moderator	moderator@hiveworkshop.com	password	Content moderation
User	user@hiveworkshop.com	password	Standard user
🗃️ Database Structure
text
databases/
├── users
├── user_profiles
├── categories
├── resources
├── tags
├── resource_tag (pivot)
├── comments
├── ratings
└── downloads
Key Models
User: Authentication and profile management

Resource: Main content with files and metadata

Category: Resource classification (Maps, Models, etc.)

Tag: Flexible labeling system

Comment: User discussions and feedback

Rating: 1-5 star rating system

🎨 Project Structure
text
hive-workshop/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── HomeController.php
│   │       ├── ResourceController.php
│   │       └── CategoryController.php
│   └── Models/
│       ├── User.php
│       ├── Resource.php
│       ├── Category.php
│       ├── Tag.php
│       ├── Comment.php
│       ├── Rating.php
│       └── Download.php
├── database/
│   ├── migrations/
│   │   ├── create_users_table.php
│   │   ├── create_resources_table.php
│   │   ├── create_categories_table.php
│   │   └── ...other migrations
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── UserSeeder.php
│       ├── CategorySeeder.php
│       └── ResourceSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── home.blade.php
│       ├── resources/
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       └── categories/
│           ├── index.blade.php
│           └── show.blade.php
├── routes/
│   └── web.php
├── public/
│   └── uploads/
│       └── resources/
├── config/
└── tests/
🛣️ Available Routes
Method	Route	Description	Controller
GET	/	Homepage with stats	HomeController@index
GET	/resources	Browse all resources	ResourceController@index
GET	/resources/{resource}	View resource details	ResourceController@show
GET	/categories	Browse categories	CategoryController@index
GET	/categories/{category}	View category resources	CategoryController@show
🛠️ Development Commands
Running Tests
bash
php artisan test
Generating Assets
bash
npm run dev
# or for production
npm run build
Database Reset
bash
php artisan migrate:fresh --seed
Creating New Components
bash
# New controller
php artisan make:controller PhotoController --resource

# New model with migration
php artisan make:model Product -m

# New migration
php artisan make:migration create_products_table
🌟 Key Features Detail
Resource Management
File upload with validation

Version control for updates

Download tracking

Approval workflow for submissions

User System
Role-based permissions (Admin, Moderator, User)

Reputation system

User profiles with avatars

Activity tracking

Search & Discovery
Full-text search across titles and descriptions

Category filtering

Tag-based navigation

Sort by popularity, recent, downloads

📊 Database Schema Overview
Users Table
id, name, email, password, role, reputation, is_active

Resources Table
id, user_id, category_id, title, slug, description, file_path, download_count, view_count, is_approved

Categories Table
id, name, slug, description, color, icon, is_active

🤝 Contributing
Fork the project

Create your feature branch (git checkout -b feature/AmazingFeature)

Commit your changes (git commit -m 'Add some AmazingFeature')

Push to the branch (git push origin feature/AmazingFeature)

Open a Pull Request

📝 License
This project is licensed under the MIT License.

🆘 Support
If you encounter any issues:

Check the Issues page

Create a new issue with detailed description

Provide steps to reproduce the problem

🚀 Deployment
For Production
Set APP_ENV=production in .env

Run php artisan config:cache

Run php artisan route:cache

Ensure file permissions are correct

Set up proper database backups

Environment Variables
Key environment variables to configure:

env
APP_NAME="Hive Workshop"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
# ... other DB settings

SESSION_DRIVER=database
Built with ❤️ using Laravel and Tailwind CSS

For more information, visit the Laravel documentation.