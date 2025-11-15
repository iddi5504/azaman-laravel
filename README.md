# Azaman

Azaman is a Laravel-based web application built for [describe purpose briefly, e.g., "managing XYZ services" or "a project management tool"]. It is designed to be secure, fast, and easy to deploy on a VPS or cloud server.

---

## Features

- User authentication and authorization
- Dynamic content management
- RESTful API endpoints
- Logging and error tracking
- Responsive design for desktop and mobile
- Ready for multi-domain deployment on a single server

---

## Tech Stack

- **Backend:** Laravel 10, PHP 8.2+
- **Frontend:** Blade templates, optionally Vue.js or React
- **Database:** MySQL / MariaDB
- **Server:** Nginx
- **Version Control:** Git

---

## Requirements

- PHP 8.2+
- Composer
- Postgres
- Nginx or Apache
- Node.js and npm (optional, for frontend build)
- Git

---

## Project Setup and Deployment Guide

This guide covers the steps for setting up the project locally, running it, and deploying it using Nginx

### 1. Clone the repository




```bash
git clone https://github.com/iddi5504/azaman-laravel.git
cd azaman-laravel
```

---


### 2. Install PHP Dependencies

Use Composer to install all necessary PHP packages.

```bash
composer install
```

3. Install Node.js Dependencies (Optional)
If your project includes front-end assets (like CSS/JavaScript) that need compilation, run the following commands:

Bash

```
npm install
npm run build
```



4. Configure Environment
Copy the example environment file and generate an application key.

Bash
```
cp .env.example .env
php artisan key:generate
```
Note: Update the newly created .env file with your database credentials and any other configuration values specific to your environment.

5. Run Database Migrations
Set up the database schema using migrations.



```
php artisan migrate
```
6. Set Proper Permissions
Ensure the web server has the necessary permissions to write to the storage and bootstrap/cache directories.

```
sudo chown -R deploy:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

🏃 7. Run Locally (Optional)
To test the application on your local machine, use the built-in PHP development server.

```
php artisan serve

```
Visit the application at: http://localhost:8000

☁️ 8. Nginx Deployment:
Follow these steps to configure Nginx for production deployment.

Server Block Configuration
Create a new server block configuration file at /etc/nginx/sites-available/azaman:

Nginx

```
server {
    listen 80;
    server_name yourdomain.com;
    root /home/deploy/azaman-laravel/public;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }

    error_log /var/log/nginx/azaman_error.log;
    access_log /var/log/nginx/azaman_access.log;
}
```

Enable Site and Reload Nginx
Create a symbolic link to enable the site, test the configuration, and reload Nginx.

```
sudo ln -s /etc/nginx/sites-available/azaman /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```
📝 9. Notes & Recommendations
Ensure the storage and bootstrap/cache directories are writable by the web server process.

Use HTTPS in production.

Memory Optimization for Small VPS (e.g., 512 MB RAM): Consider adding swap space to prevent memory issues.

```
sudo fallocate -l 2G /swapfile
sudo chmod 600 /swapfile
sudo mkswap /swapfile
sudo swapon /swapfile
echo '/swapfile none swap sw 0 0' | sudo tee -a /etc/fstab

```
Asset Management: Prebuild front-end assets in your CI/CD pipeline before deploying to the server.

🤝 Contributing
We welcome contributions! Please follow these steps:

Fork the repository.

Create a new feature branch.

Make your changes.

Submit a pull request.

📜 License
This project is released under the MIT License.

📬 Contact
For questions or feedback, you can reach out via:

GitHub: iddi5504

Email: iddi5504@gmail.com




