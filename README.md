# Biswas IT Firm Agency Automation Hunt

Laravel 12 + Vue 3 + Inertia prototype and an in-app research report for the agency's repetitive workflows.

## What is included

- `/automation`: 10-task report with current workflow, estimated manual effort, proposed automation, suggested tools, free/paid notes and estimated minutes saved.
- `/leads`: working lead qualification prototype. Submit a lead to save it, calculate a rule-based score and Hot/Warm/Cold priority, and generate a follow-up draft. Search, filters, metrics, lead detail and delete are included.
- The generated reply is a draft; staff should review it before sending.

The time figures are planning estimates because no agency time log was supplied. They are per task unit and do not represent measured savings. Record a one-week baseline before deciding what to automate first.

## Run locally

```sh
composer install
copy .env.example .env
php artisan key:generate
```

Configure a database in `.env`, then run:

```sh
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

Open `http://127.0.0.1:8000/automation` for the report or `/leads` for the prototype.

## Lead score

The score is capped at 100 and uses fixed, visible rules: base 20; budget bands add 0–35; urgency adds 10–30; supported core services add 15 (other services add 10); a referral source adds 10. Scores ≥75 are Hot, ≥50 Warm, otherwise Cold. This is a demo heuristic, not a validated sales model. Review outcomes and tune it before relying on it operationally.

## Costs and estimates

Pricing and free-tier limits change and can depend on region, billing period and account. The report links to official plan pages and notes the check date; confirm current details before purchase. Prototype hosting, domain, email delivery and database services may add costs.
