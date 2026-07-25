# Functional Requirements

> **Document ID:** DOC-001-FR
> **Project:** Karate Clubs Management System (KCMS)
> **Version:** 1.0.0
> **Status:** Draft
> **Related Document:** DOC-001-SRS

---

# Table of Contents

1. Authentication
2. Platform Management
3. Club Management
4. User Management
5. Player Management
6. Media & Attachments Management
7. Membership Management
8. Player Transfer
9. PDF Import
10. Championship Management
11. Belt Examination Management
12. Document Generation
13. Reports
14. Platform Subscription Management
15. Audit Logs
16. Settings

# 1. Authentication & Authorization

## Overview

The Authentication & Authorization module is responsible for securing access to the platform, authenticating users, managing sessions, and enforcing role-based permissions across both Platform Portal and Club Portal.

---

## FR-AUTH-001 — User Login

### Description

The system shall allow registered users to securely authenticate using their assigned credentials.

### Actors

- Platform Administrator
- Club Owner
- Branch Manager
- Coach
- Club Employee
- Read-Only User

### Permissions

Public

### Preconditions

- User account exists.
- User account is active.
- User belongs to an active club (Club Portal only).
- Club subscription is valid (Club Portal only).

### Main Flow

1. User opens the login page.
2. User enters email and password.
3. User submits the login form.
4. The system validates the credentials.
5. The system authenticates the user.
6. The system loads the user's permissions.
7. The system redirects the user to the appropriate dashboard.

### Alternative Flow

- Invalid email or password.
- User account is inactive.
- Club subscription has expired.
- User account is suspended.

### Input Validation

- Email is required.
- Email must be valid.
- Password is required.

### Business Validation

- User account must be active.
- User must belong to the selected tenant.
- Club subscription must allow access.

### Business Rules

- Authentication shall be performed securely.
- Passwords shall never be stored in plain text.
- Every successful login shall be recorded in the audit log.

### Post Conditions

- User session is created.
- User permissions are loaded.
- Last login timestamp is updated.

### Related Requirements

- FR-AUTH-002
- FR-AUTH-005

### Acceptance Criteria

- Valid credentials grant access.
- Invalid credentials are rejected.
- Audit log is created.
- User is redirected to the correct dashboard.

---

## FR-AUTH-002 — User Logout

### Description

The system shall allow authenticated users to securely terminate their current session.

### Actors

All authenticated users.

### Permissions

Authenticated User

### Preconditions

- User is logged in.

### Main Flow

1. User selects Logout.
2. System invalidates the current session.
3. Authentication cookies are removed.
4. User is redirected to the login page.

### Alternative Flow

None.

### Input Validation

N/A

### Business Validation

Session must exist.

### Business Rules

- Logout shall invalidate the current session.
- Remember-me tokens shall be revoked when applicable.

### Post Conditions

- Session is destroyed.
- User is no longer authenticated.

### Related Requirements

FR-AUTH-001

### Acceptance Criteria

- User cannot access protected pages after logout.

---

## FR-AUTH-003 — Forgot Password

### Description

The system shall allow users to request a password reset.

### Actors

Registered Users

### Permissions

Public

### Preconditions

- User account exists.

### Main Flow

1. User selects Forgot Password.
2. User enters email address.
3. System validates email.
4. Password reset link is generated.
5. Reset instructions are sent.

### Alternative Flow

- Email address not found.

### Input Validation

- Email is required.
- Email format must be valid.

### Business Validation

Email must belong to an existing user.

### Business Rules

- Reset links shall expire.
- Reset links shall only be used once.

### Post Conditions

Password reset request is created.

### Related Requirements

FR-AUTH-004

### Acceptance Criteria

- Valid users receive a reset link.
- Invalid requests do not expose user existence.

---

## FR-AUTH-004 — Reset Password

### Description

The system shall allow users to define a new password using a valid reset token.

### Actors

Registered Users

### Permissions

Public

### Preconditions

- Reset token is valid.

### Main Flow

1. User opens reset link.
2. User enters new password.
3. User confirms password.
4. System validates password.
5. Password is updated.
6. User is redirected to login.

### Alternative Flow

- Invalid token.
- Expired token.

### Input Validation

- Password is required.
- Password confirmation is required.

### Business Validation

- Token must be valid.
- Token must not be expired.

### Business Rules

- Previous password becomes invalid immediately.
- Password reset invalidates existing sessions.

### Post Conditions

Password successfully changed.

### Related Requirements

FR-AUTH-003

### Acceptance Criteria

- User can log in with the new password.
- Old password no longer works.

---

## FR-AUTH-005 — Role-Based Authorization

### Description

The system shall restrict access to features according to the user's assigned roles and permissions.

### Actors

Authenticated Users

### Permissions

System

### Preconditions

- User is authenticated.

### Main Flow

1. User requests a protected resource.
2. System checks assigned permissions.
3. System grants or denies access.

### Alternative Flow

- User lacks the required permission.

### Input Validation

N/A

### Business Validation

Permission must exist.

### Business Rules

- Permissions shall be evaluated before every protected action.
- Unauthorized access attempts shall be logged.

### Post Conditions

Requested action is either executed or rejected.

### Related Requirements

- FR-USER-001
- FR-ROLE-001

### Acceptance Criteria

- Authorized users access permitted resources.
- Unauthorized users receive an access denied response.
- Unauthorized attempts are logged.

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

# 3. Club Management

## Overview

The Club Management module is responsible for managing club information, branches, and operational settings within the Club Portal.

Each club operates within its own isolated tenant environment and can manage its own organizational structure.

---

# FR-CLUB-001 — View Club Profile

## Description

The system shall allow authorized club users to view the club information.

## Actors

- Club Owner
- Branch Manager
- Club Employee

## Permissions

club.profile.view

## Preconditions

- User is authenticated.
- User belongs to an active club tenant.

## Main Flow

1. User opens the club profile page.
2. System retrieves club information.
3. System displays the club details.

## Alternative Flow

- Club information is incomplete.

## Input Validation

N/A

## Business Validation

- User must belong to the same tenant.

## Business Rules

- Users can only access their own club information.
- Tenant data isolation must always be enforced.

## Post Conditions

Club information is displayed.

## Related Requirements

- FR-CLUB-002

## Acceptance Criteria

- Authorized users can view club information.
- Users cannot access another club's data.


---

# FR-CLUB-002 — Update Club Profile

## Description

The system shall allow authorized users to update club information.

## Actors

- Club Owner

## Permissions

club.profile.update

## Preconditions

- Club exists.
- User has required permission.

## Main Flow

1. Club owner opens club settings.
2. Updates club information.
3. System validates changes.
4. System saves the updated information.
5. System records the action.

## Alternative Flow

- Invalid information provided.

## Input Validation

- Club name is required.
- Contact information must be valid.

## Business Validation

- User must have ownership permission.
- Updates must belong to the current tenant.

## Business Rules

- Updating club information does not affect historical records.
- Important changes should be tracked.

## Post Conditions

Club profile is updated.

## Acceptance Criteria

- Club information can be updated successfully.
- Unauthorized users cannot modify club information.


---

# FR-CLUB-003 — Create Branch

## Description

The system shall allow clubs to create and manage multiple branches.

## Actors

- Club Owner
- Branch Manager (if permitted)

## Permissions

club.branch.create

## Preconditions

- Club exists.
- User has branch management permission.

## Main Flow

1. User opens create branch form.
2. User enters branch information.
3. System validates data.
4. System creates the branch.
5. Branch becomes available for player assignment.

## Alternative Flow

- Branch name already exists within the club.
- Required data is missing.

## Input Validation

- Branch name is required.
- Branch address is required.
- Contact information is optional.

## Business Validation

- Branch must belong to the current club.
- Branch identifier must be unique within the club.

## Business Rules

- A club may have multiple branches.
- Players shall be assigned to a specific branch.
- Branch data must remain isolated within the club tenant.

## Post Conditions

New branch is created.

## Related Requirements

- FR-PLAYER-001
- FR-USER-001

## Acceptance Criteria

- Branch is created successfully.
- Users can manage only branches belonging to their club.


---

# FR-CLUB-004 — Update Branch Information

## Description

The system shall allow authorized users to update branch details.

## Actors

- Club Owner
- Branch Manager

## Permissions

club.branch.update

## Preconditions

- Branch exists.
- User has permission.

## Main Flow

1. User selects a branch.
2. User updates information.
3. System validates changes.
4. System saves updates.

## Alternative Flow

- Branch does not exist.
- User does not have permission.

## Input Validation

- Branch name is required.
- Address format must be valid.

## Business Validation

- Branch must belong to the current club.

## Business Rules

- Updating branch information shall not affect historical player records.
- Existing player history must preserve previous branch assignments.

## Post Conditions

Branch information is updated.

## Acceptance Criteria

- Branch information is updated successfully.
- Historical data remains unchanged.


---

# FR-CLUB-005 — Disable Branch

## Description

The system shall allow authorized users to disable a branch without deleting its historical data.

## Actors

- Club Owner

## Permissions

club.branch.disable

## Preconditions

- Branch exists.

## Main Flow

1. User selects a branch.
2. User disables the branch.
3. System updates branch status.
4. System prevents new assignments to the branch.

## Alternative Flow

- Branch is already disabled.

## Input Validation

N/A

## Business Validation

- Only authorized users can disable branches.

## Business Rules

- Disabling a branch shall not delete players.
- Historical records linked to the branch must remain available.
- Disabled branches cannot receive new players.

## Post Conditions

Branch becomes inactive.

## Acceptance Criteria

- Disabled branch cannot be selected for new operations.
- Existing historical records remain accessible.


---

# FR-CLUB-006 — View Club Dashboard

## Description

The system shall provide club users with operational statistics related to their club.

## Actors

- Club Owner
- Branch Manager

## Permissions

club.dashboard.view

## Preconditions

- User is authenticated.

## Main Flow

1. User opens club dashboard.
2. System retrieves club statistics.
3. System displays summarized information.

## Dashboard Information

- Total players.
- Active memberships.
- Expired memberships.
- Number of branches.
- Upcoming championships.
- Upcoming examinations.

## Business Rules

- Dashboard information must be limited to the current tenant.
- Users should only see information allowed by their permissions.

## Acceptance Criteria

- Users can view relevant club statistics.
- Data does not include other clubs.

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

# 5. Player Management

## Overview

The Player Management module is responsible for managing the complete lifecycle of karate players within the system.

The module allows clubs to register players, maintain player information, track player history, manage player documents, and provide player data for other system modules.

Player records are considered permanent business entities and shall not be deleted when a player leaves a club.

---

# FR-PLAYER-001 — Create Player

## Description

The system shall allow authorized club users to register a new player.

## Actors

- Club Owner
- Branch Manager
- Club Employee

## Permissions

player.create

## Preconditions

- User is authenticated.
- User has permission to create players.
- Club tenant is active.
- Selected branch belongs to the current club.

## Main Flow

1. User opens the create player form.
2. User enters player information.
3. User uploads required documents if available.
4. System validates player information.
5. System creates the player record.
6. System creates the initial club assignment record.
7. System records the operation in the audit log.

## Alternative Flow

- Required information is missing.
- Player already exists.
- Invalid branch selected.

## Input Validation

- First name is required.
- Last name is required.
- Date of birth is required.
- Gender is required.
- Branch is required.

## Business Validation

- Player uniqueness must be checked before creation.
- Branch must belong to the current club.
- User must have permission to create players.

## Business Rules

- Every player shall have a unique global identifier.
- A player shall belong to only one active club at a time.
- Creating a player shall create an initial player-club history record.

## Post Conditions

- Player record is created.
- Player is available for memberships and document generation.

## Related Requirements

- FR-MEDIA-001
- FR-TRANSFER-001

## Acceptance Criteria

- Authorized users can create players.
- Duplicate players are prevented.
- Player history starts correctly.

---

# FR-PLAYER-002 — Update Player Information

## Description

The system shall allow authorized users to update player information.

## Actors

- Club Owner
- Branch Manager
- Club Employee

## Permissions

player.update

## Preconditions

- Player exists.
- User has permission.
- Player belongs to the current club.

## Main Flow

1. User selects a player.
2. User updates player information.
3. System validates changes.
4. System saves updated information.
5. System records the modification.

## Alternative Flow

- Player does not exist.
- User does not have permission.

## Input Validation

- Required fields must remain valid.
- Date fields must have valid formats.

## Business Validation

- Sensitive identity fields may require additional permission to modify.
- Updates must belong to the current tenant.

## Business Rules

- Updating player information shall not modify historical documents.
- Existing generated documents must keep their original snapshot.
- Important changes should be audited.

## Post Conditions

Player information is updated.

## Acceptance Criteria

- Authorized users can update players.
- Historical records remain unchanged.

---

# FR-PLAYER-003 — View Player Profile

## Description

The system shall allow authorized users to view complete player information.

## Actors

- Club Owner
- Branch Manager
- Coach
- Club Employee

## Permissions

player.view

## Preconditions

- Player exists.
- User has access to the player's club/branch.

## Main Flow

1. User searches for a player.
2. User opens player profile.
3. System displays player information.

## Player Information

- Personal information.
- Contact information.
- Current club.
- Current branch.
- Membership status.
- Transfer history.
- Generated documents.
- Uploaded attachments.

## Business Rules

- Users can only view players within their access scope.
- Player history must remain visible to authorized users.

## Acceptance Criteria

- Authorized users can view player details.
- Unauthorized access is prevented.

---

# FR-PLAYER-004 — Search Players

## Description

The system shall allow users to search and filter players.

## Actors

- Club Owner
- Branch Manager
- Club Employee

## Permissions

player.view

## Preconditions

- User is authenticated.

## Main Flow

1. User enters search criteria.
2. System searches available player records.
3. System displays matching results.

## Search Criteria

- Player name.
- National ID.
- Federation ID.
- Date of birth.
- Branch.
- Membership status.

## Business Rules

- Search results must respect tenant isolation.
- Users should only see permitted players.

## Acceptance Criteria

- Users can quickly find registered players.
- Search results are accurate.

---

# FR-PLAYER-005 — Archive Player

## Description

The system shall allow authorized users to archive players without deleting their records.

## Actors

- Club Owner

## Permissions

player.archive

## Preconditions

- Player exists.
- User has permission.

## Main Flow

1. User selects player.
2. User archives player.
3. System updates player availability.
4. System keeps historical records.

## Alternative Flow

- Player has active membership.

## Business Validation

- System should warn before archiving players with active records.

## Business Rules

- Players shall never be permanently deleted.
- Archived players remain available for historical reporting.
- Archived players cannot be used for new registrations.

## Post Conditions

Player becomes archived.

## Acceptance Criteria

- Player data remains stored.
- Player is excluded from active operations.

---

# FR-PLAYER-006 — Import Players From Federation PDF

## Description

The system shall allow clubs to import player information from federation-generated PDF files.

## Actors

- Club Owner
- Club Employee

## Permissions

player.import

## Preconditions

- PDF file exists.
- User has import permission.

## Main Flow

1. User uploads PDF file.
2. System extracts player data.
3. System validates extracted information.
4. User reviews imported data.
5. System creates approved player records.

## Alternative Flow

- Invalid PDF format.
- Missing required information.
- Duplicate players detected.

## Input Validation

- File type must be supported.
- File size must comply with system limits.

## Business Validation

- Imported players must belong to the current club.
- Duplicate detection must be performed before saving.

## Business Rules

- Imported data must not overwrite existing players automatically.
- User confirmation is required before final import.
- Import history must be stored.

## Post Conditions

Approved players are created.

## Acceptance Criteria

- Valid PDF files are imported successfully.
- Duplicate players are detected.
- Import process is traceable.

# 6. Media & Attachments Management

## Overview

The Media & Attachments Management module is responsible for managing uploaded files, images, and documents associated with system entities.

The module provides a centralized approach for storing, organizing, and accessing attachments while maintaining security, ownership, and historical records.

The module is designed to support multiple business entities, including players, clubs, branches, and generated documents.

---

# FR-MEDIA-001 — Upload Attachment

## Description

The system shall allow authorized users to upload files and attach them to supported entities.

## Actors

- Club Owner
- Branch Manager
- Club Employee
- Platform Administrator

## Permissions

media.upload

## Preconditions

- User is authenticated.
- User has upload permission.
- Target entity exists.
- User has access to the target entity.

## Main Flow

1. User selects an entity.
2. User chooses a file.
3. System validates the file.
4. System stores the file.
5. System creates an attachment record.
6. System associates the attachment with the entity.
7. System records the action.

## Alternative Flow

- Unsupported file type.
- File exceeds allowed size.
- User does not have permission.

## Input Validation

- File is required.
- File type must be supported.
- File size must be within system limits.

## Business Validation

- User must have access to the entity.
- Uploaded file must belong to the current tenant.

## Business Rules

- Files must not be stored without an attachment record.
- Every attachment must have an owner entity.
- Tenant isolation must be enforced.

## Post Conditions

Attachment is stored and available for authorized users.

## Related Requirements

- FR-PLAYER-001
- FR-DOCUMENT-001

## Acceptance Criteria

- Authorized users can upload files.
- Unauthorized users cannot upload files.
- Attachment metadata is stored correctly.

---

# FR-MEDIA-002 — View Attachments

## Description

The system shall allow authorized users to view attachments associated with an entity.

## Actors

- Club Owner
- Branch Manager
- Coach
- Club Employee

## Permissions

media.view

## Preconditions

- Attachment exists.
- User has access to the related entity.

## Main Flow

1. User opens entity profile.
2. System retrieves related attachments.
3. System displays available files.

## Alternative Flow

- Attachment does not exist.
- User lacks permission.

## Business Rules

- Users can only access attachments within their tenant scope.
- Sensitive documents may require additional permissions.

## Post Conditions

Attachments are displayed.

## Acceptance Criteria

- Authorized users can view allowed attachments.
- Unauthorized access is prevented.

---

# FR-MEDIA-003 — Download Attachment

## Description

The system shall allow authorized users to download stored attachments.

## Actors

- Club Owner
- Branch Manager
- Club Employee

## Permissions

media.download

## Preconditions

- Attachment exists.
- User has permission.

## Main Flow

1. User requests download.
2. System verifies access permission.
3. System provides the file.

## Alternative Flow

- File not found.
- Access denied.

## Business Rules

- Download attempts should be logged for sensitive documents.
- Files must not expose direct storage paths.

## Post Conditions

File is downloaded securely.

## Acceptance Criteria

- Authorized users can download files.
- Storage locations are protected.

---

# FR-MEDIA-004 — Delete Attachment

## Description

The system shall allow authorized users to remove attachments from active usage.

## Actors

- Club Owner
- Platform Administrator

## Permissions

media.delete

## Preconditions

- Attachment exists.
- User has permission.

## Main Flow

1. User selects attachment.
2. User requests deletion.
3. System validates permission.
4. System removes attachment from active records.
5. System records the action.

## Alternative Flow

- Attachment is referenced by a historical document.

## Input Validation

N/A

## Business Validation

- Historical attachments must not be permanently deleted.

## Business Rules

- Attachments related to generated official documents shall be preserved.
- Deletion should follow soft-delete principles where applicable.

## Post Conditions

Attachment is removed from active access.

## Acceptance Criteria

- Active attachments can be removed.
- Historical records remain protected.

---

# FR-MEDIA-005 — Manage Attachment Categories

## Description

The system shall allow the platform to define attachment categories.

## Actors

- Platform Administrator

## Permissions

media.category.manage

## Preconditions

- Administrator is authenticated.

## Main Flow

1. Administrator creates attachment category.
2. System validates category information.
3. System saves the category.

## Examples

- Player Photo
- Birth Certificate
- National ID
- Passport
- Federation Document
- Medical Report

## Business Rules

- Categories should be reusable across entities.
- Categories should support future expansion.

## Acceptance Criteria

- Administrators can manage attachment categories.
- Attachments can be classified correctly.

---

# FR-MEDIA-006 — Preserve Attachment History

## Description

The system shall preserve historical attachments required for auditing and official records.

## Actors

System

## Permissions

System

## Preconditions

- Attachment exists.

## Main Flow

1. System identifies historical attachment.
2. System prevents destructive deletion.
3. System maintains attachment reference.

## Business Rules

- Official document attachments must remain immutable.
- Historical records must be accessible according to permissions.

## Post Conditions

Attachment history remains available.

## Acceptance Criteria

- Historical documents remain accessible.
- Data integrity is maintained.

# 7. Membership Management

## Overview

The Membership Management module is responsible for managing player memberships inside clubs, including membership plans, subscription periods, renewals, payments, and payment history.

The module enables clubs to track player financial obligations and maintain complete membership history.

Membership records shall be preserved as historical business records and shall not be deleted.

---

# FR-MEMBER-001 — Manage Membership Plans

## Description

The system shall allow clubs to create and manage membership plans used for player subscriptions.

## Actors

- Club Owner
- Authorized Club Administrator

## Permissions

membership.plan.manage

## Preconditions

- User is authenticated.
- User has membership management permission.

## Main Flow

1. User opens membership plans management.
2. User creates or updates a membership plan.
3. System validates plan information.
4. System saves the membership plan.

## Plan Information

- Plan name.
- Description.
- Duration.
- Price.
- Status.

## Examples

- Kids Training Monthly Plan.
- Adults Training Monthly Plan.
- Elite Team Plan.
- Private Training Plan.

## Alternative Flow

- Duplicate plan name.
- Invalid price.
- Invalid duration.

## Input Validation

- Plan name is required.
- Duration is required.
- Price must be greater than or equal to zero.

## Business Validation

- Plan belongs to the current club.
- Only authorized users can manage plans.

## Business Rules

- Each club manages its own membership plans.
- Existing memberships shall keep the original plan information.
- Updating a plan shall not modify historical memberships.

## Post Conditions

Membership plan is available for player assignment.

## Acceptance Criteria

- Club can create membership plans.
- Historical memberships remain unchanged after plan updates.


---

# FR-MEMBER-002 — Create Player Membership

## Description

The system shall allow authorized users to create a membership record for a player.

## Actors

- Club Owner
- Branch Manager
- Club Employee

## Permissions

membership.create

## Preconditions

- Player exists.
- Player belongs to the club.
- Membership plan exists.

## Main Flow

1. User selects a player.
2. User selects a membership plan.
3. User enters membership period.
4. System calculates membership details.
5. System creates membership record.
6. System records the operation.

## Alternative Flow

- Player already has an active membership.
- Invalid membership period.

## Input Validation

- Player is required.
- Membership plan is required.
- Start date is required.
- End date is required.

## Business Validation

- Player must belong to the current club.
- Membership dates must be valid.
- Overlapping active memberships should be prevented.

## Business Rules

- A player can have membership history.
- Only one active membership should exist for the same period.
- Membership records cannot be deleted.

## Post Conditions

Player has a new membership record.

## Related Requirements

- FR-PAYMENT-001

## Acceptance Criteria

- Membership is created successfully.
- Membership history is preserved.


---

# FR-MEMBER-003 — Renew Player Membership

## Description

The system shall allow authorized users to renew an expired or active player membership.

## Actors

- Club Owner
- Branch Manager
- Club Employee

## Permissions

membership.renew

## Preconditions

- Player exists.
- Previous membership exists.

## Main Flow

1. User selects player membership.
2. User starts renewal process.
3. System creates a new membership period.
4. User records payment if applicable.
5. System updates membership status.

## Alternative Flow

- Renewal period overlaps.
- Player is not eligible.

## Input Validation

- Renewal period is required.

## Business Validation

- Renewal dates must follow membership rules.

## Business Rules

- Renewal creates a new historical membership record.
- Previous membership remains unchanged.

## Post Conditions

New membership period exists.

## Acceptance Criteria

- Renewal history is preserved.
- Previous records remain available.


---

# FR-MEMBER-004 — Suspend Membership

## Description

The system shall allow authorized users to temporarily suspend a player membership.

## Actors

- Club Owner
- Branch Manager

## Permissions

membership.suspend

## Preconditions

- Active membership exists.

## Main Flow

1. User selects active membership.
2. User suspends membership.
3. System updates membership status.
4. System records suspension reason.

## Alternative Flow

- Membership already suspended.

## Input Validation

- Suspension reason is required.

## Business Rules

- Suspension shall not delete payment history.
- Suspension reasons must be stored.

## Post Conditions

Membership becomes suspended.

## Acceptance Criteria

- Suspended memberships are identified correctly.
- History remains available.


---

# FR-MEMBER-005 — View Player Membership History

## Description

The system shall allow authorized users to view all historical memberships for a player.

## Actors

- Club Owner
- Branch Manager
- Club Employee

## Permissions

membership.view

## Preconditions

- Player exists.

## Main Flow

1. User opens player profile.
2. User views membership history.
3. System displays all membership records.

## Display Information

- Membership plan.
- Start date.
- End date.
- Status.
- Payments.
- Created by.

## Business Rules

- Historical memberships must remain immutable.
- Access must respect tenant permissions.

## Acceptance Criteria

- Complete membership history is available.
- Data accuracy is maintained.


---

# FR-MEMBER-006 — Membership Status Management

## Description

The system shall manage membership lifecycle statuses.

## Membership Statuses

- Active
- Pending Payment
- Expired
- Suspended
- Cancelled

## Business Rules

- Status changes must be recorded.
- Expired memberships must not be deleted.
- Historical status changes should be traceable.

## Acceptance Criteria

- Membership status accurately reflects current state.

# 8. Payment Management

## Overview

The Payment Management module is responsible for managing financial transactions related to player memberships inside clubs.

The module allows clubs to record payments, track payment history, manage payment methods, and generate financial reports.

Payment records are considered financial business records and shall be preserved for auditing and reporting purposes.

---

# FR-PAYMENT-001 — Record Membership Payment

## Description

The system shall allow authorized club users to record payments made by players against their memberships.

## Actors

- Club Owner
- Branch Manager
- Club Employee

## Permissions

```
payment.create
```

## Preconditions

- User is authenticated.
- User has payment creation permission.
- Player membership exists.
- Membership belongs to the current club tenant.

## Main Flow

1. User opens the payment creation form.
2. User selects a player membership.
3. User enters payment details.
4. System validates payment information.
5. System creates the payment record.
6. System updates the membership payment status.
7. System records the operation in the audit log.

## Alternative Flow

- Membership does not exist.
- Invalid payment amount.
- User does not have permission.

## Input Validation

- Payment amount is required.
- Payment amount must be greater than zero.
- Payment date is required.
- Payment method is required.

## Business Validation

- Payment must belong to the current club.
- User must have payment permission.
- Payment amount must follow membership rules.

## Business Rules

- Payments shall never be permanently deleted.
- Every payment must be linked to a membership.
- Payment creator and creation time must be stored.
- Financial records must remain traceable.

## Post Conditions

- Payment record is created.
- Membership payment status is updated.

## Related Requirements

- FR-MEMBER-002
- FR-MEMBER-006

## Acceptance Criteria

- Authorized users can record payments.
- Payment appears in membership history.
- Payment audit information is stored.

---

# FR-PAYMENT-002 — View Payment History

## Description

The system shall allow authorized users to view payment history for players and memberships.

## Actors

- Club Owner
- Branch Manager
- Club Employee

## Permissions

```
payment.view
```

## Preconditions

- User is authenticated.
- User has access to the player or membership.

## Main Flow

1. User opens player profile.
2. User navigates to payment history.
3. System retrieves related payments.
4. System displays payment records.

## Payment Information

- Payment amount.
- Payment date.
- Payment method.
- Related membership.
- Recorded by user.
- Notes.

## Business Rules

- Payment history is read-only for unauthorized users.
- Historical payments cannot be modified directly.

## Post Conditions

Payment history is displayed.

## Acceptance Criteria

- Authorized users can view payment history.
- Data belongs only to their tenant.

---

# FR-PAYMENT-003 — Manage Payment Methods

## Description

The system shall allow clubs to manage available payment methods used during payment recording.

## Actors

- Club Owner
- Authorized Club Administrator

## Permissions

```
payment_method.manage
```

## Preconditions

- User has required permission.

## Main Flow

1. User opens payment methods management.
2. User creates or updates payment methods.
3. System validates information.
4. System saves payment methods.

## Default Payment Methods

- Cash.
- Bank Transfer.
- Card.
- Mobile Wallet.
- Other.

## Input Validation

- Payment method name is required.

## Business Validation

- Payment method belongs to the current club.

## Business Rules

- Existing payments shall keep the original payment method.
- Disabling a payment method prevents new usage only.

## Post Conditions

Payment method becomes available for future transactions.

## Acceptance Criteria

- Club can manage payment methods.
- Historical payments remain unchanged.

---

# FR-PAYMENT-004 — Update Payment Record

## Description

The system shall allow authorized users to correct payment information while maintaining financial integrity.

## Actors

- Club Owner

## Permissions

```
payment.update
```

## Preconditions

- Payment exists.
- User has permission.

## Main Flow

1. User selects payment record.
2. User updates payment information.
3. System validates changes.
4. System saves the update.
5. System records the modification.

## Business Rules

- Payment modifications must be audited.
- Previous values should remain available through audit history.
- Financial records must remain traceable.

## Post Conditions

Payment record is updated.

## Acceptance Criteria

- Authorized users can correct payment information.
- Changes are traceable.

---

# FR-PAYMENT-005 — Void Payment

## Description

The system shall allow authorized users to invalidate incorrect payments without deleting financial records.

## Actors

- Club Owner

## Permissions

```
payment.void
```

## Preconditions

- Payment exists.
- User has permission.

## Main Flow

1. User selects payment.
2. User requests payment void.
3. User enters void reason.
4. System changes payment status.
5. System records the operation.

## Input Validation

- Void reason is required.

## Business Rules

- Voided payments remain stored.
- Voided payments shall not be included in financial calculations.
- Original transaction information must remain available.

## Post Conditions

Payment status becomes void.

## Acceptance Criteria

- Voided payments are excluded from reports.
- Payment history remains available.

---

# FR-PAYMENT-006 — Generate Financial Reports

## Description

The system shall provide financial reports related to memberships and payments.

## Actors

- Club Owner
- Branch Manager

## Permissions

```
payment.report.view
```

## Reports

- Daily payment report.
- Monthly revenue report.
- Outstanding payments report.
- Membership payment status report.

## Filters

- Date range.
- Branch.
- Membership plan.
- Payment method.

## Business Rules

- Reports must respect tenant isolation.
- Only valid payment records are included.

## Acceptance Criteria

- Reports display accurate financial information.
- Users cannot access other clubs' financial data.

---

# FR-PAYMENT-007 — Payment Audit Tracking

## Description

The system shall maintain an audit trail for all financial operations.

## Actors

System

## Business Rules

The system shall record:

- Payment creation.
- Payment updates.
- Payment void operations.
- User performing the action.
- Date and time.
- Previous and new values.

## Acceptance Criteria

- Financial operations are traceable.
- Audit history cannot be modified by normal users.


# 10. Federation PDF Import Management

## Overview

The Federation PDF Import Management module is responsible for importing player data from federation-generated PDF files into the system.

The module allows clubs to reduce manual data entry by extracting player information from official federation documents while maintaining data validation, review, and import history.

Imported data shall not be stored directly without user approval.

---

# FR-IMPORT-001 — Upload Federation PDF

## Description

The system shall allow authorized club users to upload federation PDF documents containing player information.

## Actors

- Club Owner
- Club Employee

## Permissions

```
player.import
```

## Preconditions

- User is authenticated.
- User has import permission.
- Club tenant is active.

## Main Flow

1. User opens PDF import page.
2. User uploads federation PDF file.
3. System validates the uploaded file.
4. System creates an import process record.
5. System starts data extraction.

## Alternative Flow

- Invalid file format.
- File is corrupted.
- File exceeds allowed size.

## Input Validation

- File is required.
- File type must be PDF.
- File size must be within allowed limits.

## Business Validation

- User must belong to the current club.
- Uploaded file must be associated with the current club.

## Business Rules

- Original uploaded file must be preserved.
- Every import attempt must have a tracking record.
- Import files shall not directly create players before validation.

## Post Conditions

Import process is created.

## Acceptance Criteria

- Valid PDF files are accepted.
- Import history is created.
- Invalid files are rejected.


---

# FR-IMPORT-002 — Extract Player Data From PDF

## Description

The system shall extract player information from uploaded federation PDF documents.

## Actors

System

## Permissions

System

## Preconditions

- Valid PDF file exists.
- Import process exists.

## Main Flow

1. System reads the uploaded PDF.
2. System extracts available player information.
3. System creates temporary import records.
4. System marks extraction status.

## Extracted Information

- Player name.
- Federation number (if available).
- Date of birth.
- Gender.
- Nationality.
- Registration information.

## Alternative Flow

- PDF structure is not supported.
- Required data cannot be extracted.

## Business Rules

- Extracted data must not overwrite existing players automatically.
- Extraction errors must be recorded.
- Import process must remain traceable.

## Post Conditions

Temporary import records are created.

## Acceptance Criteria

- Extracted data is stored for review.
- Extraction errors are reported.


---

# FR-IMPORT-003 — Validate Imported Players

## Description

The system shall validate extracted player information before creating player records.

## Actors

System

## Permissions

System

## Preconditions

- Extraction process completed.

## Main Validation Rules

- Required fields exist.
- Duplicate players are detected.
- Data formats are valid.
- Federation identifiers are checked.

## Duplicate Detection Criteria

The system should check:

- Federation ID.
- National ID (if available).
- Player name and date of birth combination.

## Business Rules

- Duplicate players must not be created.
- Potential duplicates must be presented to the user.
- Validation results must be stored.

## Post Conditions

Imported records receive validation status.

## Acceptance Criteria

- Invalid records are identified.
- Duplicate records are detected.


---

# FR-IMPORT-004 — Review Imported Players

## Description

The system shall allow users to review extracted player data before final import.

## Actors

- Club Owner
- Club Employee

## Permissions

```
player.import.review
```

## Preconditions

- Import extraction completed.

## Main Flow

1. User opens import review page.
2. System displays extracted records.
3. User reviews player information.
4. User approves valid records.
5. User rejects invalid records.

## Available Actions

- Approve.
- Reject.
- Edit extracted data.
- Ignore duplicate records.

## Business Rules

- User confirmation is required before creating players.
- Rejected records must remain available for review history.

## Post Conditions

Records are ready for final import.

## Acceptance Criteria

- User can review all imported records.
- Only approved records proceed.


---

# FR-IMPORT-005 — Import Approved Players

## Description

The system shall create player records from approved imported data.

## Actors

- Club Owner
- Authorized Club Employee

## Permissions

```
player.import.execute
```

## Preconditions

- Import records are validated.
- User approved records.

## Main Flow

1. User confirms import.
2. System creates player records.
3. System creates initial player club history.
4. System links imported documents.
5. System updates import status.

## Alternative Flow

- Import fails during processing.
- Database validation error occurs.

## Business Rules

- Import operation must be transactional.
- Partial imports should be handled safely.
- Created players must follow normal player creation rules.

## Post Conditions

Approved players are created.

## Related Requirements

- FR-PLAYER-001
- FR-TRANSFER-001

## Acceptance Criteria

- Players are created successfully.
- Import history is preserved.
- Failed imports do not corrupt data.


---

# FR-IMPORT-006 — View Import History

## Description

The system shall allow authorized users to view previous PDF import operations.

## Actors

- Club Owner
- Branch Manager

## Permissions

```
player.import.history
```

## Preconditions

- User is authenticated.

## Main Flow

1. User opens import history.
2. System retrieves previous imports.
3. System displays import details.

## Import Information

- Uploaded file.
- Import date.
- Created by.
- Number of records.
- Successful records.
- Failed records.
- Import status.

## Import Statuses

- Uploaded.
- Processing.
- Validation Failed.
- Awaiting Review.
- Completed.
- Failed.

## Business Rules

- Import history cannot be deleted.
- Historical imports must remain available for auditing.

## Acceptance Criteria

- Users can review previous imports.
- Import records remain traceable.


---

# FR-IMPORT-007 — Handle Import Errors

## Description

The system shall provide error handling and reporting during PDF import operations.

## Actors

System

## Permissions

System

## Error Types

- Invalid PDF structure.
- Missing required fields.
- Duplicate player.
- Invalid data format.
- Processing failure.

## Business Rules

- Errors must be stored with affected records.
- Users must understand why records failed.
- Failed records can be corrected and retried.

## Acceptance Criteria

- Import errors are clearly reported.
- Failed records do not affect valid imports.
