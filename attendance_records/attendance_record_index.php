<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Record Management</title>
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

        input[type="text"], input[type="date"], input[type="datetime-local"], select {
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
    <h1>Attendance Record Management System</h1>

    <div class="card">
        <h2>Add New Attendance Record</h2>
        <div class="form-row">
            <div class="form-group">
                <label for="new_employee_id">Employee</label>
                <select id="new_employee_id" required>
                    <option value="">Select Employee</option>
                    <?php
                    $result = $conn->query("SELECT employee_id, first_name, last_name FROM employees");
                    while ($row = $result->fetch_assoc()):
                        echo "<option value='{$row['employee_id']}'>{$row['first_name']} {$row['last_name']}</option>";
                    endwhile;
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="new_date">Date</label>
                <input type="date" id="new_date" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_clock_in">Clock In</label>
                <input type="datetime-local" id="new_clock_in">
            </div>
            <div class="form-group">
                <label for="new_clock_out">Clock Out</label>
                <input type="datetime-local" id="new_clock_out">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_status">Status</label>
                <select id="new_status" required>
                    <option value="">Select Status</option>
                    <option value="present">Present</option>
                    <option value="absent">Absent</option>
                    <option value="late">Late</option>
                    <option value="half_day">Half Day</option>
                    <option value="holiday">Holiday</option>
                    <option value="weekend">Weekend</option>
                    <option value="on_leave">On Leave</option>
                </select>
            </div>
            <div class="form-group">
                <label for="new_leave_application_id">Leave Application (Optional)</label>
                <select id="new_leave_application_id">
                    <option value="">None</option>
                    <?php
                    $result = $conn->query("SELECT application_id FROM leave_applications");
                    while ($row = $result->fetch_assoc()):
                        echo "<option value='{$row['application_id']}'>App #{$row['application_id']}</option>";
                    endwhile;
                    ?>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_holiday_id">Holiday ID (Optional)</label>
                <input type="number" id="new_holiday_id" min="0">
            </div>
            <div class="form-group">
                <label for="new_verified_by">Verified By (Optional)</label>
                <select id="new_verified_by">
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
        <div class="form-group">
            <label for="new_notes">Notes</label>
            <textarea id="new_notes" rows="3" placeholder="Optional notes"></textarea>
        </div>
        <button onclick="addAttendanceRecord()" class="success">➕ Add Record</button>
    </div>

    <div class="card">
        <h2>Existing Records</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Employee</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Clock In</th>
                    <th>Clock Out</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT r.record_id, r.employee_id, r.date, r.clock_in, r.clock_out,
                               r.status, u.username AS verified_by
                        FROM attendance_records r
                        LEFT JOIN users u ON r.verified_by = u.user_id
                        ORDER BY r.record_id DESC";

                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['record_id'] ?>">
                    <td><?= $row['record_id'] ?></td>
                    <td><?= htmlspecialchars($row['employee_id']) ?></td>
                    <td><input type="date" id="date_<?= $row['record_id'] ?>" value="<?= $row['date'] ?>"></td>
                    <td>
                        <select id="status_<?= $row['record_id'] ?>">
                            <option value="present" <?= $row['status'] === 'present' ? 'selected' : '' ?>>Present</option>
                            <option value="absent" <?= $row['status'] === 'absent' ? 'selected' : '' ?>>Absent</option>
                            <option value="late" <?= $row['status'] === 'late' ? 'selected' : '' ?>>Late</option>
                            <option value="half_day" <?= $row['status'] === 'half_day' ? 'selected' : '' ?>>Half Day</option>
                            <option value="holiday" <?= $row['status'] === 'holiday' ? 'selected' : '' ?>>Holiday</option>
                            <option value="weekend" <?= $row['status'] === 'weekend' ? 'selected' : '' ?>>Weekend</option>
                            <option value="on_leave" <?= $row['status'] === 'on_leave' ? 'selected' : '' ?>>On Leave</option>
                        </select>
                    </td>
                    <td><input type="datetime-local" id="clock_in_<?= $row['record_id'] ?>" value="<?= substr($row['clock_in'], 0, 16) ?? '' ?>"></td>
                    <td><input type="datetime-local" id="clock_out_<?= $row['record_id'] ?>" value="<?= substr($row['clock_out'], 0, 16) ?? '' ?>"></td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="updateAttendanceRecord(<?= $row['record_id'] ?>)" class="success">💾 Save</button>
                            <button onclick="deleteAttendanceRecord(<?= $row['record_id'] ?>)" class="danger">🗑️ Delete</button>
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

    function updateAttendanceRecord(recordId) {
        const date = document.getElementById(`date_${recordId}`).value;
        const status = document.getElementById(`status_${recordId}`).value;
        const clockIn = document.getElementById(`clock_in_${recordId}`).value || null;
        const clockOut = document.getElementById(`clock_out_${recordId}`).value || null;

        if (!date || !status) {
            showNotification('❌ Date and status are required', false);
            return;
        }

        fetch('update_attendance_record.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `record_id=${recordId}&date=${date}&status=${status}&clock_in=${clockIn}&clock_out=${clockOut}`
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

    function addAttendanceRecord() {
        const employeeId = document.getElementById('new_employee_id').value;
        const date = document.getElementById('new_date').value;
        const clockIn = document.getElementById('new_clock_in').value || null;
        const clockOut = document.getElementById('new_clock_out').value || null;
        const status = document.getElementById('new_status').value;
        const leaveAppId = document.getElementById('new_leave_application_id').value || null;
        const holidayId = document.getElementById('new_holiday_id').value || null;
        const verifiedBy = document.getElementById('new_verified_by').value || null;
        const notes = document.getElementById('new_notes').value;

        if (!employeeId || !date || !status) {
            showNotification("❌ Required fields are missing", false);
            return;
        }

        fetch('add_attendance_record.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `employee_id=${employeeId}&date=${date}&clock_in=${clockIn}&clock_out=${clockOut}&status=${status}&leave_application_id=${leaveAppId}&holiday_id=${holidayId}&notes=${encodeURIComponent(notes)}&verified_by=${verifiedBy}`
        })
        .then(response => response.text())
        .then(data => {
            showNotification(data, true);
            setTimeout(() => location.reload(), 1500);
        })
        .catch(error => {
            showNotification(`❌ Failed to add record: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function deleteAttendanceRecord(recordId) {
        if (!confirm("Are you sure you want to delete this attendance record? This action cannot be undone.")) return;

        fetch('delete_attendance_record.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `record_id=${recordId}`
        })
        .then(response => response.text())
        .then(data => {
            showNotification(data, true);
            document.getElementById(`row_${recordId}`).remove();
        })
        .catch(error => {
            showNotification(`❌ Failed to delete: ${error}`, false);
            console.error('Error:', error);
        });
    }
</script>
</body>
</html>