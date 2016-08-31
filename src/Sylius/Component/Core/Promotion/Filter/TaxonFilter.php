<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Core\Promotion\Filter;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ProductInterface;

/**
 * @author Mateusz Zalewski <mateusz.zalewski@lakion.com>
 */
class TaxonFilter implements FilterInterface
{
    /**
     * {@inheritdoc}
     */
    public function filter(array $items, array $configuration)
    {
        if (!isset($configuration['taxons'])) {
            return $items;
        }

        $filteredItems = [];
        foreach ($items as $item) {
            if ($this->hasProductValidTaxon($item->getProduct(), $configuration['taxons'])) {
                $filteredItems[] = $item;
            }
        }

        return $filteredItems;
    }

    /**
     * @param ProductInterface $product
     * @param array $taxons
     *
     * @return bool
     */
    private function hasProductValidTaxon(ProductInterface $product, $taxons)
    {
        foreach ($product->getTaxons() as $taxon) {
            if ($taxon->getCode() === $taxons) {
                return true;
            }
        }

        return false;
    }
}
