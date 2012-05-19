<?php

require_once 'config.php';

include 'inc/header.php';


$id = $_GET['id'];
if(empty($id)) {
    echo 'no id';
    exit;
}

$list = dao_station::getInstance()->getAllStation();

if(empty($list['station'][$id])) {
    echo 'no record';
    exit;
}

$r = $list['station'][$id];

?>

<style type="text/css">
.st-cell span {
    background-color: #ccc;
    padding: 2px auto;
    border: 1px solid transparent;
    margin-right: 5px;
    display: inline-block;
    width: 120px;
    font-size: 9pt;
    text-align: center;
    cursor: default; 
}

.st-cell span b {
    display: inline-block;
    width: 15px;
    height: 15px;
    vertical-align: middle;
    border: 1px solid transparent;
    margin-right: 5px;
    float: left;
}
.hi {
    background-color: #ff0;
}
</style>
<div>


<table width="500" cellpadding="4" cellspacing="0" border="1">


<tr>
    <td class="rr">station id </td>
    <td class="cc" colspan="2"><?php echo $id; ?></td>
</tr>
<tr>
    <td class="rr">station name </td>
    <td class="cc" colspan="2"><?php echo htmlspecialchars(xstation2name($id)); ?></td>
</tr>
<tr>
    <td colspan="3" class="cc">cells </td>
</tr>

<?php 
foreach($r['cell'] as $c) { 
$color = substr(sprintf("%06s", base_convert(crc32($c['key']), 10, 16)), 0, 6);

$ccc = count($list['cell'][$c['key']]);
if($ccc == 1) {
    $unique_color = 'aea';
} else {
$unique_count = abs(14 - min(15, ( $ccc - 1 ) * 3 ));
$t_color = substr(sprintf("%1s", base_convert($unique_count, 10, 16)), 0, 1);
$unique_color = 'e'.$t_color.$t_color;
}

?>
<tr>
    <td class="cc st-cell" colspan="2">
    <span style="background-color:#<?php echo $unique_color; ?>"><b style="background-color:#<?php echo $color; ?>;"></b><?php echo $c['lac']; ?>:<?php echo $c['cid']; ?></span>
</td>
<td class="cc"><button class="btn-delete" id="<?php echo $c['key']; ?>">delete</button></td>
</tr>
<?php
}
?>

<tr style="">
    <td width="30%"></td>
    <td width="50%"></td>
    <td></td>
</tr>

</table>






</div>




<form id="frm-act" name="frm-act" method="post" action="op.php">
<input type="hidden" name="next" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" />
<input type="hidden" name="action" value="" />
<input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>" />
<input type="hidden" name="lac" value="" />
<input type="hidden" name="cid" value="" />
</form>

<script type="text/javascript">
$(document).ready(function(){
    $('.btn-delete').click(function(){
        var id = this.id; 
        var a = id.split(':');
        console.info(a);
        var lac = a[0];
        var cid = a[1];

        $('#frm-act input[name="action"]').val('st-delete');
        $('#frm-act input[name="lac"]').val(lac);
        $('#frm-act input[name="cid"]').val(cid);
        $('#frm-act').submit();
    });
});
</script>


<?php
include 'inc/footer.php';

