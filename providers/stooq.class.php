<?php

/**
 * stooq.com
 */
class Stooq
{
    private $data;

    public function __construct()
    {
    }

    public function quote($symbol)
    {
        if (!$this->data['symbol'])
        {
            $this->load_element($symbol);
        }

        return $this->data[$symbol]['close'];
    }

    public function get_element($symbol)
    {
        return $this->data[$symbol];
    }

    public function load_element($symbol)
    {
        $url = 'http://stooq.com/q/l/?s='.$symbol.'&f=sd2t2ohlcv&h&e=csv';
        $file = fopen($url, 'r');
        if ($file)
        {
            $keys = fgetcsv($file);
            $values = fgetcsv($file);
        }

        $this->data[$symbol]['close'] = $values[6];
        $this->data[$symbol]['volume'] = $values[7];
    }

    public function preload()
    {
        //@todo 
        $url = 'http://stooq.com/notowania/?kat=g2';
    }

}
