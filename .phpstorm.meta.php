<?php

namespace PHPSTORM_META {

    /** @noinspection PhpIllegalArrayKeyTypeInspection */
    /** @noinspection PhpUnusedLocalVariableInspection */
    $STATIC_METHOD_TYPES = [
      \Omnipay\Omnipay::create('') => [
        'Mojopay' instanceof \Omnipay\Mojopay\Gateway,
      ],
      \Omnipay\Common\GatewayFactory::create('') => [
        'Mojopay' instanceof \Omnipay\Mojopay\Gateway,
      ],
    ];
}
