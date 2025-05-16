<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pay Period Management</title>
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
    <h1>Pay Period Management System</h1>

    <div class="card">
        <h2>Add New Pay Period</h2>
        <div class="form-group">
            <label for="new_name">Name</label>
            <input type="text" id="new_name" placeholder="e.g., Jan 2025 - Biweekly" required>
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
                <label for="new_pay_date">Pay Date</label>
                <input type="date" id="new_pay_date" required>
            </div>
            <div class="form-group">
                <label for="new_status">Status</label>
                <select id="new_status">
                    <option value="draft">Draft</option>
                    <option value="locked">Locked</option>
                    <option value="processed">Processed</option>
                    <option value="paid">Paid</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="new_created_by">Created By (Optional)</label>
            <select id="new_created_by">
                <option value="">None</option>
                <?php
                $result = $conn->query("SELECT user_id, username FROM users");
                while ($row = $result->fetch_assoc()):
                ?>
                <option value="<?= $row['user_id'] ?>"><?= htmlspecialchars($row['username']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button onclick="addPayPeriod()" class="success">➕ Add Pay Period</button>
    </div>

    <div class="card">
        <h2>Existing Pay Periods</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Dates</th>
                    <th>Pay Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p.period_id, p.name, p.start_date, p.end_date, p.pay_date, p.status, u.username AS created_by 
                        FROM pay_periods p
                        LEFT JOIN users u ON p.created_by = u.user_id
                        ORDER BY p.period_id DESC";

                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['period_id'] ?>">
                    <td><?= $row['period_id'] ?></td>
                    <td><input type="text" id="name_<?= $row['period_id'] ?>" value="<?= htmlspecialchars($row['name']) ?>"></td>
                    <td>
                        <input type="date" id="start_<?= $row['period_id'] ?>" value="<?= $row['start_date'] ?>"> –
                        <input type="date" id="end_<?= $row['period_id'] ?>" value="<?= $row['end_date'] ?>">
                    </td>
                    <td><input type="date" id="pay_<?= $row['period_id'] ?>" value="<?= $row['pay_date'] ?>"></td>
                    <td>
                        <select id="status_<?= $row['period_id'] ?>">
                            <option value="draft" <?= $row['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                            <option value="locked" <?= $row['status'] === 'locked' ? 'selected' : '' ?>>Locked</option>
                            <option value="processed" <?= $row['status'] === 'processed' ? 'selected' : '' ?>>Processed</option>
                            <option value="paid" <?= $row['status'] === 'paid' ? 'selected' : '' ?>>Paid</option>
                        </select>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="updatePayPeriod(<?= $row['period_id'] ?>)" class="success">💾 Save</button>
                            <button onclick="deletePayPeriod(<?= $row['period_id'] ?>)" class="danger">🗑️ Delete</button>
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

    function updatePayPeriod(periodId) {
        const name = document.getElementById(`name_${periodId}`).value;
        const start = document.getElementById(`start_${periodId}`).value;
        const end = document.getElementById(`end_${periodId}`).value;
        const pay = document.getElementById(`pay_${periodId}`).value;
        const status = document.getElementById(`status_${periodId}`).value;

        if (!name || !start || !end || !pay) {
            showNotification('❌ All date and name fields are required', false);
            return;
        }

        fetch('update_pay_period.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `period_id=${periodId}&name=${encodeURIComponent(name)}&start_date=${start}&end_date=${end}&pay_date=${pay}&status=${status}`
        })
        .then(response => response.text())
        .then(data => {
            showNotification(data, true);
        })
        .catch(error => {
            showNotification(`❌ Error updating period: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function addPayPeriod() {
        const name = document.getElementById('new_name').value;
        const start = document.getElementById('new_start_date').value;
        const end = document.getElementById('new_end_date').value;
        const pay = document.getElementById('new_pay_date').value;
        const status = document.getElementById('new_status').value;
        const createdBy = document.getElementById('new_created_by').value || null;

        if (!name || !start || !end || !pay) {
            showNotification('❌ Required fields are missing', false);
            return;
        }

        fetch('add_pay_period.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `name=${encodeURIComponent(name)}&start_date=${start}&end_date=${end}&pay_date=${pay}&status=${status}&created_by=${createdBy}`
        })
        .then(response => response.text())
        .then(data => {
            showNotification(data, true);
            setTimeout(() => location.reload(), 1500);
        })
        .catch(error => {
            showNotification(`❌ Failed to add period: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function deletePayPeriod(periodId) {
        if (!confirm("Are you sure you want to delete this pay period? This action cannot be undone.")) return;

        fetch('delete_pay_period.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `period_id=${periodId}`
        })
        .then(response => response.text())
        .then(data => {
            showNotification(data, true);
            document.getElementById(`row_${periodId}`).remove();
        })
        .catch(error => {
            showNotification(`❌ Failed to delete: ${error}`, false);
            console.error('Error:', error);
        });
    }
</script>
</body>
</html>