<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Leave Policies</title>
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
    <h1>Employee Leave Policy Assignment</h1>

    <div class="card">
        <h2>Add New Assignment</h2>
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
                <label for="new_policy_id">Leave Policy</label>
                <select id="new_policy_id" required>
                    <option value="">Select Policy</option>
                    <?php
                    $result = $conn->query("SELECT policy_id, name FROM leave_policies");
                    while ($row = $result->fetch_assoc()):
                        echo "<option value='{$row['policy_id']}'>{$row['name']}</option>";
                    endwhile;
                    ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_effective_from">Effective From</label>
                <input type="date" id="new_effective_from" required>
            </div>
            <div class="form-group">
                <label for="new_effective_to">Effective To</label>
                <input type="date" id="new_effective_to">
            </div>
        </div>
        <div class="form-group">
            <label for="new_assigned_by">Assigned By</label>
            <select id="new_assigned_by">
                <option value="">Select User</option>
                <?php
                $result = $conn->query("SELECT user_id, username FROM users");
                while ($row = $result->fetch_assoc()):
                    echo "<option value='{$row['user_id']}'>{$row['username']}</option>";
                endwhile;
                ?>
            </select>
        </div>
        <button onclick="assignLeavePolicy()" class="success">➕ Assign Policy</button>
    </div>

    <div class="card">
        <h2>Existing Assignments</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee</th>
                    <th>Policy</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Assigned By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT e.id, e.employee_id, emp.first_name, emp.last_name,
                               p.name AS policy_name, e.effective_from, e.effective_to,
                               u.username AS assigned_by
                        FROM employee_leave_policies e
                        JOIN employees emp ON e.employee_id = emp.employee_id
                        JOIN leave_policies p ON e.policy_id = p.policy_id
                        LEFT JOIN users u ON e.assigned_by = u.user_id
                        ORDER BY e.id DESC";

                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['id'] ?>">
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                    <td><?= htmlspecialchars($row['policy_name']) ?></td>
                    <td><input type="date" id="from_<?= $row['id'] ?>" value="<?= $row['effective_from'] ?>"></td>
                    <td><input type="date" id="to_<?= $row['id'] ?>" value="<?= $row['effective_to'] ?? '' ?>"></td>
                    <td><?= htmlspecialchars($row['assigned_by'] ?? '') ?></td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="updateLeavePolicyAssignment(<?= $row['id'] ?>)" class="success">💾 Save</button>
                            <button onclick="deleteLeavePolicyAssignment(<?= $row['id'] ?>)" class="danger">🗑️ Delete</button>
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

    function assignLeavePolicy() {
        const employeeId = document.getElementById('new_employee_id').value;
        const policyId = document.getElementById('new_policy_id').value;
        const effectiveFrom = document.getElementById('new_effective_from').value;
        const effectiveTo = document.getElementById('new_effective_to').value || null;
        const assignedBy = document.getElementById('new_assigned_by').value || null;

        if (!employeeId || !policyId || !effectiveFrom) {
            showNotification("❌ Required fields are missing", false);
            return;
        }

        fetch('add_employee_leave_policy.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `employee_id=${employeeId}&policy_id=${policyId}&effective_from=${effectiveFrom}&effective_to=${effectiveTo}&assigned_by=${assignedBy}`
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
            showNotification(`❌ Failed to assign: ${error}`, false);
            console.error(error);
        });
    }

    function updateLeavePolicyAssignment(id) {
        const effectiveFrom = document.getElementById(`from_${id}`).value;
        const effectiveTo = document.getElementById(`to_${id}`).value || null;

        if (!effectiveFrom) {
            showNotification("❌ Effective From date is required", false);
            return;
        }

        fetch('update_employee_leave_policy.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `id=${id}&effective_from=${effectiveFrom}&effective_to=${effectiveTo}`
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

    function deleteLeavePolicyAssignment(id) {
        if (!confirm("Are you sure you want to delete this assignment?")) return;

        fetch('delete_employee_leave_policy.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `id=${id}`
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