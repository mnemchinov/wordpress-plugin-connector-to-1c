<?php
/*
  Plugin Name: UMK 1.0 connector
  Plugin URI:
  Description: <strong>Конектор к программе Учетмикрокредитов 1.0</strong>
  Version: 0.1
  Author: Mikhail Nemchinov
  Author URI: http://nemchinov.pro
  License: MIT
 */

/**
 * Plugin version
 * 
 * @var string
 */
define('SP_VERSION', '0.1');

/**
 * Path to the plugin directory
 * 
 * @var string
 */
define('UMK_DIR', plugin_dir_path(__FILE__));
define('UMK_URL', plugin_dir_url(__FILE__));

function umk_admin_menu() {
    add_options_page('УМК 1.0', 'УМК 1.0', 8, basename(__FILE__), 'create_umk_parametrs');
}

add_action('admin_menu', 'umk_admin_menu');

function create_umk_parametrs() {
    ?>

    <div class="wrap">
        <h1>Настройки</h1>
        <hr/>
        <form method="post" action="options.php">
            <?php wp_nonce_field('update-options'); ?>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><label for="start_of_week">Тип HTTP соединения</label></th>
                        <td><select name="umk_typeConnection" id="umk_typeConnection">
                                <option value=""></option>
                                <option value="http" <?php echo((get_option('umk_typeConnection') == 'http') ? 'selected="selected"' : ''); ?>>http</option>
                                <option value="https" <?php echo((get_option('umk_typeConnection') == 'https') ? 'selected="selected"' : ''); ?>>https</option>
                            </select>
                            <p class="description">Выберите тип протокола HTTP</p>
                        </td>
                    </tr>                    
                    <tr>
                        <th scope="row"><label for="blogname">Домен публикации</label></th>
                        <td><input name="umk_server" type="text" id="umk_server" class="regular-text" value="<?php echo get_option('umk_server'); ?>">
                            <p class="description">Введите домен вашей публикации, например: mysite.com</p></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="blogname">Имя публикации</label></th>
                        <td><input name="umk_publicName" type="text" id="umk_publicName" class="regular-text" value="<?php echo get_option('umk_publicName'); ?>">
                            <p class="description">Введите имя публикации ИБ</p></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="mailserver_login">Пользователь</label></th>
                        <td><input name="umk_user" type="text" id="umk_user" class="regular-text ltr" value="<?php echo get_option('umk_user'); ?>"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="mailserver_pass">Пароль</label></th>
                        <td>
                            <input name="umk_pass" type="text" id="umk_pass" class="regular-text ltr" value="<?php echo get_option('umk_pass'); ?>">
                        </td>
                    </tr>                    
                </tbody>
            </table>

            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="umk_typeConnection,umk_server,umk_publicName,umk_user,umk_pass" />

            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>  
        </form>
    </div>
    <?php
}

function umk_widgets_init()
{
 include_once UMK_DIR . '/umk-1.0-connector-widget.php';
 register_widget( 'umkWidget' );
}

add_action('wp_enqueue_scripts', 'umk_scripts_method');
add_action('widgets_init', 'umk_widgets_init');
