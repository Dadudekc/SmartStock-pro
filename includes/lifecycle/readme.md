# Lifecycle Directory

The `lifecycle` directory contains classes that manage the SmartStock Pro plugin's lifecycle events, including activation, deactivation, and uninstallation. These classes ensure that the plugin initializes and cleans up resources efficiently and securely.

---

## Overview of Lifecycle Classes

### **1. `SSP_Activation`**
- **Purpose:** Handles tasks to set up the plugin when activated.
- **Key Features:**
  - Creates necessary database tables.
  - Clears and initializes caches.
  - Schedules cron jobs for background tasks.
  - Logs activation events for debugging and tracking.

- **Suggested Improvements:**
  - Add validation to ensure database tables are created successfully.
  - Log specific actions performed during activation for transparency.
  - Handle partial activations gracefully by retrying failed tasks.

---

### **2. `SSP_Deactivation`**
- **Purpose:** Manages tasks when the plugin is deactivated.
- **Key Features:**
  - Unschedules cron jobs to prevent unnecessary server load.
  - Logs deactivation events to track plugin lifecycle transitions.

- **Suggested Improvements:**
  - Add a flag to mark temporary deactivation for easier troubleshooting.
  - Ensure any remaining background processes are stopped cleanly.

---

### **3. `SSP_Uninstall`**
- **Purpose:** Handles tasks to clean up resources when the plugin is uninstalled.
- **Key Features:**
  - Deletes database tables used by the plugin.
  - Clears caches and removes plugin-specific options.
  - Logs uninstallation events for debugging and tracking.
  - Provides a filter (`ssp_uninstall_cleanup`) to allow custom cleanup tasks.

- **Suggested Improvements:**
  - Add user confirmation before proceeding with irreversible actions like data deletion.
  - Backup data before uninstallation as an optional feature.
  - Implement error reporting for any cleanup tasks that fail.

---

## Directory Structure
```
includes/
└── lifecycle/
    ├── class-ssp-activation.php  # Handles plugin activation tasks
    ├── class-ssp-deactivation.php  # Manages plugin deactivation tasks
    └── class-ssp-uninstall.php  # Cleans up resources during uninstallation
```

---

## Usage Guidelines
- **Single Responsibility:** Each class is responsible for handling a specific lifecycle event (activation, deactivation, uninstallation).
- **Logging:** Use `SSP_Logger` to track events and ensure smooth debugging in production.
- **Extensibility:** Leverage filters and hooks provided by these classes to customize lifecycle behavior.

---

## Example Workflow

### Plugin Activation
- Tasks performed:
  - Database tables are created using `SSP_Alerts_Handler::create_alerts_table()`.
  - Caches are initialized via `SSP_Cache_Manager::clear_cache()`.
  - Cron jobs are scheduled using `SSP_Alerts_Cron::schedule_cron()`.
  - Logs are written using `SSP_Logger::log()`.

### Plugin Deactivation
- Tasks performed:
  - Cron jobs are unscheduled using `SSP_Alerts_Cron::unschedule_cron()`.
  - Logs are written to indicate deactivation.

### Plugin Uninstallation
- Tasks performed:
  - Database tables are deleted via `SSP_Alerts_Handler::delete_alerts_table()`.
  - Caches are cleared using `SSP_Cache_Manager::clear_cache()`.
  - Plugin options are deleted using `delete_option()` for keys like `ssp_settings` and `ssp_api_usage`.
  - Logs are written to track uninstallation progress.

---

## Future Improvements
1. **Enhanced Security:**
   - Require admin-level permissions for lifecycle operations.
   - Validate database operations to prevent accidental data loss.

2. **Error Handling:**
   - Log errors encountered during lifecycle operations for troubleshooting.
   - Retry failed operations, such as database creation or deletion.

3. **User Experience:**
   - Provide a confirmation dialog for uninstallation to prevent accidental data loss.
   - Display detailed status messages during activation, deactivation, and uninstallation.

4. **Extensibility:**
   - Allow developers to hook into lifecycle events to extend functionality (e.g., custom cleanup tasks).

---

## Contributions
To contribute to the `lifecycle` directory:
- Ensure all lifecycle operations are secure and efficient.
- Follow WordPress coding standards.
- Provide detailed inline documentation for any new classes or methods.
- Test lifecycle operations thoroughly to avoid potential conflicts or issues.

---

### Example Usage

#### Activating the Plugin
```php
register_activation_hook(__FILE__, ['SSP_Activation', 'handle']);
```

#### Deactivating the Plugin
```php
register_deactivation_hook(__FILE__, ['SSP_Deactivation', 'handle']);
```

#### Uninstalling the Plugin
```php
register_uninstall_hook(__FILE__, ['SSP_Uninstall', 'handle']);
```

This directory ensures the plugin's lifecycle is managed efficiently, maintaining a seamless user experience and minimizing server overhead.
