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

namespace Checkboform\Controller\Admin;

use Doctrine\ORM\EntityManager;
use PrestaShop\PrestaShop\Core\Exception\DatabaseException;
use PrestaShop\PrestaShop\Core\Grid\GridFactory;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Security\Annotation\{AdminSecurity, ModuleActivated};
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\{Request, Response};

/**
 * Class AdminCheckboformSettings.
 *
 * @ModuleActivated(moduleName="checkboform", redirectRoute="admin_module_manage")
 */
class AdminCheckboformSettings extends FrameworkBundleAdminController
{

    /**
     * @param Request $request
     * @param FormInterface|null $form
     *
     * @AdminSecurity("is_granted('read', request.get('_legacy_controller'))")
     *
     * @return Response
     *
     * @throws \LogicException
     */
    public function indexAction(Request $request, FormInterface $form = null)
    {
        if (null === $form) {
            $form = $this->get('checkboform.core.settings.form_handler')->getForm();
        }

        return $this->render('@Modules/checkboform/views/templates/admin/settings/configurations.html.twig', [
            'layoutHeaderToolbarBtn' => [],
            'layoutTitle' => $this->get('translator')->trans('Check Backoffice forms', [], 'Module.Checkboform.Admin'),
            'requireBulkActions' => false,
            'showContentHeader' => true,
            'requireFilterStatus' => false,
            'form' => $form->createView(),
            'currentIp' => $request->getClientIp(),
        ]);
    }

    /**
     * @param Request $request
     *
     * @AdminSecurity("is_granted(['update', 'create', 'delete'], request.get('_legacy_controller'))",
     *     message="You do not have permission to update this.")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @throws \LogicException
     */
    public function processFormAction(Request $request)
    {
        /** @var FormInterface $form */
        $form = $this->get('checkboform.core.settings.form_handler')->getForm();
        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            return $this->redirectToRoute('checkboform_settings');
        }

        $data = $form->getData();
        $saveErrors = $this->get('checkboform.core.settings.form_handler')->save($data);

        if (0 === count($saveErrors)) {
            $this->addFlash('success', $this->trans('Successful update.', 'Admin.Notifications.Success'));

            return $this->redirectToRoute('checkboform_settings');
        }

        $this->flashErrors($saveErrors);

        return $this->redirectToRoute('checkboform_settings');
    }
}
