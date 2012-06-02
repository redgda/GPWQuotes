<?php

class QuotesGPW
{
    private $default_provider = 'stooq';

    public function __construct($provider=null)
    {
        if (!$provider)
        {
            $provider = $this->default_provider;
        }

        $this->provider = $this->factory($provider);
        $this->provider->preload();
    }

    private function factory($provider)
    {
        $path = 'providers/'.$provider.'.class.php';
        //@todo sprawdzic czy istnieje i zabezpieczyc
        require_once $path;
        return new $provider;
    }

    public function quote($symbol)
    {
        return $this->provider->quote($symbol);
    }

    public function get_symbol_data($symbol)
    {
        return $this->provider->get_symbol_data($symbol);
    }
}
