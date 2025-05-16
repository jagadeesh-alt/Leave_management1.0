<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Work Schedule Management</title>
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

        input[type="text"], input[type="time"], textarea, select {
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
    <h1>Work Schedule Management System</h1>

    <div class="card">
        <h2>Add New Work Schedule</h2>
        <div class="form-group">
            <label for="new_name">Schedule Name</label>
            <input type="text" id="new_name" placeholder="e.g., Standard 8-Hour Day" required>
        </div>
        <div class="form-group">
            <label for="new_description">Description</label>
            <textarea id="new_description" rows="3" placeholder="Optional description"></textarea>
        </div>
        <div class="checkbox-group">
            <input type="checkbox" id="new_is_default">
            <label for="new_is_default">Set as Default</label>
        </div>

        <div class="card" style="margin-top: 20px; border: 1px solid #ddd;">
            <h2 style="font-size: 1rem;">Working Hours Per Day</h2>
            <?php $days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun']; ?>
            <?php foreach ($days as $day): ?>
                <div class="form-row">
                    <div class="form-group">
                        <label><?= ucfirst($day) ?> Start</label>
                        <input type="time" id="new_<?= $day ?>_start">
                    </div>
                    <div class="form-group">
                        <label><?= ucfirst($day) ?> End</label>
                        <input type="time" id="new_<?= $day ?>_end">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <button onclick="addWorkSchedule()" class="success">➕ Add Schedule</button>
    </div>

    <div class="card">
        <h2>Existing Schedules</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Daily Avg Hrs</th>
                    <th>Default</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT schedule_id, name, is_default FROM work_schedules ORDER BY schedule_id DESC");
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['schedule_id'] ?>">
                    <td><?= $row['schedule_id'] ?></td>
                    <td><input type="text" id="name_<?= $row['schedule_id'] ?>" value="<?= htmlspecialchars($row['name']) ?>"></td>
                    <td><?= getDailyAvgHours($conn, $row['schedule_id']) ?></td>
                    <td style="text-align: center;">
                        <input type="checkbox" id="default_<?= $row['schedule_id'] ?>" <?= $row['is_default'] ? 'checked' : '' ?>>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="updateWorkSchedule(<?= $row['schedule_id'] ?>)" class="success">💾 Save</button>
                            <button onclick="deleteWorkSchedule(<?= $row['schedule_id'] ?>)" class="danger">🗑️ Delete</button>
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

    function updateWorkSchedule(scheduleId) {
        const name = document.getElementById(`name_${scheduleId}`).value;
        const isDefault = document.getElementById(`default_${scheduleId}`).checked ? 1 : 0;

        // Build data
        let formData = `schedule_id=${scheduleId}&name=${encodeURIComponent(name)}&is_default=${isDefault}`;

        // Fetch time inputs dynamically
        const days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
        for (const day of days) {
            const start = document.getElementById(`${day}_start_${scheduleId}`)?.value || null;
            const end = document.getElementById(`${day}_end_${scheduleId}`)?.value || null;
            formData += `&${day}_start=${encodeURIComponent(start)}&${day}_end=${encodeURIComponent(end)}`;
        }

        fetch('update_work_schedule.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: formData
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
            console.error('Error:', error);
        });
    }

    function addWorkSchedule() {
        const name = document.getElementById('new_name').value;
        const desc = document.getElementById('new_description').value;
        const isDefault = document.getElementById('new_is_default').checked ? 1 : 0;

        // Build form data
        let formData = `name=${encodeURIComponent(name)}&description=${encodeURIComponent(desc)}&is_default=${isDefault}`;

        const days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
        for (const day of days) {
            const start = document.getElementById(`new_${day}_start`).value || null;
            const end = document.getElementById(`new_${day}_end`).value || null;
            formData += `&${day}_start=${encodeURIComponent(start)}&${day}_end=${encodeURIComponent(end)}`;
        }

        fetch('add_work_schedule.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: formData
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
            console.error('Error:', error);
        });
    }

    function deleteWorkSchedule(scheduleId) {
        if (!confirm("Are you sure you want to delete this schedule? This action cannot be undone.")) return;

        fetch('delete_work_schedule.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `schedule_id=${scheduleId}`
        })
        .then(response => response.text())
        .then(data => {
            showNotification(data, true);
            document.getElementById(`row_${scheduleId}`).remove();
        })
        .catch(error => {
            showNotification(`❌ Failed to delete: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function getDailyAvgHours(conn, $id) {
        $stmt = $conn->prepare("
            SELECT 
                SEC_TO_TIME(TIME_TO_SEC(mon_start) + TIME_TO_SEC(tue_start) + TIME_TO_SEC(wed_start) +
                      TIME_TO_SEC(thu_start) + TIME_TO_SEC(fri_start) + TIME_TO_SEC(sat_start) + TIME_TO_SEC(sun_start)) AS total_start,
                SEC_TO_TIME(TIME_TO_SEC(mon_end) + TIME_TO_SEC(tue_end) + TIME_TO_SEC(wed_end) +
                      TIME_TO_SEC(thu_end) + TIME_TO_SEC(fri_end) + TIME_TO_SEC(sat_end) + TIME_TO_SEC(sun_end)) AS total_end
            FROM work_schedules WHERE schedule_id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($totalStart, $totalEnd);
        $stmt->fetch();
        $stmt->close();

        if (!$totalStart || !$totalEnd) return '--';

        $totalSeconds = strtotime($totalEnd) - strtotime($totalStart);
        $dailyAvg = number_format($totalSeconds / 3600 / 7, 2);
        return $dailyAvg;
    }
</script>
</body>
</html>