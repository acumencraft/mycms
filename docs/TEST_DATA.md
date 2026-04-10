# Test Data Setup Instructions for Archvadze Platform

This file contains instructions for generating realistic test data for all modules in the Archvadze web agency platform.

---

## 1. Users & Clients

- Create 5 users with role 'Client'.
- Each user should have 1–3 clients associated via `user_id`.
- Use realistic names, emails, and phone numbers.
- Example:
  - User: client1@example.com / password
  - Client: "Acme Corp", contact_name: "John Doe", email matches user, phone random.

---

## 2. Projects

- Each client should have 1–3 projects.
- Include `status` (pending, in_progress, completed), `price`, `deadline`, and assigned `client_id`.
- Include message history (ProjectMessage) and file attachments (ProjectFile) where possible.
- Randomize `completed_at` dates for completed projects.

---

## 3. Services

- Create 5–10 services.
- Boolean `is_active` should be randomly true/false.
- Include name, description, price, and duration.

---

## 4. Portfolio Projects

- Create 5–10 portfolio projects linked to clients.
- Boolean `is_featured` randomly true/false.
- Include `completed_at` for ordering.
- Include associated `PortfolioImage` entries.

---

## 5. Publications

- 5–10 publications with random categories and tags.
- Boolean `is_published` randomly true/false.
- Include `published_at` dates in the past month.

---

## 6. Testimonials

- 3–5 testimonials.
- Boolean `is_featured` randomly true/false.
- Include client_name and testimonial_text fields.

---

## 7. Polls

- 1–2 polls.
- Each poll has 3–4 options.
- Include votes (PollVote) for each option, random counts.

---

## 8. Guides

- 3–5 guides with categories.
- Include title, content, and associated category.

---

## 9. Seeder / Factory Rules

- Use Laravel 11 Factories and Seeders.
- Ensure proper Eloquent relationships between clients, projects, services, publications, testimonials, polls, and guides.
- Randomize data for realism.
- Run all seeders after migrations: `php artisan migrate:fresh --seed`
- After seeding, test:
  - Homepage loads featured services, portfolio projects, publications, testimonials.
  - Client Dashboard shows assigned projects and messages.
  - Admin Panel resources display seeded data correctly.

---

End of Test Data Instructions
