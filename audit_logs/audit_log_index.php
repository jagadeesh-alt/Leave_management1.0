<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Audit Log Management</title>
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

        input[type="text"], textarea, select {
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
    <h1>Audit Logs</h1>

    <div class="card">
        <h2>Add New Audit Log</h2>
        <div class="form-group">
            <label for="new_user_id">User (Optional)</label>
            <select id="new_user_id">
                <option value="">None</option>
                <?php
                $result = $conn->query("SELECT user_id, username FROM users");
                while ($row = $result->fetch_assoc()):
                    echo "<option value='{$row['user_id']}'>{$row['username']}</option>";
                endwhile;
                ?>
            </select>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_action">Action</label>
                <input type="text" id="new_action" placeholder="e.g., update_employee_schedule">
            </div>
            <div class="form-group">
                <label for="new_table_name">Table Name</label>
                <input type="text" id="new_table_name" placeholder="e.g., leave_applications">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_record_id">Record ID</label>
                <input type="number" id="new_record_id" min="0">
            </div>
            <div class="form-group">
                <label for="new_ip_address">IP Address</label>
                <input type="text" id="new_ip_address" placeholder="e.g., 192.168.1.1">
            </div>
        </div>
        <div class="form-group">
            <label for="new_user_agent">User Agent</label>
            <textarea id="new_user_agent" rows="2" placeholder="Browser info"></textarea>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_old_values">Old Values (JSON)</label>
                <textarea id="new_old_values" rows="3" placeholder='{"name": "old_value"}'></textarea>
            </div>
            <div class="form-group">
                <label for="new_new_values">New Values (JSON)</label>
                <textarea id="new_new_values" rows="3" placeholder='{"name": "new_value"}'></textarea>
            </div>
        </div>
        <button onclick="addAuditLog()" class="success">➕ Add Audit Log</button>
    </div>

    <div class="card">
        <h2>Existing Audit Logs</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Table</th>
                    <th>Record</th>
                    <th>Timestamp</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT l.log_id, l.user_id, u.username AS user, l.action, l.table_name, l.record_id, l.created_at
                        FROM audit_logs l
                        LEFT JOIN users u ON l.user_id = u.user_id
                        ORDER BY l.created_at DESC";

                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['log_id'] ?>">
                    <td><?= $row['log_id'] ?></td>
                    <td><?= htmlspecialchars($row['user'] ?? 'System') ?></td>
                    <td><input type="text" id="action_<?= $row['log_id'] ?>" value="<?= htmlspecialchars($row['action']) ?>"></td>
                    <td><input type="text" id="table_<?= $row['log_id'] ?>" value="<?= htmlspecialchars($row['table_name']) ?>"></td>
                    <td><input type="number" id="record_<?= $row['log_id'] ?>" value="<?= $row['record_id'] ?? '' ?>"></td>
                    <td><?= htmlspecialchars(date('M d, Y H:i', strtotime($row['created_at']))) ?></td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="updateAuditLog(<?= $row['log_id'] ?>)" class="success">💾 Save</button>
                            <button onclick="deleteAuditLog(<?= $row['log_id'] ?>)" class="danger">🗑️ Delete</button>
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

    function updateAuditLog(logId) {
        const action = document.getElementById(`action_${logId}`).value;
        const table = document.getElementById(`table_${logId}`).value;
        const record = document.getElementById(`record_${logId}`).value || null;

        if (!action || !table) {
            showNotification("❌ Action and Table Name are required", false);
            return;
        }

        fetch('update_audit_log.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `log_id=${logId}&action=${encodeURIComponent(action)}&table_name=${encodeURIComponent(table)}&record_id=${record}`
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

    function addAuditLog() {
        const userId = document.getElementById('new_user_id').value || null;
        const action = document.getElementById('new_action').value;
        const table = document.getElementById('new_table_name').value;
        const record = document.getElementById('new_record_id').value || null;
        const oldValues = document.getElementById('new_old_values').value;
        const newValues = document.getElementById('new_new_values').value;
        const ip = document.getElementById('new_ip_address').value;
        const ua = document.getElementById('new_user_agent').value;

        if (!action || !table) {
            showNotification("❌ Action and Table Name are required", false);
            return;
        }

        fetch('add_audit_log.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `user_id=${userId}&action=${encodeURIComponent(action)}&table_name=${encodeURIComponent(table)}&record_id=${record}&old_values=${encodeURIComponent(oldValues)}&new_values=${encodeURIComponent(newValues)}&ip_address=${encodeURIComponent(ip)}&user_agent=${encodeURIComponent(ua)}`
        })
        .then(response => response.text())
        .then(data => {
            showNotification(data, true);
            setTimeout(() => location.reload(), 1500);
        })
        .catch(error => {
            showNotification(`❌ Failed to add log: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function deleteAuditLog(logId) {
        if (!confirm("Are you sure you want to delete this audit log? This action cannot be undone.")) return;

        fetch('delete_audit_log.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `log_id=${logId}`
        })
        .then(response => response.text())
        .then(data => {
            showNotification(data, true);
            document.getElementById(`row_${logId}`).remove();
        })
        .catch(error => {
            showNotification(`❌ Failed to delete: ${error}`, false);
            console.error('Error:', error);
        });
    }
</script>
</body>
</html>