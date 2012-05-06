<?php

require_once 'config.php';

$status   = '--';
$next     = '';
$autojump = '';

switch($_POST['action']) {
    case 'r-delete':
        $status = 'record delete ';
        $next = 'record.php';
        $autojump = 1;
        $item = $_POST['checkitem']; 
        foreach($item as $id) {
            dao_record::getInstance()->delete($id);
        }
        break;

    case 'r-approve':
        $status = 'record approve ';
        $next = 'record.php';
        $autojump = 1;
        $item = $_POST['checkitem']; 
        foreach($item as $id) {
            dao_record::getInstance()->approve($id, true);
        }
        break;
       
    case 'r-decline':
        $status = 'record decline ';
        $next = 'record.php';
        $autojump = 1;
        $item = $_POST['checkitem']; 
        foreach($item as $id) {
            dao_record::getInstance()->approve($id, false);
        }
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

