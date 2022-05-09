<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/googleads/v9/errors/payments_account_error.proto

namespace Google\Ads\GoogleAds\V9\Errors\PaymentsAccountErrorEnum;

use UnexpectedValueException;

/**
 * Enum describing possible errors in payments account service.
 *
 * Protobuf type <code>google.ads.googleads.v9.errors.PaymentsAccountErrorEnum.PaymentsAccountError</code>
 */
class PaymentsAccountError
{
    /**
     * Enum unspecified.
     *
     * Generated from protobuf enum <code>UNSPECIFIED = 0;</code>
     */
    const UNSPECIFIED = 0;
    /**
     * The received error code is not known in this version.
     *
     * Generated from protobuf enum <code>UNKNOWN = 1;</code>
     */
    const UNKNOWN = 1;
    /**
     * Manager customers are not supported for payments account service.
     *
     * Generated from protobuf enum <code>NOT_SUPPORTED_FOR_MANAGER_CUSTOMER = 2;</code>
     */
    const NOT_SUPPORTED_FOR_MANAGER_CUSTOMER = 2;

    private static $valueToName = [
        self::UNSPECIFIED => 'UNSPECIFIED',
        self::UNKNOWN => 'UNKNOWN',
        self::NOT_SUPPORTED_FOR_MANAGER_CUSTOMER => 'NOT_SUPPORTED_FOR_MANAGER_CUSTOMER',
    ];

    public static function name($value)
    {
        if (!isset(self::$valueToName[$value])) {
            throw new UnexpectedValueException(sprintf(
                    'Enum %s has no name defined for value %s', __CLASS__, $value));
        }
        return self::$valueToName[$value];
    }


    public static function value($name)
    {
        $const = __CLASS__ . '::' . strtoupper($name);
        if (!defined($const)) {
            throw new UnexpectedValueException(sprintf(
                    'Enum %s has no value defined for name %s', __CLASS__, $name));
        }
        return constant($const);
    }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(PaymentsAccountError::class, \Google\Ads\GoogleAds\V9\Errors\PaymentsAccountErrorEnum_PaymentsAccountError::class);

