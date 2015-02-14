<?php
/**
 * General Options (Example Page)
 */
class SFM_General_Settings_Admin{

    /**
     * Option key, and option page slug
     * @var string
     */
    protected static $key = 'sfm_general_settings';

    /**
     * Array of metaboxes/fields
     * @var array
     */
    protected static $general_settings = array();

    /**
     * Options Page title
     * @var string
     */
    protected $title = 'SFM Settings';

    /**
     * Constructor
     * @since 0.1.0
     */
    public function __construct() {
        // Set our title
        $this->title = __( 'SFM Settings', 'bonestheme' );
    }

    /**
     * Initiate our hooks
     * @since 0.1.0
     */
    public function hooks() {
        add_action( 'admin_init', array( $this, 'sfm_general_settings_init' ) );
        add_action( 'admin_menu', array( $this, 'add_page' ) );
    }

    /**
     * Register our setting to WP
     * @since  0.1.0
     */
    public function sfm_general_settings_init() {
        register_setting( self::$key, self::$key );
    }

    /**
     * Add menu options page
     * @since 0.1.0
     */
    public function add_page() {
        $this->options_page = add_menu_page( 'SFM Starter Settings', $this->title, 'manage_options', self::$key, array( $this, 'admin_page_display' ), '', 85 );
        add_action( 'admin_head-' . $this->options_page, array( $this, 'admin_head' ) );
    }

    /**
     * CSS, etc
     * @since  0.1.0
     */
    public function admin_head() {
        // CSS, etc
    }

    /**
     * Admin page markup. Mostly handled by CMB
     * @since  0.1.0
     */
    public function admin_page_display() {
        ?>
        <div class="wrap cmb_options_page <?php echo self::$key; ?>">
            <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
            <p>An example general settings page for the SFM Starter theme.  To create a real settings page, edit the file "sfm-starter-example-options-page.php" located in the "includes" folder within the main SFM Starter plugin folder.</p>
            <?php cmb_metabox_form( $this->option_fields(), self::$key ); ?>
        </div>
        <?php
    }

    /**
     * Defines the theme option metabox and field configuration
     * @since  0.1.0
     * @return array
     */
    public static function option_fields() {
        $prefix = 'sfm_general_setting_';
        // Only need to initiate the array once per page-load
        if ( ! empty( self::$general_settings ) )
            return self::$general_settings;
        $fields = array(
            array(
                'name' => 'Logo',
                'desc' => 'Here you can upload a logo.',
                'id'   => $prefix . 'logo',
                'type' => 'file',
                'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
            ),
            array(
                'name' => 'Leaderboard Ad',
                'desc' => 'A textarea for code, for example code for a leaderboard ad from an Ad Server',
                'id'   => $prefix . 'leaderboard_ad',
                'type' => 'textarea_code'
            ),
            array(
                'name' => 'Primary 300 x 250px Ad',
                'desc' => 'Another code textarea for another ad.',
                'id'   => $prefix . 'primary300',
                'type' => 'textarea_code'
            )
        );
        self::$general_settings = array(
            'id'         => 'sfm_general_settings',
            'show_on'    => array( 'key' => 'options-page', 'value' => array( self::$key, ), ),
            'show_names' => true,
            'fields'     => $fields,
        );
        return self::$general_settings;
    }

    /**
     * Make public the protected $key variable.
     * @since  0.1.0
     * @return string  Option key
     */
    public static function key() {
        return self::$key;
    }

}
// Get it started
$SFM_General_Settings_Admin = new SFM_General_Settings_Admin();
$SFM_General_Settings_Admin->hooks();

/**
 * Wrapper function around cmb_get_option
 * @since  0.1.0
 * @param  string  $key Options array key
 * @return mixed        Option value
 */
function sfm_general_settings_get_option( $key = '' ) {
    return cmb_get_option( SFM_General_Settings_Admin::key(), $key );
}
?>