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

use PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;
use PrestaShop\PrestaShop\Core\ConfigurationInterface;

/**
 * Configuration is used to save data to configuration table and retrieve from it.
 */
final class GeneralDataConfiguration implements DataConfigurationInterface
{
    public const AWSTOCKALERT_ORDER_STATE_TO_CHECK = 'AWSTOCKALERT_ORDER_STATE_TO_CHECK';

    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    public function __construct(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getConfiguration(): array
    {
        return [
            'order_state_to_check' => (int) $this->configuration->get(static::AWSTOCKALERT_ORDER_STATE_TO_CHECK),
        ];
    }

    public function updateConfiguration(array $configuration): array
    {
        $errors = [];

        // Quick normalisation
        $orderStateToCheck = isset($configuration['order_state_to_check']) ? (int) $configuration['order_state_to_check'] : 0;

        if (!$this->validateConfiguration(['order_state_to_check' => $orderStateToCheck])) {
            $errors[] = 'Invalid configuration payload.';

            return $errors;
        }

        // Validation
        if ($orderStateToCheck <= 0) {
            $errors[] = 'Order state must be selected.';
        }

        // Verify that the order state exists
        if ($orderStateToCheck > 0 && !\Validate::isLoadedObject(new \OrderState($orderStateToCheck))) {
            $errors[] = 'Selected order state does not exist.';
        }

        if (!empty($errors)) {
            return $errors;
        }

        // Persist
        $this->configuration->set(static::AWSTOCKALERT_ORDER_STATE_TO_CHECK, $orderStateToCheck);

        // empty = ok
        return $errors;
    }

    /**
     * Ensure the parameters passed are valid.
     *
     * @return bool Returns true if no exception are thrown
     */
    public function validateConfiguration(array $configuration): bool
    {
        return isset($configuration['order_state_to_check']);
    }
}
