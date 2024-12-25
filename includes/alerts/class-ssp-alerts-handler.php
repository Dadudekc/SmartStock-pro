if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Class SSP_Alerts_Handler
 * Handles creation and management of user alerts.
 */
class SSP_Alerts_Handler {
    /**
     * Initialize the alerts handler.
     * Registers hooks and other setup tasks.
     */
    public static function init() {
        add_action('ssp_cron_check_alerts', [__CLASS__, 'process_alerts']);
    }

    /**
     * Create alerts table upon plugin activation.
     */
    public static function create_alerts_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ssp_alerts';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            email varchar(100) NOT NULL,
            stock_symbol varchar(10) NOT NULL,
            alert_type varchar(20) NOT NULL,
            condition_value varchar(50) NOT NULL,
            active tinyint(1) DEFAULT 1 NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        SSP_Logger::log('INFO', "Alerts table created or already exists.");
    }

    /**
     * Delete alerts table upon plugin uninstall.
     */
    public static function delete_alerts_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ssp_alerts';

        $sql = "DROP TABLE IF EXISTS $table_name;";
        $wpdb->query($sql);

        SSP_Logger::log('INFO', "Alerts table removed.");
    }

    /**
     * Retrieve all active alerts.
     *
     * @return array List of active alerts.
     */
    public static function get_active_alerts(): array {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ssp_alerts';

        $sql = $wpdb->prepare("SELECT * FROM $table_name WHERE active = %d", 1);
        $alerts = $wpdb->get_results($sql, ARRAY_A);

        SSP_Logger::log('INFO', 'Retrieved active alerts from database.');

        return $alerts;
    }

    /**
     * Deactivate an alert after it has been triggered.
     *
     * @param int $alert_id Alert ID to deactivate.
     */
    public static function deactivate_alert(int $alert_id): void {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ssp_alerts';

        $updated = $wpdb->update(
            $table_name,
            ['active' => 0],
            ['id' => $alert_id],
            ['%d'],
            ['%d']
        );

        if ($updated !== false) {
            SSP_Logger::log('INFO', "Alert ID $alert_id deactivated.");
        } else {
            SSP_Logger::log('ERROR', "Failed to deactivate Alert ID $alert_id.");
        }
    }

    /**
     * Process active alerts.
     * This function runs periodically via a cron job.
     */
    public static function process_alerts() {
        $alerts = self::get_active_alerts();

        foreach ($alerts as $alert) {
            // Logic to process each alert
            SSP_Logger::log('INFO', "Processing alert ID {$alert['id']} for stock {$alert['stock_symbol']}.");
        }
    }
}
