<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Leave Balances</title>
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

        input[type="text"], input[type="number"], input[type="year"], select {
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
    <h1>Employee Leave Balance Management</h1>

    <div class="card">
        <h2>Add New Leave Balance</h2>
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
                <label for="new_year">Year</label>
                <input type="number" id="new_year" min="1900" max="<?= date('Y') + 5 ?>" placeholder="e.g., <?= date('Y') ?>">
            </div>
            <div class="form-group">
                <label for="new_total_allocated">Total Allocated</label>
                <input type="number" id="new_total_allocated" step="0.01" min="0" placeholder="e.g., 15.00">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_total_used">Used</label>
                <input type="number" id="new_total_used" step="0.01" min="0" value="0.00">
            </div>
            <div class="form-group">
                <label for="new_carried_forward">Carried Forward</label>
                <input type="number" id="new_carried_forward" step="0.01" min="0" value="0.00">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_pending_approval">Pending Approval</label>
                <input type="number" id="new_pending_approval" step="0.01" min="0" value="0.00">
            </div>
            <div class="form-group">
                <label for="new_encashed">Encashed</label>
                <input type="number" id="new_encashed" step="0.01" min="0" value="0.00">
            </div>
        </div>
        <div class="form-group">
            <label for="new_notes">Notes</label>
            <textarea id="new_notes" rows="3" placeholder="Optional notes"></textarea>
        </div>
        <button onclick="addLeaveBalance()" class="success">➕ Add Leave Balance</button>
    </div>

    <div class="card">
        <h2>Existing Leave Balances</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee</th>
                    <th>Type</th>
                    <th>Year</th>
                    <th>Allocated</th>
                    <th>Used</th>
                    <th>Remaining</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT b.balance_id, b.employee_id, b.type_id, b.year,
                               b.total_allocated, b.total_used, b.carried_forward,
                               b.pending_approval, b.encashed, b.notes,
                               e.first_name, e.last_name, t.name AS type_name
                        FROM employee_leave_balances b
                        JOIN employees e ON b.employee_id = e.employee_id
                        JOIN leave_types t ON b.type_id = t.type_id
                        ORDER BY b.year DESC";

                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['balance_id'] ?>">
                    <td><?= $row['balance_id'] ?></td>
                    <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                    <td><?= htmlspecialchars($row['type_name']) ?></td>
                    <td><input type="number" id="year_<?= $row['balance_id'] ?>" min="1900" max="<?= date('Y') + 5 ?>" value="<?= $row['year'] ?>"></td>
                    <td><input type="number" id="alloc_<?= $row['balance_id'] ?>" step="0.01" value="<?= $row['total_allocated'] ?>"></td>
                    <td><input type="number" id="used_<?= $row['balance_id'] ?>" step="0.01" value="<?= $row['total_used'] ?>"></td>
                    <td><?= number_format($row['total_allocated'] - $row['total_used'], 2) ?></td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="updateLeaveBalance(<?= $row['balance_id'] ?>)" class="success">💾 Save</button>
                            <button onclick="deleteLeaveBalance(<?= $row['balance_id'] ?>)" class="danger">🗑️ Delete</button>
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

    function updateLeaveBalance(balanceId) {
        const year = document.getElementById(`year_${balanceId}`).value;
        const totalAllocated = parseFloat(document.getElementById(`alloc_${balanceId}`).value) || 0;
        const totalUsed = parseFloat(document.getElementById(`used_${balanceId}`).value) || 0;

        if (!year || totalAllocated < 0 || totalUsed < 0) {
            showNotification("❌ Invalid input", false);
            return;
        }

        fetch('update_employee_leave_balance.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `balance_id=${balanceId}&year=${year}&total_allocated=${totalAllocated}&total_used=${totalUsed}`
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

    function addLeaveBalance() {
        const employeeId = document.getElementById('new_employee_id').value;
        const typeId = document.getElementById('new_type_id').value;
        const year = document.getElementById('new_year').value;
        const totalAllocated = parseFloat(document.getElementById('new_total_allocated').value) || 0;
        const totalUsed = parseFloat(document.getElementById('new_total_used').value) || 0;
        const carriedForward = parseFloat(document.getElementById('new_carried_forward').value) || 0;
        const pendingApproval = parseFloat(document.getElementById('new_pending_approval').value) || 0;
        const encashed = parseFloat(document.getElementById('new_encashed').value) || 0;
        const notes = document.getElementById('new_notes').value;

        if (!employeeId || !typeId || !year || totalAllocated <= 0) {
            showNotification("❌ Required fields are missing", false);
            return;
        }

        fetch('add_employee_leave_balance.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `employee_id=${employeeId}&type_id=${typeId}&year=${year}&total_allocated=${totalAllocated}&total_used=${totalUsed}&carried_forward=${carriedForward}&pending_approval=${pendingApproval}&encashed=${encashed}&notes=${encodeURIComponent(notes)}`
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

    function deleteLeaveBalance(balanceId) {
        if (!confirm("Are you sure you want to delete this leave balance? This action cannot be undone.")) return;

        fetch('delete_employee_leave_balance.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `balance_id=${balanceId}`
        })
        .then(response => response.text())
        .then(data => {
            showNotification(data, true);
            document.getElementById(`row_${balanceId}`).remove();
        })
        .catch(error => {
            showNotification(`❌ Failed to delete: ${error}`, false);
            console.error('Error:', error);
        });
    }
</script>
</body>
</html>