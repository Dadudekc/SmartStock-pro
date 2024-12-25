<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Class SSP_Activation
 * Handles plugin activation tasks.
 */
class SSP_Activation {
    /**
     * Handle plugin activation.
     */
    public static function handle() {
        try {
            // Create necessary database tables
            if (class_exists('SSP_Alerts_Handler')) {
                SSP_Alerts_Handler::create_alerts_table();
            } else {
                SSP_Logger::log('ERROR', 'SSP_Alerts_Handler class not found during activation.');
            }

            // Initialize cache
            if (class_exists('SSP_Cache_Manager')) {
                SSP_Cache_Manager::clear_cache();
            } else {
                SSP_Logger::log('ERROR', 'SSP_Cache_Manager class not found during activation.');
            }

            // Schedule cron jobs
            if (class_exists('SSP_Alerts_Cron')) {
                SSP_Alerts_Cron::schedule_cron();
            } else {
                SSP_Logger::log('ERROR', 'SSP_Alerts_Cron class not found during activation.');
            }

            // Initialize analytics
            if (class_exists('SSP_Analytics')) {
                $analytics = new SSP_Analytics();
                // Add any required analytics initialization
            } else {
                SSP_Logger::log('ERROR', 'SSP_Analytics class not found during activation.');
            }

            // Perform any additional setup tasks
            // Add hooks, settings initialization, or file creation if needed

            SSP_Logger::log('INFO', 'Plugin activated and necessary setups completed.');
        } catch (Exception $e) {
            SSP_Logger::log('ERROR', 'Plugin activation failed: ' . $e->getMessage());
        }
    }
}
?>
