<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leave Impact on Payroll</title>
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

        input[type="text"], input[type="number"], select {
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
    <h1>Leave Impact on Payroll</h1>

    <div class="card">
        <h2>Add New Leave Impact</h2>
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
                <label for="new_period_id">Pay Period</label>
                <select id="new_period_id" required>
                    <option value="">Select Pay Period</option>
                    <?php
                    $result = $conn->query("SELECT period_id, name FROM pay_periods");
                    while ($row = $result->fetch_assoc()):
                        echo "<option value='{$row['period_id']}'>{$row['name']}</option>";
                    endwhile;
                    ?>
                </select>
            </div>
        </div>
        <div class="form-row">
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
            <div class="form-group">
                <label for="new_application_id">Application ID (Optional)</label>
                <select id="new_application_id">
                    <option value="">None</option>
                    <?php
                    $result = $conn->query("SELECT application_id, employee_id FROM leave_applications");
                    while ($row = $result->fetch_assoc()):
                        echo "<option value='{$row['application_id']}'>App #{$row['application_id']}</option>";
                    endwhile;
                    ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_days">Days</label>
                <input type="number" id="new_days" step="0.01" min="0" placeholder="e.g., 2.5">
            </div>
            <div class="form-group">
                <label for="new_impact_type">Impact Type</label>
                <select id="new_impact_type">
                    <option value="">Select Type</option>
                    <option value="deduction">Deduction</option>
                    <option value="addition">Addition</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_amount">Amount</label>
                <input type="number" id="new_amount" step="0.01" min="0" placeholder="e.g., 250.00">
            </div>
        </div>
        <button onclick="addLeaveImpact()" class="success">➕ Add Leave Impact</button>
    </div>

    <div class="card">
        <h2>Existing Leave Impacts</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee</th>
                    <th>Period</th>
                    <th>Type</th>
                    <th>Days</th>
                    <th>Impact</th>
                    <th>Amount</th>
                    <th>Processed At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT l.id, l.employee_id, l.period_id, l.application_id, l.type_id,
                               l.days, l.impact_type, l.amount, l.processed_at,
                               e.first_name, e.last_name, p.name AS period_name,
                               t.name AS type_name
                        FROM leave_impact_on_payroll l
                        JOIN employees e ON l.employee_id = e.employee_id
                        JOIN pay_periods p ON l.period_id = p.period_id
                        JOIN leave_types t ON l.type_id = t.type_id
                        ORDER BY l.id DESC";

                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['id'] ?>">
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
    <td><?= htmlspecialchars($row['type_name']) ?></td>
    <td><?= htmlspecialchars($row['period_name']) ?></td>
    <td><input type="number" id="days_<?= $row['id'] ?>" step="0.01" value="<?= $row['days_encashed'] ?>"></td>
    <td>
        <select id="status_<?= $row['id'] ?>">
            <option value="pending" <?= $row['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
            <option value="approved" <?= $row['status'] === 'approved' ? 'selected' : '' ?>>Approved</option>
            <option value="rejected" <?= $row['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
            <option value="processed" <?= $row['status'] === 'processed' ? 'selected' : '' ?>>Processed</option>
        </select>
    </td>
    <td><input type="number" id="amount_<?= $row['id'] ?>" step="0.01" value="<?= $row['amount'] ?>"></td>
    <td><?= htmlspecialchars(date('M d, Y H:i', strtotime($row['processed_at']))) ?></td>
    <td>
        <div class="action-buttons">
            <button onclick="updateLeaveImpact(<?= $row['id'] ?>)" class="success">💾 Save</button>
            <button onclick="deleteLeaveImpact(<?= $row['id'] ?>)" class="danger">🗑️ Delete</button>
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

    function updateLeaveImpact(id) {
        const days = parseFloat(document.getElementById(`days_${id}`).value) || 0.00;
        const impactType = document.getElementById(`impact_${id}`).value;
        const amount = parseFloat(document.getElementById(`amount_${id}`).value) || 0.00;

        if (!impactType || days <= 0 || amount < 0) {
            showNotification("❌ Invalid values", false);
            return;
        }

        fetch('update_leave_impact.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `id=${id}&days=${days}&impact_type=${impactType}&amount=${amount}`
        })
        .then(response => response.text())
        .then(data => {
            showNotification(data, true);
        })
        .catch(error => {
            showNotification(`❌ Failed to update: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function addLeaveImpact() {
        const employeeId = document.getElementById('new_employee_id').value;
        const periodId = document.getElementById('new_period_id').value;
        const typeId = document.getElementById('new_type_id').value;
        const appId = document.getElementById('new_application_id').value || null;
        const days = parseFloat(document.getElementById('new_days').value) || 0.00;
        const impactType = document.getElementById('new_impact_type').value;
        const amount = parseFloat(document.getElementById('new_amount').value) || 0.00;

        if (!employeeId || !periodId || !typeId || !impactType || days <= 0 || amount < 0) {
            showNotification("❌ Required fields are missing", false);
            return;
        }

        fetch('add_leave_impact.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `employee_id=${employeeId}&period_id=${periodId}&type_id=${typeId}&application_id=${appId}&days=${days}&impact_type=${impactType}&amount=${amount}`
        })
        .then(response => response.text())
        .then(data => {
            showNotification(data, true);
            setTimeout(() => location.reload(), 1500);
        })
        .catch(error => {
            showNotification(`❌ Failed to add: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function deleteLeaveImpact(id) {
        if (!confirm("Are you sure you want to delete this leave impact? This action cannot be undone.")) return;

        fetch('delete_leave_impact.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `id=${id}`
        })
        .then(response => response.text())
        .then(data => {
            showNotification(data, true);
            document.getElementById(`row_${id}`).remove();
        })
        .catch(error => {
            showNotification(`❌ Failed to delete: ${error}`, false);
            console.error('Error:', error);
        });
    }
</script>
</body>
</html>