# Karate Clubs Management System (KCMS)

> Project Documentation

## Overview

Karate Clubs Management System (KCMS) is a multi-tenant SaaS web application designed to help karate clubs and sports academies manage players, monthly memberships, branches, championships, belt examinations, and official federation documents through a centralized platform.

The system provides two separate portals:

- **Admin Portal** for platform administration.
- **Club Portal** for club operations and player management.

---

## Technology Stack

| Layer | Technology |
|--------|------------|
| Backend | Laravel 13 |
| Admin Panel | Filament 5 |
| Database | MySQL 8+ |
| Cache & Queue | Redis |
| Storage | Local / Amazon S3 |
| Containerization | Docker |

---

## Documentation Structure

```
docs/
│
├── README.md
│
├── 01-Requirements/
│   └── DOC-001-SRS.md
│
├── 02-Architecture/
│   └── DOC-002-Software-Architecture.md
│
├── 03-Database/
│   └── DOC-003-Database-Design.md
│
├── 04-API/
│   └── DOC-004-API-Specification.md
│
└── 05-Development/
    └── Development-Guidelines.md
```

---

## Documentation Roadmap

| Document | Description | Status |
|----------|-------------|--------|
| DOC-001 | Software Requirements Specification (SRS) | 🚧 In Progress |
| DOC-002 | Software Architecture Document (SAD) | ⏳ Planned |
| DOC-003 | Database Design | ⏳ Planned |
| DOC-004 | API Specification | ⏳ Planned |
| Development Guidelines | Coding standards and development workflow | ⏳ Planned |

---

## Reading Order

For new developers, it is recommended to read the documentation in the following order:

1. DOC-001 — Software Requirements Specification (SRS)
2. DOC-002 — Software Architecture Document
3. DOC-003 — Database Design
4. DOC-004 — API Specification
5. Development Guidelines

---

## Project Status

The project is currently in the **Analysis & Design** phase.

Development will begin after completing and approving the Software Requirements Specification (SRS).

The initial development priority is:

1. Player Management
2. Monthly Membership Management
3. Official Document Generation

---

## Core Features

- Player Management
- Monthly Membership Management
- Club & Branch Management
- Player Transfer Tracking
- PDF Player Import
- Championship Management
- Belt Examination Management
- Federation Document Generation
- Reports & Statistics
- Subscription Management

---

## Contributing

Before implementing any new feature:

1. Review the SRS.
2. Verify the architecture.
3. Check the database design.
4. Follow the Development Guidelines.
5. Submit changes through Pull Requests.