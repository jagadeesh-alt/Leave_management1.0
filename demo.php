<?php
// PHP Data Section
$stats = [
    'users' => ['value' => 1245, 'change' => '+12.5%', 'icon' => 'user'],
    'revenue' => ['value' => '$48,254', 'change' => '+8.2%', 'icon' => 'money'],
    'growth' => ['value' => '+12.5%', 'change' => '+2.3%', 'icon' => 'growth'],
    'tasks' => ['value' => 42, 'change' => '-5', 'icon' => 'task'],
    'satisfaction' => ['value' => '94%', 'change' => '+3%', 'icon' => 'favorite'],
    'uptime' => ['value' => '99.9%', 'change' => '0%', 'icon' => 'checkmark']
];

$notifications = [
    ['id' => 1, 'title' => 'System update available', 'content' => 'Version 2.3.1 includes new security patches', 'time' => '2 hours ago', 'priority' => 'high'],
    ['id' => 2, 'title' => 'New user registration', 'content' => 'Jane Doe (jane@example.com) registered as admin', 'time' => '5 hours ago', 'priority' => 'medium'],
    ['id' => 3, 'title' => 'Performance alert', 'content' => 'Server CPU usage exceeded 90% threshold', 'time' => '1 day ago', 'priority' => 'critical'],
    ['id' => 4, 'title' => 'Database backup', 'content' => 'Nightly backup completed successfully', 'time' => '1 day ago', 'priority' => 'low']
];

$recentActivities = [
    ['user' => 'John Smith', 'action' => 'created Quarterly Financial Report', 'time' => '10 mins ago', 'avatar' => 'JS'],
    ['user' => 'Sarah Johnson', 'action' => 'updated security settings', 'time' => '25 mins ago', 'avatar' => 'SJ'],
    ['user' => 'Mike Brown', 'action' => 'deleted outdated project files', 'time' => '1 hour ago', 'avatar' => 'MB'],
    ['user' => 'Emily Wilson', 'action' => 'approved budget request', 'time' => '2 hours ago', 'avatar' => 'EW'],
    ['user' => 'David Lee', 'action' => 'exported user data', 'time' => '3 hours ago', 'avatar' => 'DL']
];

$projects = [
    ['name' => 'Website Redesign', 'progress' => 75, 'status' => 'on track', 'team' => 5, 'due' => '2023-12-15'],
    ['name' => 'Mobile App Launch', 'progress' => 90, 'status' => 'ahead', 'team' => 8, 'due' => '2023-11-30'],
    ['name' => 'CRM Migration', 'progress' => 45, 'status' => 'delayed', 'team' => 12, 'due' => '2024-01-20'],
    ['name' => 'Data Analytics', 'progress' => 30, 'status' => 'on track', 'team' => 6, 'due' => '2024-02-10']
];

function priorityBadge($priority) {
    $classes = [
        'critical' => 'bx--tag--red',
        'high' => 'bx--tag--magenta',
        'medium' => 'bx--tag--purple',
        'low' => 'bx--tag--cool-gray'
    ];
    return $classes[$priority] ?? 'bx--tag--cool-gray';
}

function statusBadge($status) {
    $classes = [
        'on track' => 'bx--tag--green',
        'ahead' => 'bx--tag--cyan',
        'delayed' => 'bx--tag--red'
    ];
    return $classes[$status] ?? 'bx--tag--cool-gray';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterprise Dashboard | Carbon Design</title>
    <!-- Carbon Design System CSS -->
    <link rel="stylesheet" href="https://unpkg.com/carbon-components/css/carbon-components.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --header-height: 64px;
            --primary-color: #0f62fe;
            --primary-hover: #0353e9;
            --primary-blue: #0A66C2;
    --accent-orange: #FF6F00;
    --neutral-gray: #F5F5F5;
    --dark-text-gray: #333333;
    --light-text-gray: #666666;
    --white: #FFFFFF;
        }
        
        body {
            background-color: #f4f4f4;
            font-family: 'IBM Plex Sans', sans-serif;
            overflow-x: hidden;
        }
        
        /* Header Styles */
        .dashboard-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--header-height);
            background: white;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            z-index: 1000;
            display: flex;
            align-items: center;
            padding: 0 2rem;
        }
        
        .header-search {
            max-width: 400px;
            margin-left: auto;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            margin-left: 2rem;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            font-weight: bold;
        }
        
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: var(--header-height);
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - var(--header-height));
            background: white;
            box-shadow: 1px 0 3px rgba(0,0,0,0.1);
            padding: 1.5rem 0;
            z-index: 900;
            transition: transform 0.3s ease;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-item {
            padding: 0.75rem 1.5rem;
            margin: 0.25rem 0;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
        }
        
        .sidebar-item:hover {
            background-color: #f4f4f4;
        }
        
        .sidebar-item.active {
            background-color: #e8f2ff;
            border-left: 3px solid var(--primary-color);
        }
        
        .sidebar-item i {
            margin-right: 1rem;
            width: 20px;
            text-align: center;
        }
        
        /* Main Content Styles */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: calc(var(--header-height) + 2rem) 2rem 2rem;
            min-height: 100vh;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #161616;
        }
        
        /* Stat Cards */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-color);
        }
        
        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .stat-title {
            font-size: 0.875rem;
            color: #525252;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e8f2ff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 600;
            margin: 0.5rem 0;
            color: #161616;
        }
        
        .stat-change {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
        }
        
        .stat-change.positive {
            color: #24a148;
        }
        
        .stat-change.negative {
            color: #da1e28;
        }
        
        /* Dashboard Grid Layout */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
        }
        
        .chart-container {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }
        
        .chart-header {
            margin-bottom: 1.5rem;
        }
        
        /* Notifications */
        .notifications-container {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            height: 100%;
        }
        
        .notification-item {
            padding: 1rem 0;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
        }
        
        .notification-priority {
            width: 8px;
            height: 40px;
            border-radius: 4px;
            margin-right: 1rem;
        }
        
        .notification-priority.critical {
            background-color: #da1e28;
        }
        
        .notification-priority.high {
            background-color: #fa4d56;
        }
        
        .notification-priority.medium {
            background-color: #ff832b;
        }
        
        .notification-priority.low {
            background-color: #8a3ffc;
        }
        
        .notification-content {
            flex: 1;
        }
        
        .notification-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .notification-time {
            font-size: 0.75rem;
            color: #525252;
        }
        
        /* Activity Feed */
        .activity-item {
            display: flex;
            padding: 1rem 0;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .activity-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-weight: bold;
            flex-shrink: 0;
        }
        
        .activity-content {
            flex: 1;
        }
        
        .activity-user {
            font-weight: 600;
        }
        
        .activity-time {
            font-size: 0.75rem;
            color: #525252;
        }
        
        /* Projects Table */
        .projects-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        
        .projects-table th {
            text-align: left;
            padding: 1rem;
            background-color: #f4f4f4;
            font-weight: 600;
        }
        
        .projects-table td {
            padding: 1rem;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .progress-bar {
            height: 8px;
            background-color: #e0e0e0;
            border-radius: 4px;
            overflow: hidden;
            width: 100%;
        }
        
        .progress-fill {
            height: 100%;
            background-color: var(--primary-color);
            border-radius: 4px;
        }
        .link-grid {
    margin-top: 1rem;
    
}

.link-card {
    padding: 1.25rem;
    
    transition: all 0.2s ease;
    height: 100%;
    border: 1px solid #e0e0e0;
    position: relative;
    overflow: hidden;
    
}

.link-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    border-color: var(--primary-blue);
}

.link-card::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    height: 4px;
    width: 0%;
    background-color: var(--primary-blue);
    transition: all 0.2s ease;
}

.link-card:hover::after {
    width: 100%;
}

.link-title {
    color: var(--primary-blue);
    text-decoration: none;
    font-weight: 600;
    display: block;
    margin-bottom: 0.5rem;
    transition: color 0.2s ease;
}

.link-title:hover {
    color: var(--accent-orange);
    text-decoration: underline;
}

.table-name {
    font-family: 'IBM Plex Mono', monospace;
    background-color: var(--neutral-gray);
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.85rem;
    color: var(--light-text-gray);
    display: inline-block;
    margin-bottom: 0.75rem;
}

.link-description {
    font-size: 0.95rem;
    color: var(--light-text-gray);
    line-height: 1.5;
}

        
        /* Responsive Adjustments */
        @media (max-width: 1200px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .menu-toggle {
                display: block !important;
            }
        }
        
        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        .content-section {
            margin: 1.5rem;
            
    display: none;
}
.content-section.active {
    display: block;
}
    </style>
</head>
<body class="bx--body">
    <!-- Header -->
    <header class="dashboard-header">
        <button class="bx--btn bx--btn--ghost menu-toggle" style="display: none;">
            <i class="fas fa-bars"></i>
        </button>
        
        <h1 class="bx--type-productive-heading-05" style="margin: 0; font-weight: 600;">Leave Management</h1>
        
        <div class="header-search">
             <div class="user-profile">
            <div class="user-avatar">AD</div>
            <div>
                <div class="bx--type-body-short-01 bx--font-semibold">Admin User</div>
                <div class="bx--type-helper-text-01">Administrator</div>
            </div>
        </div>
        </div>
        
       
    </header>

 <!-- Sidebar -->
<nav class="sidebar">
    <ul class="sidebar-menu">
        <li class="sidebar-item" data-section="dashboard">
    <i class="fas fa-tachometer-alt"></i>
    <span>Dashboard</span>
</li>
        <li class="sidebar-item active" data-section="employee">
            <i class="fas fa-users"></i>
            <span>Employee Management</span>
        </li>
        <li class="sidebar-item" data-section="auth">
            <i class="fas fa-user-shield"></i>
            <span>User Authentication</span>
        </li>
        <li class="sidebar-item" data-section="leave">
            <i class="fas fa-calendar-check"></i>
            <span>Leave Management Core</span>
        </li>
        <li class="sidebar-item" data-section="attendance">
            <i class="fas fa-clock"></i>
            <span>Time & Attendance</span>
        </li>
        <li class="sidebar-item" data-section="payroll">
            <i class="fas fa-money-bill-wave"></i>
            <span>Payroll Integration</span>
        </li>
        <li class="sidebar-item" data-section="system">
            <i class="fas fa-cogs"></i>
            <span>System Management</span>
        </li>
    </ul>
</nav>


 <!-- Main Content -->
<main class="main-content">
<!-- Dashboard -->
<div id="dashboard-content" class="content-section">
    <h2 class="section-title">Leave Dashboard</h2>

    <!-- Stat Cards -->
    <div class="stat-grid">
        <?php foreach ($stats as $key => $item): ?>
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title"><?= ucfirst($key) ?></div>
                    <div class="stat-icon">
                        <i class="fas fa-<?= $item['icon'] ?>"></i>
                    </div>
                </div>
                <div class="stat-value"><?= $item['value'] ?></div>
                <div class="stat-change <?= strpos($item['change'], '-') === false ? 'positive' : 'negative' ?>">
                    <?= $item['change'] ?> from last month
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="dashboard-grid">
        <!-- Notifications -->
        <div class="chart-container">
            <h3 class="section-title" style="font-size:1rem; margin-bottom:1rem;">Recent Leave Activity</h3>
            <div class="notifications-container">
                <?php foreach ($recentActivities as $activity): ?>
                    <div class="activity-item">
                        <div class="activity-avatar"><?= $activity['avatar'] ?></div>
                        <div class="activity-content">
                            <div class="activity-user"><?= $activity['user'] ?></div>
                            <div><?= $activity['action'] ?></div>
                            <div class="activity-time"><?= $activity['time'] ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Projects / Leave Summary Table -->
        <div class="chart-container">
            <h3 class="section-title" style="font-size:1rem; margin-bottom:1rem;">Project Leave Status</h3>
            <table class="projects-table">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Progress</th>
                        <th>Status</th>
                        <th>Team Size</th>
                        <th>Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <td><?= $project['name'] ?></td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?= $project['progress'] ?>%; background-color: #0f62fe;"></div>
                                </div>
                            </td>
                            <td>
                                <span class="<?= statusBadge($project['status']) ?> bx--tag">
                                    <?= ucfirst($project['status']) ?>
                                </span>
                            </td>
                            <td><?= $project['team'] ?></td>
                            <td><?= date('M j, Y', strtotime($project['due'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    <!-- Employee Management -->
    <div id="employee-content" class="content-section active">
        <h2 class="section-title">Employee Management</h2>
        <div class="bx--row link-grid" >
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3"style="margin-bottom: 1rem;" >
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/employees/employee_index.php" class="link-title">1. Employee Records</a>
                    <span class="table-name">`employees`</span>
                    <p class="link-description">Manage all employee personal and professional information</p>
                </div>
            </div>
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/departments/department_index.php" class="link-title">2. Departments</a>
                    <span class="table-name">`departments`</span>
                    <p class="link-description">Organize company departments and reporting hierarchies</p>
                </div>
            </div>
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/Locations_Module/location_index.php" class="link-title">3. Locations</a>
                    <span class="table-name">`locations`</span>
                    <p class="link-description">Manage office locations, addresses, and regional details</p>
                </div>
            </div>
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/positions/position_index.php" class="link-title">4. Positions</a>
                    <span class="table-name">`positions`</span>
                    <p class="link-description">Define job positions, roles, and career levels</p>
                </div>
            </div>
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/positions/position_index.php" class="link-title">5. Position History</a>
                    <span class="table-name">`employee_position_history`</span>
                    <p class="link-description">Track employee promotions, transfers, and role changes</p>
                </div>
            </div>
        </div>
    </div>

    <!-- User Authentication -->
    <div id="auth-content" class="content-section">
        <h2 class="section-title">User Authentication</h2>
        <div class="bx--row link-grid">
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/users/user_index.php" class="link-title">6. User Accounts</a>
                    <span class="table-name">`users`</span>
                    <p class="link-description">Manage system user accounts, credentials, and profiles</p>
                </div>
            </div>
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/roles/" class="link-title">7. User Roles</a>
                    <span class="table-name">`roles`</span>
                    <p class="link-description">Define access levels, permissions, and system roles</p>
                </div>
            </div>
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/permissions/permission_index.php" class="link-title">8. Permissions</a>
                    <span class="table-name">`permissions`</span>
                    <p class="link-description">Configure granular system permissions and access controls</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Leave Management Core -->
    <div id="leave-content" class="content-section">
        <h2 class="section-title">Leave Management Core</h2>
        <div class="bx--row link-grid">
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/leave_types/leave_type_index.php" class="link-title">9. Leave Types</a>
                    <span class="table-name">`leave_types`</span>
                    <p class="link-description">Configure different types of leave and their specific rules</p>
                </div>
            </div>
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/leave_policies/leave_policy_index.php" class="link-title">10. Leave Policies</a>
                    <span class="table-name">`leave_policies`</span>
                    <p class="link-description">Create and manage comprehensive leave policy frameworks</p>
                </div>
            </div>
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/leave_policy_rules/leave_policy_rule_index.php" class="link-title">11. Policy Rules</a>
                    <span class="table-name">`leave_policy_rules`</span>
                    <p class="link-description">Define accrual rules, eligibility criteria for each leave type</p>
                </div>
            </div>
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/employee_leave_policies/employee_leave_policy_index.php" class="link-title">12. Employee Policies</a>
                    <span class="table-name">`employee_leave_policies`</span>
                    <p class="link-description">Assign appropriate policies to individual employees</p>
                </div>
            </div>
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/employee_leave_balances/employee_leave_balance_index.php" class="link-title">13. Leave Balances</a>
                    <span class="table-name">`employee_leave_balances`</span>
                    <p class="link-description">Monitor and manage current leave balances for employees</p>
                </div>
            </div>
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/leave_accruals/leave_accrual_index.php" class="link-title">14. Leave Accruals</a>
                    <span class="table-name">`leave_accruals`</span>
                    <p class="link-description">Track automatic leave accumulation transactions</p>
                </div>
            </div>
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/leave_applications/leave_application_index.php" class="link-title">15. Leave Applications</a>
                    <span class="table-name">`leave_applications`</span>
                    <p class="link-description">Process employee leave requests with detailed tracking</p>
                </div>
            </div>
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/leave_approval_workflow/leave_approval_workflow_index.php" class="link-title">16. Approval Workflow</a>
                    <span class="table-name">`leave_approval_workflow`</span>
                    <p class="link-description">Manage multi-level approval processes for leave applications</p>
                </div>
            </div>
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/leave_blackout_periods/leave_blackout_period_index.php" class="link-title">17. Blackout Periods</a>
                    <span class="table-name">`leave_blackout_periods`</span>
                    <p class="link-description">Configure restricted leave periods for business critical times</p>
                </div>
            </div>
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/leave_attachments/leave_attachment_index.php" class="link-title">18. Leave Attachments</a>
                    <span class="table-name">`leave_attachments`</span>
                    <p class="link-description">Manage supporting documents submitted with leave requests</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Time & Attendance -->
    <div id="attendance-content" class="content-section">
        <h2 class="section-title">Time & Attendance</h2>
        <div class="bx--row link-grid">
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/work_schedules/work_schedule_index.php" class="link-title">19. Work Schedules</a>
                    <span class="table-name">`work_schedules`</span>
                    <p class="link-description">Define shift patterns, working hours, and attendance expectations</p>
                </div>
            </div>
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/employee_schedules/employee_schedule_index.php" class="link-title">20. Employee Schedules</a>
                    <span class="table-name">`employee_schedules`</span>
                    <p class="link-description">Assign customized schedules to employees based on role and location</p>
                </div>
            </div>
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/attendance_records/attendance_record_index.php" class="link-title">21. Attendance Records</a>
                    <span class="table-name">`attendance_records`</span>
                    <p class="link-description">Review and manage daily attendance data across the organization</p>
                </div>
            </div>
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/attendance_adjustments/attendance_adjustment_index.php" class="link-title">22. Attendance Adjustments</a>
                    <span class="table-name">`attendance_adjustments`</span>
                    <p class="link-description">Track and manage corrections to attendance records</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Payroll Integration -->
    <div id="payroll-content" class="content-section">
        <h2 class="section-title">Payroll Integration</h2>
        <div class="bx--row link-grid">
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/pay_periods/pay_period_index.php" class="link-title">23. Pay Periods</a>
                    <span class="table-name">`pay_periods`</span>
                    <p class="link-description">Manage payroll processing cycles and pay dates</p>
                </div>
            </div>
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/leave_encashment/leave_encashment_index.php" class="link-title">24. Leave Encashment</a>
                    <span class="table-name">`leave_encashment`</span>
                    <p class="link-description">Process payments for unused leave entitlements</p>
                </div>
            </div>
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/leave_impact_on_payroll/leave_impact_index.php" class="link-title">25. Payroll Impact</a>
                    <span class="table-name">`leave_impact_on_payroll`</span>
                    <p class="link-description">Analyze how leave affects payroll calculations and compensation</p>
                </div>
            </div>
        </div>
    </div>

    <!-- System Management -->
    <div id="system-content" class="content-section">
        <h2 class="section-title">System Management</h2>
        <div class="bx--row link-grid">
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/notifications/notification_index.php" class="link-title">26. Notifications</a>
                    <span class="table-name">`notifications`</span>
                    <p class="link-description">Manage automated system alerts and important messages</p>
                </div>
            </div>
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/audit_logs/audit_log_index.php" class="link-title">27. Audit Logs</a>
                    <span class="table-name">`audit_logs`</span>
                    <p class="link-description">Review system changes, user activities, and security events</p>
                </div>
            </div>
            <div class="bx--col-md-4 bx--col-lg-4 bx--col-xlg-3" style="margin-bottom: 1rem;">
                <div class="bx--tile link-card">
                    <a href="http://localhost/Leave_mangement/system_settings/system_setting_index.php" class="link-title">28. System Settings</a>
                    <span class="table-name">`system_settings`</span>
                    <p class="link-description">Configure global system parameters and default settings</p>
                </div>
            </div>
        </div>
    </div>

</main>
<script>
document.querySelectorAll('.sidebar-item').forEach(item => {
    item.addEventListener('click', function () {
        const section = this.getAttribute('data-section');
        document.querySelectorAll('.sidebar-item').forEach(i => i.classList.remove('active'));
        this.classList.add('active');
        document.querySelectorAll('.content-section').forEach(sec => sec.classList.remove('active'));
        document.getElementById(section + '-content').classList.add('active');
    });
});
</script>
</body>
</html>