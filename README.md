# DineFlow – Multi-Tenant Restaurant Platform (Laravel 12)

A production-grade **Laravel 12** project showcasing **scalable backend architecture** with **MySQL, Redis, queues, Elasticsearch, Docker, and CI/CD**.
Designed to demonstrate mastery of **Laravel, API development, caching, cloud deployment, and backend best practices** for enterprise applications.

---

## 🚀 Features

* **Laravel 12 API-first** backend
* **Multi-tenant support** (restaurants, branches, staff, customers)
* **RESTful API** with OpenAPI/Swagger docs
* **Authentication & RBAC**

  * Laravel Sanctum (SPA/mobile tokens)
  * Policies & Gates for access control
* **Databases:** MySQL (primary), Redis (cache/queue), Elasticsearch (search)
* **Queues & Background Jobs** (Redis, SQS, RabbitMQ)
* **Caching:** Redis response/query cache, tags, rate limiting
* **Inventory & Orders:** transactional consistency with locking
* **Payments:** external gateway integration + webhook handling
* **Notifications:** email, SMS, push with retries & DLQ
* **File Storage:** S3/MinIO with signed URLs
* **CI/CD:** GitHub Actions (lint → test → Docker build → deploy)
* **Cloud Ready:** deployable to AWS ECS/Fargate or DigitalOcean
* **Observability:** JSON logs, request tracing, audit logs
* **Testing:** PHPUnit + Pest (unit, feature, integration)

---

## 🏗️ Architecture

* **App:** Laravel 12 (PHP 8.3, tested against 8.4 in CI)
* **Web server:** Nginx
* **Containers:** Docker Compose (local) → Docker images (prod)
* **Infra:**

  * MySQL 8 (relational DB)
  * Redis 7 (cache, queues, rate limit)
  * Elasticsearch 8 (search) + Kibana
  * MinIO (S3-compatible file storage)
  * RabbitMQ (optional MQ)

---

## 📂 Project Structure

```
/dineflow
 ├── app/           # Domain logic, services, policies, jobs
 ├── config/        # Laravel configs
 ├── database/      # Migrations, factories, seeders
 ├── tests/         # PHPUnit & Pest tests
 ├── docker/        # Docker configs (php-fpm, nginx)
 ├── .github/       # GitHub Actions CI/CD workflows
 └── README.md
```

---

## ⚡ Getting Started

### 1. Clone repo

```bash
git clone https://github.com/your-username/dineflow.git
cd dineflow
```

### 2. Copy env file

```bash
cp .env.example .env
```

### 3. Start services (Docker)

```bash
docker compose up -d
```

### 4. Install dependencies

```bash
docker exec -it dineflow-app composer install
docker exec -it dineflow-app php artisan key:generate
docker exec -it dineflow-app php artisan migrate --seed
```

### 5. Visit app

* API base: [http://localhost:8080](http://localhost:8080)
* Swagger docs: [http://localhost:8080/api/documentation](http://localhost:8080/api/documentation)
* Kibana: [http://localhost:5601](http://localhost:5601)
* MinIO: [http://localhost:9001](http://localhost:9001)

---

## 🧪 Testing

```bash
docker exec -it dineflow-app vendor/bin/phpunit
```

---

## 🔄 CI/CD

* Lint, test, and security scan on every PR
* Build Docker image → push to GHCR/ECR
* Auto-deploy staging; manual prod promotion

---

## 📖 Documentation

* API docs generated via **L5-Swagger**
* Postman collection included (`/docs/postman`)
* ADRs for architectural decisions (`/docs/adr`)

---

## 🎯 Roadmap

* [ ] Reservations module (tables, slots, conflicts)
* [ ] Search microservice (optional extraction)
* [ ] Serverless functions (image processing/webhook receiver)
* [ ] Observability with OpenTelemetry + Grafana stack
