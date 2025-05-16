<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leave Application Management</title>
    <style>
        /* Same styles from index.php */
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

        input[type="text"], input[type="date"], input[type="number"], textarea, select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border 0.3s;
        }

        input:focus, select:focus, textarea:focus {
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

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .checkbox-group input {
            margin-right: 10px;
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
    <h1>Leave Application Management System</h1>

    <div class="card">
        <h2>Add New Leave Application</h2>
        <div class="form-row">
            <div class="form-group">
                <label for="new_employee_id">Employee</label>
                <select id="new_employee_id" required>
                    <option value="">Select Employee</option>
                    <?php
                    $result = $conn->query("SELECT employee_id, first_name, last_name FROM employees");
                    while ($row = $result->fetch_assoc()):
                        echo "<option value='{$row['employee_id']}'>{$row['first_name']} {$row['last_name']}</option>";
                    endwhile;
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="new_type_id">Leave Type</label>
                <select id="new_type_id" required>
                    <option value="">Select Leave Type</option>
                    <?php
                    $result = $conn->query("SELECT type_id, name FROM leave_types");
                    while ($row = $result->fetch_assoc()):
                        echo "<option value='{$row['type_id']}'>{$row['name']}</option>";
                    endwhile;
                    ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_start_date">Start Date</label>
                <input type="date" id="new_start_date" required>
            </div>
            <div class="form-group">
                <label for="new_end_date">End Date</label>
                <input type="date" id="new_end_date" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_days">Number of Days</label>
                <input type="number" id="new_days" step="0.01" min="0" placeholder="e.g., 1.5" required>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="new_is_half_day">
                <label for="new_is_half_day">Half Day</label>
            </div>
            <div class="form-group">
                <label for="new_half_day_type">Half Day Type</label>
                <select id="new_half_day_type" disabled>
                    <option value="">Select</option>
                    <option value="first">First Half</option>
                    <option value="second">Second Half</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="new_reason">Reason</label>
            <textarea id="new_reason" rows="3" placeholder="Enter reason for leave"></textarea>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_emergency_contact">Emergency Contact</label>
                <input type="text" id="new_emergency_contact" placeholder="Phone or email">
            </div>
            <div class="form-group">
                <label for="new_address_during_leave">Address During Leave</label>
                <input type="text" id="new_address_during_leave" placeholder="Optional">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_substitute_employee_id">Substitute Employee</label>
                <select id="new_substitute_employee_id">
                    <option value="">None</option>
                    <?php
                    $result = $conn->query("SELECT employee_id, first_name, last_name FROM employees");
                    while ($row = $result->fetch_assoc()):
                        echo "<option value='{$row['employee_id']}'>{$row['first_name']} {$row['last_name']}</option>";
                    endwhile;
                    ?>
                </select>
            </div>
        </div>
        <button onclick="applyForLeave()" class="success">➕ Apply Leave</button>
    </div>

    <div class="card">
        <h2>Existing Leave Applications</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee</th>
                    <th>Type</th>
                    <th>Dates</th>
                    <th>Days</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT a.application_id, e.employee_id, CONCAT(e.first_name, ' ', e.last_name) AS employee,
                               t.name AS leave_type, a.start_date, a.end_date, a.days, a.status
                        FROM leave_applications a
                        JOIN employees e ON a.employee_id = e.employee_id
                        JOIN leave_types t ON a.type_id = t.type_id
                        ORDER BY a.application_id DESC";

                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['application_id'] ?>">
                    <td><?= $row['application_id'] ?></td>
                    <td><?= htmlspecialchars($row['employee']) ?></td>
                    <td><?= htmlspecialchars($row['leave_type']) ?></td>
                    <td><?= htmlspecialchars($row['start_date']) ?> - <?= htmlspecialchars($row['end_date']) ?></td>
                    <td><?= htmlspecialchars($row['days']) ?></td>
                    <td>
                        <select id="status_<?= $row['application_id'] ?>">
                            <option value="pending" <?= $row['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="approved" <?= $row['status'] === 'approved' ? 'selected' : '' ?>>Approved</option>
                            <option value="rejected" <?= $row['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                            <option value="cancelled" <?= $row['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            <option value="recalled" <?= $row['status'] === 'recalled' ? 'selected' : '' ?>>Recalled</option>
                        </select>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="updateLeaveApplication(<?= $row['application_id'] ?>)" class="success">💾 Save</button>
                            <button onclick="deleteLeaveApplication(<?= $row['application_id'] ?>)" class="danger">🗑️ Delete</button>
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
    document.getElementById('new_is_half_day').addEventListener('change', function () {
        document.getElementById('new_half_day_type').disabled = !this.checked;
    });

    function showNotification(message, isSuccess) {
        const notification = document.getElementById('notification');
        notification.textContent = message;
        notification.className = `notification ${isSuccess ? 'success' : 'error'} show`;
        setTimeout(() => notification.classList.remove('show'), 3000);
    }

    function updateLeaveApplication(id) {
        const status = document.getElementById(`status_${id}`).value;

        fetch('update_leave_application.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `application_id=${id}&status=${status}`
        })
        .then(response => {
            if (!response.ok) throw new Error('Network error');
            return response.text();
        })
        .then(data => {
            showNotification(data, true);
        })
        .catch(error => {
            showNotification(`❌ Failed to update: ${error}`, false);
            console.error(error);
        });
    }

    function applyForLeave() {
        const employeeId = document.getElementById('new_employee_id').value;
        const typeId = document.getElementById('new_type_id').value;
        const startDate = document.getElementById('new_start_date').value;
        const endDate = document.getElementById('new_end_date').value;
        const days = parseFloat(document.getElementById('new_days').value) || 0;
        const isHalfDay = document.getElementById('new_is_half_day').checked ? 1 : 0;
        const halfDayType = isHalfDay ? document.getElementById('new_half_day_type').value : null;
        const reason = document.getElementById('new_reason').value;
        const emergencyContact = document.getElementById('new_emergency_contact').value;
        const addressDuringLeave = document.getElementById('new_address_during_leave').value;
        const substituteId = document.getElementById('new_substitute_employee_id').value || null;

        if (!employeeId || !typeId || !startDate || !endDate || days <= 0 || !reason) {
            showNotification("❌ Required fields are missing", false);
            return;
        }

        fetch('add_leave_application.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `employee_id=${employeeId}&type_id=${typeId}&start_date=${startDate}&end_date=${endDate}&days=${days}&is_half_day=${isHalfDay}&half_day_type=${halfDayType}&reason=${encodeURIComponent(reason)}&emergency_contact=${encodeURIComponent(emergencyContact)}&address_during_leave=${encodeURIComponent(addressDuringLeave)}&substitute_employee_id=${substituteId}`
        })
        .then(response => {
            if (!response.ok) throw new Error('Network error');
            return response.text();
        })
        .then(data => {
            showNotification(data, true);
            setTimeout(() => location.reload(), 1500);
        })
        .catch(error => {
            showNotification(`❌ Failed to apply: ${error}`, false);
            console.error(error);
        });
    }

    function deleteLeaveApplication(id) {
        if (!confirm("Are you sure you want to delete this application? This action cannot be undone.")) return;

        fetch('delete_leave_application.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `application_id=${id}`
        })
        .then(response => {
            if (!response.ok) throw new Error('Network error');
            return response.text();
        })
        .then(data => {
            showNotification(data, true);
            document.getElementById(`row_${id}`).remove();
        })
        .catch(error => {
            showNotification(`❌ Failed to delete: ${error}`, false);
            console.error(error);
        });
    }
</script>
</body>
</html>