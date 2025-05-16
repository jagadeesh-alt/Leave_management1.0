<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Position History</title>
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

        input[type="text"], input[type="date"], select {
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
    <h1>Employee Position History Management</h1>

    <div class="card">
        <h2>Add New Position History</h2>
        <div class="form-row">
            <div class="form-group">
                <label for="new_employee_id">Employee</label>
                <select id="new_employee_id" required>
                    <option value="">Select Employee</option>
                    <?php
                    $result = $conn->query("SELECT employee_id, first_name, last_name FROM employees");
                    while ($row = $result->fetch_assoc()):
                    ?>
                    <option value="<?= $row['employee_id'] ?>"><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="new_position_id">Position</label>
                <select id="new_position_id" required>
                    <option value="">Select Position</option>
                    <?php
                    $result = $conn->query("SELECT position_id, title FROM positions");
                    while ($row = $result->fetch_assoc()):
                    ?>
                    <option value="<?= $row['position_id'] ?>"><?= htmlspecialchars($row['title']) ?></option>
                    <?php endwhile; ?>
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
                <input type="date" id="new_end_date">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_reporting_to">Reporting To</label>
                <select id="new_reporting_to">
                    <option value="">None</option>
                    <?php
                    $result = $conn->query("SELECT employee_id, first_name, last_name FROM employees");
                    while ($row = $result->fetch_assoc()):
                    ?>
                    <option value="<?= $row['employee_id'] ?>"><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="new_is_primary" checked>
                <label for="new_is_primary">Is Primary Role</label>
            </div>
        </div>
        <button onclick="addPositionHistory()" class="success">➕ Add Record</button>
    </div>

    <div class="card">
        <h2>Existing Records</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee</th>
                    <th>Position</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Primary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT eph.id, e.employee_id, e.first_name, e.last_name, p.title AS position_title,
                               eph.start_date, eph.end_date, eph.is_primary, r.first_name AS report_first, r.last_name AS report_last
                        FROM employee_position_history eph
                        JOIN employees e ON eph.employee_id = e.employee_id
                        JOIN positions p ON eph.position_id = p.position_id
                        LEFT JOIN employees r ON eph.reporting_to = r.employee_id
                        ORDER BY eph.id DESC";

                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['id'] ?>">
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                    <td><?= htmlspecialchars($row['position_title']) ?></td>
                    <td><input type="date" id="start_<?= $row['id'] ?>" value="<?= $row['start_date'] ?>"></td>
                    <td><input type="date" id="end_<?= $row['id'] ?>" value="<?= $row['end_date'] ?? '' ?>"></td>
                    <td style="text-align: center;">
                        <input type="checkbox" id="primary_<?= $row['id'] ?>" <?= $row['is_primary'] ? 'checked' : '' ?>>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="updatePositionHistory(<?= $row['id'] ?>)" class="success">💾 Save</button>
                            <button onclick="deletePositionHistory(<?= $row['id'] ?>)" class="danger">🗑️ Delete</button>
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

    function updatePositionHistory(id) {
        const start = document.getElementById(`start_${id}`).value;
        const end = document.getElementById(`end_${id}`).value || null;
        const primary = document.getElementById(`primary_${id}`).checked ? 1 : 0;

        if (!start) {
            showNotification('Start date is required', false);
            return;
        }

        fetch('update_position_history.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `id=${id}&start_date=${start}&end_date=${end}&is_primary=${primary}`
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(data => {
            showNotification(data, true);
        })
        .catch(error => {
            showNotification(`Error updating record: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function addPositionHistory() {
        const employeeId = document.getElementById('new_employee_id').value;
        const positionId = document.getElementById('new_position_id').value;
        const start = document.getElementById('new_start_date').value;
        const end = document.getElementById('new_end_date').value || null;
        const reportingTo = document.getElementById('new_reporting_to').value || null;
        const isPrimary = document.getElementById('new_is_primary').checked ? 1 : 0;

        if (!employeeId || !positionId || !start) {
            showNotification('Required fields are missing', false);
            return;
        }

        fetch('add_position_history.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `employee_id=${employeeId}&position_id=${positionId}&start_date=${start}&end_date=${end}&reporting_to=${reportingTo}&is_primary=${isPrimary}`
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
            showNotification(`Error adding record: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function deletePositionHistory(id) {
        if (!confirm("Are you sure you want to delete this record? This action cannot be undone.")) return;

        fetch('delete_position_history.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `id=${id}`
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(data => {
            showNotification(data, true);
            document.getElementById(`row_${id}`).remove();
        })
        .catch(error => {
            showNotification(`Error deleting record: ${error}`, false);
            console.error('Error:', error);
        });
    }
</script>
</body>
</html>