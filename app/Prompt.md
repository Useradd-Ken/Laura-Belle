You are a Senior UI/UX Engineer specializing in ERP, Accounting Systems, and Vue.js applications.

## Context

I already have a fully working backend.

**Do NOT modify or regenerate:**

* Laravel API
* Database
* Models
* Controllers
* Routes
* Business logic

Everything already exists.

The API endpoints and database are complete.

Your job is **ONLY to redesign the frontend UI**.

---

## Tech Stack

* Vue.js
* Tailwind CSS
* Laravel API (already connected)
* Vue Router

---

## Goal

Redesign my current **Chart of Accounts** page into a modern ERP-style interface similar to:

* QuickBooks
* Xero
* Odoo
* SAP
* Oracle NetSuite

The current page is just a form above a table.

I want a professional accounting dashboard.

---

## Design Style

Modern

Minimal

Professional

ERP

Lots of whitespace

Rounded cards

Soft shadows

Smooth hover animations

Responsive

No flashy gradients.

No glassmorphism.

Keep it clean and business-oriented.

---

## Layout

Create a dashboard layout.

Top:

Chart of Accounts

Subtitle

Buttons

Below:

Statistics cards

Example:

Total Accounts

Assets

Liabilities

Revenue

Expenses

Active Accounts

Header Accounts

Posting Accounts

---

Main Area

Split into two panels.

LEFT PANEL

Chart of Accounts Tree

Display hierarchy.

Example:

📁 Assets

```
📁 Current Assets

    💵 Cash

    🏦 Bank

    📄 Accounts Receivable
```

📁 Liabilities

📁 Equity

📁 Revenue

📁 Expenses

Requirements:

* Expand / Collapse
* Search
* Highlight selected account
* Nice folder icons
* Active account indicator

---

RIGHT PANEL

Account Details

Nicely formatted card showing:

* Account Code
* Account Name
* Type
* Parent
* Normal Balance
* Description
* Status
* Created Date
* Updated Date

Action buttons:

Edit

Delete

View Ledger

---

New/Edit Account

Replace the inline form with a **right-side slide-over drawer**.

When clicking:

New Account

or

Edit

Open the drawer.

The drawer contains the existing form.

Do NOT create a new page.

---

Account Table

Allow switching between:

Tree View

Table View

Table columns:

Code

Name

Type

Parent

Status

Actions

Actions:

View

Edit

Delete

Add Child

View Ledger

---

Filtering

Top toolbar:

Search

Type Filter

Status Filter

Sort

Rows per page

---

Badges

Color account types.

Asset → Green

Liability → Red

Equity → Purple

Revenue → Blue

Expense → Orange

Status badges:

Active

Inactive

Header

Posting

---

Icons

Use Lucide icons.

Examples:

Folder

FolderOpen

Landmark

Wallet

Building

Coins

ChevronRight

ChevronDown

Search

Plus

Edit

Trash

Eye

FileText

---

Animations

Use Tailwind transitions.

Smooth hover effects.

Drawer animation.

Expand/collapse animation.

Button hover animations.

---

Code Structure

Break the page into reusable Vue components.

Example:

ChartOfAccounts/

Index.vue

components/

AccountTree.vue

AccountTable.vue

AccountDrawer.vue

AccountDetails.vue

AccountToolbar.vue

AccountStats.vue

Do not create one huge Vue file.

---

Important

Assume every API already works.

Do not change API calls.

Do not modify fetch logic.

Do not modify backend code.

Focus only on producing a polished, production-quality frontend layout and component structure using the existing data.
