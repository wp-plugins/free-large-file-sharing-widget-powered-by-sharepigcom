<?php


include_once('FreeFileSharingFromSharepigcom_LifeCycle.php');

class FreeFileSharingFromSharepigcom_Plugin extends FreeFileSharingFromSharepigcom_LifeCycle {

    /**
     * @return array of option meta data.
     */
    public function getOptionMetaData() {
        return array(
            //'_version' => array('Installed Version'), // Leave this one commented-out. Uncomment to test upgrades.
            'DashboardID' => array(__('SharePig Dashboard ID<br/> (<a target="_blank" href="http://www.sharepig.com">Click here</a> and enter the Dashboard ID)', 'free-file-sharing-sharepig')),
            'widgetHeight' => array(__('File Upload Widget Height<br/> (e.g 250)', 'free-file-sharing-sharepig')),
            'widgetWidth' => array(__('File Upload Widget Width<br/> (e.g 350)', 'free-file-sharing-sharepig')),
        );
    }


    protected function initOptions() {
        $options = $this->getOptionMetaData();
        if (!empty($options)) {
            foreach ($options as $key => $arr) {
                if (is_array($arr) && count($arr > 1)) {
                    $this->addOption($key, $arr[1]);
                }
            }
        }
    }

    public function getPluginDisplayName() {
        return 'Free File Sharing from Sharepig.com';
    }

    protected function getMainPluginFileName() {
        return 'free-file-sharing-from-sharepigcom.php';
    }

    /**
     * Called by install() to create any database tables if needed.
     * Best Practice:
     * (1) Prefix all table names with $wpdb->prefix
     * (2) make table names lower case only
     * @return void
     */
    protected function installDatabaseTables() {
        //        global $wpdb;
        //        $tableName = $this->prefixTableName('mytable');
        //        $wpdb->query("CREATE TABLE IF NOT EXISTS `$tableName` (
        //            `id` INTEGER NOT NULL");
    }

    /**
     * Drop plugin-created tables on uninstall.
     * @return void
     */
    protected function unInstallDatabaseTables() {
        //        global $wpdb;
        //        $tableName = $this->prefixTableName('mytable');
        //        $wpdb->query("DROP TABLE IF EXISTS `$tableName`");
    }


    /**
     * Perform actions when upgrading from version X to version Y
     * @return void
     */
    public function upgrade() {
    }

    public function addActionsAndFilters() {

        // Add options administration page
        add_action('admin_menu', array(&$this, 'addSettingsSubMenuPage'));
        add_shortcode('sharepig-file-upload', array($this, 'sharePigWidget'));
        wp_enqueue_script('jquery');
        wp_enqueue_style('my-style', plugins_url('/css/dropzone.css', __FILE__));
        wp_enqueue_script('my-script', plugins_url('/js/dropzone.js', __FILE__));
        wp_enqueue_script('my-script', plugins_url('/js/dropzone-amd-module.js', __FILE__));

        // Example adding a script & style just for the options administration page
        //        if (strpos($_SERVER['REQUEST_URI'], $this->getSettingsSlug()) !== false) {
        //            wp_enqueue_script('my-script', plugins_url('/js/my-script.js', __FILE__));
        //            wp_enqueue_style('my-style', plugins_url('/css/my-style.css', __FILE__));
        //        }


        // Add Actions & Filters




    }
    public function sharePigWidget() {

        $option = $this->getOption('DashboardID');
        $height = $this->getOption('widgetHeight');
        $width = $this->getOption('widgetWidth');
        if(empty($height)){
            $height = 250;
        }
        if(empty($width)){
            $width = 350;
        }
        $content = '<div id="sharePigUpload" style="height:'.$height.'px;width:'.$width.'px"><form action="http://www.sharepig.com/index.php/externalUpload/'.$option.'" class="dropzone dz-clickable" id="filemanager">
        <div class="dz-default dz-message"><span>Drop files here to upload</span></div>

    </form>
    <div class="poweredBy">Powered by <a href="http://www.sharepig.com" target="_blank">SharePig.com</a></div>
    </div>
    ';
        return $content;
    }

}
