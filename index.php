<?php # -*- coding: utf-8 -*-

/**
 * Plugin Name: WordPress Model
 * Plugin URI: http://github.com/widoz/wordpress-model
 * Author: Guido Scialfa
 * Author URI: https://guidoscialfa.com
 * Description: Collection of Models to reuse within your themes or plugins with your favorite template engine
 * Version: 1.0.0-beta
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wordpress-model
 */

declare(strict_types=1);

// phpcs:disable

function bootstrap(): void
{
    $autoloader = plugin_dir_path(__FILE__) . '/vendor/autoload.php';

    if (!file_exists($autoloader)) {
        add_action('admin_notices', function () {
            ?>
            <div class="notice notice-error">
                <p>
                    <?= wp_kses(sprintf(
                    // translators: %s Is the name of the plugin.
                        __(
                            '%s: No autoloader found, plugin cannot load properly.',
                            'wordpress-model'
                        ),
                        '<strong>' . esc_html__('WordPress Model', 'wordpress-model') . '</strong>'
                    ), ['strong' => true]) ?>
                </p>
            </div>
            <?php
        });

        return;
    }

    require_once $autoloader;
}

add_action('plugins_loaded', __NAMESPACE__ . '\\bootstrap');
