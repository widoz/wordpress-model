<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the WordPress Theme Model package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WordPressModel\Tests;

use Brain\Monkey;
use Brain\Monkey\Functions;

/**
 * Class WordPress Theme ModelTestCase
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    protected static $sourcePath;

    /**
     * Define Common WordPress Functions
     */
    protected function defineCommonWPFunctions()
    {
        Functions\when('__')->returnArg(1);
        Functions\when('esc_url')->returnArg(1);
        Functions\when('esc_html__')->returnArg(1);
        Functions\when('esc_html_x')->returnArg(1);
        Functions\when('sanitize_key')->alias(function ($key) {
            return preg_replace('/[^a-z0-9_\-]/', '', strtolower($key));
        });
        Functions\when('wp_parse_args')->alias(function ($args, $defaults) {
            if (is_object($args)) {
                $r = get_object_vars($args);
            } else if (is_array($args)) {
                $r =& $args;
            } else {
                wp_parse_str($args, $r);
            }

            if (is_array($defaults)) {
                return array_merge($defaults, $r);
            }

            return $r;
        });
        Functions\when('plugin_dir_path')->justReturn(static::$sourcePath);
        Functions\when('untrailingslashit')->alias(function ($val) {
            return rtrim($val, '/');
        });
    }

    /**
     * SetUp
     */
    protected function setUp()
    {
        parent::setUp();
        Monkey\setUp();

        self::defineCommonWPFunctions();
    }

    /**
     * TearDown
     */
    protected function tearDown()
    {
        Monkey\tearDown();
        \Mockery::close();
        parent::tearDown();
    }

    /**
     * Constructs a test case with the given name.
     *
     * @param string $name
     * @param array  $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        self::$sourcePath = dirname(dirname(__DIR__));
    }
}
