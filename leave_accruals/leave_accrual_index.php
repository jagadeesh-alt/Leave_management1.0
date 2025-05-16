<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leave Accrual Management</title>
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

        input[type="text"], input[type="date"], input[type="number"], select {
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
    <h1>Leave Accrual Management System</h1>

    <div class="card">
        <h2>Add New Accrual</h2>
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
                <label for="new_accrual_date">Accrual Date</label>
                <input type="date" id="new_accrual_date" required>
            </div>
            <div class="form-group">
                <label for="new_amount">Amount</label>
                <input type="number" id="new_amount" step="0.01" min="0" placeholder="e.g., 1.5">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_policy_rule_id">Policy Rule (Optional)</label>
                <select id="new_policy_rule_id">
                    <option value="">None</option>
                    <?php
                    $result = $conn->query("SELECT rule_id, policy_id, type_id FROM leave_policy_rules");
                    while ($row = $result->fetch_assoc()):
                        echo "<option value='{$row['rule_id']}'>Rule #{$row['rule_id']}</option>";
                    endwhile;
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="new_processed_by">Processed By (Optional)</label>
                <select id="new_processed_by">
                    <option value="">None</option>
                    <?php
                    $result = $conn->query("SELECT user_id, username FROM users");
                    while ($row = $result->fetch_assoc()):
                        echo "<option value='{$row['user_id']}'>{$row['username']}</option>";
                    endwhile;
                    ?>
                </select>
            </div>
        </div>
        <button onclick="addLeaveAccrual()" class="success">➕ Add Accrual</button>
    </div>

    <div class="card">
        <h2>Existing Accruals</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Processed By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT a.accrual_id, a.employee_id, a.type_id, a.accrual_date,
                               a.amount, u.username AS processed_by
                        FROM leave_accruals a
                        LEFT JOIN employees e ON a.employee_id = e.employee_id
                        LEFT JOIN leave_types t ON a.type_id = t.type_id
                        LEFT JOIN users u ON a.processed_by = u.user_id
                        ORDER BY a.accrual_id DESC";

                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['accrual_id'] ?>">
                    <td><?= $row['accrual_id'] ?></td>
                    <td><?= htmlspecialchars($row['employee_id']) ?></td>
                    <td><?= htmlspecialchars($row['type_id']) ?></td>
                    <td><input type="date" id="date_<?= $row['accrual_id'] ?>" value="<?= $row['accrual_date'] ?>"></td>
                    <td><input type="number" id="amount_<?= $row['accrual_id'] ?>" step="0.01" value="<?= $row['amount'] ?>"></td>
                    <td><?= htmlspecialchars($row['processed_by'] ?? '') ?></td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="updateLeaveAccrual(<?= $row['accrual_id'] ?>)" class="success">💾 Save</button>
                            <button onclick="deleteLeaveAccrual(<?= $row['accrual_id'] ?>)" class="danger">🗑️ Delete</button>
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

    function updateLeaveAccrual(accrualId) {
        const date = document.getElementById(`date_${accrualId}`).value;
        const amount = parseFloat(document.getElementById(`amount_${accrualId}`).value) || 0;

        if (!date || isNaN(amount)) {
            showNotification("❌ Date and amount are required", false);
            return;
        }

        fetch('update_leave_accrual.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `accrual_id=${accrualId}&accrual_date=${date}&amount=${amount}`
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

    function addLeaveAccrual() {
        const employeeId = document.getElementById('new_employee_id').value;
        const typeId = document.getElementById('new_type_id').value;
        const accrualDate = document.getElementById('new_accrual_date').value;
        const amount = parseFloat(document.getElementById('new_amount').value) || 0;
        const policyRuleId = document.getElementById('new_policy_rule_id').value || null;
        const processedBy = document.getElementById('new_processed_by').value || null;

        if (!employeeId || !typeId || !accrualDate || isNaN(amount)) {
            showNotification("❌ Required fields are missing", false);
            return;
        }

        fetch('add_leave_accrual.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `employee_id=${employeeId}&type_id=${typeId}&accrual_date=${accrualDate}&amount=${amount}&policy_rule_id=${policyRuleId}&processed_by=${processedBy}`
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
            showNotification(`❌ Failed to add: ${error}`, false);
            console.error(error);
        });
    }

    function deleteLeaveAccrual(accrualId) {
        if (!confirm("Are you sure you want to delete this accrual? This action cannot be undone.")) return;

        fetch('delete_leave_accrual.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `accrual_id=${accrualId}`
        })
        .then(response => {
            if (!response.ok) throw new Error('Network error');
            return response.text();
        })
        .then(data => {
            showNotification(data, true);
            document.getElementById(`row_${accrualId}`).remove();
        })
        .catch(error => {
            showNotification(`❌ Failed to delete: ${error}`, false);
            console.error(error);
        });
    }
</script>
</body>
</html>