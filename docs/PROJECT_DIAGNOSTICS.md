# Archvadze Platform – Full Diagnostics Task

The project is a Laravel 12 application running in DDEV with Filament 5.3.4.

Your task is to perform a complete diagnostics pass and produce a report of all errors, inconsistencies, and potential issues.

## 1. Filament Resources

Check all files in:

app/Filament/Resources

Verify:

- All classes import the correct Filament namespaces.
- No deprecated or missing classes (e.g. BulkActionGroup).
- Table actions and bulkActions use syntax compatible with Filament v5.
- All columns reference real database fields.
- All relations exist in models.

Resources to inspect include:

- OrderResource
- ServiceResource
- PortfolioProjectResource
- PublicationResource
- TestimonialResource
- ClientResource
- ProjectResource

If an action class is missing or outdated, replace it with the correct syntax.

Example correct bulkActions syntax:

->bulkActions([
    Tables\Actions\DeleteBulkAction::make(),
])

---

## 2. Database Schema Validation

Check all Models in:

app/Models

For each model:

- Ensure all referenced columns exist in the database.
- Check boolean fields like:

is_active  
is_featured  
is_published  

- Ensure foreign keys exist for relationships like:

client_id  
user_id  
project_id  

If any column is missing, generate a migration to add it.

---

## 3. Controller Verification

Inspect all controllers in:

app/Http/Controllers

Check for:

- Queries referencing non-existent columns
- Broken relationships
- Missing validation
- Incorrect eager loading

Controllers to review:

- HomeController
- ClientDashboardController
- ServiceController
- PublicationController
- PortfolioController

---

## 4. Routes Validation

Check:

routes/web.php  
routes/api.php

Verify:

- All routes reference existing controllers and methods.
- Middleware exists.
- No duplicate routes.
- Client dashboard routes are protected by auth and role middleware.

---

## 5. Frontend Rendering

Check Blade templates in:

resources/views

Verify:

- Layout loads Tailwind CSS.
- Sections render controller data.
- Homepage displays:

featured services  
portfolio projects  
publications  
testimonials  

---

## 6. Admin Panel Testing

Simulate loading these pages:

/admin/orders  
/admin/services  
/admin/portfolio-projects  
/admin/publications  
/admin/testimonials  

Identify:

- Missing columns
- Filament component errors
- Relationship errors

---

## 7. Output Required

Create a report file:

docs/diagnostics_report.md

The report must contain:

### Critical Errors

Errors that break the application.

### Database Issues

Missing columns, wrong types, broken relations.

### Filament Issues

Outdated syntax, missing classes.

### Controller Issues

Invalid queries or logic.

### Frontend Issues

Pages not rendering or missing assets.

### Suggested Fixes

Concrete code changes or migrations required.

Do NOT modify code yet.  
First generate the full diagnostics report.
