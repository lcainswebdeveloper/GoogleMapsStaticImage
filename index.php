<?php
use App\GoogleMapStaticImage;
require __DIR__.'/vendor/autoload.php';

$lats_lngs = [
    [
        'lat' => 51.5054564,
        'lng' => -0.0753565
    ],
    [
        'lat' => 50.8168555,
        'lng' => -0.136738
    ]
];

$image_path = __DIR__.'/images/';
$create = new GoogleMapStaticImage;
$create->path = $image_path;
$create->images($lats_lngs);

$images = scandir($image_path);

//get rid of . and ..
array_shift($images);
array_shift($images);

foreach($images as $image):
    echo '<p><img src="images/'.$image.'"></p>';
endforeach;
