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

## Alternative Flow

- No payments found.

## Business Validation

- User must have access to the player's club and branch.

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
- Authorized Administrator

## Permissions

```
payment_method.manage
```

## Preconditions

- User has permission.

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

## Alternative Flow

- Duplicate payment method.
- Invalid information.

## Input Validation

- Payment method name is required.

## Business Validation

- Payment method belongs to the current club.

## Business Rules

- Existing payments must keep their original payment method.
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
2. User requests correction.
3. System validates changes.
4. System updates the payment.
5. System records the modification.

## Alternative Flow

- Payment is locked due to financial closing.

## Input Validation

- Updated amount must be valid.
- Payment date must be valid.

## Business Validation

- Only authorized users can modify payments.
- Changes must be audited.

## Business Rules

- Direct deletion is not allowed.
- All modifications must keep previous values in audit history.
- Financial changes require tracking.

## Post Conditions

Payment record is updated with audit history.

## Acceptance Criteria

- Authorized corrections are possible.
- Previous changes are traceable.

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
2. User requests void operation.
3. User provides reason.
4. System marks payment as void.
5. System records the action.

## Alternative Flow

- Payment already voided.

## Input Validation

- Void reason is required.

## Business Validation

- Only authorized users can void payments.

## Business Rules

- Voided payments remain in the system.
- Voided payments must not be counted in financial reports.
- Original transaction data must remain available.

## Post Conditions

Payment status becomes void.

## Acceptance Criteria

- Payment is excluded from calculations.
- Historical record remains available.

---

# FR-PAYMENT-006 — Generate Financial Reports

## Description

The system shall provide financial reports related to player memberships and payments.

## Actors

- Club Owner
- Branch Manager

## Permissions

```
payment.report.view
```

## Preconditions

- User is authenticated.

## Main Flow

1. User selects report type.
2. User selects filters.
3. System generates report.
4. User views or exports report.

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
- Reports must use valid payment statuses.

## Post Conditions

Financial report is generated.

## Acceptance Criteria

- Reports show accurate financial data.
- Unauthorized data is not displayed.

---

# FR-PAYMENT-007 — Payment Audit Tracking

## Description

The system shall maintain an audit trail for financial operations.

## Actors

System

## Permissions

System

## Business Rules

The system shall record:

- Payment creation.
- Payment update.
- Payment void.
- User performing the action.
- Date and time.
- Previous and new values.

## Acceptance Criteria

- All financial changes are traceable.
- Audit history cannot be modified by normal users.
