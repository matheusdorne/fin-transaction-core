# 💸 FinTransaction Core

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vuedotjs&logoColor=4FC08D)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2CA5E0?style=for-the-badge&logo=docker&logoColor=white)

## 📖 About The Project

**FinTransaction Core** is a robust simulation of a Peer-to-Peer (P2P) payment system.

This project was developed primarily as a **focused study lab** to master **Test-Driven Development (TDD)** and explore concepts of **Idempotency**.

My goal was to move beyond basic CRUD and implement a resilient architecture that guarantees data consistency even under high concurrency or network failures.

## 🚀 Technical Highlights & Concepts Learned

This project implements "Senior-Level" patterns to ensure data safety:

* **🧪 TDD First:** The entire business logic (Services) was built using Test-Driven Development. I wrote the tests *before* the code to guarantee that every financial constraint and edge case was covered from day one.
* **🔄 Idempotency & Consistency:** Designed the transaction flow to be safe against double-processing. Using database constraints and atomic transactions, the system ensures that a retry of a failed request does not result in a duplicate transfer.
* **💰 Pessimistic Locking:** Uses `lockForUpdate()` on database rows during transfers to prevent Race Conditions (ensuring a user cannot spend the same balance twice simultaneously).
* **⚡ Asynchronous Queues:** Decoupled the Notification Service from the main transaction flow using Laravel Jobs to improve response times and fault tolerance.
* **🛡️ External Mock Integration:** Simulates interaction with third-party "Authorization" and "Notification" gateways, handling HTTP failures gracefully.
* **📦 Service Pattern:** Encapsulated business logic in dedicated Service classes (`TransferService`), adhering to SOLID principles and keeping Controllers slim.

## 🛠 Tech Stack

* **Backend:** PHP 8.3, Laravel 11
* **Frontend:** Vue.js 3 (Composition API), Inertia.js, Tailwind CSS
* **Database:** MySQL 8.0
* **Environment:** Docker (Laravel Sail)
* **Testing:** PHPUnit (Feature & Unit Tests)

## ⚙️ Installation

This project uses **Laravel Sail** (Docker), so you don't need to install PHP or Node locally.

```bash
# 1. Clone the repo
git clone [https://github.com/YOUR_USERNAME/fin-transaction-core.git](https://github.com/YOUR_USERNAME/fin-transaction-core.git)
cd fin-transaction-core

# 2. Install Dependencies
./vendor/bin/sail up -d
./vendor/bin/sail composer install
./vendor/bin/sail npm install

# 3. Setup Database
./vendor/bin/sail artisan migrate

# 4. Compile Frontend
./vendor/bin/sail npm run dev
