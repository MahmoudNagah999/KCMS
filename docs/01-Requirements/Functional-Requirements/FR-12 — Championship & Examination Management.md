# 12. Championship & Examination Management

## Overview

The Championship & Examination Management module is responsible for managing karate events including championships and belt examinations.

The module allows clubs to create events, register participating players, validate eligibility, and generate official participant lists required for federation submission.

All event participation records shall be preserved as historical records.

---

# 12.1 Championship Management

---

# FR-EVENT-001 — Create Championship

## Description

The system shall allow authorized users to create championship events.

## Actors

- Club Owner
- Branch Manager
- Club Administrator

## Permissions

```
championship.create
```

## Preconditions

- User is authenticated.
- User has championship management permission.
- Club is active.

## Main Flow

1. User opens championship creation page.
2. User enters championship information.
3. System validates the provided data.
4. System creates championship record.
5. Championship becomes available for player registration.

## Championship Information

- Championship name.
- Organizer.
- Date.
- Location.
- Registration deadline.
- Notes.
- Status.

## Championship Status

- Draft
- Open Registration
- Closed Registration
- Completed
- Cancelled

## Business Rules

- Only authorized users can create championships.
- Completed championships cannot be modified.
- Historical championships must remain available.

## Acceptance Criteria

- Championship can be created successfully.
- Championship status is managed correctly.

---

# FR-EVENT-002 — Update Championship

## Description

The system shall allow authorized users to update championship information before completion.

## Actors

- Club Owner
- Club Administrator

## Permissions

```
championship.update
```

## Preconditions

- Championship exists.
- Championship is not completed.

## Main Flow

1. User edits championship information.
2. System validates changes.
3. System saves updates.

## Business Rules

- Completed championships cannot be modified.
- Changes must be logged.

## Acceptance Criteria

- Authorized users can update active championships.
- Historical data remains protected.

---

# FR-EVENT-003 — Register Players For Championship

## Description

The system shall allow authorized users to register players as championship participants.

## Actors

- Club Owner
- Coach
- Club Employee

## Permissions

```
championship.player.register
```

## Preconditions

- Championship exists.
- Player exists.
- Registration is open.

## Main Flow

1. User selects championship.
2. User selects participating players.
3. System validates player information.
4. System registers players.
5. System stores participation records.

## Player Registration Information

- Player.
- Category.
- Age group.
- Weight category (if applicable).
- Competition type.
- Notes.

## Business Validation

- Player must belong to the club.
- Player data must be complete.
- Duplicate registration must be prevented.

## Business Rules

- Participation is a historical record.
- Player changes after registration must not affect old participation records.

## Acceptance Criteria

- Players are registered successfully.
- Duplicate registrations are prevented.

---

# FR-EVENT-004 — Generate Championship Registration List

## Description

The system shall allow users to generate championship participant documents.

## Actors

- Club Owner
- Club Administrator

## Permissions

```
championship.document.generate
```

## Preconditions

- Championship exists.
- Registered players exist.

## Main Flow

1. User selects championship.
2. System retrieves registered players.
3. System creates participant snapshots.
4. System generates document.
5. System stores generated document.

## Document Information

- Championship details.
- Player names.
- Federation information.
- Categories.
- Club information.

## Business Rules

- Generated documents must use snapshots.
- Document data must not change after generation.

## Acceptance Criteria

- Championship list is generated correctly.
- Historical document remains unchanged.

---

# 12.2 Examination Management

---

# FR-EXAM-001 — Create Belt Examination

## Description

The system shall allow authorized users to create belt examination events.

## Actors

- Club Owner
- Branch Manager

## Permissions

```
exam.create
```

## Preconditions

- User has examination management permission.

## Main Flow

1. User creates examination event.
2. User enters examination details.
3. System validates information.
4. System creates examination record.

## Examination Information

- Examination name.
- Examination date.
- Location.
- Examiner.
- Target belt.
- Notes.

## Examination Status

- Draft
- Open Registration
- Closed Registration
- Completed
- Cancelled

## Business Rules

- Examination records must be preserved.
- Completed examinations cannot be deleted.

## Acceptance Criteria

- Examination event is created successfully.

---

# FR-EXAM-002 — Register Players For Examination

## Description

The system shall allow authorized users to register eligible players for belt examinations.

## Actors

- Club Owner
- Coach
- Club Employee

## Permissions

```
exam.player.register
```

## Preconditions

- Examination exists.
- Player exists.
- Registration is open.

## Main Flow

1. User selects examination.
2. User selects players.
3. System validates eligibility.
4. System registers players.

## Examination Registration Information

- Player.
- Current belt.
- Requested belt.
- Examination category.
- Notes.

## Business Validation

- Player must belong to the club.
- Player must satisfy examination requirements.
- Duplicate registration is not allowed.

## Business Rules

- Examination participation history must remain available.
- Player belt changes after examination registration do not modify old records.

## Acceptance Criteria

- Eligible players can be registered.
- Invalid registrations are rejected.

---

# FR-EXAM-003 — Generate Examination Registration List

## Description

The system shall generate official examination participant lists.

## Actors

- Club Owner
- Club Administrator

## Permissions

```
exam.document.generate
```

## Preconditions

- Examination exists.
- Registered players exist.

## Main Flow

1. User selects examination.
2. System retrieves participants.
3. System creates snapshots.
4. System generates document.
5. System stores document history.

## Document Information

- Examination details.
- Player information.
- Current belt.
- Requested belt.
- Club information.

## Business Rules

- Generated documents must be immutable.
- Document generation must be tracked.

## Acceptance Criteria

- Examination lists are generated successfully.
- Historical documents remain available.

---

# FR-EVENT-005 — View Event History

## Description

The system shall allow authorized users to view previous championships and examinations.

## Actors

- Club Owner
- Branch Manager

## Permissions

```
event.view
```

## Preconditions

- User has access to the club.

## Main Flow

1. User opens event history.
2. System retrieves events.
3. User views event details.

## Business Rules

- Completed events cannot be deleted.
- Historical participation data must remain available.

## Acceptance Criteria

- Users can access previous events.
- Historical records remain accurate.

---

# FR-EVENT-006 — Export Event Participants

## Description

The system shall allow users to export participant lists.

## Actors

- Club Owner
- Club Administrator

## Permissions

```
event.export
```

## Export Formats

- PDF.
- Excel.

## Business Rules

- Exported data must respect user permissions.
- Exported documents must match stored event data.

## Acceptance Criteria

- Users can export participant lists.
- Exported files contain correct information.
