<?php

declare(strict_types=1);

namespace Sylius\SystempayPlugin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
final class SystempayConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('public_key', TextType::class)
        ->add('display_mode', ChoiceType::class, [
            'choices'  => [
                'Mode embarqué' => 0,
                'Mode pop-in' => 1,
            ],
        ])
        ->add('user', TextType::class, [
            'label' => 'sylius_systempay_plugin.form.user',
        ])
        ->add('test_password', TextType::class,[
            'label' => 'sylius_systempay_plugin.form.test_password',
            "required" => false,
        ])
        ->add('prod_password', TextType::class, [
            'label' => 'sylius_systempay_plugin.form.prod_password',
        ])
        ->add('public_test_key', TextType::class, [
            'label' => 'sylius_systempay_plugin.form.public_test_key',
            "required" => false,
        ])
        ->add('hmac_sha_256_test', TextType::class, [
            'label' => 'sylius_systempay_plugin.form.hmac_sha_256_test',
            "required" => false,
        ])
        ->add('mode', ChoiceType::class, [
            'label' => 'sylius_systempay_plugin.form.mode',
            'choices'  => [
                'Test' => 0,
                'Production' => 1,
            ],
        ])
        ;
    }

    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'entry_type' => null,
            'translation_domain' => 'systempay.admin.form',
        ]);
    }
}