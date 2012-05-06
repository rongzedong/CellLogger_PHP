<?php


require_once '../../boot.php';

require_once 'data/station.php';

function xstation2name($id) {
    global $stationData;
    foreach($stationData['stations'] as $line) {
        foreach($line['station'] as $station) {
            if($station['id'] == $id) {
                return $station['name'];
            }
        }
    }
    return '--';
}

