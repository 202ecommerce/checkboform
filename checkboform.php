<?php
/**
 * 2007-2020 202-ecommerce and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@202-ecommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.202-ecommerce.com for more information.
 *
 * @author    202-ecommerce <contact@202-ecommerce.com>
 * @copyright 2020 202-ecommerce and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of 202-ecommerce
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

/*
 * Run 'composer install' if the 'vendor' folder doesn't exist
 */
require_once _PS_MODULE_DIR_ . '/totcachepage/vendor/autoload.php';


class Checkboform extends Module
{
    /** @var string Unique name */
    public $name = 'checkboform';

    /** @var string Admin tab corresponding to the module */
    public $tab = 'back_office_features';

    /** @var float Version */
    public $version = '1.0.0';

    /** @var string author of the module */
    public $author = '202 ecommerce';

    /** @var int need_instance */
    public $need_instance = 0;

    /** @var array filled with known compliant PS versions */
    public $ps_versions_compliancy = array(
        'min' => '1.7.7.0',
        'max' => '1.7.9.99'
    );

    /**
     * List of ModuleAdminController used in this Module
     * With translated name by language iso code ('en' is required)
     * Syntax is compliant with Module::$tabs added with Prestashop 1.7.1.0
     * @var array
     */
    public $tabs = [
        [
            'name' => 'Check form',
            'class_name' => 'AdminCheckboformSettings',
            'parent_class_name' => 'CONFIGURE',
            'icon' => 'extension',
            'visible' => true,
        ],
    ];

    /**
     * Constructor of module
     */
    public function __construct()
    {
        parent::__construct();
        $this->displayName = $this->l('Check BO Form');
        $this->description = $this->l('A module to check all form Type from Symfony or PrestaShop');
    }

    public function install()
    {
        parent::install();

        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = 'AdminCheckboformSettings';
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = 'Check form';
        }

        //AdminPreferences
        $tab->id_parent = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)
            ->getValue(
                'SELECT MIN(id_tab)
                    FROM `'._DB_PREFIX_.'tab`
                    WHERE `class_name` = "'.pSQL('CONFIGURE').'"'
                );

        $tab->module = $this->name;

        return $tab->add();
    }
    /**
     * Get content of module admin configuration page
     * @deprecated No longer use this ! Please use a ModuleAdminController for Configuration use with HelperOption, for ObjectModel use with HelperForm
     * @return string
     */
    public function getContent()
    {
        Tools::redirectAdmin($this->context->link->getAdminLink('AdminCheckboformSettings'));
        // Recommended to redirect user to your ModuleAdminController who manage Configuration
        return null;
    }

}
