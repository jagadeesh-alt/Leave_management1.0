<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notification Management</title>
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
    <h1>System Notification Log</h1>

    <div class="card">
        <h2>Add New Notification</h2>
        <div class="form-row">
            <div class="form-group">
                <label for="new_recipient_id">Recipient</label>
                <select id="new_recipient_id" required>
                    <option value="">Select Recipient</option>
                    <?php
                    $result = $conn->query("SELECT user_id, username FROM users");
                    while ($row = $result->fetch_assoc()):
                        echo "<option value='{$row['user_id']}'>{$row['username']}</option>";
                    endwhile;
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="new_sender_id">Sender (Optional)</label>
                <select id="new_sender_id">
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
        <div class="form-row">
            <div class="form-group">
                <label for="new_type">Type</label>
                <select id="new_type" required>
                    <option value="">Select Type</option>
                    <option value="leave">Leave</option>
                    <option value="approval">Approval</option>
                    <option value="attendance">Attendance</option>
                    <option value="payroll">Payroll</option>
                    <option value="system">System</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="new_title">Title</label>
                <input type="text" id="new_title" placeholder="Enter notification title" required>
            </div>
        </div>
        <div class="form-group">
            <label for="new_message">Message</label>
            <textarea id="new_message" rows="4" placeholder="Enter full message here..." required></textarea>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_related_id">Related ID (Optional)</label>
                <input type="number" id="new_related_id" min="0">
            </div>
            <div class="form-group">
                <label for="new_related_type">Related Type (Optional)</label>
                <input type="text" id="new_related_type" placeholder="e.g., leave_applications">
            </div>
        </div>
        <button onclick="sendNotification()" class="success">🔔 Send Notification</button>
    </div>

    <div class="card">
        <h2>Existing Notifications</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Recipient</th>
                    <th>Type</th>
                    <th>Title</th>
                    <th>Read</th>
                    <th>Sent At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT n.notification_id, n.recipient_id, n.sender_id,
                               CONCAT(u.username) AS recipient,
                               IFNULL(CONCAT(s.username), 'System') AS sender,
                               n.title, n.message, n.type, n.is_read, n.read_at, n.created_at
                        FROM notifications n
                        JOIN users u ON n.recipient_id = u.user_id
                        LEFT JOIN users s ON n.sender_id = s.user_id
                        ORDER BY n.created_at DESC";

                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['notification_id'] ?>">
                    <td><?= $row['notification_id'] ?></td>
                    <td><?= htmlspecialchars($row['recipient']) ?></td>
                    <td><?= htmlspecialchars($row['type']) ?></td>
                    <td><input type="text" id="title_<?= $row['notification_id'] ?>" value="<?= htmlspecialchars($row['title']) ?>"></td>
                    <td style="text-align: center;">
                        <input type="checkbox" id="read_<?= $row['notification_id'] ?>" <?= $row['is_read'] ? 'checked' : '' ?>>
                    </td>
                    <td><?= htmlspecialchars(date('M d, Y H:i', strtotime($row['created_at']))) ?></td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="updateNotification(<?= $row['notification_id'] ?>)" class="success">💾 Save</button>
                            <button onclick="deleteNotification(<?= $row['notification_id'] ?>)" class="danger">🗑️ Delete</button>
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

    function updateNotification(id) {
        const title = document.getElementById(`title_${id}`).value;
        const isRead = document.getElementById(`read_${id}`).checked ? 1 : 0;

        if (!title) {
            showNotification("❌ Title is required", false);
            return;
        }

        fetch('update_notification.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `notification_id=${id}&title=${encodeURIComponent(title)}&is_read=${isRead}`
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

    function sendNotification() {
        const recipientId = document.getElementById('new_recipient_id').value;
        const senderId = document.getElementById('new_sender_id').value || null;
        const type = document.getElementById('new_type').value;
        const title = document.getElementById('new_title').value;
        const message = document.getElementById('new_message').value;
        const relatedId = document.getElementById('new_related_id').value || null;
        const relatedType = document.getElementById('new_related_type').value;

        if (!recipientId || !type || !title || !message) {
            showNotification("❌ Required fields are missing", false);
            return;
        }

        fetch('add_notification.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `recipient_id=${recipientId}&sender_id=${senderId}&type=${type}&title=${encodeURIComponent(title)}&message=${encodeURIComponent(message)}&related_id=${relatedId}&related_type=${encodeURIComponent(relatedType)}`
        })
        .then(response => response.text())
        .then(data => {
            showNotification(data, true);
            setTimeout(() => location.reload(), 1500);
        })
        .catch(error => {
            showNotification(`❌ Failed to send: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function deleteNotification(id) {
        if (!confirm("Are you sure you want to delete this notification? This action cannot be undone.")) return;

        fetch('delete_notification.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `notification_id=${id}`
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