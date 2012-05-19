<?php

class dao_station extends dao_base {

    const TABLE = 'station_cell';

    private static $_instance = null;
    public static function getInstance(){
        if(self::$_instance == null){
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    public function getAllStation($cache = true){

        $list = array();
        $cache_file = '/tmp/cl-cache.station.php';
        if($cache and file_exists($cache_file)) {
            include $cache_file;
            $list = $INLINE_CACHE;
        } else {

            $list = $this->getStationList(0, 9999);

            $out = "<"."?php"."\n"
                . "/"."/ gen at " . date("Y-m-d H:i:s") . "\n"
                . "\$INLINE_CACHE = "
                . var_export($list, true) 
                . ";\n";
            file_put_contents($cache_file, $out);
        }

        $ret = array(
            'station' => array(),
            'cell'    => array(),
        );

        foreach($list as $r) {
            $station_id = $r['station_id'];
            $cell_key = $r['lac'].':'.$r['cid'];

            if(!isset($ret['station'][$station_id])) {
                $ret['station'][$station_id] = array(
                    'cell' => array(),
                );
            } 
            $ret['station'][$station_id]['cell'][] = array(
                'key' => $cell_key,
                'lac' => $r['lac'],
                'cid' => $r['cid'],
            );

            if(!isset($ret['cell'][$cell_key])) {
                $ret['cell'][$cell_key] = array();
            } 
            $ret['cell'][$cell_key][] = $station_id;

        }


        return $ret;
    }

    public function updateCell($station_id) {

        $mysqli = $this->getMysqli();
        $sql = "SELECT COUNT(*) AS sample_count, lac, cid, station_id FROM `".dao_record::TABLE."` "
            . " WHERE `station_id` = '".$mysqli->real_escape_string($station_id)."'"
            . " GROUP BY `station_id`,`lac`, `cid` "
            . " ORDER BY `lac`, `cid` ASC ";

        $result = $mysqli->query($sql);

        util_log::v(__METHOD__.' '.$sql);
        $list = null;
        if($result){
            while($row = $result->fetch_assoc()) {
                $list[] = $row;
            }
            $result->free();

        }

        $sql = "DELETE FROM `".self::TABLE."` "
            . " WHERE `station_id` = '".$mysqli->real_escape_string($station_id)."' "
            . " LIMIT 1000 ";
        util_log::v(__METHOD__.' '.$sql);
        $result = $mysqli->query($sql);

        foreach($list as $r) {
            if($r['lac'] > 0 and $r['cid'] > 0) {
                $this->add($station_id, $r['lac'], $r['cid']);
            }
        }

        return count($list);
    }

    public function getCellList($station_id){

        $mysqli = $this->getMysqli();
        $sql = "SELECT * FROM `".self::TABLE."` "
            . " ORDER BY `cid`, `lac` ASC "
            . " WHERE `station_id` = '".$mysqli->real_escape_string($id)."'";

        $result = $mysqli->query($sql);

        util_log::v(__METHOD__.' '.$sql);
        $list = null;
        if($result){
            while($row = $result->fetch_assoc()) {
                $list[] = $row;
            }
            $result->free();

        }

        return $list;
    }

    public function getStationList($offset = 0, $limit = 30, $search = array()){

        $offset = intval($offset);
        $limit = intval($limit);

        $mysqli = $this->getMysqli();
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM `".self::TABLE."` "
            . " ORDER BY `station_id` ASC "
            . " LIMIT $offset, $limit ";

        $result = $mysqli->query($sql);

        util_log::v(__METHOD__.' '.$sql);
        $list = array();
        if($result){

            while($row = $result->fetch_assoc()) {
                $list[] = $row;
            }
            $result->free();

        }

        return $list;
    }

    public function getList($offset = 0, $limit = 30, $search = array()){

        $offset = intval($offset);
        $limit = intval($limit);

        $mysqli = $this->getMysqli();
        $sql = "SELECT * FROM `".self::TABLE."` "
            . " ORDER BY `station_id` ASC "
            . " LIMIT $offset, $limit ";

        $result = $mysqli->query($sql);

        util_log::v(__METHOD__.' '.$sql);
        $list = array();
        if($result){

            while($row = $result->fetch_assoc()) {
                $list[] = $row;
            }
            $result->free();

        }

        return $list;
    }


    public function add($station_id, $lac, $cid){

        $mysqli = $this->getMysqli();

        $sql = "INSERT INTO `".self::TABLE."` "
            . " (`station_id`, `lac`, `cid`, `time_create`) "
            . " VALUES "
            . " ('".$mysqli->real_escape_string($station_id)."','".$mysqli->real_escape_string($lac)."','".$mysqli->real_escape_string($cid)."', UNIX_TIMESTAMP() ) ";

        util_log::d(__METHOD__ . ' ' . $sql);
        $res = $mysqli->query($sql);

        return $res;
    }

    public function delete($station_id, $lac, $cid){

        $mysqli = $this->getMysqli();

        $sql = "DELETE FROM `".self::TABLE."` "
            . " WHERE `station_id` = '".$mysqli->real_escape_string($station_id)."' "
            . " AND `lac` = '".$mysqli->real_escape_string($lac)."' "
            . " AND `cid` = '".$mysqli->real_escape_string($cid)."' "
            . " LIMIT 1 ";

        util_log::d(__METHOD__ . ' ' . $sql);
        $res = $mysqli->query($sql);

        return $res;
    }


}

