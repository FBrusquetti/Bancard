<?php

namespace LlevaUno\Bancard\Operations\PreAuthorization;

use \LlevaUno\Bancard\Core\Config;
use \LlevaUno\Bancard\Core\HTTP;
use \LlevaUno\Bancard\Core\Environments;
use \LlevaUno\Bancard\Operations\Operations;

/**
 *
 * Cancel operation.
 *
 **/

class PreAuthorization extends \LlevaUno\Bancard\Core\Request
{

    /**
     *
     * Validates data
     *
     * @return void
     *
     **/

    private function validateData(array $data)
    {

        if (count($data) != 5) {
            throw new \InvalidArgumentException("Invalid argument count (5 values are expected).");
        }

        if (!array_key_exists('shop_process_id', $data)) {
            throw new \InvalidArgumentException("Shop process id not found [shop_process_id].");
        }

        if (!array_key_exists('amount', $data)) {
            throw new \InvalidArgumentException("Amount argument was not found [amount].");
        }

        if (!array_key_exists('currency', $data)) {
            throw new \InvalidArgumentException("Currency argument was not found [currency].");
        }

        if (!array_key_exists('description', $data)) {
            throw new \InvalidArgumentException("Description argment was not found [description].");
        }

        if (!array_key_exists('additional_data', $data)) {
            throw new \InvalidArgumentException("Additional data argument was not found [additional_data].");
        }
    }

    /**
     *
     * Initialize object
     *
     * @return class
     *
     **/

    public static function init(array $data, array $option = array(), $environment = Environments::STAGING_URL)
    {
        # Instance.
        $self = new self;
        # Validate data.
        $self->validateData($data);

        # Set Enviroment.
        $self->environment = $environment;
        $self->path = Operations::PREAUTHORIZATION_URL;

        # Configure extra data.
        if (isset($option['return_url']) and $option['return_url'] !== "") {
            $data['return_url'] = $option['return_url'];
        } else {
            $data['return_url'] = Config::get('return_url');
        }

        if (isset($option['cancel_url']) and $option['cancel_url'] !== "") {
            $data['cancel_url'] = $option['cancel_url'];
        } else {
            $data['cancel_url'] = Config::get('cancel_url');
        }

        # Attach data.
        foreach ($data as $key => $value) {
            $self->addData($key, $value);
        }
        # Generate token.
        $self->getToken('pre_authorization');
        # Create operation array.
        $self->makeOperationObject();
        return $self;
    }
}
