<?php

require_once 'config.php';

$status   = '--';
$next     = '';
$autojump = '1';

if(!empty($_REQUEST['next'])) {
    $next = $_REQUEST['next'];
}


function x_approve($approve) {

    $item = $_POST['checkitem']; 
    $station_ids = array();
    foreach($item as $id) {
        $re = dao_record::getInstance()->get($id);
        $station_id = $re['station_id'];
        $station_ids[] = $station_id;

        dao_record::getInstance()->approve($id, $approve);

    }

    $station_ids = array_unique($station_ids);

    foreach($station_ids as $station_id) {
        dao_station::getInstance()->updateCell($station_id);
    }

}

switch($_POST['action']) {
    case 'r-delete':
        $status = 'record delete ';
        $item = $_POST['checkitem']; 
        foreach($item as $id) {
            dao_record::getInstance()->delete($id);
        }
        break;

    case 'r-approve':
        $status = 'record approve ';

        x_approve(true);

        break;
       
    case 'r-decline':
        $status = 'record decline ';

        x_approve(false);

        break;


}



include 'inc/header.php';

?>

Status: <?php echo htmlspecialchars($status); ?> <br />
Next: <a href="<?php echo htmlspecialchars($next); ?>"><?php echo htmlspecialchars($next); ?></a> <br />
<?php if($autojump) { ?>
Auto redirect in <span id="tl"></span> seconds.
<?php } ?>

<script type="text/javascript">
var next = '<?php echo addslashes($next); ?>';
var autojump = '<?php echo addslashes($autojump); ?>';
var jumptime = 3;
$(document).ready(function(){
    $('#tl').text(jumptime);
    if(autojump) {
        window.setInterval(function(){
            if(jumptime <= 1) {
                window.location.href = next; 
            } else {
                jumptime -= 1;
                $('#tl').text(jumptime);
            }
        }, 1000);
    }
});
</script>


<?php
include 'inc/footer.php';

