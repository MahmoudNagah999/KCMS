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
