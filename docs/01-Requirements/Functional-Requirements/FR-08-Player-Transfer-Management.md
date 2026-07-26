# 9. Player Transfer Management

## Overview

The Player Transfer Management module is responsible for managing player movement between clubs and branches while preserving the complete historical record of player ownership and affiliation.

The system shall maintain the same player identity throughout the player's lifecycle and create transfer records whenever the player changes clubs or branches.

Transfer records are considered historical business records and shall not be deleted.

---

# FR-TRANSFER-001 — Create Player Transfer

## Description

The system shall allow authorized users to create a transfer record when a player moves from one club or branch to another.

## Actors

- Platform Administrator
- Club Owner
- Authorized Club Administrator

## Permissions

```
transfer.create
```

## Preconditions

- Player exists.
- Source club exists.
- Destination club exists.
- User has transfer permission.

## Main Flow

1. User selects a player.
2. User starts the transfer process.
3. User selects destination club or branch.
4. User enters transfer information.
5. System validates transfer rules.
6. System creates a transfer record.
7. System updates the player's current affiliation.
8. System records the operation in the audit log.

## Alternative Flow

- Player does not exist.
- Destination club is invalid.
- Transfer already exists.

## Input Validation

- Player is required.
- Destination club is required.
- Transfer date is required.
- Transfer reason is required.

## Business Validation

- Player must belong to the source club.
- Destination club must be active.
- User must have transfer permission.

## Business Rules

- Player identity must remain unchanged after transfer.
- Every transfer must create a historical record.
- Previous club ownership must remain available.
- Transfer records cannot be deleted.

## Post Conditions

- New transfer history record exists.
- Player current affiliation is updated.

## Related Requirements

- FR-PLAYER-001
- FR-PLAYER-003

## Acceptance Criteria

- Player can be transferred successfully.
- Previous transfer history remains available.
- Current club information is updated correctly.

---

# FR-TRANSFER-002 — View Player Transfer History

## Description

The system shall allow authorized users to view the complete transfer history of a player.

## Actors

- Club Owner
- Branch Manager
- Platform Administrator

## Permissions

```
transfer.view
```

## Preconditions

- Player exists.
- User has access permission.

## Main Flow

1. User opens player profile.
2. User opens transfer history.
3. System retrieves all transfer records.
4. System displays the player's movement history.

## Transfer Information

- Previous club.
- New club.
- Previous branch.
- New branch.
- Transfer date.
- Transfer reason.
- Created by user.

## Business Rules

- Transfer history must be immutable.
- Historical records must reflect actual player movement.

## Post Conditions

Transfer history is displayed.

## Acceptance Criteria

- Complete player movement history is available.
- Records cannot be modified by unauthorized users.

---

# FR-TRANSFER-003 — Transfer Player Between Branches

## Description

The system shall allow authorized club users to move players between branches of the same club.

## Actors

- Club Owner
- Branch Manager

## Permissions

```
transfer.branch.create
```

## Preconditions

- Player belongs to the club.
- Destination branch belongs to the same club.

## Main Flow

1. User selects player.
2. User selects destination branch.
3. System validates branch ownership.
4. System creates branch transfer record.
5. System updates current branch assignment.

## Alternative Flow

- Destination branch is inactive.
- Branch belongs to another club.

## Input Validation

- Destination branch is required.
- Transfer date is required.

## Business Validation

- Branch must belong to the same club.
- User must have access to both branches.

## Business Rules

- Branch movement must be tracked separately from club transfer.
- Historical branch assignments must remain available.

## Post Conditions

Player is assigned to the new branch.

## Acceptance Criteria

- Player branch movement is recorded.
- Previous branch history remains available.

---

# FR-TRANSFER-004 — Approve Player Transfer Request

## Description

The system shall support an approval workflow for player transfers when required.

## Actors

- Source Club Administrator
- Destination Club Administrator
- Platform Administrator

## Permissions

```
transfer.approve
```

## Preconditions

- Transfer request exists.
- Required approvals are available.

## Main Flow

1. Transfer request is submitted.
2. Authorized user reviews request.
3. User approves or rejects transfer.
4. System updates transfer status.
5. System records the decision.

## Transfer Statuses

- Pending
- Approved
- Rejected
- Cancelled
- Completed

## Business Rules

- Approval workflow should be configurable.
- Transfer completion updates player affiliation.
- Rejected transfers must remain in history.

## Post Conditions

Transfer request status is updated.

## Acceptance Criteria

- Approved transfers are completed successfully.
- Rejected transfers do not affect player ownership.

---

# FR-TRANSFER-005 — View Transfer Requests

## Description

The system shall allow authorized users to view transfer requests related to their club.

## Actors

- Club Owner
- Branch Manager
- Platform Administrator

## Permissions

```
transfer.request.view
```

## Preconditions

- User is authenticated.

## Main Flow

1. User opens transfer requests.
2. System retrieves related requests.
3. System displays request details.

## Display Information

- Player information.
- Source club.
- Destination club.
- Request date.
- Transfer status.

## Business Rules

- Users shall only view requests within their permission scope.

## Acceptance Criteria

- Transfer requests are displayed correctly.
- Unauthorized users cannot access transfer information.

---

# FR-TRANSFER-006 — Preserve Transfer History

## Description

The system shall preserve all player transfer history for future reference and reporting.

## Actors

System

## Business Rules

- Transfer records cannot be permanently deleted.
- Historical transfer information must remain available.
- Reports must use transfer history as the source of player movement.

## Acceptance Criteria

- Complete transfer history is preserved.
- Historical data remains consistent.