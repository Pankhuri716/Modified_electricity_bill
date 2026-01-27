# Electricity Billing System – Test Plan

**Project Name:** Electricity Billing System
**Version:** 1.0
**Prepared By:** Pankhuri
**Date:** 27-Jan-2026

---

## 1. Overview

This test plan covers all functional modules of the Electricity Billing System, including **Admin, Supervisor, and User modules**.
It is intended to verify correctness, usability, efficiency, reusability, and interoperability of the system.

---

## 2. Modules Specifications

### 2.1 Database Connection (`db.php`)

* **Module Name:** `db.php`
* **Input:** None
* **Precondition:** MySQL server running, correct credentials provided
* **Logic:** Connect to MySQL database using `mysqli_connect()`
* **Output:** `$conn` object for database operations
* **Test Cases:**

| Test ID | Functionality | Input               | Expected Output           | Actual Output | Pass/Fail |
| ------- | ------------- | ------------------- | ------------------------- | ------------- | --------- |
| DB1     | Connect to DB | Correct credentials | Connection object `$conn` | TBD           | TBD       |
| DB2     | Connect to DB | Wrong credentials   | Error / connection fails  | TBD           | TBD       |

---

### 2.2 Admin Login (`admin_login.php`)

* **Input:** Username, Password
* **Precondition:** Admin account exists in `admin` table
* **Logic:** Verify credentials using MD5 hash; set session `$_SESSION['admin']` if valid
* **Output:** Redirect to `admin_dashboard.php` on success, error on failure

**Test Cases:**

| Test ID | Input                 | Expected Output             | Actual Output | Pass/Fail |
| ------- | --------------------- | --------------------------- | ------------- | --------- |
| AL1     | Correct credentials   | Redirect to admin dashboard | TBD           | TBD       |
| AL2     | Incorrect credentials | Display "Invalid Login"     | TBD           | TBD       |
| AL3     | Empty input           | Form validation error       | TBD           | TBD       |

---

### 2.3 Supervisor Login (`supervisor_login.php`)

* **Input:** Username, Password
* **Logic:** Verify credentials using MD5 hash; set session `$_SESSION['supervisor']` if valid
* **Output:** Redirect to `supervisor_dashboard.php`

**Test Cases:**

| Test ID | Input   | Expected Output       | Actual Output | Pass/Fail |
| ------- | ------- | --------------------- | ------------- | --------- |
| SL1     | Correct | Redirect to dashboard | TBD           | TBD       |
| SL2     | Wrong   | Remain on login       | TBD           | TBD       |
| SL3     | Empty   | Validation error      | TBD           | TBD       |

---

### 2.4 Add User (`add_user.php`)

* **Input:** Name, Phone, Address, PIN, Category
* **Precondition:** Admin logged in
* **Logic:** Validate inputs, generate unique service number, insert into `users` table
* **Output:** Success message with service number

**Test Cases:**

| Test ID | Input                    | Expected Output                  | Actual Output | Pass/Fail |
| ------- | ------------------------ | -------------------------------- | ------------- | --------- |
| AU1     | Valid Name/Phone/etc     | Insert user, show service number | TBD           | TBD       |
| AU2     | Invalid Name             | Error, reject                    | TBD           | TBD       |
| AU3     | Phone <10 digits         | Error, reject                    | TBD           | TBD       |
| AU4     | Duplicate service number | Auto-generate new unique         | TBD           | TBD       |

---

### 2.5 Add Supervisor (`add_supervisor.php`)

* **Input:** Name, Username, Password
* **Precondition:** Admin logged in
* **Logic:** Insert supervisor into `supervisors` table after checking uniqueness
* **Output:** Success message

**Test Cases:**

| Test ID | Input              | Expected Output   | Actual Output | Pass/Fail |
| ------- | ------------------ | ----------------- | ------------- | --------- |
| AS1     | Valid              | Insert supervisor | TBD           | TBD       |
| AS2     | Duplicate username | Error             | TBD           | TBD       |
| AS3     | Empty input        | Validation error  | TBD           | TBD       |

---

### 2.6 Take Meter Reading (`take_reading.php`)

* **Input:** Service Number, Previous Reading, Current Reading
* **Precondition:** Supervisor logged in
* **Logic:** Validate readings, generate bill with tiered rates, insert into `meter_readings` and `bills` table
* **Output:** Success message with Bill Number and total

**Test Cases:**

| Test ID | Input              | Expected Output              | Actual Output | Pass/Fail |
| ------- | ------------------ | ---------------------------- | ------------- | --------- |
| TR1     | Valid readings     | Insert bill, display success | TBD           | TBD       |
| TR2     | Current < Previous | Error, reject                | TBD           | TBD       |
| TR3     | Non-numeric input  | Error                        | TBD           | TBD       |

---

### 2.7 Generate Bill (`generate_bill.php`)

* **Input:** Previous, Current readings
* **Logic:** Calculate units, total based on tiered rate, fine if overdue, insert into `bills`
* **Output:** Bill inserted, success message

**Test Cases:**

| Test ID | Input  | Expected Output    | Actual Output | Pass/Fail |
| ------- | ------ | ------------------ | ------------- | --------- |
| GB1     | 0→50   | 50 units, ₹75      | TBD           | TBD       |
| GB2     | 50→150 | 100 units, ₹275    | TBD           | TBD       |
| GB3     | 0→0    | Minimum charge ₹25 | TBD           | TBD       |

---

### 2.8 User Dashboard (`user_dashboard.php`)

* **Input:** None (from session)
* **Logic:** Fetch latest bill, pending charges, total payable with fine, display history
* **Output:** Render full dashboard with current and past bills

**Test Cases:**

| Test ID | Input                    | Expected Output                   | Actual Output | Pass/Fail |
| ------- | ------------------------ | --------------------------------- | ------------- | --------- |
| UD1     | User with unpaid bills   | Show unpaid bills with Pay button | TBD           | TBD       |
| UD2     | User with all paid bills | Show bills, status PAID           | TBD           | TBD       |
| UD3     | No bills                 | Show "No bills generated"         | TBD           | TBD       |

---

### 2.9 Pay Bill (`pay_bill.php`)

* **Input:** Bill Number
* **Logic:** Update `status` to PAID in `bills` table
* **Output:** Confirmation message, dashboard refresh

**Test Cases:**

| Test ID | Input        | Expected Output        | Actual Output | Pass/Fail |
| ------- | ------------ | ---------------------- | ------------- | --------- |
| PB1     | Unpaid bill  | Status updated to PAID | TBD           | TBD       |
| PB2     | Already paid | Error/ignore           | TBD           | TBD       |
| PB3     | Invalid bill | Error                  | TBD           | TBD       |

---

### 2.10 User View Bills (`user_view.php`)

* **Input:** Service Number
* **Logic:** Validate service number, fetch all bills, compute payable amount with fine
* **Output:** Table of bills with Pay buttons

**Test Cases:**

| Test ID | Input           | Expected Output           | Actual Output | Pass/Fail |
| ------- | --------------- | ------------------------- | ------------- | --------- |
| UV1     | Valid service   | Show bills                | TBD           | TBD       |
| UV2     | Invalid service | Show error                | TBD           | TBD       |
| UV3     | No bills        | Show "No bills generated" | TBD           | TBD       |

---

### 2.11 Admin View All Bills (`view_all_bills.php`)

* **Input:** None
* **Logic:** Fetch all bills, show full table with status
* **Output:** Table of bills for all users

**Test Cases:**

| Test ID | Input       | Expected Output | Actual Output | Pass/Fail |
| ------- | ----------- | --------------- | ------------- | --------- |
| AV1     | Bills exist | Table populated | TBD           | TBD       |
| AV2     | No bills    | Empty table     | TBD           | TBD       |

---

### 2.12 Logout (`logout.php`)

* **Logic:** Destroy session and redirect to login
* **Output:** User logged out

**Test Cases:**

| Test ID | Input              | Expected Output                      | Actual Output | Pass/Fail |
| ------- | ------------------ | ------------------------------------ | ------------- | --------- |
| LO1     | Any logged-in user | Redirect to login, session destroyed | TBD           | TBD       |

---

## 3. Notes

1. **Tiered Rate Logic:**

   * First 50 units: ₹1.5/unit
   * Next 50 units: ₹2.5/unit
   * Next 50 units: ₹3.5/unit
   * Above 150 units: ₹4.5/unit
   * Minimum charge: ₹25

2. **Fine:** ₹150 if payment is after due date

3. **Service Number:** Unique 10-digit number
