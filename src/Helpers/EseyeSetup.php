<?php

/*
 * This file is part of SeAT
 *
 * Copyright (C) 2015 to 2020 Leon Jacobs
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

namespace Seat\Eveapi\Helpers;

use Seat\Eseye\Configuration;
use Seat\Eseye\Containers\EsiAuthentication;
use Seat\Eseye\Eseye;

/**
 * Class EseyeSetup.
 * @package Seat\Eveapi\Helpers
 */
class EseyeSetup
{
    /**
     * EseyeSetup constructor.
     * @throws \Seat\Eseye\Exceptions\InvalidContainerDataException
     */
    public function __construct()
    {

        $config = Configuration::getInstance();
        $config->http_user_agent = 'SeAT v' . config('eveapi.config.version');
        $config->logfile_location = config('eveapi.config.eseye_logfile');
        $config->file_cache_location = config('eveapi.config.eseye_cache');
        $config->logger_level = config('eveapi.config.eseye_loglevel');
        $config->esi_scheme = config('eveapi.config.eseye_esi_scheme');
        $config->esi_host = config('eveapi.config.eseye_esi_host');
        $config->esi_port = config('eveapi.config.eseye_esi_port');
        $config->datasource = config('eveapi.config.eseye_esi_datasource');
        $config->sso_scheme = config('eveapi.config.eseye_sso_scheme');
        $config->sso_host = config('eveapi.config.eseye_sso_host');
        $config->sso_port = config('eveapi.config.eseye_sso_port');
    }

    /**
     * Gets an instance of Eseye.
     *
     * We automatically add the CLIENT_ID and SHARED_SECRET configured
     * for this SeAT instance to the EsiAuthentication container.
     *
     * @param \Seat\Eseye\Containers\EsiAuthentication|null $authentication
     *
     * @return \Seat\Eseye\Eseye
     * @throws \Seat\Eseye\Exceptions\InvalidContainerDataException
     */
    public function get(EsiAuthentication $authentication = null): Eseye
    {

        if ($authentication) {

            tap($authentication, function ($auth) {

                $auth->client_id = config('eveapi.config.eseye_client_id');
                $auth->secret = config('eveapi.config.eseye_client_secret');
            });

            return new Eseye($authentication);
        }

        // Return an unauthenticated Eseye instance
        return new Eseye;
    }
}
