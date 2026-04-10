# AI Agent Instructions

This repository contains the specification for the Archvadze Web Agency Platform.

You must build the system based on the documentation in the `/docs` directory.

Documentation files:

ARCHITECTURE.md  
System architecture and technology stack.

DATABASE.md  
Complete database schema specification.

ADMIN_PANEL.md  
Admin panel modules and Filament resources.

ROADMAP.md  
Development phases and module priorities.

---

# Development Rules

Follow these rules strictly:

1. Backend framework must be Laravel 11.

2. Admin panel must use Filament.

3. Frontend must use Blade + TailwindCSS + Alpine.js.

4. Database migrations must follow DATABASE.md.

5. Business logic must be implemented in Service classes.

6. Controllers must remain thin.

7. All models must use Eloquent relationships.

8. Follow SOLID principles.

---

# Implementation Order

The platform must be implemented in the following order:

1. Laravel project setup

2. Authentication system

3. Roles and permissions

4. Database migrations

5. Admin panel resources

6. Core modules (Clients, Projects, Orders)

7. CMS modules (Pages, Blog, Guides)

8. Marketing modules (Newsletter, Polls, Testimonials)

9. Client dashboard

10. Analytics and logging

---

# Folder Structure

Use the following structure:

app/  
Controllers  
Models  
Services  
Repositories

database/  
migrations

resources/views

routes/web.php

---

# Code Quality

Follow Laravel best practices.

- Use FormRequest validation

- Use Service layer

- Use repository pattern where needed

- Use eager loading for relationships

---

End of instructions.
