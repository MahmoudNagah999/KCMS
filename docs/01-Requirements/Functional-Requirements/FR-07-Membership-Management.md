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

