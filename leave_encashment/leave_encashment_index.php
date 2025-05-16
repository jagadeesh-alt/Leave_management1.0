<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leave Encashment Management</title>
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
    <h1>Leave Encashment Requests</h1>

    <div class="card">
        <h2>Add New Leave Encashment</h2>
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
            <div class="form-group">
                <label for="new_request_date">Request Date</label>
                <input type="date" id="new_request_date" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_days_encashed">Days Encashed</label>
                <input type="number" id="new_days_encashed" step="0.01" min="0" placeholder="e.g., 2.5">
            </div>
            <div class="form-group">
                <label for="new_rate">Rate Per Day</label>
                <input type="number" id="new_rate" step="0.01" min="0" placeholder="e.g., 100.00">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_amount">Total Amount</label>
                <input type="number" id="new_amount" step="0.01" min="0" placeholder="Auto-calculated or enter manually">
            </div>
            <div class="form-group">
                <label for="new_processed_date">Processed Date</label>
                <input type="date" id="new_processed_date">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_status">Status</label>
                <select id="new_status" required>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                    <option value="processed">Processed</option>
                </select>
            </div>
            <div class="form-group">
                <label for="new_approved_by">Approved By (Optional)</label>
                <select id="new_approved_by">
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
        <div class="form-group">
            <label for="new_notes">Notes</label>
            <textarea id="new_notes" rows="3" placeholder="Encashment notes"></textarea>
        </div>
        <button onclick="submitEncashment()" class="success">➕ Submit Encashment</button>
    </div>

    <div class="card">
        <h2>Existing Encashments</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee</th>
                    <th>Type</th>
                    <th>Period</th>
                    <th>Days</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT e.id, e.employee_id, e.type_id, e.period_id, e.days_encashed,
                               e.amount, e.status, e.notes, e.request_date, e.processed_date,
                               emp.first_name, emp.last_name, t.name AS type_name,
                               p.name AS period_name
                        FROM leave_encashment e
                        JOIN employees emp ON e.employee_id = emp.employee_id
                        JOIN leave_types t ON e.type_id = t.type_id
                        JOIN pay_periods p ON e.period_id = p.period_id
                        ORDER BY e.id DESC";

                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['id'] ?>">
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                    <td><?= htmlspecialchars($row['type_name']) ?></td>
                    <td><?= htmlspecialchars($row['period_name']) ?></td>
                    <td><input type="number" id="days_<?= $row['id'] ?>" step="0.01" value="<?= $row['days_encashed'] ?>"></td>
                    <td><input type="number" id="amount_<?= $row['id'] ?>" step="0.01" value="<?= $row['amount'] ?>"></td>
                    <td>
                        <select id="status_<?= $row['id'] ?>">
                            <option value="pending" <?= $row['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="approved" <?= $row['status'] === 'approved' ? 'selected' : '' ?>>Approved</option>
                            <option value="rejected" <?= $row['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                            <option value="processed" <?= $row['status'] === 'processed' ? 'selected' : '' ?>>Processed</option>
                        </select>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="updateEncashment(<?= $row['id'] ?>)" class="success">💾 Save</button>
                            <button onclick="deleteEncashment(<?= $row['id'] ?>)" class="danger">🗑️ Delete</button>
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

    function updateEncashment(id) {
        const days = parseFloat(document.getElementById(`days_${id}`).value) || 0;
        const amount = parseFloat(document.getElementById(`amount_${id}`).value) || 0;
        const status = document.getElementById(`status_${id}`).value;

        if (days <= 0 || amount <= 0) {
            showNotification("❌ Days and amount must be greater than zero", false);
            return;
        }

        fetch('update_leave_encashment.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `id=${id}&days_encashed=${days}&amount=${amount}&status=${status}`
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

    function submitEncashment() {
        const employeeId = document.getElementById('new_employee_id').value;
        const typeId = document.getElementById('new_type_id').value;
        const periodId = document.getElementById('new_period_id').value;
        const days = parseFloat(document.getElementById('new_days_encashed').value) || 0;
        const rate = parseFloat(document.getElementById('new_rate').value) || 0;
        const amount = parseFloat(document.getElementById('new_amount').value) || (days * rate);
        const requestDate = document.getElementById('new_request_date').value;
        const processedDate = document.getElementById('new_processed_date').value || null;
        const status = document.getElementById('new_status').value;
        const approvedBy = document.getElementById('new_approved_by').value || null;
        const notes = document.getElementById('new_notes').value;

        if (!employeeId || !typeId || !periodId || !requestDate || days <= 0 || rate <= 0) {
            showNotification("❌ Required fields are missing", false);
            return;
        }

        fetch('add_leave_encashment.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `employee_id=${employeeId}&type_id=${typeId}&period_id=${periodId}&days_encashed=${days}&rate=${rate}&amount=${amount}&request_date=${requestDate}&processed_date=${processedDate}&status=${status}&approved_by=${approvedBy}&notes=${encodeURIComponent(notes)}`
        })
        .then(response => response.text())
        .then(data => {
            showNotification(data, true);
            setTimeout(() => location.reload(), 1500);
        })
        .catch(error => {
            showNotification(`❌ Failed to add encashment: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function deleteEncashment(id) {
        if (!confirm("Are you sure you want to delete this encashment? This action cannot be undone.")) return;

        fetch('delete_leave_encashment.php', {
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