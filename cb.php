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
    </style>
</head>
<body class="bx--body">
    <!-- Header -->
    <header class="dashboard-header">
        <button class="bx--btn bx--btn--ghost menu-toggle" style="display: none;">
            <i class="fas fa-bars"></i>
        </button>
        
        <h1 class="bx--type-productive-heading-05" style="margin: 0; font-weight: 600;">Enterprise Dashboard</h1>
        
        <div class="header-search">
            <div data-search class="bx--search bx--search--sm" role="search">
                <div class="bx--search-magnifier">
                    <svg focusable="false" preserveAspectRatio="xMidYMid meet" aria-hidden="true" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M15,14.3L10.7,10c1.9-2.3,1.6-5.8-0.7-7.7S4.2,0.7,2.3,3S0.7,8.8,3,10.7c2,1.7,5,1.7,7,0l4.3,4.3L15,14.3z M2,6.5	C2,4,4,2,6.5,2S11,4,11,6.5S9,11,6.5,11S2,9,2,6.5z"></path>
                    </svg>
                </div>
                <label id="search-input-label-1" class="bx--label" for="search__input-1">Search</label>
                <input class="bx--search-input" type="text" id="search__input-1" placeholder="Search..." role="search">
            </div>
        </div>
        
        <div class="user-profile">
            <div class="user-avatar">AD</div>
            <div>
                <div class="bx--type-body-short-01 bx--font-semibold">Admin User</div>
                <div class="bx--type-helper-text-01">Administrator</div>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <nav class="sidebar">
        <ul class="sidebar-menu">
            <li class="sidebar-item active">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </li>
            <li class="sidebar-item">
                <i class="fas fa-chart-line"></i>
                <span>Analytics</span>
            </li>
            <li class="sidebar-item">
                <i class="fas fa-users"></i>
                <span>Users</span>
            </li>
            <li class="sidebar-item">
                <i class="fas fa-project-diagram"></i>
                <span>Projects                <span>Projects</span>
            </li>
            <li class="sidebar-item">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </li>
            <li class="sidebar-item">
                <i class="fas fa-file-alt"></i>
                <span>Reports</span>
            </li>
            <li class="sidebar-item">
                <i class="fas fa-bell"></i>
                <span>Notifications</span>
            </li>
            <li class="sidebar-item">
                <i class="fas fa-envelope"></i>
                <span>Messages</span>
            </li>
            <li class="sidebar-item">
                <i class="fas fa-calendar-alt"></i>
                <span>Calendar</span>
            </li>
            <li class="sidebar-item">
                <i class="fas fa-database"></i>
                <span>Database</span>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Welcome Banner -->
        <div class="bx--row">
            <div class="bx--col">
                <div class="bx--tile welcome-banner animate__animated animate__fadeIn" style="
                    background: linear-gradient(135deg, #0f62fe 0%, #4589ff 100%);
                    color: white;
                    padding: 2rem;
                    border-radius: 8px;
                    margin-bottom: 2rem;
                ">
                    <h2 class="bx--type-productive-heading-05" style="color: white; margin-bottom: 0.5rem;">Welcome back, Admin!</h2>
                    <p class="bx--type-body-short-01" style="color: rgba(255,255,255,0.8); max-width: 600px;">
                        You have 5 new notifications and 3 pending tasks. Your last login was yesterday at 2:45 PM.
                    </p>
                    <button class="bx--btn bx--btn--tertiary" style="margin-top: 1rem; color: white; border-color: rgba(255,255,255,0.3);">
                        View Updates
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stat-grid">
            <?php foreach ($stats as $key => $stat): ?>
            <div class="stat-card fade-in delay-<?php echo array_search($key, array_keys($stats)) % 4; ?>">
                <div class="stat-header">
                    <div class="stat-title"><?php echo ucfirst($key); ?></div>
                    <div class="stat-icon">
                        <i class="fas fa-<?php echo $stat['icon']; ?>"></i>
                    </div>
                </div>
                <div class="stat-value"><?php echo $stat['value']; ?></div>
                <div class="stat-change <?php echo strpos($stat['change'], '+') !== false ? 'positive' : 'negative'; ?>">
                    <i class="fas fa-<?php echo strpos($stat['change'], '+') !== false ? 'arrow-up' : 'arrow-down'; ?>"></i>
                    <?php echo $stat['change']; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Main Dashboard Grid -->
        <div class="dashboard-grid">
            <!-- Left Column -->
            <div>
                <!-- Performance Chart -->
                <div class="chart-container animate__animated animate__fadeIn">
                    <div class="chart-header">
                        <h3 class="section-title">Performance Metrics</h3>
                        <div class="bx--dropdown" data-dropdown>
                            <button class="bx--dropdown__trigger" aria-expanded="false" aria-haspopup="true">
                                Last 30 Days
                                <svg class="bx--dropdown__arrow" width="12" height="7" viewBox="0 0 12 7" aria-hidden="true">
                                    <path fill-rule="nonzero" d="M6.002 5.55L11.27 0l.726.685L6.003 7 0 .685.726 0z"></path>
                                </svg>
                            </button>
                            <ul class="bx--dropdown__list">
                                <li class="bx--dropdown__item"><a class="bx--dropdown__link" href="#">Last 7 Days</a></li>
                                <li class="bx--dropdown__item"><a class="bx--dropdown__link" href="#">Last 30 Days</a></li>
                                <li class="bx--dropdown__item"><a class="bx--dropdown__link" href="#">Last Quarter</a></li>
                                <li class="bx--dropdown__item"><a class="bx--dropdown__link" href="#">Last Year</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="performance-chart" style="height: 300px;"></div>
                </div>

                <!-- Projects Table -->
                <div class="chart-container animate__animated animate__fadeIn" style="margin-top: 1.5rem;">
                    <div class="chart-header">
                        <h3 class="section-title">Active Projects</h3>
                        <button class="bx--btn bx--btn--sm bx--btn--ghost">
                            View All Projects
                        </button>
                    </div>
                    <table class="projects-table">
                        <thead>
                            <tr>
                                <th>Project Name</th>
                                <th>Progress</th>
                                <th>Status</th>
                                <th>Team</th>
                                <th>Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($projects as $project): ?>
                            <tr>
                                <td><?php echo $project['name']; ?></td>
                                <td>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: <?php echo $project['progress']; ?>%"></div>
                                    </div>
                                    <span><?php echo $project['progress']; ?>%</span>
                                </td>
                                <td>
                                    <span class="bx--tag <?php echo statusBadge($project['status']); ?>">
                                        <?php echo ucfirst($project['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo $project['team']; ?> members</td>
                                <td><?php echo date('M j, Y', strtotime($project['due'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Column -->
            <div>
                <!-- Notifications -->
                <div class="notifications-container animate__animated animate__fadeIn">
                    <div class="section-header">
                        <h3 class="section-title">Recent Notifications</h3>
                        <button class="bx--btn bx--btn--sm bx--btn--ghost">
                            Mark All as Read
                        </button>
                    </div>
                    <div class="notifications-list">
                        <?php foreach ($notifications as $notification): ?>
                        <div class="notification-item">
                            <div class="notification-priority <?php echo $notification['priority']; ?>"></div>
                            <div class="notification-content">
                                <div class="notification-title"><?php echo $notification['title']; ?></div>
                                <p class="bx--type-body-short-01"><?php echo $notification['content']; ?></p>
                                <div class="notification-time"><?php echo $notification['time']; ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Activity Feed -->
                <div class="notifications-container animate__animated animate__fadeIn" style="margin-top: 1.5rem;">
                    <div class="section-header">
                        <h3 class="section-title">Recent Activity</h3>
                        <button class="bx--btn bx--btn--sm bx--btn--ghost">
                            View Full Log
                        </button>
                    </div>
                    <div class="activity-feed">
                        <?php foreach ($recentActivities as $activity): ?>
                        <div class="activity-item">
                            <div class="activity-avatar"><?php echo $activity['avatar']; ?></div>
                            <div class="activity-content">
                                <p class="bx--type-body-short-01">
                                    <span class="activity-user"><?php echo $activity['user']; ?></span>
                                    <?php echo $activity['action']; ?>
                                </p>
                                <div class="activity-time"><?php echo $activity['time']; ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Carbon Design System JS -->
    <script src="https://unpkg.com/carbon-components/scripts/carbon-components.min.js"></script>
    
    <!-- Chart.js for charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    
    <!-- ApexCharts for more advanced visualizations -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    
    <script>
        // Initialize Carbon components
        document.addEventListener('DOMContentLoaded', function() {
            CarbonComponents.init();
            
            // Toggle sidebar on mobile
            const menuToggle = document.querySelector('.menu-toggle');
            const sidebar = document.querySelector('.sidebar');
            
            if (menuToggle) {
                menuToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
            }
            
            // Performance Chart
            const performanceChart = new ApexCharts(document.querySelector("#performance-chart"), {
                series: [{
                    name: 'Revenue',
                    data: [21000, 32000, 28000, 35000, 42000, 39000, 45000]
                }, {
                    name: 'Users',
                    data: [1100, 1350, 1250, 1400, 1650, 1550, 1800]
                }, {
                    name: 'Engagement',
                    data: [75, 82, 78, 85, 88, 84, 90]
                }],
                chart: {
                    height: '100%',
                    type: 'area',
                    toolbar: {
                        show: true,
                        tools: {
                            download: true,
                            selection: true,
                            zoom: true,
                            zoomin: true,
                            zoomout: true,
                            pan: true,
                            reset: true
                        }
                    },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    }
                },
                colors: ['#0f62fe', '#8a3ffc', '#24a148'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.3,
                    }
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                    labels: {
                        style: {
                            colors: '#525252',
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#525252',
                            fontSize: '12px'
                        },
                        formatter: function(value) {
                            if (value > 1000) {
                                return '$' + (value / 1000) + 'k';
                            }
                            return value;
                        }
                    }
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function (y) {
                            if (typeof y !== "undefined") {
                                return y.toFixed(0);
                            }
                            return y;
                        }
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    fontSize: '14px',
                    markers: {
                        width: 12,
                        height: 12,
                        radius: 12,
                    }
                },
                grid: {
                    borderColor: '#e0e0e0',
                    strokeDashArray: 4,
                    padding: {
                        top: 20,
                        right: 20,
                        bottom: 0,
                        left: 20
                    }
                }
            });
            
            performanceChart.render();
            
            // Add animation class when elements come into view
            const animateOnScroll = function() {
                const elements = document.querySelectorAll('.fade-in');
                
                elements.forEach(element => {
                    const elementPosition = element.getBoundingClientRect().top;
                    const windowHeight = window.innerHeight;
                    
                    if (elementPosition < windowHeight - 100) {
                        element.classList.add('animate__animated', 'animate__fadeInUp');
                    }
                });
            };
            
            window.addEventListener('scroll', animateOnScroll);
            animateOnScroll(); // Run once on load
        });
    </script>
</body>
</html>