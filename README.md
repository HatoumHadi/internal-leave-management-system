<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

---

## About the Leave Management System

This project provides a simple dashboard-style backend system for managing employee leave requests. The system supports basic CRUD operations and a workflow for submitting and approving leave requests.

The system is divided into two dashboards:

- **Admin Dashboard:** Used by the admin to manage leave requests.
- **Employee Dashboard:** Used by employees to add leave requests and view all of their requests.

### Features:

- **Admin Dashboard:**
    - Admin can manage employee leave requests.
    - Admin can approve or deny leave requests.
    - Admin can view a list of all their leave requests.


- **Employee Dashboard:**
    - Employees can submit new leave requests.
    - Employees can view a list of all their leave requests.


- **Authentication:**
    - The application uses **[Laravel Breeze](https://laravel.com/docs/9.x/starter-kits#laravel-breeze)** for authentication.
    - Breeze provides simple and minimal authentication scaffolding, including login, registration, and password reset functionality.
    - Users can securely register, log in, with minimal setup and built-in features.


- **Testing:**
    - The system includes tests to ensure proper functionality:
        - **Admin tests:** Verify that the admin can manage and approve leave requests. These tests are located in the `Admin` feature tests.
        - **Employee tests:** Ensure that employees can submit and view their leave requests. These tests are located in the `Employee` feature tests.


--- 

## Installation

Follow these steps to install and set up the system:

1. Clone the repository:

    ```bash
    git clone https://github.com/HatoumHadi/internal-leave-management-system.git
    ```

2. Navigate to the project directory:

    ```bash
    cd internal-leave-management-system
    ```

3. Update dependencies:

    ```bash
    composer update
    ```

4. Copy the `.env.example` file to `.env`:

    ```bash
    cp .env.example .env
    ```

5. Generate the application key:

    ```bash
    php artisan key:generate
    ```

6. Run migrations and seed the database:

    ```bash
    php artisan migrate --seed
    ```
   
7. Install the frontend dependencies:

    ```bash
    npm install
    ```

8. Run the build process to compile the assets:

    ```bash
    npm run dev
    ```

9. Serve the application:

    ```bash
    php artisan serve
    ```

---

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
