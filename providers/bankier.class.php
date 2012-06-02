<?php

/**
 * bankier.pl
 */
class Bankier
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
        $url = 'http://www.bankier.pl/inwestowanie/notowania/akcje.html';
        $xpath = '/html/body/div[2]/div[3]/table/tbody/tr/td[3]/div[2]/table';
        $this->load_group($url, $xpath);
    }

    private function load_group($url, $xpath)
    {
        $html = file_get_contents($url);
        $dom = new DOMDocument();
        $loaded = @$dom->loadHTML($html); // not valid html
        if ($loaded)
        {
            $table = self::get_element_by_xpath($dom, $xpath, 'table');
            $trs = $table->getElementsByTagName('tr');

            foreach ($trs as $tr)
            {
                $company = array();
                foreach ($tr->childNodes as $td)
                {
                    $company[] = $td->textContent;
                }

                $symbol = trim(strtolower($company[2]));
                $this->data[$symbol]['close'] = trim($company[4]);
            }
        }
    }

    public static function get_element_by_xpath($dom, $xpath, $tag_name='*')
    {
        //(ajust firebug format to DOMDocument)
        $xpath = str_replace('/tbody', '', $xpath);
        $elements = $dom->getElementsByTagName($tag_name);

        foreach ($elements as $element)
        {
            if ($xpath == $element->getNodePath())
            {
                return $element;
            }
        }
        return null;
    }


}
