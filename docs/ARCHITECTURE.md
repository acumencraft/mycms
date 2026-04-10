# Archvadze Web Agency Platform

Technical Specification (AI Agent Ready)

## 1. Project Overview

**Project Name:** Archvadze Web Agency Platform  
**Domain:** archvadze.com  
**Type:** Web Agency Platform / CMS / CRM / Client Portal

The platform must serve three purposes:

1. Marketing website for web development services

2. Client acquisition and project ordering system

3. Internal agency management system

The system must be modular, scalable and production-ready.

---

# 2. Technology Stack

## Backend

Framework: Laravel 11  
Language: PHP 8.3+

Required packages:

- Filament (Admin Panel)

- Laravel Breeze or Laravel Jetstream (Auth)

- Spatie Laravel Permission

- Spatie Media Library

- Laravel Scout (optional search)

- Laravel Horizon (queues)

- Laravel Telescope (debug)

---

## Frontend

Frontend must use:

- Blade templates

- TailwindCSS

- Alpine.js

- Laravel Livewire (for dynamic components)

---

## Database

Engine: MySQL / MariaDB

All tables must include:

- id

- created_at

- updated_at

Use foreign keys and indexing where needed.

---

## Local Development

Environment must run using DDEV.

Required tools:

- Docker

- DDEV

- Composer

- Node.js

Setup steps:

```
ddev config
ddev start
composer install
npm install
npm run dev
php artisan migrate
```

---

# 3. System Architecture

The platform must follow layered architecture.

Layers:

1. Presentation Layer

2. Application Layer

3. Domain Layer

4. Infrastructure Layer

Structure:

```
app/
 ├ Http
 │  ├ Controllers
 │  ├ Middleware
 ├ Models
 ├ Services
 ├ Repositories
 ├ Policies
 ├ Jobs
 ├ Notifications
```

Business logic must NOT live inside controllers.

Controllers should call Services.

---

# 4. User Roles

The system must support role based permissions.

Roles:

- Super Admin

- Admin

- Editor

- Support

- Client

Use Spatie Laravel Permission.

---

# 5. Core Modules

The system must contain the following modules.

## Authentication

Features:

- Registration

- Login

- Password reset

- Email verification

---

## Client Management

Clients table must store:

- name

- email

- phone

- company

- country

Admin must be able to:

- create client

- edit client

- view client projects

- attach notes

---

## Project Management

Each project must include:

- title

- description

- status

- deadline

- price

- client_id

Project statuses:

- pending

- in_progress

- review

- completed

Projects must support:

- tasks

- messages

- file uploads

---

## Order System

Visitors must be able to order a website.

Order wizard must collect:

- business type

- website type

- selected services

- selected features

- domain name

- hosting preference

System must calculate estimated price.

Orders must appear in Admin Panel.

---

## Services Module

Admin must manage services.

Fields:

- name

- description

- base_price

- icon

- status

---

## Features Module

Optional features that can be added to projects.

Examples:

- Multilingual support

- Booking system

- Payment gateway

- Admin panel

- SEO package

---

## Portfolio Module

Showcase completed projects.

Each portfolio item must include:

- title

- description

- images

- technologies used

- project url

Images must be stored using Media Library.

---

## Publications (Blog)

Blog system must include:

- categories

- tags

- SEO metadata

Fields:

- title

- slug

- content

- author

- publish_date

- status

---

## Guides / Knowledge Base

Educational content for clients.

Examples:

- How to choose a domain

- Website launch checklist

- SEO basics

---

## FAQ Module

Store frequently asked questions.

Each FAQ:

- question

- answer

- category

---

## Testimonials

Client reviews.

Fields:

- client_name

- company

- rating

- testimonial_text

- photo

---

## Contact System

Contact page must include:

- office address

- map location

- contact form

Contact form messages must be stored in database.

---

## Poll System

Website visitors can participate in polls.

Poll structure:

Poll  
Options  
Votes

Votes must store IP to prevent duplicate votes.

---

## Newsletter

Visitors can subscribe to updates.

Fields:

- email

- status

---

## Media Library

All uploaded media must be stored in a central library.

Media must support:

- images

- documents

- project files

---

## Analytics

Track website usage.

Metrics:

- page views

- popular pages

- visitor locations

---

## Activity Logs

Every admin action must be logged.

Examples:

- user login

- content published

- service edited

- project updated

---

# 6. CMS Pages

The system must support dynamic pages.

Example pages:

- About

- Privacy Policy

- Terms

- Custom landing pages

Fields:

- title

- slug

- content

- SEO metadata

---

# 7. Settings System

Use key-value settings table.

Examples:

- site_name

- contact_email

- office_address

- latitude

- longitude

- phone

- working_hours

Admin must edit settings from dashboard.

---

# 8. Domain Search Feature

Visitors must be able to search domain availability.

Use external domain API.

Example APIs:

- WhoisXML

- Namecheap API

- Domainr API

Search results must show:

- domain availability

- estimated price

- TLD suggestions

Search logs must be stored.

---

# 9. Client Dashboard

Clients must have their own portal.

Features:

- view projects

- view project status

- upload files

- send messages

- download documents

---

# 10. Admin Panel

Admin interface must be built using Filament.

Navigation:

Dashboard  
Users  
Clients  
Projects  
Orders  
Services  
Portfolio  
Publications  
Guides  
FAQ  
Testimonials  
Polls  
Newsletter  
Media Library  
Settings  
Analytics  
Logs

---

# 11. Security Requirements

Security rules:

- CSRF protection

- Rate limiting

- Password hashing (bcrypt)

- Input validation

- XSS protection

Use Laravel Form Requests for validation.

---

# 12. Performance

System must support:

- caching

- queue jobs

- optimized database queries

- image optimization

Use:

- Redis (optional)

- Laravel cache

- lazy loading prevention

---

# 13. Deployment

Target environment:

Hostinger Shared Hosting

Deployment steps:

```
git pull
composer install
php artisan migrate
php artisan config:cache
php artisan route:cache
```

Public directory must be configured correctly.

---

# 14. Future Expansion

System must allow future modules:

- payment gateway

- subscription plans

- SaaS website builder

- automated hosting provisioning

- AI website generation

---

# 15. Development Standards

Follow best practices:

- SOLID principles

- Service layer pattern

- Repository pattern

- Clean controllers

- Modular architecture

Code must be documented and readable.

---

# End of Specification
