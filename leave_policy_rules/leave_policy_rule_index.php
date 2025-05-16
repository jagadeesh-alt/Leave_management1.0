<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leave Policy Rule Management</title>
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

        input[type="text"], input[type="number"], select {
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
    <h1>Leave Policy Rule Management System</h1>

    <div class="card">
        <h2>Add New Leave Policy Rule</h2>
        <div class="form-row">
            <div class="form-group">
                <label for="new_policy_id">Policy</label>
                <select id="new_policy_id" required>
                    <option value="">Select Policy</option>
                    <?php
                    $result = $conn->query("SELECT policy_id, name FROM leave_policies");
                    while ($row = $result->fetch_assoc()):
                    ?>
                    <option value="<?= $row['policy_id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="new_type_id">Leave Type</label>
                <select id="new_type_id" required>
                    <option value="">Select Leave Type</option>
                    <?php
                    $result = $conn->query("SELECT type_id, name FROM leave_types");
                    while ($row = $result->fetch_assoc()):
                    ?>
                    <option value="<?= $row['type_id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_accrual_frequency">Accrual Frequency</label>
                <select id="new_accrual_frequency">
                    <option value="none">None</option>
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                    <option value="quarterly">Quarterly</option>
                    <option value="yearly">Yearly</option>
                </select>
            </div>
            <div class="form-group">
                <label for="new_accrual_rate">Accrual Rate</label>
                <input type="number" id="new_accrual_rate" step="0.01" min="0" value="0.00">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_max_balance">Max Balance</label>
                <input type="number" id="new_max_balance" step="0.01" min="0">
            </div>
            <div class="form-group">
                <label for="new_tenure_min_days">Min Tenure Days</label>
                <input type="number" id="new_tenure_min_days" value="0" min="0">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_tenure_max_days">Max Tenure Days</label>
                <input type="number" id="new_tenure_max_days" min="0">
            </div>
            <div class="form-group">
                <label for="new_carry_forward_limit">Carry Forward Limit</label>
                <input type="number" id="new_carry_forward_limit" min="0">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_carry_forward_expiry_months">Expiry After Months</label>
                <input type="number" id="new_carry_forward_expiry_months" min="0">
            </div>
        </div>
        <button onclick="addLeavePolicyRule()" class="success">➕ Add Rule</button>
    </div>

    <div class="card">
        <h2>Existing Rules</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Policy</th>
                    <th>Leave Type</th>
                    <th>Accrual</th>
                    <th>Rate</th>
                    <th>Max Balance</th>
                    <th>Tenure Range</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT r.rule_id, p.name AS policy_name, t.name AS type_name,
                               r.accrual_frequency, r.accrual_rate, r.max_balance,
                               r.tenure_min_days, r.tenure_max_days,
                               r.carry_forward_limit, r.carry_forward_expiry_months
                        FROM leave_policy_rules r
                        JOIN leave_policies p ON r.policy_id = p.policy_id
                        JOIN leave_types t ON r.type_id = t.type_id
                        ORDER BY r.rule_id DESC";

                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['rule_id'] ?>">
                    <td><?= $row['rule_id'] ?></td>
                    <td><?= htmlspecialchars($row['policy_name']) ?></td>
                    <td><?= htmlspecialchars($row['type_name']) ?></td>
                    <td>
                        <select id="accrual_<?= $row['rule_id'] ?>">
                            <option value="none" <?= $row['accrual_frequency'] === 'none' ? 'selected' : '' ?>>None</option>
                            <option value="daily" <?= $row['accrual_frequency'] === 'daily' ? 'selected' : '' ?>>Daily</option>
                            <option value="weekly" <?= $row['accrual_frequency'] === 'weekly' ? 'selected' : '' ?>>Weekly</option>
                            <option value="monthly" <?= $row['accrual_frequency'] === 'monthly' ? 'selected' : '' ?>>Monthly</option>
                            <option value="quarterly" <?= $row['accrual_frequency'] === 'quarterly' ? 'selected' : '' ?>>Quarterly</option>
                            <option value="yearly" <?= $row['accrual_frequency'] === 'yearly' ? 'selected' : '' ?>>Yearly</option>
                        </select>
                    </td>
                    <td><input type="number" id="rate_<?= $row['rule_id'] ?>" step="0.01" value="<?= $row['accrual_rate'] ?>"></td>
                    <td><input type="number" id="balance_<?= $row['rule_id'] ?>" step="0.01" value="<?= $row['max_balance'] ?? '' ?>"></td>
                    <td><?= $row['tenure_min_days'] ?> - <?= $row['tenure_max_days'] ?? '∞' ?></td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="updateLeavePolicyRule(<?= $row['rule_id'] ?>)" class="success">💾 Save</button>
                            <button onclick="deleteLeavePolicyRule(<?= $row['rule_id'] ?>)" class="danger">🗑️ Delete</button>
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

    function updateLeavePolicyRule(ruleId) {
        const accrual = document.getElementById(`accrual_${ruleId}`).value;
        const rate = document.getElementById(`rate_${ruleId}`).value || 0;
        const balance = document.getElementById(`balance_${ruleId}`).value || null;

        fetch('update_leave_policy_rule.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `rule_id=${ruleId}&accrual_frequency=${accrual}&accrual_rate=${rate}&max_balance=${balance}`
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(data => {
            showNotification(data, true);
        })
        .catch(error => {
            showNotification(`Error updating rule: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function addLeavePolicyRule() {
        const policyId = document.getElementById('new_policy_id').value;
        const typeId = document.getElementById('new_type_id').value;
        const accrual = document.getElementById('new_accrual_frequency').value;
        const rate = parseFloat(document.getElementById('new_accrual_rate').value) || 0.00;
        const balance = parseFloat(document.getElementById('new_max_balance').value) || null;
        const tenureMin = parseInt(document.getElementById('new_tenure_min_days').value) || 0;
        const tenureMax = parseInt(document.getElementById('new_tenure_max_days').value) || null;
        const carryLimit = parseInt(document.getElementById('new_carry_forward_limit').value) || null;
        const carryExpiry = parseInt(document.getElementById('new_carry_forward_expiry_months').value) || null;

        if (!policyId || !typeId) {
            showNotification('Policy and Leave Type are required', false);
            return;
        }

        fetch('add_leave_policy_rule.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `policy_id=${policyId}&type_id=${typeId}&accrual_frequency=${accrual}&accrual_rate=${rate}&max_balance=${balance}&tenure_min_days=${tenureMin}&tenure_max_days=${tenureMax}&carry_forward_limit=${carryLimit}&carry_forward_expiry_months=${carryExpiry}`
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
            showNotification(`Error adding rule: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function deleteLeavePolicyRule(ruleId) {
        if (!confirm("Are you sure you want to delete this rule? This action cannot be undone.")) return;

        fetch('delete_leave_policy_rule.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `rule_id=${ruleId}`
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(data => {
            showNotification(data, true);
            document.getElementById(`row_${ruleId}`).remove();
        })
        .catch(error => {
            showNotification(`Error deleting rule: ${error}`, false);
            console.error('Error:', error);
        });
    }
</script>
</body>
</html>