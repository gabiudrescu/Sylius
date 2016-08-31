<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\PromotionBundle\Form\Type\Action;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;

/**
 * Percentage discount action configuration form type.
 *
 * @author Saša Stamenković <umpirsky@gmail.com>
 */
class PercentageDiscountConfigurationType extends AbstractType
{
    /**
     * @var TaxonRepositoryInterface
     */
    private $taxonRepository;

    /**
     * @param TaxonRepositoryInterface $taxonRepository
     */
    public function __construct(TaxonRepositoryInterface $taxonRepository)
    {
        $this->taxonRepository = $taxonRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('percentage', 'percent', [
                'label' => 'sylius.form.action.percentage_discount_configuration.percentage',
                'constraints' => [
                    new NotBlank(),
                    new Type(['type' => 'numeric']),
                ],
            ])
            ->add('filters', 'sylius_taxon_from_identifier', [
                'label' => 'sylius.form.promotion_rule.contains_taxon.taxon',
                'class' => $this->taxonRepository->getClassName(),
                'query_builder' => function () {
                    return $this->taxonRepository->getFormQueryBuilder();
                },
                'identifier' => 'code'
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_promotion_action_percentage_discount_configuration';
    }
}
