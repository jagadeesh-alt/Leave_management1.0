<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leave Blackout Period Management</title>
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
    <h1>Leave Blackout Period Management</h1>

    <div class="card">
        <h2>Add New Blackout Period</h2>
        <div class="form-group">
            <label for="new_name">Name</label>
            <input type="text" id="new_name" placeholder="Blackout Period Name" required>
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
        <div class="form-group">
            <label for="new_type_id">Leave Type (Optional)</label>
            <select id="new_type_id">
                <option value="">All Leave Types</option>
                <?php
                $result = $conn->query("SELECT type_id, name FROM leave_types");
                while ($row = $result->fetch_assoc()):
                    echo "<option value='{$row['type_id']}'>{$row['name']}</option>";
                endwhile;
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="new_description">Description</label>
            <textarea id="new_description" rows="3" placeholder="Blackout period description"></textarea>
        </div>
        <div class="form-row">
            <div class="checkbox-group">
                <input type="checkbox" id="new_is_active" checked>
                <label for="new_is_active">Active</label>
            </div>
            <div class="form-group">
                <label for="new_created_by">Created By (Optional)</label>
                <select id="new_created_by">
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
        <button onclick="addBlackoutPeriod()" class="success">➕ Add Blackout Period</button>
    </div>

    <div class="card">
        <h2>Existing Blackout Periods</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Dates</th>
                    <th>Type</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT b.id, b.name, b.start_date, b.end_date, b.description, b.is_active,
                               t.name AS type_name, u.username AS created_by
                        FROM leave_blackout_periods b
                        LEFT JOIN leave_types t ON b.type_id = t.type_id
                        LEFT JOIN users u ON b.created_by = u.user_id
                        ORDER BY b.id DESC";

                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['id'] ?>">
                    <td><?= $row['id'] ?></td>
                    <td><input type="text" id="name_<?= $row['id'] ?>" value="<?= htmlspecialchars($row['name']) ?>"></td>
                    <td>
                        <input type="date" id="start_<?= $row['id'] ?>" value="<?= $row['start_date'] ?>">
                        - 
                        <input type="date" id="end_<?= $row['id'] ?>" value="<?= $row['end_date'] ?>">
                    </td>
                    <td><?= htmlspecialchars($row['type_name'] ?? 'All Types') ?></td>
                    <td style="text-align: center;">
                        <input type="checkbox" id="active_<?= $row['id'] ?>" <?= $row['is_active'] ? 'checked' : '' ?>>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="updateBlackoutPeriod(<?= $row['id'] ?>)" class="success">💾 Save</button>
                            <button onclick="deleteBlackoutPeriod(<?= $row['id'] ?>)" class="danger">🗑️ Delete</button>
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

    function updateBlackoutPeriod(id) {
        const name = document.getElementById(`name_${id}`).value;
        const start = document.getElementById(`start_${id}`).value;
        const end = document.getElementById(`end_${id}`).value;
        const isActive = document.getElementById(`active_${id}`).checked ? 1 : 0;

        if (!name || !start || !end) {
            showNotification('❌ Name and dates are required', false);
            return;
        }

        fetch('update_leave_blackout_period.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `id=${id}&name=${encodeURIComponent(name)}&start_date=${start}&end_date=${end}&is_active=${isActive}`
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

    function addBlackoutPeriod() {
        const name = document.getElementById('new_name').value;
        const start = document.getElementById('new_start_date').value;
        const end = document.getElementById('new_end_date').value;
        const typeId = document.getElementById('new_type_id').value || null;
        const desc = document.getElementById('new_description').value;
        const isActive = document.getElementById('new_is_active').checked ? 1 : 0;
        const createdBy = document.getElementById('new_created_by').value || null;

        if (!name || !start || !end) {
            showNotification("❌ Required fields are missing", false);
            return;
        }

        fetch('add_leave_blackout_period.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `name=${encodeURIComponent(name)}&start_date=${start}&end_date=${end}&type_id=${typeId}&description=${encodeURIComponent(desc)}&is_active=${isActive}&created_by=${createdBy}`
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

    function deleteBlackoutPeriod(id) {
        if (!confirm("Are you sure you want to delete this blackout period? This action cannot be undone.")) return;

        fetch('delete_leave_blackout_period.php', {
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