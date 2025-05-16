<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Adjustment Management</title>
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
    <h1>Attendance Adjustment Log</h1>

    <div class="card">
        <h2>Add New Adjustment</h2>
        <div class="form-row">
            <div class="form-group">
                <label for="new_record_id">Attendance Record</label>
                <select id="new_record_id" required>
                    <option value="">Select Record</option>
                    <?php
                    $result = $conn->query("SELECT record_id FROM attendance_records");
                    while ($row = $result->fetch_assoc()):
                        echo "<option value='{$row['record_id']}'>Record #{$row['record_id']}</option>";
                    endwhile;
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="new_adjusted_by">Adjusted By</label>
                <select id="new_adjusted_by" required>
                    <option value="">Select User</option>
                    <?php
                    $result = $conn->query("SELECT user_id, username FROM users");
                    while ($row = $result->fetch_assoc()):
                        echo "<option value='{$row['user_id']}'>{$row['username']}</option>";
                    endwhile;
                    ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_adjustment_type">Adjustment Type</label>
                <select id="new_adjustment_type" required>
                    <option value="">Select Type</option>
                    <option value="clock_in">Clock In</option>
                    <option value="clock_out">Clock Out</option>
                    <option value="status">Status</option>
                    <option value="notes">Notes</option>
                </select>
            </div>
            <div class="form-group">
                <label for="new_reason">Reason for Adjustment</label>
                <input type="text" id="new_reason" placeholder="Why was this changed?" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_old_value">Old Value</label>
                <textarea id="new_old_value" rows="2" placeholder="Previous value"></textarea>
            </div>
            <div class="form-group">
                <label for="new_new_value">New Value</label>
                <textarea id="new_new_value" rows="2" placeholder="Updated value"></textarea>
            </div>
        </div>
        <button onclick="addAttendanceAdjustment()" class="success">➕ Add Adjustment</button>
    </div>

    <div class="card">
        <h2>Existing Adjustments</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Record ID</th>
                    <th>Type</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Reason</th>
                    <th>Adjusted By</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT a.adjustment_id, a.record_id, a.adjustment_type,
                               a.old_value, a.new_value, a.reason, u.username,
                               DATE_FORMAT(a.adjusted_at, '%M %d, %Y %H:%i') AS adjusted_at
                        FROM attendance_adjustments a
                        JOIN users u ON a.adjusted_by = u.user_id
                        ORDER BY a.adjusted_at DESC";

                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['adjustment_id'] ?>">
                    <td><?= $row['adjustment_id'] ?></td>
                    <td><?= htmlspecialchars($row['record_id']) ?></td>
                    <td><?= htmlspecialchars($row['adjustment_type']) ?></td>
                    <td><?= htmlspecialchars($row['old_value']) ?></td>
                    <td><?= htmlspecialchars($row['new_value']) ?></td>
                    <td><?= htmlspecialchars($row['reason']) ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['adjusted_at']) ?></td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="deleteAttendanceAdjustment(<?= $row['adjustment_id'] ?>)" class="danger">🗑️ Delete</button>
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

    function addAttendanceAdjustment() {
        const recordId = document.getElementById('new_record_id').value;
        const adjustedBy = document.getElementById('new_adjusted_by').value;
        const adjustmentType = document.getElementById('new_adjustment_type').value;
        const oldValue = document.getElementById('new_old_value').value;
        const newValue = document.getElementById('new_new_value').value;
        const reason = document.getElementById('new_reason').value;

        if (!recordId || !adjustedBy || !adjustmentType || !reason) {
            showNotification("❌ Required fields are missing", false);
            return;
        }

        fetch('add_attendance_adjustment.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `record_id=${recordId}&adjusted_by=${adjustedBy}&adjustment_type=${adjustmentType}&old_value=${encodeURIComponent(oldValue)}&new_value=${encodeURIComponent(newValue)}&reason=${encodeURIComponent(reason)}`
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

    function deleteAttendanceAdjustment(id) {
        if (!confirm("Are you sure you want to delete this adjustment? This action cannot be undone.")) return;

        fetch('delete_attendance_adjustment.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `adjustment_id=${id}`
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