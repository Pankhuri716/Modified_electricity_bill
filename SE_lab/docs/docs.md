Electricity Billing System – Documentation
1. Overview

This system allows Admins, Supervisors, and Users to manage electricity bills, meter readings, and payments. The system is modularized for reusability, efficiency, and usability.

Admin: Add users, add supervisors, view all bills.

Supervisor: Enter meter readings, generate bills.

User: View current and past bills, pay bills.

2. Module Specifications
Module: db.php

Purpose: Database connection for all modules.

Input: None.

Preconditions: MySQL database exists with tables users, bills, meter_readings, supervisors, admin.

Logic: Connects to MySQL using mysqli_connect and stores the connection in $conn.

Output: $conn variable for use in other modules.

Module: user_dashboard.php

Purpose: Show current and past bills for a logged-in user.

Input: $_SESSION['user']

Preconditions: User must be logged in.

Logic:

Fetch latest bill for the logged-in user.

Fetch pending amount (other unpaid bills).

Calculate total payable and fine if past due.

Fetch bill history.

Output: Render HTML showing current bill and past bills.

Pseudocode:

START
  IF user not logged in THEN redirect to login
  Fetch latest bill
  IF latest bill exists THEN
      Calculate pending charges from other bills
      Calculate total payable including fine if overdue
      Fetch past bills
  ENDIF
  Display HTML
END

Module: pay_bill.php

Purpose: Mark a specific bill as paid.

Input: POST parameter bill_number.

Preconditions: User must be logged in, bill number must exist.

Logic:

START
  Get bill_number from POST
  UPDATE bills SET status='PAID' WHERE bill_number matches
  IF update success THEN
      Set session message "Payment successful"
  ELSE
      Show error message
  ENDIF
  Redirect to user_dashboard.php
END


Output: Bill marked as PAID in the database.

Module: generate_bill.php

Purpose: Supervisor generates a bill after entering meter readings.

Input: POST parameters: service_number, previous_reading, current_reading.

Preconditions: Supervisor logged in, valid readings.

Logic:

START
  Validate readings (numeric, current >= previous)
  Calculate units consumed
  Calculate bill total using tiered rates
  Start transaction
      Insert meter reading
      Insert bill
  Commit transaction
  Redirect to supervisor_dashboard.php with success message
CATCH exception
  Rollback transaction
  Show error
END


Output: New bill entry in the database.

Module: Take_reading.php

Purpose: Supervisor enters meter readings.

Input: Service number, previous & current readings (form).

Preconditions: Supervisor logged in.

Logic: Submits readings to generate_bill.php.

Output: Redirects to generate_bill.php.

Module: admin_dashboard.php

Purpose: Admin main panel.

Input: $_SESSION['admin']

Preconditions: Admin logged in.

Logic: Shows links to add users, add supervisors, view bills, logout.

Output: HTML page with dashboard cards.

Module: add_user.php

Purpose: Admin adds a new electricity consumer.

Input: Name, Phone, Address, PIN, Category.

Preconditions: Admin logged in.

Logic:

Validate input fields
Generate unique 10-digit service number
INSERT INTO users
Redirect to admin_dashboard.php with message


Output: New user entry in users.

Module: add_supervisor.php

Purpose: Admin adds a supervisor.

Input: Name, username, password.

Preconditions: Admin logged in.

Logic:

Check if username exists
Hash password
INSERT INTO supervisors
Redirect with message


Output: New supervisor entry.

Module: supervisor_dashboard.php

Purpose: Supervisor main panel.

Input: $_SESSION['supervisor']

Preconditions: Supervisor logged in.

Logic: Display cards to take readings or logout.

Output: HTML dashboard.

Module: user_view.php

Purpose: Users can view bills by service number.

Input: Service number.

Preconditions: User or admin logged in.

Logic:

Validate service number
Fetch bills
For each bill:
   Calculate payable amount (include fine if overdue)
Display HTML table


Output: List of bills with payment button.

Module: view_all_bills.php

Purpose: Admin can view all bills.

Input: None.

Preconditions: Admin logged in.

Logic: Fetch all bills with user and meter info.

Output: HTML table of all bills.

3. Flowcharts / Diagrams

Use draw.io to create:

User bill flow: Login → View current bill → Pay → Update status.

Supervisor bill generation flow: Login → Enter readings → Generate bill → Store in DB.

Admin management flow: Login → Add User/Supervisor → View bills.

