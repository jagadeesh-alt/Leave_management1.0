<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leave Policy Management</title>
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

        input[type="text"], input[type="date"], textarea, select {
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
    <h1>Leave Policy Management System</h1>

    <div class="card">
        <h2>Add New Leave Policy</h2>
        <div class="form-group">
            <label for="new_name">Policy Name</label>
            <input type="text" id="new_name" placeholder="Enter Policy Name" required>
        </div>
        <div class="form-group">
            <label for="new_description">Description</label>
            <textarea id="new_description" rows="3" placeholder="Policy Description"></textarea>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_effective_date">Effective Date</label>
                <input type="date" id="new_effective_date" required>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="new_is_default">
                <label for="new_is_default">Default Policy</label>
            </div>
        </div>
        <div class="form-group">
            <label for="new_created_by">Created By</label>
            <select id="new_created_by">
                <option value="">Select User</option>
                <?php
                $result = $conn->query("SELECT user_id, username FROM users");
                while ($row = $result->fetch_assoc()):
                ?>
                <option value="<?= $row['user_id'] ?>"><?= htmlspecialchars($row['username']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button onclick="addLeavePolicy()" class="success">➕ Add Leave Policy</button>
    </div>

    <div class="card">
        <h2>Existing Leave Policies</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Effective Date</th>
                    <th>Default</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p.policy_id, p.name, p.description, p.effective_date, p.is_default, u.username AS created_by
                        FROM leave_policies p
                        LEFT JOIN users u ON p.created_by = u.user_id
                        ORDER BY p.policy_id DESC";

                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['policy_id'] ?>">
                    <td><?= $row['policy_id'] ?></td>
                    <td><input type="text" id="name_<?= $row['policy_id'] ?>" value="<?= htmlspecialchars($row['name']) ?>"></td>
                    <td><input type="text" id="desc_<?= $row['policy_id'] ?>" value="<?= htmlspecialchars($row['description']) ?>"></td>
                    <td><input type="date" id="eff_<?= $row['policy_id'] ?>" value="<?= $row['effective_date'] ?>"></td>
                    <td style="text-align: center;">
                        <input type="checkbox" id="def_<?= $row['policy_id'] ?>" <?= $row['is_default'] ? 'checked' : '' ?>>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="updateLeavePolicy(<?= $row['policy_id'] ?>)" class="success">💾 Save</button>
                            <button onclick="deleteLeavePolicy(<?= $row['policy_id'] ?>)" class="danger">🗑️ Delete</button>
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

    function updateLeavePolicy(policyId) {
        const name = document.getElementById(`name_${policyId}`).value;
        const desc = document.getElementById(`desc_${policyId}`).value;
        const effDate = document.getElementById(`eff_${policyId}`).value;
        const isDefault = document.getElementById(`def_${policyId}`).checked ? 1 : 0;

        if (!name || !effDate) {
            showNotification('Name and Effective Date are required', false);
            return;
        }

        fetch('update_leave_policy.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `policy_id=${policyId}&name=${encodeURIComponent(name)}&description=${encodeURIComponent(desc)}&effective_date=${effDate}&is_default=${isDefault}`
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(data => {
            showNotification(data, true);
        })
        .catch(error => {
            showNotification(`Error updating policy: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function addLeavePolicy() {
        const name = document.getElementById('new_name').value;
        const desc = document.getElementById('new_description').value;
        const effDate = document.getElementById('new_effective_date').value;
        const isDefault = document.getElementById('new_is_default').checked ? 1 : 0;
        const createdBy = document.getElementById('new_created_by').value || null;

        if (!name || !effDate) {
            showNotification('Name and Effective Date are required', false);
            return;
        }

        fetch('add_leave_policy.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `name=${encodeURIComponent(name)}&description=${encodeURIComponent(desc)}&effective_date=${effDate}&is_default=${isDefault}&created_by=${createdBy}`
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
            showNotification(`Error adding policy: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function deleteLeavePolicy(policyId) {
        if (!confirm("Are you sure you want to delete this leave policy? This action cannot be undone.")) return;

        fetch('delete_leave_policy.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `policy_id=${policyId}`
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(data => {
            showNotification(data, true);
            document.getElementById(`row_${policyId}`).remove();
        })
        .catch(error => {
            showNotification(`Error deleting policy: ${error}`, false);
            console.error('Error:', error);
        });
    }
</script>
</body>
</html>