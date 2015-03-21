<?php
// Either download the JSON in your code like this,
// or just paste the contents into your code
$country_names = json_decode(
    file_get_contents("http://country.io/names.json")
, true);

function get_name($cc) {
    return $country_names[$cc];
}

get_name("GB"); // => "United Kingdom"

?>