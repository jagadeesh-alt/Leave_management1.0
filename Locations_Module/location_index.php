<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Management System</title>
    <style>
        /* Use same styles as index.php from previous file */
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

        input[type="text"], input[type="checkbox"] {
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
    <h1>Location Management System</h1>

    <div class="card">
        <h2>Add New Location</h2>
        <div class="form-row">
            <div class="form-group">
                <label for="new_name">Name</label>
                <input type="text" id="new_name" placeholder="Location Name" required>
            </div>
            <div class="form-group">
                <label for="new_postal_code">Postal Code</label>
                <input type="text" id="new_postal_code" placeholder="Postal Code">
            </div>
        </div>
        <div class="form-group">
            <label for="new_address">Address</label>
            <input type="text" id="new_address" placeholder="Full Address">
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_city">City</label>
                <input type="text" id="new_city" placeholder="City">
            </div>
            <div class="form-group">
                <label for="new_state">State</label>
                <input type="text" id="new_state" placeholder="State">
            </div>
            <div class="form-group">
                <label for="new_country">Country</label>
                <input type="text" id="new_country" placeholder="Country">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_phone">Phone</label>
                <input type="text" id="new_phone" placeholder="Phone Number">
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="new_is_active" checked>
                <label for="new_is_active">Active</label>
            </div>
        </div>
        <button onclick="addLocation()" class="success">➕ Add Location</button>
    </div>

    <div class="card">
        <h2>Existing Locations</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Country</th>
                    <th>Postal Code</th>
                    <th>Phone</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT location_id, name, address, city, state, country, postal_code, phone, is_active FROM locations ORDER BY location_id DESC");
                while ($row = $result->fetch_assoc()):
                ?>
                <tr id="row_<?= $row['location_id'] ?>">
                    <td><?= $row['location_id'] ?></td>
                    <td><input type="text" id="name_<?= $row['location_id'] ?>" value="<?= htmlspecialchars($row['name']) ?>" required></td>
                    <td><input type="text" id="address_<?= $row['location_id'] ?>" value="<?= htmlspecialchars($row['address']) ?>"></td>
                    <td><input type="text" id="city_<?= $row['location_id'] ?>" value="<?= htmlspecialchars($row['city']) ?>"></td>
                    <td><input type="text" id="state_<?= $row['location_id'] ?>" value="<?= htmlspecialchars($row['state']) ?>"></td>
                    <td><input type="text" id="country_<?= $row['location_id'] ?>" value="<?= htmlspecialchars($row['country']) ?>"></td>
                    <td><input type="text" id="postal_code_<?= $row['location_id'] ?>" value="<?= htmlspecialchars($row['postal_code']) ?>"></td>
                    <td><input type="text" id="phone_<?= $row['location_id'] ?>" value="<?= htmlspecialchars($row['phone']) ?>"></td>
                    <td style="text-align: center;">
                        <input type="checkbox" id="is_active_<?= $row['location_id'] ?>" <?= $row['is_active'] ? 'checked' : '' ?>>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="updateLocation(<?= $row['location_id'] ?>)" class="success">💾 Save</button>
                            <button onclick="deleteLocation(<?= $row['location_id'] ?>)" class="danger">🗑️ Delete</button>
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

    function updateLocation(locationId) {
        const name = document.getElementById(`name_${locationId}`).value;
        const address = document.getElementById(`address_${locationId}`).value;
        const city = document.getElementById(`city_${locationId}`).value;
        const state = document.getElementById(`state_${locationId}`).value;
        const country = document.getElementById(`country_${locationId}`).value;
        const postalCode = document.getElementById(`postal_code_${locationId}`).value;
        const phone = document.getElementById(`phone_${locationId}`).value;
        const isActive = document.getElementById(`is_active_${locationId}`).checked ? 1 : 0;

        if (!name) {
            showNotification('Location name is required', false);
            return;
        }

        fetch('update_location.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `location_id=${locationId}&name=${encodeURIComponent(name)}&address=${encodeURIComponent(address)}&city=${encodeURIComponent(city)}&state=${encodeURIComponent(state)}&country=${encodeURIComponent(country)}&postal_code=${encodeURIComponent(postalCode)}&phone=${encodeURIComponent(phone)}&is_active=${isActive}`
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(data => {
            showNotification(data, true);
        })
        .catch(error => {
            showNotification(`Error updating location: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function addLocation() {
        const name = document.getElementById('new_name').value;
        const address = document.getElementById('new_address').value;
        const city = document.getElementById('new_city').value;
        const state = document.getElementById('new_state').value;
        const country = document.getElementById('new_country').value;
        const postalCode = document.getElementById('new_postal_code').value;
        const phone = document.getElementById('new_phone').value;
        const isActive = document.getElementById('new_is_active').checked ? 1 : 0;

        if (!name) {
            showNotification('Location name is required', false);
            return;
        }

        fetch('add_location.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `name=${encodeURIComponent(name)}&address=${encodeURIComponent(address)}&city=${encodeURIComponent(city)}&state=${encodeURIComponent(state)}&country=${encodeURIComponent(country)}&postal_code=${encodeURIComponent(postalCode)}&phone=${encodeURIComponent(phone)}&is_active=${isActive}`
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
            showNotification(`Error adding location: ${error}`, false);
            console.error('Error:', error);
        });
    }

    function deleteLocation(locationId) {
        if (!confirm("Are you sure you want to delete this location? This action cannot be undone.")) return;

        fetch('delete_location.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `location_id=${locationId}`
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.text();
        })
        .then(data => {
            showNotification(data, true);
            document.getElementById(`row_${locationId}`).remove();
        })
        .catch(error => {
            showNotification(`Error deleting location: ${error}`, false);
            console.error('Error:', error);
        });
    }
</script>
</body>
</html>