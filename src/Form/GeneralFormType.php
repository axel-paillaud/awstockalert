<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    Axelweb <contact@axelweb.fr>
 * @copyright 2007-2024 Axelweb
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

declare(strict_types=1);

namespace Axelweb\AwStockAlert\Form;

use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class GeneralFormType extends TranslatorAwareType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $orderStates = $this->getOrderStates();

        $builder
            ->add('order_state_to_check', ChoiceType::class, [
                'label' => $this->trans('Order status before checking if an order contains product X', 'Modules.Awstockalert.Admin'),
                'help' => $this->trans('Only check orders with the chosen status', 'Modules.Awstockalert.Admin'),
                'choices' => $orderStates,
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Type(['type' => 'numeric']),
                ],
                'attr' => [
                    'class' => 'w-auto',
                ],
            ]);
    }

    /**
     * Get order states for dropdown
     *
     * @return array
     */
    private function getOrderStates(): array
    {
        $states = \OrderState::getOrderStates((int) \Context::getContext()->language->id);
        $choices = [];

        foreach ($states as $state) {
            $choices[$state['name']] = (int) $state['id_order_state'];
        }

        return $choices;
    }
}
