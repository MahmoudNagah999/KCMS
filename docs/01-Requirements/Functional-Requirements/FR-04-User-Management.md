# 4. User Management

## Overview

The User Management module is responsible for managing users who access the platform, assigning them to clubs and branches, and controlling their access based on roles and permissions.

The module supports user lifecycle management including creation, activation, deactivation, and permission assignment.

---

# FR-USER-001 — Create Club User

## Description

The system shall allow authorized club users to create new users within their club tenant.

## Actors

- Club Owner
- Authorized Administrator

## Permissions

user.create

## Preconditions

- User is authenticated.
- User has permission to create users.
- Club tenant is active.

## Main Flow

1. User opens create user form.
2. User enters user information.
3. User selects role.
4. User optionally assigns branch access.
5. System validates the provided information.
6. System creates the user account.
7. System sends account activation instructions.
8. System records the action.

## Alternative Flow

- Email already exists.
- Invalid role selected.
- User does not have permission.

## Input Validation

- Name is required.
- Email is required.
- Email format must be valid.
- Role is required.

## Business Validation

- User must belong to the current tenant.
- Selected role must be available for the tenant.
- Branch assignment must belong to the same club.

## Business Rules

- Users cannot create users outside their tenant.
- User creation must be audited.
- User credentials must be stored securely.

## Post Conditions

- New user account exists.
- User can activate and access the system.

## Related Requirements

- FR-AUTH-001
- FR-ROLE-001

## Acceptance Criteria

- Authorized users can create users.
- Unauthorized users cannot create users.
- Created user belongs to the correct club.


---

# FR-USER-002 — Update User Information

## Description

The system shall allow authorized users to update user profile information.

## Actors

- Club Owner
- Authorized Administrator

## Permissions

user.update

## Preconditions

- User exists.
- Current user has permission.

## Main Flow

1. Administrator selects a user.
2. Updates user information.
3. System validates changes.
4. System saves updated information.
5. System records the action.

## Alternative Flow

- User does not exist.
- Email already belongs to another user.

## Input Validation

- Name is required.
- Email must be valid.

## Business Validation

- User must belong to the same tenant.

## Business Rules

- Updating user information shall not change historical activity records.
- Sensitive changes shall be logged.

## Post Conditions

User information is updated.

## Acceptance Criteria

- User information is updated successfully.
- Changes are recorded.


---

# FR-USER-003 — Assign Role To User

## Description

The system shall allow authorized administrators to assign roles to users.

## Actors

- Club Owner
- Platform Administrator

## Permissions

user.role.assign

## Preconditions

- User exists.
- Role exists.

## Main Flow

1. Administrator selects a user.
2. Selects available role.
3. System validates permission.
4. System assigns the role.
5. System records the change.

## Alternative Flow

- Invalid role.
- Administrator lacks permission.

## Input Validation

- Role is required.

## Business Validation

- User can only receive roles allowed within their scope.
- Club administrators cannot assign platform-level roles.

## Business Rules

- Role assignment controls system access.
- Permission changes take effect immediately.

## Post Conditions

User has updated access permissions.

## Related Requirements

- FR-AUTH-005

## Acceptance Criteria

- User receives assigned permissions.
- Unauthorized role escalation is prevented.


---

# FR-USER-004 — Assign User To Branch

## Description

The system shall allow authorized administrators to assign users to one or more branches.

## Actors

- Club Owner

## Permissions

user.branch.assign

## Preconditions

- User exists.
- Branch exists.

## Main Flow

1. Administrator selects a user.
2. Selects branch access.
3. System validates branch ownership.
4. System saves assignment.

## Alternative Flow

- Branch belongs to another club.
- User already assigned.

## Input Validation

- Branch selection is required.

## Business Validation

- Branch must belong to the user's club.

## Business Rules

- Branch access limits user visibility.
- Users assigned to a branch should only access allowed branch data.

## Post Conditions

User branch permissions are updated.

## Acceptance Criteria

- User can access assigned branches only.


---

# FR-USER-005 — Activate User Account

## Description

The system shall allow authorized administrators to activate inactive user accounts.

## Actors

- Club Owner
- Platform Administrator

## Permissions

user.activate

## Preconditions

- User exists.
- User is inactive.

## Main Flow

1. Administrator selects inactive user.
2. Activates account.
3. System updates user status.
4. User can access the platform.

## Alternative Flow

- User already active.

## Business Rules

- Activation does not modify historical data.
- Activation actions must be logged.

## Post Conditions

User account becomes active.

## Acceptance Criteria

- Activated users can authenticate successfully.


---

# FR-USER-006 — Deactivate User Account

## Description

The system shall allow authorized administrators to disable user access without deleting the account.

## Actors

- Club Owner
- Platform Administrator

## Permissions

user.deactivate

## Preconditions

- User exists.

## Main Flow

1. Administrator selects user.
2. Deactivates account.
3. System blocks authentication.
4. System records the action.

## Alternative Flow

- User already inactive.

## Business Rules

- Deactivating a user shall not delete data.
- Historical actions performed by the user must remain available.

## Post Conditions

User cannot access the system.

## Acceptance Criteria

- Disabled users cannot log in.
- User history remains preserved.
