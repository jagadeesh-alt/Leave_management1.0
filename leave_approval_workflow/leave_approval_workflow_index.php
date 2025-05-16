<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leave Approval Workflow Management</title>
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

        input[type="text"], input[type="number"], input[type="datetime-local"], select {
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
    <h1>Leave Approval Workflow Management</h1>

    <div class="card">
        <h2>Add New Approval Step</h2>
        <div class="form-row">
            <div class="form-group">
                <label for="new_application_id">Leave Application</label>
                <select id="new_application_id" required>
                    <option value="">Select Application</option>
                    <?php
                    $result = $conn->query("SELECT application_id FROM leave_applications");
                    while ($row = $result->fetch_assoc()):
                        echo "<option value='{$row['application_id']}'>App #{$row['application_id']}</option>";
                    endwhile;
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="new_approver_id">Approver Employee</label>
                <select id="new_approver_id" required>
                    <option value="">Select Approver</option>
                    <?php
                    $result = $conn->query("SELECT employee_id, first_name, last_name FROM employees");
                    while ($row = $result->fetch_assoc()):
                        echo "<option value='{$row['employee_id']}'>{$row['first_name']} {$row['last_name']}</option>";
                    endwhile;
                    ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_level">Approval Level</label>
                <input type="number" id="new_level" min="1" value="1" required>
            </div>
            <div class="form-group">
                <label for="new_status">Status</label>
                <select id="new_status">
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                    <option value="delegated">Delegated</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_delegated_to">Delegated To</label>
                <select id="new_delegated_to">
                    <option value="">None</option>
                    <?php
                    $result = $conn->query("SELECT employee_id, first_name, last_name FROM employees");
                    while ($row = $result->fetch_assoc()):
                        echo "<option value='{$row['employee_id']}'>{$row['first_name']} {$row['last_name']}</option>";
                    endwhile;
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="new_action_date">Action Date/Time</label>
                <input type="datetime-local" id="new_action_date">
            </div>
        </div>
        <div class="form-group">
            <label for="new_comments">Comments</label>
            <textarea id="new_comments" rows="3" placeholder="Optional comments"></textarea>
        </div>
        <button onclick="addApprovalStep()" class="success">➕ Add Approval Step</button>
    </div>

    <div class="card">
        <h2>Existing Approval Steps</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Application</th>
                    <th>Approver</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th>Action Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT w.id, w.application_id, w.approver_id, w.level, w.status,
                               w.action_date, w.comments, w.delegated_to,
                               a.employee_id, e.first_name, e.last_name
                        FROM leave_approval_workflow w
                        JOIN leave_applications a ON w.application_id = a.application_id
                        JOIN employees e ON w.approver_id = e.employee_id
                        ORDER BY w.id DESC";

                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['id'] ?>">
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['application_id']) ?></td>
                    <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                    <td><input type="number" id="level_<?= $row['id'] ?>" value="<?= $row['level'] ?>"></td>
                    <td>
                        <select id="status_<?= $row['id'] ?>">
                            <option value="pending" <?= $row['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="approved" <?= $row['status'] === 'approved' ? 'selected' : '' ?>>Approved</option>
                            <option value="rejected" <?= $row['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                            <option value="delegated" <?= $row['status'] === 'delegated' ? 'selected' : '' ?>>Delegated</option>
                        </select>
                    </td>
                    <td><input type="datetime-local" id="action_<?= $row['id'] ?>" value="<?= $row['action_date'] ?? '' ?>"></td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="updateApprovalStep(<?= $row['id'] ?>)" class="success">💾 Save</button>
                            <button onclick="deleteApprovalStep(<?= $row['id'] ?>)" class="danger">🗑️ Delete</button>
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

    function updateApprovalStep(id) {
        const level = parseInt(document.getElementById(`level_${id}`).value) || 1;
        const status = document.getElementById(`status_${id}`).value;
        const actionDate = document.getElementById(`action_${id}`).value;

        if (!status) {
            showNotification("❌ Status is required", false);
            return;
        }

        fetch('update_leave_approval_workflow.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `id=${id}&level=${level}&status=${status}&action_date=${actionDate}`
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

    function addApprovalStep() {
        const appId = document.getElementById('new_application_id').value;
        const approverId = document.getElementById('new_approver_id').value;
        const level = parseInt(document.getElementById('new_level').value) || 1;
        const status = document.getElementById('new_status').value;
        const delegatedTo = document.getElementById('new_delegated_to').value || null;
        const actionDate = document.getElementById('new_action_date').value || null;
        const comments = document.getElementById('new_comments').value;

        if (!appId || !approverId || !status || level <= 0) {
            showNotification("❌ Required fields are missing", false);
            return;
        }

        fetch('add_leave_approval_workflow.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `application_id=${appId}&approver_id=${approverId}&level=${level}&status=${status}&comments=${encodeURIComponent(comments)}&delegated_to=${delegatedTo}&action_date=${actionDate}`
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

    function deleteApprovalStep(id) {
        if (!confirm("Are you sure you want to delete this approval step? This action cannot be undone.")) return;

        fetch('delete_leave_approval_workflow.php', {
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