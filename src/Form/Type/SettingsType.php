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

namespace Checkboform\Form\Type;

use PrestaShopBundle\Form\Admin\Type\{SwitchType,
    YesAndNoChoiceType,
    CategoryChoiceTreeType,
    ChoiceCategoriesTreeType,
    CountryChoiceType,
    CustomMoneyType,
    DatePickerType,
    DateRangeType,
    EmailType,
    FormattedTextareaType,
    GeneratableTextType,
    IpAddressType,
    MoneyWithSuffixType,
    ReductionType,
    ResizableTextType,
    ShopChoiceTreeType,
    ShopRestrictionCheckboxType,
    TextWithLengthCounterType,
    TextWithRecommendedLengthType,
    TextWithUnitType,
    TranslatableType,
    TypeaheadCustomerCollectionType,
    TypeaheadProductCollectionType,
    TranslatorAwareType};

use Symfony\Component\Validator\Constraints\Length;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use PrestaShop\PrestaShop\Adapter\Category\CategoryDataProvider;

use Checkboform;

class SettingsType extends TranslatorAwareType
{

    /**
     * CachePageType constructor.
     * @param TranslatorInterface $translator
     * @param array $locales
     */
    public function __construct(
        $router,
        $translator,
        $shopContextAdapter,
        $countryDataprovider,
        $currencyDataprovider,
        $groupDataprovider,
        $legacyContext,
        $customerDataprovider,
        CategoryDataProvider $categoryDataProvider
    )
    {
        $this->router = $router;
        $this->translator = $translator;
        $this->context = $legacyContext;
        $this->locales = $legacyContext->getLanguages();
        $this->shops = $this->formatDataChoicesList($shopContextAdapter->getShops(), 'id_shop');
        $this->countries = $this->formatDataChoicesList(
            $countryDataprovider->getCountries($this->locales[0]['id_lang']),
            'id_country'
        );
        $this->currencies = $this->formatDataChoicesList($currencyDataprovider->getCurrencies(), 'id_currency');
        $this->groups = $this->formatDataChoicesList(
            $groupDataprovider->getGroups($this->locales[0]['id_lang']),
            'id_group'
        );
        $this->currency = $legacyContext->getContext()->currency;
        $this->customerDataprovider = $customerDataprovider;
        $this->categoryProvider = $categoryDataProvider;


        $this->selectList = [
            'displayBanner' => 'displayBanner',
            'displayNav' => 'displayNav',
            'displayFooter' => 'displayFooter',
            'displayTopColumn' => 'displayTopColumn',
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('CHECKBOFORM_YESANDNO', YesAndNoChoiceType::class, [
                'label' => $this->translator->trans('Yes and No', [], 'Module.Checkboform.Admin'),
                'required' => false,
                'expanded' => true,
                'help' => 'Set "expanded" to false to show a select instead of radio button. attr with class form-check-inline display radio inline',
                'attr' => [
                    'class' => 'form-check-inline pt-2',
                ],
                'label_attr' => [
                    'class' => 'pr-3',
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
        $builder
            ->add('CHECKBOFORM_CATEGORYTREE', CategoryChoiceTreeType::class, [
                'label' => $this->translator->trans('Category tree', [], 'Module.Checkboform.Admin'),
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'multiple' => true,
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
        $builder
            ->add('CHECKBOFORM_CATEGORIESTREE', ChoiceCategoriesTreeType::class, [
                'label' => $this->translator->trans('Categories tree', [], 'Module.Checkboform.Admin'),
                'required' => false,
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'list' => $this->categoryProvider->getNestedCategories(),
                'valid_list' => [],
                'multiple' => false,
            ]);
        $builder
            ->add('CHECKBOFORM_COUNTRY', CountryChoiceType::class, [
                'label' => $this->translator->trans('Country tree', [], 'Module.Checkboform.Admin'),
             //   'required' => false,
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
        $builder
            ->add('CHECKBOFORM_DATEPICKER', DatePickerType::class, [
                'label' => $this->translator->trans('Date picker', [], 'Module.Checkboform.Admin'),
                'required' => false,
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
        $builder
            ->add('CHECKBOFORM_DATERANGE', DateRangeType::class, [
                'label' => $this->translator->trans('Date Range', [], 'Module.Checkboform.Admin'),
                'required' => false,
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
        $builder
            ->add('CHECKBOFORM_EMAIL', EmailType::class, [
                'label' => $this->translator->trans('Email', [], 'Module.Checkboform.Admin'),
                'required' => false,
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
        $builder
            ->add('CHECKBOFORM_FORMATTEDTEXTAREA', FormattedTextareaType::class, [
                'label' => $this->translator->trans('Formatted Textarea', [], 'Module.Checkboform.Admin'),
                'required' => false,
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
        $builder
            ->add('CHECKBOFORM_GENERATALETEXT', GeneratableTextType::class, [
                'label' => $this->translator->trans('Generatable Text', [], 'Module.Checkboform.Admin'),
                'required' => false,
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
        $builder
            ->add('CHECKBOFORM_MONEYWITHSUFFIX', MoneyWithSuffixType::class, [
                'label' => $this->translator->trans('Money With Suffix', [], 'Module.Checkboform.Admin'),
                'required' => false,
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
        $builder
            ->add('CHECKBOFORM_REDUCTION', ReductionType::class, [
                'label' => $this->translator->trans('Reduction', [], 'Module.Checkboform.Admin'),
                'required' => false,
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
            /**
        $builder
            ->add('CHECKBOFORM_CUSTOMMONEY', CustomMoneyType::class, [
                'label' => $this->translator->trans('Country tree', [], 'Module.Checkboform.Admin'),
                'required' => false,
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
*/
            /**
        $builder
            ->add('CHECKBOFORM_IPADDRESS', IpAddressType::class, [
                'label' => $this->translator->trans('IP address', [], 'Module.Checkboform.Admin'),
                'required' => false,
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                //'currentIp' => '127.0.0.1',
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
*/
            /**
        $builder
            ->add('CHECKBOFORM_RESIZABLETEXT', ResizableTextType::class, [
                'label' => $this->translator->trans('Resizable Text', [], 'Module.Checkboform.Admin'),
                'required' => false,
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
*/
        $builder
            ->add('CHECKBOFORM_SHOPCHOICETREE', ShopChoiceTreeType::class, [
                'label' => $this->translator->trans('Shop Choice Tree', [], 'Module.Checkboform.Admin'),
                'required' => false,
                'multiple' => false,
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
            /**
        $builder
            ->add('CHECKBOFORM_SHOPRESTRICTION', ShopRestrictionCheckboxType::class, [
                'label' => $this->translator->trans('Shop Restriction', [], 'Module.Checkboform.Admin'),
                'required' => false,
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
*/
        $builder
            ->add('CHECKBOFORM_SWITCH', SwitchType::class, [
                'label' => $this->translator->trans('Switch', [], 'Module.Checkboform.Admin'),
                'required' => false,
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
        $builder
            ->add('CHECKBOFORM_TEXTWITHLENGTHCOUNTER', TextWithLengthCounterType::class, [
                'label' => $this->translator->trans('Text With Length Counter', [], 'Module.Checkboform.Admin'),
                'required' => false,
                'max_length' => 128,
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
        $builder
            ->add('CHECKBOFORM_TEXTWITHRECOMMENDEDLENGTH', TextWithRecommendedLengthType::class, [
                'label' => $this->translator->trans('Text With recommended Length', [], 'Module.Checkboform.Admin'),
                'required' => false,
                'recommended_length' => 128,
                'attr' => [
                        'maxlength' => 128,
                        'placeholder' => $this->translator->trans(
                            'To have a different title from the category name, enter it here.',
                            [],
                            'Admin.Catalog.Help'
                        ),
                    ],
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
        $builder
            ->add('CHECKBOFORM_TEXTWITHUNIT', TextWithUnitType::class, [
                'label' => $this->translator->trans('Text With rUnit', [], 'Module.Checkboform.Admin'),
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'required' => false,
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);

        $builder
            ->add('CHECKBOFORM_TRANSLATABLE', TranslatableType::class, [
                'label' => $this->translator->trans('Translatable', [], 'Module.Checkboform.Admin'),
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'required' => false,
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
        $builder
            ->add('CHECKBOFORM_CUSTOMMERCOLLECTION', TypeaheadCustomerCollectionType::class, [
                'remote_url' => $this->router->generate('admin_customers_search', ['sf2' => 1]) . '&customer_search=%QUERY',
                'mapping_value' => 'id_customer',
                'mapping_name' => 'fullname_and_email',
                'placeholder' => $this->translator->trans('All customers', [], 'Admin.Global'),
                'template_collection' => '<div class="media-body"><div class="label">%s</div><i class="material-icons delete">clear</i></div>',
                'limit' => 1,
                'required' => false,
                'label' => $this->translator->trans('Add customer', [], 'Admin.Catalog.Feature'),
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
        $builder
            ->add('CHECKBOFORM_PRODUCTCOLLECTION', TypeaheadProductCollectionType::class, [
                'remote_url' => $this->context->getLegacyAdminLink('AdminProducts', true, ['ajax' => 1, 'action' => 'productsList', 'forceJson' => 1, 'excludeVirtuals' => 1, 'limit' => 20]) . '&q=%QUERY',
                'mapping_value' => 'id',
                'mapping_name' => 'name',
                'placeholder' => $this->translator->trans('Search for a product', [], 'Admin.Catalog.Help'),
                'template_collection' => '
              <h4>%s</h4>
              <div class="ref">REF: %s</div>
              <div class="quantity text-md-right">x%s</div>
              <button type="button" class="btn btn-danger btn-sm delete"><i class="material-icons">delete</i></button>
            ',
                'required' => false,
                'label' => $this->translator->trans('Add productsk', [], 'Admin.Catalog.Feature'),
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'required' => false,
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);





        $builder
            ->add('CHECKBOFORM_TEXTAREA', TextareaType::class, [
                'label' => $this->translator->trans('Texarea', [], 'Module.Checkboform.Admin'),
                'required' => false,
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
        $builder
            ->add('CHECKBOFORM_CHOICE_CHECKBOX', ChoiceType::class, [
                'label' => $this->translator->trans('Checkbox', [], 'Module.Checkboform.Admin'),
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'choices' => $this->selectList,
                'attr' => [
                    'class' => 'form-check-inline pt-2'
                ],
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'label_attr' => [
                    'class' => 'pr-3',
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],

            ]);
        $builder
            ->add('CHECKBOFORM_CHOICE_RADIO', ChoiceType::class, [
                'label' => $this->translator->trans('Radio', [], 'Module.Checkboform.Admin'),
                'multiple' => false,
                'expanded' => true,
                'required' => false,
                'choices' => $this->selectList,
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
        $builder
            ->add('CHECKBOFORM_CHOICE_SELECT', ChoiceType::class, [
                'label' => $this->translator->trans('Select', [], 'Module.Checkboform.Admin'),
                'multiple' => false,
                'expanded' => false,
                'required' => false,
                'choices' => $this->selectList,
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
        $builder
            ->add('CHECKBOFORM_CHOICE_SELECTMULTI', ChoiceType::class, [
                'label' => $this->translator->trans('Checkbox', [], 'Module.Checkboform.Admin'),
                'multiple' => true,
                'expanded' => false,
                'required' => false,
                'choices' => $this->selectList,
                'help' => $this->translator->trans('Help me I\'m famous !', [], 'Module.Checkboform.Admin'),
                'label_attr' => [
                    'popover' => $this->translator->trans('Tooltip me I\'m famous !', [], 'Module.Checkboform.Admin'),
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'Module.Checkboform.Admin',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'settings';
    }
}
