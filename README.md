# Tenanzo

A rental application manager for small landlords. Landlords list properties, tenants submit applications, and both sides track status in real time.

Built as a portfolio project to demonstrate full-stack development with the Laravel + Vue 3 + Inertia.js stack.

---

## Live demo

🔗 **[tenanzo.up.railway.app](https://tenanzo.up.railway.app)** *(update this after deploying)*

### Test accounts

| Role | Email | Password |
|------|-------|----------|
| Landlord | landlord@tenanzo.test | password |
| Tenant | tenant@tenanzo.test | password |
| Tenant | tenant2@tenanzo.test | password |

---

## Stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel 11 |
| Frontend | Vue 3 (Composition API) |
| Routing / SSR bridge | Inertia.js |
| Database | PostgreSQL |
| Auth scaffold | Laravel Breeze |
| Deployment | Railway |

---

## Features

- **Two roles** — landlord and tenant, selected at registration
- **Property listings** — landlords create, edit, and deactivate properties
- **Rental applications** — tenants apply with a cover message, income, and move-in date; one application per property enforced
- **Status workflow** — landlord approves or rejects with an optional note; tenants see their status update in real time
- **Auth** — registration, login, email verification via Breeze

---

## Local setup

**Requirements:** PHP 8.2+, Composer, Node 18+, PostgreSQL (or SQLite for development)

```bash
git clone https://github.com/your-username/tenanzo.git
cd tenanzo

cp .env.example .env
# Set DB_CONNECTION, DB_DATABASE, DB_USERNAME, DB_PASSWORD in .env

composer install
php artisan key:generate
php artisan migrate --seed SeedTestData

npm install && npm run dev
php artisan serve
```

Visit `http://localhost:8000` — the seeder creates 3 properties and test accounts for both roles.

---

## Project structure

```
app/
  Http/Controllers/
    PropertyController.php     # CRUD for properties
    ApplicationController.php  # Apply, approve/reject, dashboards
  Models/
    Property.php
    Application.php
resources/js/Pages/
  Properties/
    Index.vue                  # Public listing
    Show.vue                   # Detail + application form
  Dashboard/
    LandlordView.vue           # Properties + incoming applications
    TenantView.vue             # Tenant's own applications + statuses
```

---

## What I'd build next

The core workflow is intentionally tight i.e, list, apply, decide. In a production product I'd extend it in three directions:

**AI-powered tenant screening**  parse uploaded income documents and reference letters with an LLM, surface a plain-language summary and a risk score for the landlord. This removes the manual reading step that slows most landlords down.

**Automated lease generation**  on approval, trigger a document generation pipeline that fills a lease template from application data (tenant name, property address, rent, move-in date) and sends it for e-signature via DocuSign or a similar API.

**Notifications and messaging**  email + in-app notifications on status changes, plus a simple thread between landlord and tenant per application so all communication stays attached to the record rather than scattered across email.

Multi-tenancy for property management companies (one account, many landlords) and a Stripe integration for deposit collection on approval are natural next steps after that.

---

## AI tooling used

I used **Cursor** throughout this project as my primary editor. The most useful applications were:

- Scaffolding repetitive boilerplate (migrations, model relationships, form validation rules) so I could focus on the domain logic and architecture decisions
- Generating a first draft of Vue components that I then restructured are particularly useful for the `LandlordView` dashboard where the nested property → applications data shape required careful prop handling
- Explaining unfamiliar Inertia.js patterns (like `useForm()` error binding) inline without breaking flow

The architecture decisions which are role design, status workflow, authorization approach were made manually. AI tooling accelerated the implementation; it didn't replace the thinking.

---

## License

MIT
