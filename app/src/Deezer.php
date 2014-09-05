<?php

namespace Karma\Util;

class Deezer extends \DeezerAPI\Search
{
    protected $_typesValues = array(
        'album',
        'artist',
        'autocomplete'
    );

    protected function _parse($url) {
        $results = json_decode(file_get_contents($url));

        try{
            foreach($results as $type => $typeResult){
                if($type == "total" || $type == "next" || $type == "prev")
                    continue;

                //var_dump($type);
                //echo "<BR><BR><BR>";

                foreach ($typeResult->data as $result) {
                    array_push($this->_results, $result);
                }
            }
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }

        if (isset($results->next)) {
            $this->_parse($results->next);
        }

    }
}