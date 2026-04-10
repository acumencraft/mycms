# AI Agent Instructions

This repository contains the specification for the Archvadze Web Agency Platform.

You must build the system based on the documentation in the `/docs` directory.

Documentation files:

- ARCHITECTURE.md – System architecture and technology stack.
- DATABASE.md – Complete database schema specification.
- ADMIN_PANEL.md – Admin panel modules and Filament resources.
- ROADMAP.md – Development phases and module priorities.

---

# Development Rules

Follow these rules strictly:

1. Backend framework must be Laravel 11.
2. Admin panel must use Filament and create resources automatically for all modules.
3. Frontend must use Blade + TailwindCSS + Alpine.js + Livewire.
4. Database migrations must strictly follow DATABASE.md.
5. Business logic must be implemented in Service classes.
6. Controllers must remain thin.
7. All models must use Eloquent relationships.
8. Use FormRequest validation for all inputs.
9. Follow SOLID principles.
10. Create client dashboard, CMS modules, marketing modules, and analytics as specified in ROADMAP.md.
11. All generated code must follow Laravel, TailwindCSS, and Filament best practices.

---

# Implementation Order (Step-by-Step)

## Step 1: Laravel Project Setup

- Use `composer create-project laravel/laravel .` in the project root.
- Configure `.env` for DDEV environment:
  DB_CONNECTION=mysql  
  DB_HOST=db  
  DB_PORT=3306  
  DB_DATABASE=db  
  DB_USERNAME=db  
  DB_PASSWORD=db
  
  

- Generate `APP_KEY` using `php artisan key:generate`.
- Ensure storage and bootstrap directories are writable.

## Step 2: Authentication System

- Use Laravel Breeze or Jetstream for authentication.
- Implement registration, login, password reset, and email verification.

## Step 3: Roles and Permissions

- Use Spatie Permission package.
- Create roles: Super Admin, Admin, Editor, Support, Client.
- Assign permissions to each role as per ARCHITECTURE.md.

## Step 4: Database Migrations

- Implement all migrations exactly as defined in DATABASE.md.
- Use foreign keys, indexes, and pivot tables where necessary.
- Seed initial roles and admin user.

## Step 5: Admin Panel Resources

- Use Filament to scaffold all resources automatically.
- Resources must include:
- Clients
- Projects
- Orders
- Services
- Features
- Portfolio
- Publications
- Guides
- FAQ
- Pages
- Testimonials
- Polls
- Newsletter
- Media Library
- Settings
- Analytics
- Activity Logs

## Step 6: Core Modules

- Implement Clients, Projects, and Orders modules.
- Projects module must support tasks, messages, and file uploads.
- Orders module must have domain search, service selection, and pricing calculation.

## Step 7: CMS Modules

- Implement Pages, Blog/Publications, Guides, and FAQ modules.
- Support categories, tags, SEO metadata.
- All content must be editable via Filament admin panel.

## Step 8: Marketing Modules

- Implement Newsletter subscription system.
- Implement Polls system with options and vote tracking.
- Implement Testimonials system.
- All data must be manageable in Filament admin panel.

## Step 9: Client Dashboard

- Implement frontend portal for clients:
- View projects and status
- Upload files
- Send messages
- Download documents

## Step 10: Analytics and Logging

- Implement Activity Logs for all admin actions.
- Implement page visit tracking.
- Implement domain search logs.

---

# Folder Structure

app/
├ Controllers
├ Models
├ Services
├ Repositories
├ Actions
├ DTO
├ Policies

database/
├ migrations
├ seeders
├ factories

resources/views/
├ frontend/
├ admin/
├ client_dashboard/

routes/
├ web.php
├ api.php

public/
├ css/
├ js/
├ images/



# Important Notes for AI

- Scaffold all Filament admin panel resources automatically.

- Implement all migrations according to DATABASE.md.

- Use Service layer and Repository pattern.

- Keep controllers thin; no business logic inside controllers.

- Setup DDEV environment properly.

- Implement client dashboard, CMS modules, marketing modules, and analytics.

- Use Livewire for interactive frontend components.

- Follow Laravel, TailwindCSS, and Filament best practices.

- Generate all folders, files, and configurations needed to run the platform.
