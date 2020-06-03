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

namespace Checkboform\Form;

use PrestaShop\PrestaShop\Adapter\Configuration;
use PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;

/**
 * This class will provide Cache configuration.
 */
class Settings implements DataConfigurationInterface
{
    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return [
            'CHECKBOFORM_YESANDNO' => $this->configuration->get('CHECKBOFORM_YESANDNO'),
            'CHECKBOFORM_CATEGORYTREE' => $this->configuration->get('CHECKBOFORM_CATEGORYTREE'),
            'CHECKBOFORM_COUNTRY' => $this->configuration->get('CHECKBOFORM_COUNTRY'),
            'CHECKBOFORM_TEXTAREA' => $this->configuration->get('CHECKBOFORM_TEXTAREA'),

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function updateConfiguration(array $configuration)
    {
        if ($this->validateConfiguration($configuration)) {
            $this->configuration->set('CHECKBOFORM_YESANDNO', $configuration['CHECKBOFORM_YESANDNO']);
            $this->configuration->set('CHECKBOFORM_CATEGORYTREE', $configuration['CHECKBOFORM_CATEGORYTREE']);
            $this->configuration->set('CHECKBOFORM_COUNTRY', $configuration['CHECKBOFORM_COUNTRY']);
            $this->configuration->set('CHECKBOFORM_TEXTAREA', $configuration['CHECKBOFORM_TEXTAREA']);
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function validateConfiguration(array $configuration)
    {
        return isset(
            $configuration['CHECKBOFORM_TEXTAREA']
        );
    }
}
