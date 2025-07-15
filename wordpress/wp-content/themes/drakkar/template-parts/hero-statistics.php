<?php
/**
 * Statistics Section Component - REFACTORED v2.0
 *
 * Key metrics section showcasing Drakkar's achievements and impact
 * Features animated counters displaying company statistics and success metrics
 *
 * Now uses the unified component system for better maintainability
 *
 * @package Drakkar
 * @version 2.0
 */

// Statistics data configuration
$statistics = [
    [
        'number' => '1000000',
        'label' => 'Amostras coletadas',
        'suffix' => '',
        'delay' => 0
    ],
    [
        'number' => '1200',
        'label' => 'Clientes ativos',
        'suffix' => '',
        'delay' => 200
    ],
    [
        'number' => '5000000',
        'label' => 'Hectares influenciados',
        'suffix' => '',
        'delay' => 400
    ],
    [
        'number' => '3700',
        'label' => 'Fazendas atendidas',
        'suffix' => '',
        'delay' => 600
    ],
    [
        'number' => '1500000',
        'label' => 'Mapas gerados/ano',
        'suffix' => '',
        'delay' => 800
    ]
];

// Output using the unified component system
echo Drakkar_Components::statistics_section($statistics);
?>
