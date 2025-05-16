<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Management System</title>
    <style>
        /* Same styles as index.php */
        :root {
            --primary: #4361ee;
            --primary-light: #4895ef;
            --danger: #f72585;
            --success: #4cc9f0;
            --dark: #212529;
            --light: #f8f9fa;
            --gray: #6c757d;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: var(--dark);
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: var(--primary);
            margin-bottom: 25px;
            text-align: center;
            font-weight: 600;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            border: 1px solid #eee;
        }

        .card h2 {
            color: var(--gray);
            font-size: 1.2rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--dark);
        }

        input[type="text"], input[type="email"], input[type="tel"], input[type="date"], select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border 0.3s;
        }

        input:focus, select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-row .form-group {
            flex: 1;
        }

        button {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s;
        }

        button:hover {
            background-color: var(--primary-light);
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }

        button.danger {
            background-color: var(--danger);
        }

        button.danger:hover {
            background-color: #e3176a;
        }

        button.success {
            background-color: var(--success);
        }

        button.success:hover {
            background-color: #3ab5d8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: var(--primary);
            color: white;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .action-buttons button {
            padding: 6px 12px;
            font-size: 14px;
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 4px;
            color: white;
            font-weight: 500;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .notification.show {
            opacity: 1;
        }

        .notification.success {
            background-color: #10b981;
        }

        .notification.error {
            background-color: #ef4444;
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }

            table {
                display: block;
                overflow-x: auto;
            }

            .action-buttons {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Employee Management System</h1>

    <div class="card">
        <h2>Add New Employee</h2>
        <div class="form-row">
            <div class="form-group">
                <label for="new_employee_code">Employee Code</label>
                <input type="text" id="new_employee_code" placeholder="EMP-XXX" required>
            </div>
            <div class="form-group">
                <label for="new_email">Email</label>
                <input type="email" id="new_email" placeholder="Email Address" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_first_name">First Name</label>
                <input type="text" id="new_first_name" placeholder="First Name" required>
            </div>
            <div class="form-group">
                <label for="new_last_name">Last Name</label>
                <input type="text" id="new_last_name" placeholder="Last Name" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_phone">Phone</label>
                <input type="tel" id="new_phone" placeholder="Phone Number">
            </div>
            <div class="form-group">
                <label for="new_hire_date">Hire Date</label>
                <input type="date" id="new_hire_date" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_birth_date">Birth Date</label>
                <input type="date" id="new_birth_date">
            </div>
            <div class="form-group">
                <label for="new_gender">Gender</label>
                <select id="new_gender">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                    <option value="prefer_not_to_say">Prefer not to say</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_marital_status">Marital Status</label>
                <select id="new_marital_status">
                    <option value="">Select Marital Status</option>
                    <option value="single">Single</option>
                    <option value="married">Married</option>
                    <option value="divorced">Divorced</option>
                    <option value="widowed">Widowed</option>
                </select>
            </div>
            <div class="form-group">
                <label for="new_employment_type">Employment Type</label>
                <select id="new_employment_type">
                    <option value="">Select Employment Type</option>
                    <option value="full_time">Full Time</option>
                    <option value="part_time">Part Time</option>
                    <option value="contract">Contract</option>
                    <option value="temporary">Temporary</option>
                    <option value="intern">Intern</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_job_title">Job Title</label>
                <input type="text" id="new_job_title" placeholder="Job Title">
            </div>
            <div class="form-group">
                <label for="new_department_id">Department</label>
                <select id="new_department_id">
                    <option value="">Select Department</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="senior">Senior</option>
                    <option value="manager">Manager</option>
                    <option value="director">Director</option>
                    <option value="executive">Executive</option>
                    <?php
                    $result = $conn->query("SELECT department_id, name FROM departments");
                    while ($row = $result->fetch_assoc()):
                    ?>
                    <option value="<?= $row['department_id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_location_id">Location</label>
                <select id="new_location_id">
                    <option value="">Select Location</option>
                    <?php
                    $result = $conn->query("SELECT location_id, name FROM locations");
                    while ($row = $result->fetch_assoc()):
                    ?>
                    <option value="<?= $row['location_id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="new_status">Status</label>
                <select id="new_status">
                    <option value="active">Active</option>
                    <option value="on_leave">On Leave</option>
                    <option value="suspended">Suspended</option>
                    <option value="terminated">Terminated</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_termination_date">Termination Date</label>
                <input type="date" id="new_termination_date">
            </div>
            <div class="form-group">
                <label for="new_termination_reason">Termination Reason</label>
                <input type="text" id="new_termination_reason">
            </div>
        </div>
        <button onclick="addEmployee()" class="success">➕ Add Employee</button>
    </div>

    <div class="card">
        <h2>Existing Employees</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Hire Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT employee_id, employee_code, first_name, last_name, email, status, hire_date 
                        FROM employees ORDER BY employee_id DESC";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['employee_id'] ?>">
                    <td><?= $row['employee_id'] ?></td>
                    <td><input type="text" id="code_<?= $row['employee_id'] ?>" value="<?= htmlspecialchars($row['employee_code']) ?>"></td>
                    <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                    <td><input type="email" id="email_<?= $row['employee_id'] ?>" value="<?= htmlspecialchars($row['email']) ?>"></td>
                    <td>
                        <select id="status_<?= $row['employee_id'] ?>">
                            <option value="active" <?= $row['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="on_leave" <?= $row['status'] === 'on_leave' ? 'selected' : '' ?>>On Leave</option>
                            <option value="suspended" <?= $row['status'] === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                            <option value="terminated" <?= $row['status'] === 'terminated' ? 'selected' : '' ?>>Terminated</option>
                        </select>
                    </td>
                    <td><input type="date" id="hire_date_<?= $row['employee_id'] ?>" value="<?= $row['hire_date'] ?>"></td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="updateEmployee(<?= $row['employee_id'] ?>)" class="success">💾 Save</button>
                            <button onclick="deleteEmployee(<?= $row['employee_id'] ?>)" class="danger">🗑️ Delete</button>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="notification" class="notification"></div>

<script>
    function showNotification(message, isSuccess) {
        const notification = document.getElementById('notification');
        notification.textContent = message;
        notification.className = `notification ${isSuccess ? 'success' : 'error'} show`;
        setTimeout(() => notification.classList.remove('show'), 3000);
    }

    function updateEmployee(employeeId) {
        const code = document.getElementById(`code_${employeeId}`).value;
        const email = document.getElementById(`email_${employeeId}`).value;
        const status = document.getElementById(`status_${employeeId}`).value;
        const hireDate = document.getElementById(`hire_date_${employeeId}`).value;

        if (!code || !email || !hireDate) {
            showNotification('All required fields must be filled', false);
            return;
        }

        fetch('update_employee.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `employee_id=${employeeId}&employee_code=${encodeURIComponent(code)}&email=${encodeURIComponent(email)}&status=${status}&hire_date=${hireDate}`
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(data => {
            showNotification(data, true);
        })
        .catch(error => {
            showNotification(`Error updating employee: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function addEmployee() {
        const code = document.getElementById('new_employee_code').value;
        const email = document.getElementById('new_email').value;
        const firstName = document.getElementById('new_first_name').value;
        const lastName = document.getElementById('new_last_name').value;
        const phone = document.getElementById('new_phone').value;
        const hireDate = document.getElementById('new_hire_date').value;
        const birthDate = document.getElementById('new_birth_date').value;
        const gender = document.getElementById('new_gender').value;
        const maritalStatus = document.getElementById('new_marital_status').value;
        const employmentType = document.getElementById('new_employment_type').value;
        const jobTitle = document.getElementById('new_job_title').value;
        const deptId = document.getElementById('new_department_id').value || null;
        const locId = document.getElementById('new_location_id').value || null;
        const status = document.getElementById('new_status').value;
        const termDate = document.getElementById('new_termination_date').value || null;
        const termReason = document.getElementById('new_termination_reason').value;

        if (!code || !email || !firstName || !lastName || !hireDate) {
            showNotification('Required fields are missing', false);
            return;
        }

        fetch('add_employee.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `employee_code=${encodeURIComponent(code)}&first_name=${encodeURIComponent(firstName)}&last_name=${encodeURIComponent(lastName)}&email=${encodeURIComponent(email)}&phone=${encodeURIComponent(phone)}&hire_date=${hireDate}&birth_date=${birthDate}&gender=${gender}&marital_status=${maritalStatus}&employment_type=${employmentType}&job_title=${jobTitle}&department_id=${deptId}&location_id=${locId}&status=${status}&termination_date=${termDate}&termination_reason=${termReason}`
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(data => {
            showNotification(data, true);
            setTimeout(() => location.reload(), 1500);
        })
        .catch(error => {
            showNotification(`Error adding employee: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function deleteEmployee(employeeId) {
        if (!confirm("Are you sure you want to delete this employee? This action cannot be undone.")) return;

        fetch('delete_employee.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `employee_id=${employeeId}`
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(data => {
            showNotification(data, true);
            document.getElementById(`row_${employeeId}`).remove();
        })
        .catch(error => {
            showNotification(`Error deleting employee: ${error}`, false);
            console.error('Error:', error);
        });
    }
</script>
</body>
</html>