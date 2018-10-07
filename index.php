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

namespace WordPressModel;

/**
 * Custom Admin Notice Message
 *
 * @param string $message
 * @param string $noticeType
 * @param array $allowedMarkup
 */
function adminNotice(string $message, string $noticeType, array $allowedMarkup = []): void
{
    add_action('admin_notices', function () use ($message, $noticeType, $allowedMarkup) {
        ?>
        <div class="notice notice-<?= esc_attr($noticeType) ?>">
            <p><?= wp_kses($message, $allowedMarkup) ?></p>
        </div>
        <?php
    });
}

function bootstrap(): void
{
    $autoloader = plugin_dir_path(__FILE__) . '/vendor/autoload.php';

    if (!file_exists($autoloader)) {
        adminNotice(
            sprintf(
                // translators: %s Is the name of the plugin.
                __('%s: No autoloader found, plugin cannot load properly.', 'wordpress-model'),
                '<strong>' . esc_html__('WordPress Model', 'wordpress-model') . '</strong>'
            ),
            'error',
            ['strong' => true]
        );

        return;
    }

    require_once $autoloader;
}

add_action('plugins_loaded', __NAMESPACE__ . '\\bootstrap');
