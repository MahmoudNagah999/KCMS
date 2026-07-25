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