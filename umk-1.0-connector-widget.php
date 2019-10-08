<?php

/**
 * User: Mikhail Nemchinov (http://nemchinov.pro)
 * Date: 26.09.16
 * Time: 0:08
 */
class umkWidget extends WP_Widget {

    function umkWidget() {
        $widget_ops = array(
            'classname' => 'umkWidget',
            'description' => __('Вывести актуальный номер версии УМК', 'umkWidget')
        );

        $this->WP_Widget('umkWidget', __('УМК: Номер версии', 'umkWidget'), $widget_ops);
        $this->alt_option_name = 'umkWidget';

        add_action('save_post', array(&$this, 'flush_widget_cache'));
        add_action('deleted_post', array(&$this, 'flush_widget_cache'));
        add_action('switch_theme', array(&$this, 'flush_widget_cache'));
    }

    /**
     * Outputs the HTML for this widget.
     *
     * @param array An array of standard parameters for widgets in this theme
     * @param array An array of settings for this widget instance
     * @return void Echoes it's output
     * */
    function widget($args, $instance) {
        global $wpdb, $assetsUrl, $filetype_icons;

        $cache = wp_cache_get('umkWidget', 'widget');

        if (!is_array($cache))
            $cache = array();

        if (!isset($args['widget_id']))
            $args['widget_id'] = null;

        if (isset($cache[$args['widget_id']])) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract($args, EXTR_SKIP);

        echo $before_widget;
        echo $before_title;
        echo $after_title;

        $url = get_option('umk_typeConnection') . "://" . get_option('umk_server') . "/" . get_option('umk_publicName') . "/hs/api/getversion";
        $User = get_option('umk_user');
        $Pass = get_option('umk_pass');
        ?>
        <p><strong>Актуальный релиз программы</strong>
        </p>
        <p> <?php
            try {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                curl_setopt($ch, CURLOPT_USERPWD, "$User:$Pass");
                $response = curl_exec($ch);
                curl_close($ch);
                echo $response;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            ?>
        </p>
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        
    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     * */
    function form($instance) {
        ?>  
        <p>Вывести актуальный номер версии УМК</p>
        <?php
    }

}
