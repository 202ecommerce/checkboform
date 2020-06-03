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

use Doctrine\ORM\EntityManager;
use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;

class SettingsFormDataProvider implements FormDataProviderInterface
{
    protected $configurations;

    public function __construct(Settings $configurations)
    {
        $this->configurations = $configurations;
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        return [
            'settings' => $this->configurations->getConfiguration(),
        ];
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function setData(array $data)
    {
        return
            $this->configurations->updateConfiguration($data['settings'])
        ;
    }
}
