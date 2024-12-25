# SmartStock Pro Plugin Documentation

## Overview
SmartStock Pro is a comprehensive WordPress plugin designed to provide advanced tools for stock research, AI-powered trade planning, customizable alerts, and enhanced analytics. Built for ease of use and extensibility, this plugin integrates with popular financial APIs to deliver real-time data and actionable insights.

## Features

### 1. Stock Research and AI-Generated Trade Plans
- Fetch stock quotes and historical data from Alpha Vantage and yFinance.
- Use AI to generate detailed trade plans based on stock data and sentiment analysis.

### 2. Customizable Alerts
- Set price-based and sentiment-based alerts.
- Real-time notifications via email.
- Alert management through a user-friendly interface.

### 3. Analytics and Sentiment Analysis
- Integrated with OpenAI for advanced sentiment analysis.
- Track API usage and alert performance through detailed analytics.

### 4. Shortcodes for Front-End Integration
- Shortcodes for stock research forms and alert setup.
- Dynamic, AJAX-powered forms for seamless user experience.

### 5. Robust Lifecycle Management
- Dedicated handlers for activation, deactivation, and uninstallation.
- Automatic database table creation and cleanup.

### 6. Performance Optimizations
- Caching mechanisms for API responses.
- Retry logic and exponential backoff for API requests.
- Support for multiple API keys with fallback handling.

## Directory Structure

```plaintext
includes/
├── utils/
│   ├── class-ssp-logger.php         # Logging utility.
│   ├── class-ssp-error.php          # Error handling.
│   ├── class-ssp-analytics.php      # Analytics tracking.
│   ├── class-plugin-update-checker.php # GitHub update checker.
│
├── admin/
│   ├── class-ssp-admin-notices.php  # Admin notices.
│   ├── class-ssp-settings.php       # Plugin settings.
│   ├── class-ssp-shortcodes.php     # Shortcode handling.
│   ├── class-ssp-log-viewer.php     # Log file viewer.
│
├── api/
│   ├── class-ssp-api-requests.php   # API request handler.
│   ├── class-ssp-alpha-vantage.php  # Alpha Vantage integration.
│   ├── class-ssp-finnhub.php        # Finnhub integration.
│   ├── interface-ssp-openai-service.php  # OpenAI interface.
│   ├── class-ssp-trade-plan-generator.php # Trade plan generator.
│
├── alerts/
│   ├── class-ssp-alerts-handler.php # Alert creation and management.
│   ├── class-ssp-alerts-cron.php    # Cron jobs for alerts.
│
├── ajax/
│   ├── class-ssp-ajax-handlers.php  # AJAX request handlers.
│
├── cache/
│   ├── class-ssp-cache-manager.php  # Caching utility.
│
├── lifecycle/
│   ├── class-ssp-activation.php     # Activation handler.
│   ├── class-ssp-deactivation.php   # Deactivation handler.
│   ├── class-ssp-uninstall.php      # Uninstallation handler.
```

## Installation

1. Clone or download the repository from GitHub:
   ```bash
   git clone https://github.com/dadudekc/smartstock-pro.git
   ```
2. Upload the plugin folder to the `wp-content/plugins` directory of your WordPress installation.
3. Activate the plugin through the WordPress admin panel.
4. Configure API keys and settings under the plugin's settings menu.

## Usage

### Shortcodes

#### 1. Stock Research Form
```plaintext
[stock_research]
```
- Displays a form for fetching stock data and generating trade plans.

#### 2. Alert Setup Form
```plaintext
[alert_setup]
```
- Displays a form for setting up stock alerts.

### AJAX Endpoints
- `ssp_fetch_stock_data`: Fetches stock data and generates a trade plan.
- `ssp_set_alert`: Creates a new stock alert.

## API Integrations

### Alpha Vantage
- Fetches real-time stock quotes and historical data.
- Uses fallback API keys to handle rate limits.

### Finnhub
- Retrieves news and sentiment data for stocks.

### OpenAI
- Generates trade plans and performs sentiment analysis.

## Logging
- All plugin activities are logged to `debug.log` located in the plugin's directory.
- Logs can be viewed in the WordPress admin interface.

## Development Notes

- **Version:** 2.2.1
- **Dependencies:** Ensure PHP 7.4+ and WordPress 5.8+ are installed.
- **Extensibility:** Hooks and filters are provided for developers to extend functionality.
- **Fallback Mechanisms:** yFinance is used when Alpha Vantage limits are exceeded.

## License

This plugin is open-source and available under the MIT license. Contributions are welcome.

