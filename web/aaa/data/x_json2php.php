<?php

$stationData = json_decode(file_get_contents('station.json'), true);

echo var_export($stationData, true);
