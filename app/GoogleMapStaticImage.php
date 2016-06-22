<?php

namespace App;

use \GuzzleHttp\Client;

class GoogleMapStaticImage{

    private $client;
    public $path;
    public $zoom;
    public $size;
    public $scale;
    public $maptype;

    public function __construct(){
        $this->client = new Client([ 'exceptions' => false ]);
        $this->zoom = 16;
        $this->size = '750x400';
        $this->scale = 1;
        $this->maptype = 'roadmap';
    }

    protected function make_google_url($lat, $lng){
        $google_url  = 'https://maps.googleapis.com/maps/api/staticmap?center='.$lat.','.$lng;
        $google_url .= '&zoom='.$this->zoom.'&size='.$this->size.'&scale='.$this->scale;
        $google_url .= '&maptype='.$this->maptype.'&markers=color:red%7C'.$lat.','.$lng;
        return $google_url;
    }

    public function images($lats_lngs){
        foreach($lats_lngs as $key => $item):
            $lat = $item['lat'];
            $lng = $item['lng'];

            $map_static_image_ref = md5($key.$lat.$lng.'.png');

            $target = $this->path.$map_static_image_ref.'.png';

            $google_url = $this->make_google_url($lat, $lng);

            if(!file_exists($target)):
                $this->make_image_from_url($target, $google_url);
            endif;
        endforeach;
    }

    private function make_image_from_url($path, $url){
	$resource = fopen($path, 'w');
	$this->client->request('GET', $url, ['sink' => $resource]);
    }
}
