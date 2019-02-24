<?php # -*- coding: utf-8 -*-

/**
 * Plugin Name: WordPress Model
 * Plugin URI: http://github.com/widoz/wordpress-model
 * Author: Guido Scialfa
 * Author URI: https://guidoscialfa.com
 * Description: Reusable models for your themes or plugins
 * Version: 0.2.0
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: wordpress-model
 */

/*
 * This file is part of the WordPress Model package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

// phpcs:disable

namespace WordPressModel;

(function () {
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
})();
