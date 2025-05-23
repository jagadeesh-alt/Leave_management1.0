-- CORE EMPLOYEE TABLES (5 tables)
CREATE TABLE `employees` (
  `employee_id` INT AUTO_INCREMENT PRIMARY KEY,
  `employee_code` VARCHAR(20) UNIQUE NOT NULL,
  `first_name` VARCHAR(50) NOT NULL,
  `last_name` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) UNIQUE NOT NULL,
  `phone` VARCHAR(20),
  `hire_date` DATE NOT NULL,
  `birth_date` DATE,
  `gender` ENUM('male','female','other','prefer_not_to_say'),
  `marital_status` ENUM('single','married','divorced','widowed'),
  `employment_type` ENUM('full_time','part_time','contract','temporary','intern'),
  `job_title` VARCHAR(100),
  `department_id` INT,
  `location_id` INT,
  `manager_id` INT,
  `status` ENUM('active','on_leave','suspended','terminated') DEFAULT 'active',
  `termination_date` DATE,
  `termination_reason` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `departments` (
  `department_id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(50) NOT NULL,
  `code` VARCHAR(10) UNIQUE,
  `parent_department_id` INT,
  `manager_id` INT,
  `cost_center` VARCHAR(20),
  `description` TEXT,
  FOREIGN KEY (`parent_department_id`) REFERENCES `departments`(`department_id`),
  FOREIGN KEY (`manager_id`) REFERENCES `employees`(`employee_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `locations` (
  `location_id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `address` TEXT NOT NULL,
  `city` VARCHAR(50) NOT NULL,
  `state` VARCHAR(50) NOT NULL,
  `country` VARCHAR(50) NOT NULL,
  `postal_code` VARCHAR(20) NOT NULL,
  `phone` VARCHAR(20),
  `is_active` BOOLEAN DEFAULT TRUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `positions` (
  `position_id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(100) NOT NULL,
  `job_description` TEXT,
  `department_id` INT,
  `is_management` BOOLEAN DEFAULT FALSE,
  `career_level` ENUM('entry','intermediate','senior','manager','director','executive'),
  FOREIGN KEY (`department_id`) REFERENCES `departments`(`department_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `employee_position_history` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `employee_id` INT NOT NULL,
  `position_id` INT NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE,
  `is_primary` BOOLEAN DEFAULT TRUE,
  `reporting_to` INT,
  FOREIGN KEY (`employee_id`) REFERENCES `employees`(`employee_id`) ON DELETE CASCADE,
  FOREIGN KEY (`position_id`) REFERENCES `positions`(`position_id`) ON DELETE RESTRICT,
  FOREIGN KEY (`reporting_to`) REFERENCES `employees`(`employee_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- USER AUTHENTICATION (3 tables)
CREATE TABLE `users` (
  `user_id` INT AUTO_INCREMENT PRIMARY KEY,
  `employee_id` INT UNIQUE,
  `username` VARCHAR(50) UNIQUE NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) UNIQUE NOT NULL,
  `role_id` INT NOT NULL,
  `last_login` DATETIME,
  `failed_login_attempts` INT DEFAULT 0,
  `account_locked` BOOLEAN DEFAULT FALSE,
  `password_changed_at` DATETIME,
  `must_change_password` BOOLEAN DEFAULT TRUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`employee_id`) REFERENCES `employees`(`employee_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `roles` (
  `role_id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(50) UNIQUE NOT NULL,
  `description` TEXT,
  `is_system` BOOLEAN DEFAULT FALSE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `permissions` (
  `permission_id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) UNIQUE NOT NULL,
  `description` TEXT,
  `category` VARCHAR(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- LEAVE MANAGEMENT (10 tables)
CREATE TABLE `leave_types` (
  `type_id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(50) NOT NULL,
  `code` VARCHAR(10) UNIQUE NOT NULL,
  `description` TEXT,
  `category` ENUM('vacation','sick','personal','maternity','paternity','bereavement','jury_duty','other') NOT NULL,
  `is_paid` BOOLEAN DEFAULT TRUE,
  `requires_approval` BOOLEAN DEFAULT TRUE,
  `min_notice_days` INT DEFAULT 1,
  `max_consecutive_days` INT,
  `max_days_per_request` INT,
  `max_days_per_year` INT,
  `allow_half_day` BOOLEAN DEFAULT FALSE,
  `carry_forward` BOOLEAN DEFAULT FALSE,
  `carry_forward_limit` INT,
  `carry_forward_expiry_months` INT,
  `gender_specific` ENUM('male','female','none') DEFAULT 'none',
  `tenure_restriction_days` INT DEFAULT 0,
  `is_active` BOOLEAN DEFAULT TRUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `leave_policies` (
  `policy_id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT,
  `effective_date` DATE NOT NULL,
  `is_default` BOOLEAN DEFAULT FALSE,
  `created_by` INT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`created_by`) REFERENCES `users`(`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `leave_policy_rules` (
  `rule_id` INT AUTO_INCREMENT PRIMARY KEY,
  `policy_id` INT NOT NULL,
  `type_id` INT NOT NULL,
  `accrual_frequency` ENUM('none','daily','weekly','monthly','quarterly','yearly') NOT NULL DEFAULT 'none',
  `accrual_rate` DECIMAL(5,2) NOT NULL DEFAULT 0.00,
  `max_balance` DECIMAL(5,2),
  `tenure_min_days` INT DEFAULT 0,
  `tenure_max_days` INT,
  `carry_forward_limit` INT,
  `carry_forward_expiry_months` INT,
  FOREIGN KEY (`policy_id`) REFERENCES `leave_policies`(`policy_id`) ON DELETE CASCADE,
  FOREIGN KEY (`type_id`) REFERENCES `leave_types`(`type_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `employee_leave_policies` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `employee_id` INT NOT NULL,
  `policy_id` INT NOT NULL,
  `effective_from` DATE NOT NULL,
  `effective_to` DATE,
  `assigned_by` INT,
  `assigned_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `unique_employee_policy` (`employee_id`, `policy_id`, `effective_from`),
  FOREIGN KEY (`employee_id`) REFERENCES `employees`(`employee_id`) ON DELETE CASCADE,
  FOREIGN KEY (`policy_id`) REFERENCES `leave_policies`(`policy_id`) ON DELETE RESTRICT,
  FOREIGN KEY (`assigned_by`) REFERENCES `users`(`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `employee_leave_balances` (
  `balance_id` INT AUTO_INCREMENT PRIMARY KEY,
  `employee_id` INT NOT NULL,
  `type_id` INT NOT NULL,
  `year` YEAR NOT NULL,
  `total_allocated` DECIMAL(5,2) NOT NULL,
  `total_used` DECIMAL(5,2) DEFAULT 0.00,
  `carried_forward` DECIMAL(5,2) DEFAULT 0.00,
  `pending_approval` DECIMAL(5,2) DEFAULT 0.00,
  `encashed` DECIMAL(5,2) DEFAULT 0.00,
  `notes` TEXT,
  UNIQUE KEY `unique_employee_leave_year` (`employee_id`, `type_id`, `year`),
  FOREIGN KEY (`employee_id`) REFERENCES `employees`(`employee_id`) ON DELETE CASCADE,
  FOREIGN KEY (`type_id`) REFERENCES `leave_types`(`type_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `leave_accruals` (
  `accrual_id` INT AUTO_INCREMENT PRIMARY KEY,
  `employee_id` INT NOT NULL,
  `type_id` INT NOT NULL,
  `accrual_date` DATE NOT NULL,
  `amount` DECIMAL(5,2) NOT NULL,
  `policy_rule_id` INT,
  `processed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `processed_by` INT,
  FOREIGN KEY (`employee_id`) REFERENCES `employees`(`employee_id`) ON DELETE CASCADE,
  FOREIGN KEY (`type_id`) REFERENCES `leave_types`(`type_id`) ON DELETE CASCADE,
  FOREIGN KEY (`policy_rule_id`) REFERENCES `leave_policy_rules`(`rule_id`) ON DELETE SET NULL,
  FOREIGN KEY (`processed_by`) REFERENCES `users`(`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `leave_applications` (
  `application_id` INT AUTO_INCREMENT PRIMARY KEY,
  `employee_id` INT NOT NULL,
  `type_id` INT NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `days` DECIMAL(5,2) NOT NULL,
  `is_half_day` BOOLEAN DEFAULT FALSE,
  `half_day_type` ENUM('first','second') NULL,
  `reason` TEXT NOT NULL,
  `status` ENUM('pending','approved','rejected','cancelled','recalled') DEFAULT 'pending',
  `applied_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `approved_by` INT,
  `approved_at` DATETIME,
  `rejection_reason` TEXT,
  `emergency_contact` VARCHAR(100),
  `address_during_leave` TEXT,
  `substitute_employee_id` INT,
  FOREIGN KEY (`employee_id`) REFERENCES `employees`(`employee_id`) ON DELETE CASCADE,
  FOREIGN KEY (`type_id`) REFERENCES `leave_types`(`type_id`) ON DELETE RESTRICT,
  FOREIGN KEY (`approved_by`) REFERENCES `users`(`user_id`) ON DELETE SET NULL,
  FOREIGN KEY (`substitute_employee_id`) REFERENCES `employees`(`employee_id`) ON DELETE SET NULL,
  INDEX `idx_status` (`status`),
  INDEX `idx_dates` (`start_date`, `end_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `leave_approval_workflow` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `application_id` INT NOT NULL,
  `approver_id` INT NOT NULL,
  `level` INT NOT NULL,
  `status` ENUM('pending','approved','rejected','delegated') DEFAULT 'pending',
  `comments` TEXT,
  `action_date` DATETIME,
  `delegated_to` INT,
  FOREIGN KEY (`application_id`) REFERENCES `leave_applications`(`application_id`) ON DELETE CASCADE,
  FOREIGN KEY (`approver_id`) REFERENCES `employees`(`employee_id`) ON DELETE CASCADE,
  FOREIGN KEY (`delegated_to`) REFERENCES `employees`(`employee_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `leave_blackout_periods` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `type_id` INT,
  `name` VARCHAR(100) NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `description` TEXT,
  `is_active` BOOLEAN DEFAULT TRUE,
  `created_by` INT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`type_id`) REFERENCES `leave_types`(`type_id`) ON DELETE CASCADE,
  FOREIGN KEY (`created_by`) REFERENCES `users`(`user_id`) ON DELETE SET NULL,
  INDEX `idx_dates` (`start_date`, `end_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `leave_attachments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `application_id` INT NOT NULL,
  `file_name` VARCHAR(255) NOT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `file_type` VARCHAR(50),
  `file_size` INT,
  `uploaded_by` INT NOT NULL,
  `uploaded_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`application_id`) REFERENCES `leave_applications`(`application_id`) ON DELETE CASCADE,
  FOREIGN KEY (`uploaded_by`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TIME & ATTENDANCE (4 tables)
CREATE TABLE `work_schedules` (
  `schedule_id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(50) NOT NULL,
  `description` TEXT,
  `is_default` BOOLEAN DEFAULT FALSE,
  `mon_start` TIME,
  `mon_end` TIME,
  `tue_start` TIME,
  `tue_end` TIME,
  `wed_start` TIME,
  `wed_end` TIME,
  `thu_start` TIME,
  `thu_end` TIME,
  `fri_start` TIME,
  `fri_end` TIME,
  `sat_start` TIME,
  `sat_end` TIME,
  `sun_start` TIME,
  `sun_end` TIME,
  `daily_hours` DECIMAL(4,2) GENERATED ALWAYS AS (
    (TIME_TO_SEC(COALESCE(mon_end,'00:00:00'))-TIME_TO_SEC(COALESCE(mon_start,'00:00:00'))+
    TIME_TO_SEC(COALESCE(tue_end,'00:00:00'))-TIME_TO_SEC(COALESCE(tue_start,'00:00:00'))+
    TIME_TO_SEC(COALESCE(wed_end,'00:00:00'))-TIME_TO_SEC(COALESCE(wed_start,'00:00:00'))+
    TIME_TO_SEC(COALESCE(thu_end,'00:00:00'))-TIME_TO_SEC(COALESCE(thu_start,'00:00:00'))+
    TIME_TO_SEC(COALESCE(fri_end,'00:00:00'))-TIME_TO_SEC(COALESCE(fri_start,'00:00:00'))+
    TIME_TO_SEC(COALESCE(sat_end,'00:00:00'))-TIME_TO_SEC(COALESCE(sat_start,'00:00:00'))+
    TIME_TO_SEC(COALESCE(sun_end,'00:00:00'))-TIME_TO_SEC(COALESCE(sun_start,'00:00:00'))
  )/3600/7) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `employee_schedules` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `employee_id` INT NOT NULL,
  `schedule_id` INT NOT NULL,
  `effective_from` DATE NOT NULL,
  `effective_to` DATE,
  `assigned_by` INT,
  `assigned_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`employee_id`) REFERENCES `employees`(`employee_id`) ON DELETE CASCADE,
  FOREIGN KEY (`schedule_id`) REFERENCES `work_schedules`(`schedule_id`) ON DELETE RESTRICT,
  FOREIGN KEY (`assigned_by`) REFERENCES `users`(`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `attendance_records` (
  `record_id` INT AUTO_INCREMENT PRIMARY KEY,
  `employee_id` INT NOT NULL,
  `date` DATE NOT NULL,
  `clock_in` DATETIME,
  `clock_out` DATETIME,
  `status` ENUM('present','absent','late','half_day','holiday','weekend','on_leave') NOT NULL,
  `leave_application_id` INT,
  `holiday_id` INT,
  `notes` TEXT,
  `verified_by` INT,
  `verified_at` DATETIME,
  UNIQUE KEY `unique_employee_date` (`employee_id`, `date`),
  FOREIGN KEY (`employee_id`) REFERENCES `employees`(`employee_id`) ON DELETE CASCADE,
  FOREIGN KEY (`leave_application_id`) REFERENCES `leave_applications`(`application_id`) ON DELETE SET NULL,
  FOREIGN KEY (`verified_by`) REFERENCES `users`(`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `attendance_adjustments` (
  `adjustment_id` INT AUTO_INCREMENT PRIMARY KEY,
  `record_id` INT NOT NULL,
  `adjusted_by` INT NOT NULL,
  `adjustment_type` ENUM('clock_in','clock_out','status','notes') NOT NULL,
  `old_value` TEXT,
  `new_value` TEXT,
  `reason` TEXT NOT NULL,
  `adjusted_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`record_id`) REFERENCES `attendance_records`(`record_id`) ON DELETE CASCADE,
  FOREIGN KEY (`adjusted_by`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- PAYROLL INTEGRATION (3 tables)
CREATE TABLE `pay_periods` (
  `period_id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(50) NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `pay_date` DATE NOT NULL,
  `status` ENUM('draft','locked','processed','paid') DEFAULT 'draft',
  `created_by` INT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`created_by`) REFERENCES `users`(`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `leave_encashment` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `employee_id` INT NOT NULL,
  `type_id` INT NOT NULL,
  `period_id` INT NOT NULL,
  `days_encashed` DECIMAL(5,2) NOT NULL,
  `rate` DECIMAL(10,2) NOT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `request_date` DATE NOT NULL,
  `processed_date` DATE,
  `status` ENUM('pending','approved','rejected','processed') DEFAULT 'pending',
  `approved_by` INT,
  `notes` TEXT,
  FOREIGN KEY (`employee_id`) REFERENCES `employees`(`employee_id`) ON DELETE CASCADE,
  FOREIGN KEY (`type_id`) REFERENCES `leave_types`(`type_id`) ON DELETE RESTRICT,
  FOREIGN KEY (`period_id`) REFERENCES `pay_periods`(`period_id`) ON DELETE RESTRICT,
  FOREIGN KEY (`approved_by`) REFERENCES `users`(`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `leave_impact_on_payroll` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `employee_id` INT NOT NULL,
  `period_id` INT NOT NULL,
  `application_id` INT,
  `type_id` INT NOT NULL,
  `days` DECIMAL(5,2) NOT NULL,
  `impact_type` ENUM('deduction','addition') NOT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `processed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`employee_id`) REFERENCES `employees`(`employee_id`) ON DELETE CASCADE,
  FOREIGN KEY (`period_id`) REFERENCES `pay_periods`(`period_id`) ON DELETE CASCADE,
  FOREIGN KEY (`application_id`) REFERENCES `leave_applications`(`application_id`) ON DELETE SET NULL,
  FOREIGN KEY (`type_id`) REFERENCES `leave_types`(`type_id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- NOTIFICATIONS & AUDITING (3 tables)
CREATE TABLE `notifications` (
  `notification_id` INT AUTO_INCREMENT PRIMARY KEY,
  `recipient_id` INT NOT NULL,
  `sender_id` INT,
  `title` VARCHAR(100) NOT NULL,
  `message` TEXT NOT NULL,
  `type` ENUM('leave','approval','attendance','payroll','system','other') NOT NULL,
  `related_id` INT,
  `related_type` VARCHAR(50),
  `is_read` BOOLEAN DEFAULT FALSE,
  `read_at` DATETIME,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`recipient_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE,
  FOREIGN KEY (`sender_id`) REFERENCES `users`(`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `audit_logs` (
  `log_id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT,
  `action` VARCHAR(50) NOT NULL,
  `table_name` VARCHAR(50) NOT NULL,
  `record_id` INT,
  `old_values` JSON,
  `new_values` JSON,
  `ip_address` VARCHAR(45),
  `user_agent` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `system_settings` (
  `setting_id` INT AUTO_INCREMENT PRIMARY KEY,
  `setting_key` VARCHAR(50) UNIQUE NOT NULL,
  `setting_value` TEXT NOT NULL,
  `data_type` ENUM('string','number','boolean','json','date') NOT NULL,
  `description` TEXT,
  `is_public` BOOLEAN DEFAULT FALSE,
  `updated_by` INT,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`updated_by`) REFERENCES `users`(`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
