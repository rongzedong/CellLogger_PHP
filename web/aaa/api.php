<?php

require_once 'config.php';

class aaa_api {

    const FUNCTION_NOT_EXISTS = 2;

    const BAD_INPUT_FORMAT = 101;

    private static $_instance = null;
    public static function getInstance(){
        if(self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function uploadAction() {

        $input = file_get_contents('php://input');

        error_log($input . "\n\n", 3, '/tmp/1.log');

        $data = json_decode($input, true);
        if($data === $input) {
            return $this->err(self::BAD_INPUT_FORMAT);
        }

        if(!is_array($data)) {
            return $this->err(self::BAD_INPUT_FORMAT);
        }

        $client = $data['client'];
        if(empty($client)) {
            return $this->err(self::EMPTY_CLIENT);
        }
        $records = $data['records'];

        $status = array(
            'success' => 0,
            'failed' => 0,
        );

        $rdao = dao_record::getInstance();

        foreach($records as $re) {
            $inf = array(
                'client_id'     => $client,
                'seq'           => $re['id'],
                'network_type'  => $re['network_type'],
                'lac'           => $re['lac'],
                'cid'           => $re['cid'],
                'station_id'    => $re['station'],
                'signal_strength' => $re['signal'],
                'time'          => $re['time'],
                'approved'      => 0,
            );

            $res = $rdao->add($inf);    

            if($res) {
                $status['success'] += 1;
            } else {

                $status['failed'] += 1;
            }
        }


        return $this->ok(array(
            'success' => $status['success'],
            'failed'  => $status['failed'],
        )); 
    }   


    public function downloadAction() {

        $version = 1;
        $stations = array();
        $version = 0;

        $list = dao_station::getInstance()->getList(0, 9999);
        $s = array();
        foreach($list as $r) {
            $id = $r['station_id'];
            if(!isset($s[$id])) {
                $s[$id] = array(
                    'id'    => intval($id),
                    'name'  => 'station-' . $id,
                    'cells' => array(),
                );
            }

            $s[$id]['cells'][] = array(
                'lac' => intval($r['lac']),
                'cid' => intval($r['cid']),
            );

            $v = intval($r['time_create']);
            if($v > $version) {
                $version = $v;
            }

        }

        
         
        $stations = array_values($s);

        return $this->ok(array(
            'version' => $version,
            'stations' => $stations,
        ));
    }

    public function pingAction() {

        return $this->ok();
    }

    /* {{{ */
    public function ok($data = array()) {
        return $this->output(0, $data); 
    }

    public function err($error, $data = array()) {
        return $this->output($error, $data);
    }

    public function output($e, $d) {
        return array(
            'error' => $e,
            'payload' => $d,
        );
    }

    public function run($call = null){
        if(empty($call)) {
            $call = $_REQUEST['call'];
        }

        $methodName = $call . 'Action';
        $result = null;

        if(is_callable(array($this, $methodName))){
            $result = call_user_func(array($this, $methodName));
        } else {
            $result = $this->err(self::FUNCTION_NOT_EXISTS);
        }   

        $what = @ob_get_clean();
        if(!empty($what)) {
            util_log::w(__METHOD__ . ' unexpected output: ' . $what);
        }
        echo json_encode($result);

    } 
    /* }}} */

}

aaa_api::getInstance()->run();

