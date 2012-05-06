<?php

class dao_record extends dao_base {

    const TABLE = 'user_record';

    private static $_instance = null;
    public static function getInstance(){
        if(self::$_instance == null){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function get($id){

        $mysqli = $this->getMysqli();
        $sql = "SELECT * FROM `".self::TABLE."` "
            . " WHERE `id` = '".$mysqli->real_escape_string($id)."'";

        $result = $mysqli->query($sql);

        util_log::v(__METHOD__.' '.$sql);
        $row = null;
        if($result){
            $row = $result->fetch_assoc();
            $result->free();

        }

        return $row;
    }

    public function getList($offset = 0, $limit = 30, $search = array()){

        $offset = intval($offset);
        $limit = intval($limit);

        $mysqli = $this->getMysqli();
        $sql = "SELECT * FROM `".self::TABLE."` "
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

    public function set($id, $row){

        $updateInfo = array();
        foreach(array(
            'client_id',
            'seq',
            'network',
            'cid',
            'lac',
            'station_id',
            'signal_strength',
            'time',
        ) as $field) {
            if(isset($row[$field])) {
                $updateInfo[$field] = $row[$field];
            }
        }

        $mysqli = $this->getMysqli();

        list($sqlInsertFields, $sqlInsertValues) = $this->sqlInsert($mysqli, $updateInfo);
        $sqlUpdate = $this->sqlUpdate($mysqli, $updateInfo);


        $sql = "INSERT INTO `".self::TABLE."` "
            . " (`id`, ".$sqlInsertFields.",`time_upload`) "
            . " VALUES "
            . " ('".$mysqli->real_escape_string($id)."', ".$sqlInsertValues.", UNIX_TIMESTAMP() ) "
            . " ON DUPLICATE KEY UPDATE "
            . " ".$sqlUpdate.", `time_upload` = UNIX_TIMESTAMP() ";
        util_log::d(__METHOD__ . ' ' . $sql);
        $res = $mysqli->query($sql);

        return $res;
    }


}

