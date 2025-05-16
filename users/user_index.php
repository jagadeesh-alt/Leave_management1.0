<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
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

        input[type="text"], input[type="password"], input[type="email"], input[type="number"], select {
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
    <h1>User Management System</h1>

    <div class="card">
        <h2>Add New User</h2>
        <div class="form-group">
            <label for="new_employee_id">Employee (Optional)</label>
            <select id="new_employee_id">
                <option value="">None</option>
                <?php
                $result = $conn->query("SELECT employee_id, first_name, last_name FROM employees");
                while ($row = $result->fetch_assoc()):
                    echo "<option value='{$row['employee_id']}'>{$row['first_name']} {$row['last_name']}</option>";
                endwhile;
                ?>
            </select>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_username">Username</label>
                <input type="text" id="new_username" placeholder="Enter Username" required>
            </div>
            <div class="form-group">
                <label for="new_email">Email</label>
                <input type="email" id="new_email" placeholder="Enter Email" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_password_hash">Password Hash</label>
                <input type="password" id="new_password_hash" placeholder="Hashed Password" required>
            </div>
            <div class="form-group">
                <label for="new_role_id">Role</label>
                <select id="new_role_id" required>
                    <option value="">Select Role</option>
                    <?php
                    $result = $conn->query("SELECT role_id, name FROM roles");
                    while ($row = $result->fetch_assoc()):
                        echo "<option value='{$row['role_id']}'>{$row['name']}</option>";
                    endwhile;
                    ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="checkbox-group">
                <input type="checkbox" id="new_must_change_password" checked>
                <label for="new_must_change_password">Must Change Password</label>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="new_account_locked">
                <label for="new_account_locked">Account Locked</label>
            </div>
        </div>
        <button onclick="addUser()" class="success">➕ Add User</button>
    </div>

    <div class="card">
        <h2>Existing Users</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT u.user_id, u.username, u.email, u.role_id, u.employee_id,
                               r.name AS role_name, u.account_locked, u.must_change_password
                        FROM users u
                        JOIN roles r ON u.role_id = r.role_id
                        ORDER BY u.user_id DESC";

                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['user_id'] ?>">
                    <td><?= $row['user_id'] ?></td>
                    <td><input type="text" id="username_<?= $row['user_id'] ?>" value="<?= htmlspecialchars($row['username']) ?>"></td>
                    <td><input type="email" id="email_<?= $row['user_id'] ?>" value="<?= htmlspecialchars($row['email']) ?>"></td>
                    <td>
                        <select id="role_<?= $row['user_id'] ?>">
                            <?php
                            $roles = $conn->query("SELECT role_id, name FROM roles");
                            while ($r = $roles->fetch_assoc()):
                                $selected = ($r['role_id'] == $row['role_id']) ? 'selected' : '';
                                echo "<option value='{$r['role_id']}' $selected>{$r['name']}</option>";
                            endwhile;
                            ?>
                        </select>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="updateUser(<?= $row['user_id'] ?>)" class="success">💾 Save</button>
                            <button onclick="deleteUser(<?= $row['user_id'] ?>)" class="danger">🗑️ Delete</button>
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

    function updateUser(userId) {
        const username = document.getElementById(`username_${userId}`).value;
        const email = document.getElementById(`email_${userId}`).value;
        const roleId = document.getElementById(`role_${userId}`).value;
        if (!username || !email || !roleId) {
            showNotification("❌ Required fields are missing", false);
            return;
        }

        fetch('update_user.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `user_id=${userId}&username=${encodeURIComponent(username)}&email=${encodeURIComponent(email)}&role_id=${roleId}`
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

    function addUser() {
        const employeeId = document.getElementById('new_employee_id').value || null;
        const username = document.getElementById('new_username').value;
        const email = document.getElementById('new_email').value;
        const password = document.getElementById('new_password_hash').value;
        const roleId = document.getElementById('new_role_id').value;
        const mustChangePass = document.getElementById('new_must_change_password').checked ? 1 : 0;
        const accountLocked = document.getElementById('new_account_locked').checked ? 1 : 0;

        if (!username || !email || !roleId) {
            showNotification("❌ Required fields are missing", false);
            return;
        }

        fetch('add_user.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `employee_id=${employeeId}&username=${encodeURIComponent(username)}&email=${encodeURIComponent(email)}&password_hash=${encodeURIComponent(password)}&role_id=${roleId}&must_change_password=${mustChangePass}&account_locked=${accountLocked}`
        })
        .then(response => response.text())
        .then(data => {
            showNotification(data, true);
            setTimeout(() => location.reload(), 1500);
        })
        .catch(error => {
            showNotification(`❌ Failed to add user: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function deleteUser(userId) {
        if (!confirm("Are you sure you want to delete this user? This action cannot be undone.")) return;

        fetch('delete_user.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `user_id=${userId}`
        })
        .then(response => response.text())
        .then(data => {
            showNotification(data, true);
            document.getElementById(`row_${userId}`).remove();
        })
        .catch(error => {
            showNotification(`❌ Failed to delete: ${error}`, false);
            console.error('Error:', error);
        });
    }
</script>
</body>
</html>