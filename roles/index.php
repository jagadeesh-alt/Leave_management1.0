<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Role Management System</title>
  
  <style>
   :root {
    /* GitHub Color Palette */
    --primary: #0969da;          /* GitHub's primary blue */
    --primary-light: #f6f8fa;    /* GitHub's light background */
    --sidebar-bg: #f6f8fa;       /* GitHub's sidebar background */
    --card-bg: #ffffff;          /* White background */
    --border: #d0d7de;           /* GitHub's border color */
    --border-muted: #d8dee4;     /* GitHub's muted border */
    --text-dark: #24292f;        /* GitHub's primary text */
    --text-gray: #57606a;        /* GitHub's muted text */
    --text-light: #6e7781;       /* GitHub's light text */
    --success: #1a7f37;          /* GitHub's success green */
    --danger: #cf222e;           /* GitHub's danger red */
    --neutral-muted: rgba(175, 184, 193, 0.2); /* GitHub's muted background */

    /* Button Colors */
    --btn-primary-bg: #2da44e;
    --btn-primary-hover: #2c974b;
    --btn-danger-bg: #d1242f;
    --btn-danger-hover: #b62324;
  }
  
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
  }
  
  body {
    background-color: var(--primary-light);
    color: var(--text-dark);
    line-height: 1.5; /* GitHub's line-height */
    font-size: 14px;  /* GitHub's base font size */
  }
  
  a {
    text-decoration: none;
    color: var(--primary);
  }
  
  a:hover {
    text-decoration: underline;
  }
  
  /* Monospace font for code elements */
  code, pre, input, textarea {
    font-family: ui-monospace, SFMono-Regular, "SF Mono", Menlo, Consolas, "Liberation Mono", monospace;
  }
  
  .dashboard {
    display: flex;
    min-height: 100vh;
  }
  
  /* Sidebar Styles - GitHub inspired */
  .sidebar {
    background-color: var(--sidebar-bg);
    width: 280px;
    padding: 16px;
    border-right: 1px solid var(--border);
  }
  
  .sidebar-header {
    margin-bottom: 16px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--border);
  }
  
  .sidebar-header h1 {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 8px;
  }
  
  .sidebar-header .stat {
    font-size: 14px;
    color: var(--text-gray);
  }
  
  .sidebar-nav {
    list-style: none;
    margin-bottom: 16px;
  }
  
  .sidebar-nav li {
    margin-bottom: 4px;
  }
  
  .sidebar-nav a {
    display: flex;
    align-items: center;
    padding: 8px 8px;
    color: var(--text-dark);
    border-radius: 6px;
    font-size: 14px;
  }
  
  .sidebar-nav a:hover {
    background-color: var(--neutral-muted);
  }
  
  .sidebar-nav a.active {
    background-color: var(--primary);
    color: white;
    font-weight: 600;
  }
  
  /* Main Content Styles */
  .main-content {
    flex: 1;
    padding: 32px;
    overflow-y: auto;
  }
  
  .content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--border);
  }
  
  .content-header h1 {
    font-size: 24px;
    font-weight: 600;
    color: var(--text-dark);
  }
  
  /* Card Styles - GitHub inspired */
  .card {
    background: var(--card-bg);
    border-radius: 6px;
    padding: 16px;
    margin-bottom: 16px;
    border: 1px solid var(--border);
  }
  
  .card h2 {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 16px;
  }
  
  /* Form Styles */
  .form-group {
    margin-bottom: 16px;
  }
  
  label {
    display: block;
    margin-bottom: 6px;
    font-size: 14px;
    font-weight: 600;
    color: var(--text-dark);
  }
  
  input[type="text"] {
    width: 100%;
    padding: 5px 12px;
    border: 1px solid var(--border);
    border-radius: 6px;
    font-size: 14px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
  }
  
  input[type="text"]:focus {
    border-color: var(--primary);
    outline: none;
    box-shadow: 0 0 0 3px rgba(9, 105, 218, 0.3);
  }
  
  /* Button Styles - GitHub inspired */
  button {
    background-color: var(--primary);
    color: white;
    border: 1px solid rgba(27, 31, 36, 0.15);
    padding: 5px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
  }
  
  button:hover {
    background-color: #0969da;
  }
  
  button.danger {
    background-color: var(--btn-danger-bg);
  }
  
  button.danger:hover {
    background-color: var(--btn-danger-hover);
  }
  
  button.success {
    background-color: var(--btn-primary-bg);
  }
  
  button.success:hover {
    background-color: var(--btn-primary-hover);
  }
  
  /* Table Styles - GitHub inspired */
  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 16px;
    font-size: 14px;
    border: 1px solid var(--border);
    border-radius: 6px;
  }
  
  th, td {
    padding: 8px 16px;
    text-align: left;
    border-bottom: 1px solid var(--border-muted);
  }
  
  th {
    font-weight: 600;
    color: var(--text-gray);
    background-color: var(--sidebar-bg);
  }
  
  tr:hover {
    background-color: var(--neutral-muted);
  }

    
    .action-buttons {
      display: flex;
      gap: 8px;
    }
    
    .action-buttons button {
      padding: 6px 10px;
      font-size: 13px;
    }
    
    .loading-spinner {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid #fff;
    border-top: 2px solid transparent;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
    margin-right: 8px;
  }
  
  @keyframes spin {
    to { transform: rotate(360deg); }
  }
    /* Responsive */
    @media (max-width: 1024px) {
      .dashboard {
        flex-direction: column;
      }
      
      .sidebar {
        width: 100%;
        border-right: none;
        border-bottom: 1px solid var(--border);
      }
    }
    
    /* Input focus animation */
    .input-wrapper {
      position: relative;
      margin-bottom: 20px;
    }
    
    .input-wrapper input:focus + .underline::after,
    .input-wrapper textarea:focus + .underline::after {
      transform: scaleX(1);
    }
    
    .underline {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 2px;
      background: var(--primary);
      transform: scaleX(0);
      transition: transform 0.3s ease;
    }
    
    /* Mobile responsive table */
    @media (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }
      
      thead {
        display: none;
      }
      
      tr {
        margin-bottom: 1rem;
        border: 1px solid var(--border);
        padding: 10px;
        border-radius: 8px;
      }
      
      td {
        display: flex;
        justify-content: space-between;
        padding: 6px 10px;
        position: relative;
      }
      
      td::before {
        content: attr(data-label);
        font-weight: bold;
        color: var(--gray);
      }
    }

    /* Enhanced Notification Styles */
   /* Realistic Card-Style Notification */
.notification {
  position: fixed;
   background-color: var(--card-bg);
    color: var(--text-dark);
    border: 1px solid var(--border);
  top: 20px;
  left: 50%;
  transform: translateX(-50%) translateY(0);
  right: auto; /* Remove right alignment */
  min-width: 280px;
  max-width: 400px;
  border-radius: 12px;
  background-color: #fff;
  color: white;
  font-weight: 500;
  z-index: 9999;
  opacity: 0;
  transform: translateX(-50%) translateY(20px); /* Start off-screen vertically */
  transition: all 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
}

.notification.show {
  opacity: 1;
  transform: translateX(-50%) translateY(0); /* Slide into view */
}

.notification-content {
  display: flex;
  align-items: center;
  padding: 16px 20px;
}

.notification-icon {
  width: 32px;
  height: 32px;
  margin-right: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  border-radius: 50%;
  background-color: transparent;
}

.notification-icon svg {
  width: 20px;
  height: 20px;
}

.notification-message {
  flex: 1;
  font-size: 14px;
  line-height: 1.5;
  color: #212529;
}

.notification-close {
  background: transparent;
  border: none;
  color: #6c757d;
  font-size: 18px;
  cursor: pointer;
  margin-left: 12px;
  padding: 0;
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: color 0.2s;
}

.notification-close:hover {
  color: #333;
}

.notification.success .notification-icon {
  background-color: #d4edda;
  color: #155724;
}

.notification.error .notification-icon {
  background-color: #f8d7da;
  color: #721c24;
}

.notification.success .notification-close {
  color: #155724;
}

.notification.error .notification-close {
  color: #721c24;
}

.notification.progress-bar {
  height: 6px;
  width: 100%;
  overflow: hidden;
  background-color: rgba(0, 0, 0, 0.05);
}

.notification.progress-bar span {
  display: block;
  height: 100%;
  width: 100%;
  background-color: currentColor;
  animation: progressAnim 5s linear forwards;
}

@keyframes progressAnim {
  from { width: 100%; }
  to { width: 0; }
}
  </style>
</head>
<body>
  <div class="dashboard">
    <!-- Sidebar Navigation -->
    

    <!-- Main Content -->
    <div class="main-content">
      <div class="content-header">
        <h1>Role Management System</h1>
         <div class="stat"><?php 
          $result = $conn->query("SELECT COUNT(*) as total FROM roles");
          $row = $result->fetch_assoc();
          echo $row['total'] . " Roles |";?>
          <?php 
                $result = $conn->query("SELECT COUNT(*) as total FROM roles WHERE is_system = 1");
                $row = $result->fetch_assoc();
                echo $row['total'] . " System ";
              ?>
        </div>
      </div>
      
      <div class="card">
        <h2>Add New Role</h2>
        <div class="form-group">
          <label for="new_name">Role Name</label>
          <div class="input-wrapper">
            <input type="text" id="new_name" placeholder="Enter role name..." required>
            <div class="underline"></div>
          </div>
        </div>
        
        <div class="form-group">
          <label for="new_desc">Description</label>
          <div class="input-wrapper">
            <input type="text" id="new_desc" placeholder="Enter description...">
            <div class="underline"></div>
          </div>
        </div>
        
        <div class="checkbox-group">
          <input type="checkbox" id="new_system">
          <label for="new_system">System Role</label>
        </div>
        
        <button onclick="addRole()" class="success" disabled id="addRoleBtn">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
          Add
        </button>
      </div>
      
      <div class="card">
        <h2>Existing Roles</h2>
        <div class="form-group">
          <label for="searchInput">Search Roles</label>
          <input type="text" id="searchInput" onkeyup="filterRoles()" placeholder="Search roles by name..." style="width: 100%; padding: 10px;">
        </div>
        
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
          <tbody id="rolesTable">
            <?php
$result = $conn->query("SELECT role_id, name, description, is_system FROM roles ORDER BY role_id ASC");
while ($row = $result->fetch_assoc()):
?>
            <tr id="row_<?= $row['role_id'] ?>">
              <td data-label="ID"><?= $row['role_id'] ?></td>
              <td data-label="Name">
                <input type="text" id="name_<?= $row['role_id'] ?>" value="<?= htmlspecialchars($row['name']) ?>" class="form-control" required>
              </td>
              <td data-label="Description">
                <input type="text" id="desc_<?= $row['role_id'] ?>" value="<?= htmlspecialchars($row['description']) ?>" class="form-control">
              </td>
              <td data-label="System Role" style="text-align: center;">
                <input type="checkbox" id="sys_<?= $row['role_id'] ?>" <?= $row['is_system'] ? 'checked' : '' ?>>
              </td>
              <td data-label="Actions">
                <div class="action-buttons">
                  <button onclick="updateRole(<?= $row['role_id'] ?>)" class="success" title="Save changes">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                  </button>
                  <button onclick="deleteRole(<?= $row['role_id'] ?>)" class="danger" title="Delete role">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                  </button>
                </div>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Enhanced Notification -->
  <!-- Realistic Notification -->
<div id="notification" class="notification">
  <div class="notification-content">
    <div class="notification-icon"></div>
    <div class="notification-message"></div>
    <button class="notification-close">&times;</button>
  </div>
  <div class="progress-bar"><span></span></div>
</div>

  <script>
    // Enable/disable add role button based on input
    document.getElementById('new_name').addEventListener('input', function () {
      const addBtn = document.getElementById('addRoleBtn');
      addBtn.disabled = this.value.trim() === '';
    });

    // Search functionality
    function filterRoles() {
      const input = document.getElementById("searchInput");
      const filter = input.value.toLowerCase();
      const rows = document.querySelectorAll("#rolesTable tr");

      rows.forEach(row => {
        const nameCell = row.querySelector("td:nth-child(2)");
        if (nameCell) {
          const inputField = nameCell.querySelector("input");
          const txtValue = inputField ? inputField.value.toLowerCase() : "";
          row.style.display = txtValue.indexOf(filter) > -1 ? "" : "none";
        }
      });
    }

    function showNotification(message, isSuccess, duration = 5000) {
  const notification = document.getElementById('notification');
  const iconContainer = notification.querySelector('.notification-icon');
  const messageContainer = notification.querySelector('.notification-message');
  const closeBtn = notification.querySelector('.notification-close');
  const progressBar = notification.querySelector('.progress-bar span');

  // Reset animation
  progressBar.style.animation = 'none';
  void progressBar.offsetWidth;

  // Set content
  iconContainer.innerHTML = isSuccess ? `
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
      <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
    </svg>
  ` : `
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
      <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
    </svg>
  `;

  messageContainer.textContent = message;

  notification.className = `notification ${isSuccess ? 'success' : 'error'}`;
  notification.classList.add('show');

  // Start progress bar animation
  progressBar.style.animation = `progressAnim ${duration}ms linear forwards`;

  // Close button handler
  closeBtn.onclick = () => {
    notification.classList.remove('show');
    setTimeout(() => {
      notification.className = 'notification';
    }, 300);
  };

  let timeout = setTimeout(() => {
    notification.classList.remove('show');
    setTimeout(() => {
      notification.className = 'notification';
    }, 300);
  }, duration);

  // Pause on hover
  notification.addEventListener('mouseenter', () => {
    progressBar.style.animationPlayState = 'paused';
    clearTimeout(timeout);
  });

  notification.addEventListener('mouseleave', () => {
    progressBar.style.animationPlayState = 'running';
    timeout = setTimeout(() => {
      notification.classList.remove('show');
      setTimeout(() => {
        notification.className = 'notification';
      }, 300);
    }, duration * 0.2); // resume with remaining time
  });
}
    // Role management functions
   function updateRole(roleId) {
  const name = document.getElementById(`name_${roleId}`).value;
  const desc = document.getElementById(`desc_${roleId}`).value;
  const isSystem = document.getElementById(`sys_${roleId}`).checked ? 1 : 0;
  const btn = event.currentTarget;
  
  if (!name) {
    showNotification('Role name is required', false);
    return;
  }
  
  btn.innerHTML = '<div class="loading-spinner"></div> Saving...';
  btn.disabled = true;
  
  fetch('update_role.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `role_id=${roleId}&name=${encodeURIComponent(name)}&description=${encodeURIComponent(desc)}&is_system=${isSystem}`
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        showNotification(data.message, true);
        // Update the counts in the header
        document.querySelector('.content-header .stat').textContent = 
          `${data.totalCount} Roles | ${data.systemCount} System`;
      } else {
        showNotification(data.message, false);
      }
      btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>';
      btn.disabled = false;
    })
    .catch(error => {
      showNotification(`Error updating role: ${error}`, false);
      btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>';
      btn.disabled = false;
      console.error('Error:', error);
    });
}

    function addRole() {
      const name = document.getElementById('new_name').value;
      const desc = document.getElementById('new_desc').value;
      const isSystem = document.getElementById('new_system').checked ? 1 : 0;
      const btn = document.getElementById('addRoleBtn');
      
      if (!name) {
        showNotification('Role name is required', false);
        return;
      }
      
      btn.innerHTML = '<div class="loading-spinner"></div> Adding...';
      btn.disabled = true;
      
      fetch('add_role.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
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
          btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add';
          btn.disabled = false;
          console.error('Error:', error);
        });
    }

    function deleteRole(roleId) {
  if (!confirm("Are you sure you want to delete this role? This action cannot be undone.")) return;
  
  const btn = event.currentTarget;
  const originalHTML = btn.innerHTML;
  btn.innerHTML = '<div class="loading-spinner"></div> Deleting...';
  btn.disabled = true;
  
  fetch('delete_role.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `role_id=${roleId}`
  })
    .then(response => {
      if (!response.ok) throw new Error('Network response was not ok');
      return response.json();
    })
    .then(data => {
      if (data.success) {
        showNotification(data.message, true);
        document.getElementById(`row_${roleId}`).remove();
        // Update the counts in the header
        document.querySelector('.content-header .stat').textContent = 
          `${data.totalCount} Roles | ${data.systemCount} System`;
      } else {
        showNotification(data.message, false);
      }
    })
    .catch(error => {
      showNotification(`Error deleting role: ${error.message}`, false);
      console.error('Error:', error);
    })
    .finally(() => {
      btn.innerHTML = originalHTML;
      btn.disabled = false;
    });
}
  </script>
</body>
</html>