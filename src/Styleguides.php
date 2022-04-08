<?php
/**
 * styleguides plugin for Craft CMS 3.x
 *
 * Creates a simple styleguide
 *
 * @link      https://www.b3rning14.fr
 * @copyright Copyright (c) 2022 B3rning14
 */

namespace b3rning14\styleguides;

use b3rning14\styleguides\models\Settings;
use b3rning14\styleguides\twig\extensions\StyleguidesTwigExtension;
use Craft;
use craft\base\Plugin;
use craft\events\PluginEvent;
use craft\helpers\UrlHelper;
use craft\services\Plugins;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use yii\base\Event;
use yii\base\Exception;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://docs.craftcms.com/v3/extend/
 *
 * @author    B3rning14
 * @package   Styleguides
 * @since     1.0.0
 *
 * @property Settings $settings
 * @method Settings getSettings()
 */
class Styleguides extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * Styleguides::$plugin
     *
     * @var Styleguides
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * To execute your plugin’s migrations, you’ll need to increase its schema version.
     *
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /**
     * Set to `true` if the plugin should have a settings view in the control panel.
     *
     * @var bool
     */
    public $hasCpSettings = true;

    /**
     * Set to `true` if the plugin should have its own section (main nav item) in the control panel.
     *
     * @var bool
     */
    public $hasCpSection = false;

    // Public Methods
    // =========================================================================

    /**
     * Initializes the plugin.
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Add in our Twig extensions
        Craft::$app->view->registerTwigExtension(new StyleguidesTwigExtension());

        $this->_registerAfterInstallEvent();

        // Do something after we're installed
        /*Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    // We were just installed
                }
            }
        );*/

        Craft::info(
            Craft::t(
                'styleguides',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    /**
     * Redirect user to plugin setting after installation if from CP
     */
    private function _registerAfterInstallEvent()
    {
        // Do something after we're installed
        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this && Craft::$app->getRequest()->getIsCpRequest()) {
                    // Redirect to settings page
                    Craft::$app->getResponse()->redirect(
                        UrlHelper::cpUrl('settings/plugins/styleguides')
                    )->send();
                }
            }
        );
    }


    // Protected Methods
    // =========================================================================

    /**
     * Creates and returns the model used to store the plugin’s settings.
     *
     * @return Settings|null
     */
    protected function createSettingsModel(): Settings
    {
        return new Settings();
    }

    /**
     * Returns the rendered settings HTML, which will be inserted into the content
     * block on the settings page.
     *
     * @return string The rendered settings HTML
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws Exception
     * @throws LoaderError
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'styleguides/settings',
            [
                'settings' => $this->getSettings(),
            ]
        );
    }
}
