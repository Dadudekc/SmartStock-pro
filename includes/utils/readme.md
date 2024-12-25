# Utils Directory

The `utils` directory contains utility classes and functions that provide essential support for the SmartStock Pro plugin. These utilities centralize reusable logic, enhance plugin functionality, and focus on improving security, efficiency, and maintainability.

---

## Overview of Utility Classes

### **1. `class-ssp-logger.php`**
- **Purpose:** Handles logging of plugin activities for debugging and tracking.
- **Key Features:**
  - Ensures the log file exists and is writable.
  - Logs messages with levels (`INFO`, `ERROR`, `WARNING`).
  - Uses the plugin’s log file (`debug.log`) or PHP's error log as a fallback.
- **Suggested Improvements:**
  - **Custom Log Levels:** Extend logging levels to include `DEBUG` and `CRITICAL` for more granularity.
  - **File Rotation:** Implement log file rotation to archive older logs and prevent the file from growing indefinitely.
  - **Log Context:** Add support for contextual data (e.g., user actions, API requests) to help with debugging.
  - **Error Handling:** Add error handling when writing to the log file to ensure the plugin gracefully handles logging failures.
  - **WP-CLI Support:** Include functions to view or manage logs via WP-CLI for easier debugging in production environments.

### **2. `class-ssp-error.php`**
- **Purpose:** Custom exception class for handling plugin-specific errors.
- **Key Features:**
  - Supports custom error messages and codes.
  - Provides a structured approach to error handling across the plugin.
- **Suggested Improvements:**
  - **Logging Support:** Extend the class to log errors automatically using `SSP_Logger` for better debugging.
  - **Error Context:** Add support for passing additional context (e.g., stack trace, user ID, API request data) for detailed debugging.
  - **Standardized Error Codes:** Define a centralized registry for error codes to ensure consistent usage across the plugin.
  - **Error Severity Levels:** Introduce severity levels (e.g., `INFO`, `WARNING`, `CRITICAL`) to categorize errors for easier triage.

### **3. `class-ssp-analytics.php`**
- **Purpose:** Tracks API usage and user interactions within the plugin.
- **Key Features:**
  - Tracks the frequency and duration of API calls.
  - Stores analytics data in WordPress options.
  - Provides methods to retrieve and reset analytics data.
- **Suggested Improvements:**
  - **Security:**
    - Validate `event` and `time_taken` inputs to ensure data integrity.
    - Use a dedicated database table for storing analytics data for better control and performance.
  - **Performance:**
    - Use a caching mechanism (e.g., transients) for frequently accessed statistics.
    - Batch update analytics data periodically to reduce database writes.
  - **Extensibility:**
    - Add hooks to allow developers to track custom events.
    - Provide a UI in the admin dashboard to display analytics data and reset options.

### **4. `class-plugin-update-checker.php`**
- **Purpose:** Checks for plugin updates from a GitHub repository.
- **Key Features:**
  - Fetches the latest release from GitHub.
  - Integrates with WordPress' plugin update system.
  - Provides metadata for the WordPress Plugin API.
- **Suggested Improvements:**
  - **Security:**
    - Validate GitHub API response data more thoroughly to prevent invalid updates.
    - Handle edge cases like missing or malformed JSON responses.
  - **Performance:**
    - Cache the latest release data in a transient to minimize API calls.
    - Use WordPress filters to allow customization of GitHub API timeout values.
  - **Extensibility:**
    - Add support for pre-release versions or specific branches.
    - Allow developers to override the GitHub URL or slug dynamically.

### **5. `class-ssp-helper.php`**
- **Purpose:** Provides general-purpose helper functions.
- **Key Features:**
  - Validates and sanitizes stock symbols.
  - Formats monetary values.
  - Manages nonces and simplifies request handling.
  - Escapes output for security and ensures consistent logging.
- **Suggested Improvements:**
  - **Expand Helper Functions:** Continuously add more helper functions as new features are developed to cover additional repetitive tasks.
  - **Localization Enhancements:** Ensure all helper functions that output text support localization for broader accessibility.
  - **Enhanced Validation:** Incorporate more comprehensive validation rules for different types of inputs as the plugin scales.

---

## Planned Future Utility Classes

### **1. `class-ssp-file-handler.php`**
- **Purpose:** Centralized file handling for reading, writing, or deleting plugin-related files (e.g., logs, cached data).
- **Potential Features:**
  - Safe reading, writing, and deletion of files with error handling.
  - Clearing cache directories or specific files.
  - Checking and managing file permissions.
- **Integration:**
  - Supports `SSP_Cache_Manager` and ensures safe file operations for `SSP_Logger`.

### **2. `class-ssp-validator.php`**
- **Purpose:** Input validation and sanitization utility.
- **Potential Features:**
  - Validate stock symbols, numeric ranges, and user inputs.
  - Predefined rules for email validation, date format validation, etc.
- **Integration:**
  - Used in `ajax handlers`, `settings`, and `alerts`.

### **3. `class-ssp-encryptor.php`**
- **Purpose:** Secure sensitive data such as API keys, alerts, or user-specific preferences.
- **Potential Features:**
  - Encrypt and decrypt sensitive data using WordPress `wp_salt()` or a secure encryption library.
  - Mask sensitive data for logs or debugging (e.g., `abc123` → `***123`).
- **Integration:**
  - Used in `settings` to store sensitive data securely.
  - Supports `SSP_Alerts_Handler` for encrypting alert conditions.

### **4. `class-ssp-api-client.php`**
- **Purpose:** Abstract API requests to external services like Alpha Vantage, Finnhub, and OpenAI.
- **Potential Features:**
  - Centralize HTTP request handling (`wp_remote_get`, `wp_remote_post`).
  - Retry mechanism for transient API failures.
  - Standardize error handling and logging for API failures.
- **Integration:**
  - All API integrations (`Alpha Vantage`, `Finnhub`, `OpenAI`) use this class as a base.

### **5. `class-ssp-rate-limiter.php`**
- **Purpose:** Implement rate limiting to avoid exceeding API quotas or spamming requests.
- **Potential Features:**
  - Monitor API usage in real time.
  - Implement cool-down periods or delays for excessive requests.
- **Integration:**
  - Works alongside `SSP_Analytics` to manage and enforce API limits.

### **6. `class-ssp-security.php`**
- **Purpose:** Harden plugin security against common vulnerabilities.
- **Potential Features:**
  - Generate secure nonces for AJAX or form submissions.
  - Validate WordPress user permissions.
  - Check plugin integrity (e.g., file modification alerts).
- **Integration:**
  - Used across the entire plugin for secure operations.

### **7. `class-ssp-cache-handler.php`**
- **Purpose:** Simplify caching for API results and computed data.
- **Potential Features:**
  - Create, read, and delete transient-based or file-based caches.
  - Define cache expiry policies for different data types.
- **Integration:**
  - Supports API-related classes (`Alpha Vantage`, `OpenAI`) and boosts plugin performance.

---

## Usage Guidelines
- **Single Responsibility:** Each class is designed to serve a specific utility purpose. Use these classes to avoid code duplication and ensure consistency across the plugin.
- **Inclusion:** Include utility classes where needed using `require_once` or implement an autoloader for dynamic class loading.
- **Sanitization & Validation:** Always sanitize and validate inputs using `SSP_Helper` and `SSP_Validator` to secure operations against vulnerabilities.
- **Logging:** Utilize `SSP_Logger` for consistent and centralized logging throughout the plugin.
- **Extensibility:** Leverage hooks provided in utility classes to customize and extend functionality as needed.

---

## Future Improvements

### **Security**
1. **PluginUpdateChecker:**
   - Validate GitHub API response data more thoroughly to prevent invalid updates.
   - Handle edge cases like missing or malformed JSON responses.
2. **SSP_Security:**
   - Implement file integrity checks to detect unauthorized modifications.
   - Enhance nonce management for additional security layers.

### **Performance**
1. **Caching:**
   - Introduce caching mechanisms for frequently accessed analytics and API responses to improve performance.
   - Periodically batch update data to minimize database writes and reduce load.
2. **SSP_Analytics:**
   - Utilize transients for caching API usage statistics.
   - Optimize data retrieval methods for faster access.

### **Extensibility**
1. **Hooks & Filters:**
   - Provide hooks in utility classes to allow developers to extend functionality without modifying core files.
   - Enable dynamic configuration for GitHub repository settings or API endpoints through filters.
2. **SSP_Helper:**
   - Continuously expand helper functions to cover new repetitive tasks as the plugin evolves.
   - Ensure all helper functions support localization for broader accessibility.

---

## Contributions
Contributors should:
1. **Follow Standards:** Adhere to WordPress coding standards for consistency and maintainability.
2. **Focused Development:** Write utility classes with a clear, single responsibility to maintain clarity and reduce redundancy.
3. **Documentation:** Provide inline documentation and update this README to include descriptions of new utility classes.
4. **Testing:** Ensure new functionalities are covered with appropriate unit tests to guarantee reliability.
5. **Security Practices:** Implement and follow best security practices when adding new utilities or enhancing existing ones.

---
Copy code
```
## Directory Structure
includes/ 
└── utils/ 
├── class-ssp-logger.php # Handles logging 
├── class-ssp-error.php # Custom exception class 
├── class-ssp-analytics.php # Tracks API usage and interactions 
├── class-plugin-update-checker.php # Manages GitHub plugin updates 
├── class-ssp-helper.php # General-purpose helper functions 
(future files)
├── class-ssp-file-handler.php # Centralized file operations 
├── class-ssp-validator.php # Input validation and sanitization 
├── class-ssp-encryptor.php # Secure data encryption and decryption 
├── class-ssp-api-client.php # Abstracts external API requests 
├── class-ssp-rate-limiter.php # Implements rate limiting for API calls 
├── class-ssp-security.php # Enhances plugin security 
└── class-ssp-cache-handler.php # Manages caching of API results and data


handler.php # Manages caching of API results and data

```
---

## Example Usage

### Logging Events
```php
SSP_Logger::log('INFO', 'This is a log message.');
Validating Stock Symbols
```

```php
$symbol = SSP_Helper::sanitize_stock_symbol('AAPL');
if (!$symbol) {
    echo 'Invalid stock symbol.';
}
Tracking API Usage
```


```php
$analytics = new SSP_Analytics();
$analytics->track_api_usage('analyze_sentiment', 1.23);
Generating and Validating Nonces
```

```php
// Generating a nonce
$nonce = SSP_Helper::generate_nonce('ssp_action');

// Validating a nonce
if (SSP_Helper::validate_nonce($_POST['nonce'], 'ssp_action')) {
    // Proceed with action
} else {
    // Handle invalid nonce
}
Formatting Monetary Values
```

```

echo SSP_Helper::format_money(1234.56); // Outputs: $1,234.56
```






