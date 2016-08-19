# Omnipay: Mojopay

**Mojopay gateway for the Omnipay PHP payment processing library**

[![Latest Version on Packagist](https://img.shields.io/packagist/v/knightar/omnipay-mojopay.svg?style=flat-square)](https://packagist.org/packages/knightar/omnipay-mojopay)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/knightar/omnipay-mojopay/master.svg?style=flat-square)](https://travis-ci.org/knightar/omnipay-mojopay)
[![Total Downloads](https://img.shields.io/packagist/dt/knightar/omnipay-mojopay.svg?style=flat-square)](https://packagist.org/packages/knightar/omnipay-mojopay)


[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements Mojopay support for Omnipay.

## Install

Via Composer

``` bash
$ composer require meebio/omnipay-mojopay
```

## Usage

The following gateways are provided by this package:

 * Mojopay

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay) repository.

This driver supports following transaction types:

- authorize($options) - authorize an amount on the customer's card
- capture($options) - capture an amount you have previously authorized
- purchase($options) - authorize and immediately capture an amount on the customer's card
- refund($options) - refund an already processed transaction
- void($options) - generally can only be called up to 24 hours after submitting a transaction

Gateway instantiation:
``` PHP
    $gateway = Omnipay::create('Mojopay');
    $gateway->setProcessorId('abcdefg1234567');
    $gateway->setToken('6ef44f261a4a1595cd377d3ca7b57b92');
    $gateway->setTestMode(true);
```

Driver also supports paying using store cards in the customer vault using `customerHash` instead of `card`, 
use the vault functions with the `customerHash` parameter.

This driver also supports storing customer data in Mojopay's customer vault:

- vault_create($options) - Create a entry in the customer vault
- vault_update($options) - Update an entry in the customer vault
- vault_delete($options) - Delete an entry in a customer vault
``` PHP
    $response = $gateway->vault_purchase([
        'card'        => '10.00',
        'customerHash'  => '1234567890'
    ])->send();
    
    $customerHash = $response->getCustomerHash();
```

It can be used in authorize, purchase, and refund requests:
 
- vault_authorize($options) - authorize an amount using customer's card in the vault
- vault_purchase($options) - authorize and immediately capture an amount using customer's card in the vault
- vault_refund($options) - refund an already processed transaction using customer's card in the vault

    $gateway->vault_purchase([
        'amount'        => '10.00',
        'customerHash'  => '1234567890'
    ]);

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/meebio/omnipay-creditcall/issues),
or better yet, fork the library and submit a pull request.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email jablonski.kce@gmail.com instead of using the issue tracker.

## Credits

- [John Jablonski](https://github.com/jan-j)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
