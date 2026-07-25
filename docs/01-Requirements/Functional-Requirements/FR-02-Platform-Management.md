# 2. Platform Management

## Overview

The Platform Management module is responsible for managing the SaaS platform operations, including clubs (tenants), subscription plans, platform configuration, and overall system administration.

This module is accessible only through the Platform Portal.

---

# FR-PLATFORM-001 — Create Club Tenant

## Description

The system shall allow Platform Administrators to create a new club tenant on the platform.

## Actors

- Platform Administrator

## Permissions

platform.club.create

## Preconditions

- User is authenticated.
- User has the required permission.

## Main Flow

1. Administrator opens the create club form.
2. Administrator enters club information.
3. System validates the provided data.
4. System creates the club tenant.
5. System creates initial tenant configuration.
6. System records the operation in the audit log.

## Alternative Flow

- Club name already exists.
- Required information is missing.
- Invalid data provided.

## Input Validation

- Club name is required.
- Contact information is required.
- Club identifier must be unique.

## Business Validation

- Only Platform Administrators can create tenants.
- Each tenant must have a unique identifier.

## Business Rules

- Each club operates as an isolated tenant.
- Tenant data must never be accessible by another tenant.
- Creating a tenant does not automatically activate access without a valid subscription.

## Post Conditions

- New club tenant exists.
- Tenant can be assigned a subscription plan.

## Related Requirements

- FR-SUB-001
- FR-CLUB-001

## Acceptance Criteria

- Administrator can successfully create a club.
- Duplicate clubs cannot be created.
- Tenant isolation is maintained.


---

# FR-PLATFORM-002 — Update Club Tenant Information

## Description

The system shall allow Platform Administrators to update tenant information.

## Actors

- Platform Administrator

## Permissions

platform.club.update

## Preconditions

- Tenant exists.
- User has permission.

## Main Flow

1. Administrator selects a tenant.
2. Administrator updates information.
3. System validates changes.
4. System saves updated data.
5. System records the action.

## Alternative Flow

- Tenant does not exist.
- Invalid information provided.

## Input Validation

- Required fields must remain valid.
- Unique identifiers cannot conflict.

## Business Validation

- Tenant identifier cannot be changed if it affects existing records.

## Business Rules

- Updating tenant information shall not affect historical data.
- Changes shall be audited.

## Post Conditions

Tenant information is updated.

## Acceptance Criteria

- Updated information is saved.
- Previous data remains traceable through audit logs.


---

# FR-PLATFORM-003 — Disable Club Tenant

## Description

The system shall allow Platform Administrators to temporarily disable a club tenant.

## Actors

- Platform Administrator

## Permissions

platform.club.disable

## Preconditions

- Tenant exists.

## Main Flow

1. Administrator selects a club.
2. Administrator disables the tenant.
3. System changes tenant status.
4. System prevents tenant users from accessing the platform.
5. System records the action.

## Alternative Flow

- Tenant already disabled.

## Input Validation

N/A

## Business Validation

- Only authorized administrators can disable tenants.

## Business Rules

- Disabling a tenant shall not delete any data.
- Historical records must remain available.
- Tenant can be reactivated later.

## Post Conditions

Tenant access is blocked.

## Acceptance Criteria

- Club users cannot access the platform.
- Data remains preserved.


---

# FR-PLATFORM-004 — Manage Subscription Plans

## Description

The system shall allow Platform Administrators to create and manage subscription plans for clubs.

## Actors

- Platform Administrator

## Permissions

platform.subscription_plan.manage

## Preconditions

- User has required permission.

## Main Flow

1. Administrator creates or updates a subscription plan.
2. System validates plan information.
3. System saves the plan.
4. Plan becomes available for club subscriptions.

## Alternative Flow

- Invalid plan configuration.

## Input Validation

- Plan name is required.
- Duration is required.
- Price is required.

## Business Validation

- Plan must have a valid duration.
- Plan must have defined limits if applicable.

## Business Rules

- Plans define available features and limits.
- Existing subscriptions shall keep their assigned plan snapshot.

## Post Conditions

Subscription plan is available.

## Related Requirements

FR-SUB-001

## Acceptance Criteria

- Administrator can create plans.
- Clubs can be assigned available plans.


---

# FR-PLATFORM-005 — View Platform Dashboard

## Description

The system shall provide Platform Administrators with a dashboard showing platform-level statistics.

## Actors

- Platform Administrator

## Permissions

platform.dashboard.view

## Preconditions

- User is authenticated.

## Main Flow

1. Administrator opens dashboard.
2. System retrieves platform statistics.
3. System displays summarized information.

## Dashboard Information

- Total clubs.
- Active subscriptions.
- Expired subscriptions.
- Total players.
- System usage statistics.

## Business Rules

- Dashboard data shall respect administrator permissions.
- Sensitive tenant data shall not be exposed unnecessarily.

## Acceptance Criteria

- Administrator can view platform statistics.
- Data is accurate and updated.

