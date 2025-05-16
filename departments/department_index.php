<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Department Management System</title>
    <style>
        /* Same styles as index.php */
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

        input[type="text"], input[type="email"], input[type="tel"], textarea, select {
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
    <h1>Department Management System</h1>

    <div class="card">
        <h2>Add New Department</h2>
        <div class="form-row">
            <div class="form-group">
                <label for="new_name">Name</label>
                <input type="text" id="new_name" placeholder="Department Name" required>
            </div>
            <div class="form-group">
                <label for="new_code">Code</label>
                <input type="text" id="new_code" placeholder="Dept Code (e.g., HR)">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_parent_id">Parent Department</label>
                <select id="new_parent_id">
                    <option value="">None</option>
                    <?php
                    $result = $conn->query("SELECT department_id, name FROM departments");
                    while ($row = $result->fetch_assoc()):
                    ?>
                    <option value="<?= $row['department_id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="new_manager_id">Manager</label>
                <select id="new_manager_id">
                    <option value="">Select Manager</option>
                    <?php
                    $result = $conn->query("SELECT employee_id, first_name, last_name FROM employees WHERE status = 'active'");
                    while ($row = $result->fetch_assoc()):
                    ?>
                    <option value="<?= $row['employee_id'] ?>"><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_cost_center">Cost Center</label>
                <input type="text" id="new_cost_center" placeholder="Cost Center Code">
            </div>
        </div>
        <div class="form-group">
            <label for="new_description">Description</label>
            <textarea id="new_description" rows="3" placeholder="Department Description"></textarea>
        </div>
        <button onclick="addDepartment()" class="success">➕ Add Department</button>
    </div>

    <div class="card">
        <h2>Existing Departments</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Parent</th>
                    <th>Manager</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT d.department_id, d.name, d.code, d.cost_center, d.description,
                               p.name AS parent_name, CONCAT(e.first_name, ' ', e.last_name) AS manager_name
                        FROM departments d
                        LEFT JOIN departments p ON d.parent_department_id = p.department_id
                        LEFT JOIN employees e ON d.manager_id = e.employee_id
                        ORDER BY d.department_id DESC";

                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['department_id'] ?>">
                    <td><?= $row['department_id'] ?></td>
                    <td><input type="text" id="name_<?= $row['department_id'] ?>" value="<?= htmlspecialchars($row['name']) ?>" required></td>
                    <td><input type="text" id="code_<?= $row['department_id'] ?>" value="<?= htmlspecialchars($row['code']) ?>"></td>
                    <td>
                        <select id="parent_<?= $row['department_id'] ?>">
                            <option value="">None</option>
                            <?php
                            $conn2 = new mysqli($host, $user, $password, $dbname);
                            $depts = $conn2->query("SELECT department_id, name FROM departments WHERE department_id != {$row['department_id']}");
                            while ($d = $depts->fetch_assoc()):
                                $selected = ($d['department_id'] == $row['department_id']) ? 'selected' : '';
                            ?>
                            <option value="<?= $d['department_id'] ?>" <?= $row['department_id'] == $d['department_id'] ? 'selected' : '' ?>><?= htmlspecialchars($d['name']) ?></option>
                            <?php endwhile; $conn2->close(); ?>
                        </select>
                    </td>
                    <td>
                        <select id="manager_<?= $row['department_id'] ?>">
                            <option value="">None</option>
                            <?php
                            $conn3 = new mysqli($host, $user, $password, $dbname);
                            $emps = $conn3->query("SELECT employee_id, first_name, last_name FROM employees WHERE status = 'active'");
                            while ($e = $emps->fetch_assoc()):
                                $selected = ($e['employee_id'] == $row['manager_id']) ? 'selected' : '';
                            ?>
                            <option value="<?= $e['employee_id'] ?>" <?= $selected ?>><?= htmlspecialchars($e['first_name'] . ' ' . $e['last_name']) ?></option>
                            <?php endwhile; $conn3->close(); ?>
                        </select>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="updateDepartment(<?= $row['department_id'] ?>)" class="success">💾 Save</button>
                            <button onclick="deleteDepartment(<?= $row['department_id'] ?>)" class="danger">🗑️ Delete</button>
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

    function updateDepartment(departmentId) {
        const name = document.getElementById(`name_${departmentId}`).value;
        const code = document.getElementById(`code_${departmentId}`).value || null;
        const parentId = document.getElementById(`parent_${departmentId}`).value || null;
        const managerId = document.getElementById(`manager_${departmentId}`).value || null;

        if (!name) {
            showNotification('Department name is required', false);
            return;
        }

        fetch('update_department.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `department_id=${departmentId}&name=${encodeURIComponent(name)}&code=${encodeURIComponent(code)}&parent_id=${parentId}&manager_id=${managerId}`
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(data => {
            showNotification(data, true);
        })
        .catch(error => {
            showNotification(`Error updating department: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function addDepartment() {
        const name = document.getElementById('new_name').value;
        const code = document.getElementById('new_code').value || null;
        const parentId = document.getElementById('new_parent_id').value || null;
        const managerId = document.getElementById('new_manager_id').value || null;
        const costCenter = document.getElementById('new_cost_center').value || null;
        const desc = document.getElementById('new_description').value;

        if (!name) {
            showNotification('Department name is required', false);
            return;
        }

        fetch('add_department.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `name=${encodeURIComponent(name)}&code=${encodeURIComponent(code)}&parent_id=${parentId}&manager_id=${managerId}&cost_center=${encodeURIComponent(costCenter)}&description=${encodeURIComponent(desc)}`
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
            showNotification(`Error adding department: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function deleteDepartment(departmentId) {
        if (!confirm("Are you sure you want to delete this department? This action cannot be undone.")) return;

        fetch('delete_department.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `department_id=${departmentId}`
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(data => {
            showNotification(data, true);
            document.getElementById(`row_${departmentId}`).remove();
        })
        .catch(error => {
            showNotification(`Error deleting department: ${error}`, false);
            console.error('Error:', error);
        });
    }
</script>
</body>
</html>