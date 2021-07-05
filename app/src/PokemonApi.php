<?php

namespace App;

class PokemonApi
{
    public function __construct()
    {
        $this->baseUrl = 'https://pokeapi.co/api/v2/';
    }
    
    public function resourceList($endpoint, $limit = null, $offset = null)
    {
        $url = $this->baseUrl.$endpoint.'/?limit='.$limit.'&offset='.$offset;
        
        return $this->sendRequest($url);
    }

    public function item($lookUp)
    {
        $url = $this->baseUrl.'item/'.$lookUp;
        
        return $this->sendRequest($url);
    }
    
    public function itemAttribute($lookUp)
    {
        $url = $this->baseUrl.'item-attribute/'.$lookUp;
        
        return $this->sendRequest($url);
    }
    
    public function itemCategory($lookUp)
    {
        $url = $this->baseUrl.'item-category/'.$lookUp;
        
        return $this->sendRequest($url);
    }

    
    public function getRandomPokemon()
    {
        $random_int = random_int(1, 1118);
        
        $url = $this->baseUrl.'pokemon/'.$random_int;
        
        return $this->sendRequest($url);
    }
    
  
   
    
    /**
     * @param string $url
     */
    public function sendRequest($url)
    {
        $ch = curl_init();
        
        $timeout = 5;
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        curl_close($ch);
        
        if ($http_code != 200) {
            
            // return http code and error message
            return json_encode([
                'code'    => $http_code,
                'message' => $data,
                'error'   => true,
            ]);
        }
        
        return $data;
    }
}