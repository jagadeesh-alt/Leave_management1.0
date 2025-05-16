<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leave Type Management</title>
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
    <h1>Leave Type Management System</h1>

    <div class="card">
        <h2>Add New Leave Type</h2>
        <div class="form-row">
            <div class="form-group">
                <label for="new_name">Name</label>
                <input type="text" id="new_name" placeholder="Leave Type Name" required>
            </div>
            <div class="form-group">
                <label for="new_code">Code</label>
                <input type="text" id="new_code" placeholder="Short Code (e.g., VL)">
            </div>
        </div>
        <div class="form-group">
            <label for="new_description">Description</label>
            <textarea id="new_description" rows="3" placeholder="Leave Type Description"></textarea>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_category">Category</label>
                <select id="new_category">
                    <option value="">Select Category</option>
                    <option value="vacation">Vacation</option>
                    <option value="sick">Sick</option>
                    <option value="personal">Personal</option>
                    <option value="maternity">Maternity</option>
                    <option value="paternity">Paternity</option>
                    <option value="bereavement">Bereavement</option>
                    <option value="jury_duty">Jury Duty</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="new_is_paid" checked>
                <label for="new_is_paid">Paid Leave</label>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="new_requires_approval" checked>
                <label for="new_requires_approval">Requires Approval</label>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_min_notice_days">Minimum Notice (Days)</label>
                <input type="number" id="new_min_notice_days" value="1" min="0">
            </div>
            <div class="form-group">
                <label for="new_max_consecutive_days">Max Consecutive Days</label>
                <input type="number" id="new_max_consecutive_days" min="0">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_max_days_per_request">Max Days per Request</label>
                <input type="number" id="new_max_days_per_request" min="0">
            </div>
            <div class="form-group">
                <label for="new_max_days_per_year">Max Days per Year</label>
                <input type="number" id="new_max_days_per_year" min="0">
            </div>
        </div>
        <div class="form-row">
            <div class="checkbox-group">
                <input type="checkbox" id="new_allow_half_day">
                <label for="new_allow_half_day">Allow Half Day</label>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="new_carry_forward">
                <label for="new_carry_forward">Carry Forward</label>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_carry_forward_limit">Carry Forward Limit</label>
                <input type="number" id="new_carry_forward_limit" min="0">
            </div>
            <div class="form-group">
                <label for="new_carry_forward_expiry_months">Expiry After Months</label>
                <input type="number" id="new_carry_forward_expiry_months" min="0">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_gender_specific">Gender Restriction</label>
                <select id="new_gender_specific">
                    <option value="none">None</option>
                    <option value="male">Male Only</option>
                    <option value="female">Female Only</option>
                </select>
            </div>
            <div class="form-group">
                <label for="new_tenure_restriction_days">Tenure Restriction (Days)</label>
                <input type="number" id="new_tenure_restriction_days" value="0" min="0">
            </div>
        </div>
        <div class="checkbox-group">
            <input type="checkbox" id="new_is_active" checked>
            <label for="new_is_active">Active</label>
        </div>
        <button onclick="addLeaveType()" class="success">➕ Add Leave Type</button>
    </div>

    <div class="card">
        <h2>Existing Leave Types</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Category</th>
                    <th>Paid</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT type_id, name, code, category, is_paid, is_active FROM leave_types ORDER BY type_id DESC");
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['type_id'] ?>">
                    <td><?= $row['type_id'] ?></td>
                    <td><input type="text" id="name_<?= $row['type_id'] ?>" value="<?= htmlspecialchars($row['name']) ?>"></td>
                    <td><input type="text" id="code_<?= $row['type_id'] ?>" value="<?= htmlspecialchars($row['code']) ?>"></td>
                    <td>
                        <select id="category_<?= $row['type_id'] ?>">
                            <option value="vacation" <?= $row['category'] === 'vacation' ? 'selected' : '' ?>>Vacation</option>
                            <option value="sick" <?= $row['category'] === 'sick' ? 'selected' : '' ?>>Sick</option>
                            <option value="personal" <?= $row['category'] === 'personal' ? 'selected' : '' ?>>Personal</option>
                            <option value="maternity" <?= $row['category'] === 'maternity' ? 'selected' : '' ?>>Maternity</option>
                            <option value="paternity" <?= $row['category'] === 'paternity' ? 'selected' : '' ?>>Paternity</option>
                            <option value="bereavement" <?= $row['category'] === 'bereavement' ? 'selected' : '' ?>>Bereavement</option>
                            <option value="jury_duty" <?= $row['category'] === 'jury_duty' ? 'selected' : '' ?>>Jury Duty</option>
                            <option value="other" <?= $row['category'] === 'other' ? 'selected' : '' ?>>Other</option>
                        </select>
                    </td>
                    <td style="text-align: center;">
                        <input type="checkbox" id="is_paid_<?= $row['type_id'] ?>" <?= $row['is_paid'] ? 'checked' : '' ?>>
                    </td>
                    <td style="text-align: center;">
                        <input type="checkbox" id="is_active_<?= $row['type_id'] ?>" <?= $row['is_active'] ? 'checked' : '' ?>>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="updateLeaveType(<?= $row['type_id'] ?>)" class="success">💾 Save</button>
                            <button onclick="deleteLeaveType(<?= $row['type_id'] ?>)" class="danger">🗑️ Delete</button>
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

    function updateLeaveType(typeId) {
        const name = document.getElementById(`name_${typeId}`).value;
        const code = document.getElementById(`code_${typeId}`).value;
        const category = document.getElementById(`category_${typeId}`).value;
        const isPaid = document.getElementById(`is_paid_${typeId}`).checked ? 1 : 0;
        const isActive = document.getElementById(`is_active_${typeId}`).checked ? 1 : 0;

        if (!name || !code) {
            showNotification('Name and code are required', false);
            return;
        }

        fetch('update_leave_type.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `type_id=${typeId}&name=${encodeURIComponent(name)}&code=${encodeURIComponent(code)}&category=${category}&is_paid=${isPaid}&is_active=${isActive}`
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(data => {
            showNotification(data, true);
        })
        .catch(error => {
            showNotification(`Error updating leave type: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function addLeaveType() {
        const name = document.getElementById('new_name').value;
        const code = document.getElementById('new_code').value;
        const desc = document.getElementById('new_description').value;
        const category = document.getElementById('new_category').value;
        const isPaid = document.getElementById('new_is_paid').checked ? 1 : 0;
        const requiresApproval = document.getElementById('new_requires_approval').checked ? 1 : 0;
        const minNotice = parseInt(document.getElementById('new_min_notice_days').value) || 0;
        const maxConsec = parseInt(document.getElementById('new_max_consecutive_days').value) || null;
        const maxPerRequest = parseInt(document.getElementById('new_max_days_per_request').value) || null;
        const maxPerYear = parseInt(document.getElementById('new_max_days_per_year').value) || null;
        const allowHalfDay = document.getElementById('new_allow_half_day').checked ? 1 : 0;
        const carryForward = document.getElementById('new_carry_forward').checked ? 1 : 0;
        const carryLimit = parseInt(document.getElementById('new_carry_forward_limit').value) || null;
        const carryExpiry = parseInt(document.getElementById('new_carry_forward_expiry_months').value) || null;
        const genderRestrict = document.getElementById('new_gender_specific').value;
        const tenureRestrict = parseInt(document.getElementById('new_tenure_restriction_days').value) || 0;
        const isActive = document.getElementById('new_is_active').checked ? 1 : 0;

        if (!name || !code) {
            showNotification('Name and code are required', false);
            return;
        }

        const formData = new URLSearchParams({
            name, code, description: desc, category, is_paid: isPaid,
            requires_approval: requiresApproval, min_notice_days: minNotice,
            max_consecutive_days: maxConsec, max_days_per_request: maxPerRequest,
            max_days_per_year: maxPerYear, allow_half_day: allowHalfDay,
            carry_forward: carryForward, carry_forward_limit: carryLimit,
            carry_forward_expiry_months: carryExpiry, gender_specific: genderRestrict,
            tenure_restriction_days: tenureRestrict, is_active: isActive
        });

        fetch('add_leave_type.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: formData.toString()
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
            showNotification(`Error adding leave type: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function deleteLeaveType(typeId) {
        if (!confirm("Are you sure you want to delete this leave type? This action cannot be undone.")) return;

        fetch('delete_leave_type.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `type_id=${typeId}`
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(data => {
            showNotification(data, true);
            document.getElementById(`row_${typeId}`).remove();
        })
        .catch(error => {
            showNotification(`Error deleting leave type: ${error}`, false);
            console.error('Error:', error);
        });
    }
</script>
</body>
</html>