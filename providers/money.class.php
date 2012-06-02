<?php

/**
 * money.pl
 */
class Money
{
    private $data;

    public function __construct()
    {
        $this->preload();
    }

    public function quote($symbol)
    {
        return $this->data[$symbol]['close'];
    }

    public function get_symbol_data($symbol)
    {
        return $this->data[$symbol];
    }

    public function preload()
    {
        //akcje
        $url = 'http://www.money.pl/gielda/gpw/akcje/';
        $xpath = '/html/body/div[3]/div[4]/div/div[3]/div/table';
        $this->load_group($url, $xpath);
    }

    private function load_group($url, $xpath)
    {
        $html = file_get_contents($url);
        $dom = new DOMDocument();
        $loaded = @$dom->loadHTML($html); // not valid html

        if ($loaded)
        {
            $dx = new DOMXPath($dom);
            $tables = $dx->query($xpath);
            $table = $tables->item(0);
            //echo $table->C14N();
            $trs = $table->getElementsByTagName('tr');

            foreach ($trs as $tr)
            {
                $company = array();
                foreach ($tr->childNodes as $td)
                {
                    $company[] = $td->textContent;
                }

                $symbol = trim(strtolower($company[4]));
                $this->data[$symbol]['close'] = trim($company[12]);

                //if ($i++ < 3)
                //{
                    //echo '<pre>';
                    //print_r($company);
                    //echo "<br><br>";
                //}
            }
        }
    }


    


}
