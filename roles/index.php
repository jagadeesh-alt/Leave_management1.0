<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Role Management System</title>
  <style>
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
    
    input[type="text"] {
      width: 100%;
      padding: 10px 15px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 16px;
      transition: border 0.3s;
    }
    
    input[type="text"]:focus {
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
    <h1>Role Management System</h1>
    
    <div class="card">
      <h2>Add New Role</h2>
      <div class="form-group">
        <input type="text" id="new_name" placeholder="Role Name" class="form-control" required>
      </div>
      <div class="form-group">
        <input type="text" id="new_desc" placeholder="Role Description" class="form-control">
      </div>
      <div class="checkbox-group">
        <input type="checkbox" id="new_system">
        <label for="new_system">System Role</label>
      </div>
      <button onclick="addRole()" class="success">➕ Add Role</button>
    </div>
    
    <div class="card">
      <h2>Existing Roles</h2>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>System Role</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = $conn->query("SELECT role_id, name, description, is_system FROM roles ORDER BY role_id DESC");
          while ($row = $result->fetch_assoc()):
          ?>
          <tr id="row_<?= $row['role_id'] ?>">
            <td><?= $row['role_id'] ?></td>
            <td><input type="text" id="name_<?= $row['role_id'] ?>" value="<?= htmlspecialchars($row['name']) ?>" class="form-control" required></td>
            <td><input type="text" id="desc_<?= $row['role_id'] ?>" value="<?= htmlspecialchars($row['description']) ?>" class="form-control"></td>
            <td style="text-align: center;">
              <input type="checkbox" id="sys_<?= $row['role_id'] ?>" <?= $row['is_system'] ? 'checked' : '' ?>>
            </td>
            <td>
              <div class="action-buttons">
                <button onclick="updateRole(<?= $row['role_id'] ?>)" class="success">💾 Save</button>
                <button onclick="deleteRole(<?= $row['role_id'] ?>)" class="danger">🗑️ Delete</button>
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
    // Notification system
    function showNotification(message, isSuccess) {
      const notification = document.getElementById('notification');
      notification.textContent = message;
      notification.className = `notification ${isSuccess ? 'success' : 'error'} show`;
      
      setTimeout(() => {
        notification.classList.remove('show');
      }, 3000);
    }

    // Role management functions
    function updateRole(roleId) {
      const name = document.getElementById(`name_${roleId}`).value;
      const desc = document.getElementById(`desc_${roleId}`).value;
      const isSystem = document.getElementById(`sys_${roleId}`).checked ? 1 : 0;

      if (!name) {
        showNotification('Role name is required', false);
        return;
      }

      fetch('update_role.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `role_id=${roleId}&name=${encodeURIComponent(name)}&description=${encodeURIComponent(desc)}&is_system=${isSystem}`
      })
      .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.text();
      })
      .then(data => {
        showNotification(data, true);
      })
      .catch(error => {
        showNotification(`Error updating role: ${error}`, false);
        console.error('Error:', error);
      });
    }

    function addRole() {
      const name = document.getElementById('new_name').value;
      const desc = document.getElementById('new_desc').value;
      const isSystem = document.getElementById('new_system').checked ? 1 : 0;

      if (!name) {
        showNotification('Role name is required', false);
        return;
      }

      fetch('add_role.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `name=${encodeURIComponent(name)}&description=${encodeURIComponent(desc)}&is_system=${isSystem}`
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
        showNotification(`Error adding role: ${error}`, false);
        console.error('Error:', error);
      });
    }

    function deleteRole(roleId) {
      if (!confirm("Are you sure you want to delete this role? This action cannot be undone.")) return;

      fetch('delete_role.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `role_id=${roleId}`
      })
      .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.text();
      })
      .then(data => {
        showNotification(data, true);
        document.getElementById(`row_${roleId}`).remove();
      })
      .catch(error => {
        showNotification(`Error deleting role: ${error}`, false);
        console.error('Error:', error);
      });
    }
  </script>
</body>
</html>