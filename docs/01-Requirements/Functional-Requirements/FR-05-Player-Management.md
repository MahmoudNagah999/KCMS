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
