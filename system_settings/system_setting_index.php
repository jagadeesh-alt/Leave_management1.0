<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>System Settings</title>
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

        input[type="text"], input[type="number"], textarea, select {
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
    <h1>System Settings Management</h1>

    <div class="card">
        <h2>Add New Setting</h2>
        <div class="form-group">
            <label for="new_key">Setting Key</label>
            <input type="text" id="new_key" placeholder="e.g., leave.max_days_per_year">
        </div>
        <div class="form-group">
            <label for="new_value">Value</label>
            <textarea id="new_value" rows="3" placeholder="Enter raw value"></textarea>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_data_type">Data Type</label>
                <select id="new_data_type">
                    <option value="">Select Data Type</option>
                    <option value="string">String</option>
                    <option value="number">Number</option>
                    <option value="boolean">Boolean</option>
                    <option value="json">JSON</option>
                    <option value="date">Date</option>
                </select>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="new_is_public">
                <label for="new_is_public">Public Access</label>
            </div>
        </div>
        <div class="form-group">
            <label for="new_description">Description</label>
            <textarea id="new_description" rows="2" placeholder="Describe this setting"></textarea>
        </div>
        <div class="form-group">
            <label for="new_updated_by">Updated By (Optional)</label>
            <select id="new_updated_by">
                <option value="">None</option>
                <?php
                $result = $conn->query("SELECT user_id, username FROM users");
                while ($row = $result->fetch_assoc()):
                ?>
                <option value="<?= $row['user_id'] ?>"><?= htmlspecialchars($row['username']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button onclick="addSystemSetting()" class="success">➕ Add Setting</button>
    </div>

    <div class="card">
        <h2>Existing System Settings</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Key</th>
                    <th>Value</th>
                    <th>Type</th>
                    <th>Public</th>
                    <th>Updated By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT s.setting_id, s.setting_key, s.setting_value, s.data_type,
                               s.description, s.is_public, u.username AS updater
                        FROM system_settings s
                        LEFT JOIN users u ON s.updated_by = u.user_id
                        ORDER BY s.setting_key ASC";

                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['setting_id'] ?>">
                    <td><?= $row['setting_id'] ?></td>
                    <td><input type="text" id="key_<?= $row['setting_id'] ?>" value="<?= htmlspecialchars($row['setting_key']) ?>"></td>
                    <td><textarea id="value_<?= $row['setting_id'] ?>" rows="2"><?= htmlspecialchars($row['setting_value']) ?></textarea></td>
                    <td>
                        <select id="type_<?= $row['setting_id'] ?>">
                            <option value="string" <?= $row['data_type'] === 'string' ? 'selected' : '' ?>>String</option>
                            <option value="number" <?= $row['data_type'] === 'number' ? 'selected' : '' ?>>Number</option>
                            <option value="boolean" <?= $row['data_type'] === 'boolean' ? 'selected' : '' ?>>Boolean</option>
                            <option value="json" <?= $row['data_type'] === 'json' ? 'selected' : '' ?>>JSON</option>
                            <option value="date" <?= $row['data_type'] === 'date' ? 'selected' : '' ?>>Date</option>
                        </select>
                    </td>
                    <td style="text-align: center;">
                        <input type="checkbox" id="public_<?= $row['setting_id'] ?>" <?= $row['is_public'] ? 'checked' : '' ?>>
                    </td>
                    <td><?= htmlspecialchars($row['updater'] ?? '') ?></td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="updateSystemSetting(<?= $row['setting_id'] ?>)" class="success">💾 Save</button>
                            <button onclick="deleteSystemSetting(<?= $row['setting_id'] ?>)" class="danger">🗑️ Delete</button>
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

    function updateSystemSetting(id) {
        const key = document.getElementById(`key_${id}`).value;
        const value = document.getElementById(`value_${id}`).value;
        const type = document.getElementById(`type_${id}`).value;
        const isPublic = document.getElementById(`public_${id}`).checked ? 1 : 0;

        if (!key || !type) {
            showNotification('❌ Key and Data Type are required', false);
            return;
        }

        fetch('update_system_setting.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `setting_id=${id}&setting_key=${encodeURIComponent(key)}&setting_value=${encodeURIComponent(value)}&data_type=${type}&is_public=${isPublic}`
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

    function addSystemSetting() {
        const key = document.getElementById('new_key').value;
        const value = document.getElementById('new_value').value;
        const type = document.getElementById('new_data_type').value;
        const isPublic = document.getElementById('new_is_public').checked ? 1 : 0;
        const desc = document.getElementById('new_description').value;
        const updatedBy = document.getElementById('new_updated_by').value || null;

        if (!key || !type) {
            showNotification("❌ Key and Data Type are required", false);
            return;
        }

        fetch('add_system_setting.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `setting_key=${encodeURIComponent(key)}&setting_value=${encodeURIComponent(value)}&data_type=${type}&description=${encodeURIComponent(desc)}&is_public=${isPublic}&updated_by=${updatedBy}`
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

    function deleteSystemSetting(id) {
        if (!confirm("Are you sure you want to delete this setting? This action cannot be undone.")) return;

        fetch('delete_system_setting.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `setting_id=${id}`
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