<?php

class GPWQuotes
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
        $path = __DIR__ . "/providers/$provider.class.php";
        if (!is_file($path))
        {
           Throw new Exception("Bad provider ($provider)");
        }

        require_once $path;
        if (!class_exists($provider))
        {
           Throw new Exception("Bad provider ($provider)");
        }

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
