<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Position Management System</title>
    <style>
        /* Same styles as index.php from your file */
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

        input[type="text"]:focus, textarea:focus, select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
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
    <h1>Position Management System</h1>

    <div class="card">
        <h2>Add New Position</h2>
        <div class="form-group">
            <label for="new_title">Title</label>
            <input type="text" id="new_title" placeholder="Job Title" required>
        </div>
        <div class="form-group">
            <label for="new_description">Job Description</label>
            <textarea id="new_description" rows="3" placeholder="Job Description"></textarea>
        </div>
        <div class="form-group">
            <label for="new_department_id">Department</label>
            <select id="new_department_id">
                <option value="">Select Department</option>
                 <option value="intermediate">Intermediate</option>
                    <option value="senior">Senior</option>
                    <option value="manager">Manager</option>
                    <option value="director">Director</option>
                    <option value="executive">Executive</option>
                <?php
                $result = $conn->query("SELECT department_id, name FROM departments");
                while ($row = $result->fetch_assoc()):
                ?>
                <option value="<?= $row['department_id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_career_level">Career Level</label>

                <select id="new_career_level">
                    <option value="">Select Career Level</option>
                    <option value="entry">Entry</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="senior">Senior</option>
                    <option value="manager">Manager</option>
                    <option value="director">Director</option>
                    <option value="executive">Executive</option>
                </select>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="new_is_management">
                <label for="new_is_management">Management Role</label>
            </div>
        </div>
        <button onclick="addPosition()" class="success">➕ Add Position</button>
    </div>

    <div class="card">
        <h2>Existing Positions</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Department</th>
                    <th>Career Level</th>
                    <th>Management</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p.position_id, p.title, p.job_description, p.department_id, p.career_level, p.is_management, d.name AS department_name 
                        FROM positions p LEFT JOIN departments d ON p.department_id = d.department_id ORDER BY p.position_id DESC";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['position_id'] ?>">
                    <td><?= $row['position_id'] ?></td>
                    <td><input type="text" id="title_<?= $row['position_id'] ?>" value="<?= htmlspecialchars($row['title']) ?>" required></td>
                    <td><textarea id="desc_<?= $row['position_id'] ?>" rows="2"><?= htmlspecialchars($row['job_description']) ?></textarea></td>
                    <td>
                        <select id="dept_<?= $row['position_id'] ?>">
                            <option value="">None</option>
                            <?php
                            $conn2 = new mysqli($host, $user, $password, $dbname);
                            $depts = $conn2->query("SELECT department_id, name FROM departments");
                            while ($d = $depts->fetch_assoc()):
                                $selected = ($d['department_id'] == $row['department_id']) ? 'selected' : '';
                            ?>
                            <option value="<?= $d['department_id'] ?>" <?= $selected ?>><?= htmlspecialchars($d['name']) ?></option>
                            <?php endwhile; $conn2->close(); ?>
                        </select>
                    </td>
                    <td>
                        <select id="level_<?= $row['position_id'] ?>">
                            <option value="entry" <?= $row['career_level'] === 'entry' ? 'selected' : '' ?>>Entry</option>
                            <option value="intermediate" <?= $row['career_level'] === 'intermediate' ? 'selected' : '' ?>>Intermediate</option>
                            <option value="senior" <?= $row['career_level'] === 'senior' ? 'selected' : '' ?>>Senior</option>
                            <option value="manager" <?= $row['career_level'] === 'manager' ? 'selected' : '' ?>>Manager</option>
                            <option value="director" <?= $row['career_level'] === 'director' ? 'selected' : '' ?>>Director</option>
                            <option value="executive" <?= $row['career_level'] === 'executive' ? 'selected' : '' ?>>Executive</option>
                        </select>
                    </td>
                    <td style="text-align: center;">
                        <input type="checkbox" id="man_<?= $row['position_id'] ?>" <?= $row['is_management'] ? 'checked' : '' ?>>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="updatePosition(<?= $row['position_id'] ?>)" class="success">💾 Save</button>
                            <button onclick="deletePosition(<?= $row['position_id'] ?>)" class="danger">🗑️ Delete</button>
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

    function updatePosition(positionId) {
        const title = document.getElementById(`title_${positionId}`).value;
        const desc = document.getElementById(`desc_${positionId}`).value;
        const dept = document.getElementById(`dept_${positionId}`).value || null;
        const level = document.getElementById(`level_${positionId}`).value;
        const isMan = document.getElementById(`man_${positionId}`).checked ? 1 : 0;

        if (!title) {
            showNotification('Position title is required', false);
            return;
        }

        fetch('update_position.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `position_id=${positionId}&title=${encodeURIComponent(title)}&description=${encodeURIComponent(desc)}&department_id=${dept}&career_level=${level}&is_management=${isMan}`
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(data => {
            showNotification(data, true);
        })
        .catch(error => {
            showNotification(`Error updating position: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function addPosition() {
        const title = document.getElementById('new_title').value;
        const desc = document.getElementById('new_description').value;
        const dept = document.getElementById('new_department_id').value || null;
        const level = document.getElementById('new_career_level').value;
        const isMan = document.getElementById('new_is_management').checked ? 1 : 0;

        if (!title) {
            showNotification('Position title is required', false);
            return;
        }

        fetch('add_position.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `title=${encodeURIComponent(title)}&description=${encodeURIComponent(desc)}&department_id=${dept}&career_level=${level}&is_management=${isMan}`
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
            showNotification(`Error adding position: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function deletePosition(positionId) {
        if (!confirm("Are you sure you want to delete this position? This action cannot be undone.")) return;

        fetch('delete_position.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `position_id=${positionId}`
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(data => {
            showNotification(data, true);
            document.getElementById(`row_${positionId}`).remove();
        })
        .catch(error => {
            showNotification(`Error deleting position: ${error}`, false);
            console.error('Error:', error);
        });
    }
</script>
</body>
</html>