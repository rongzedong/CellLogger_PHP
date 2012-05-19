<?php

require_once 'config.php';

include 'inc/header.php';


$page = util_request::get('page', 1);
$page = intval($page);


$list = dao_station::getInstance()->getAllStation();

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


<table width="100%" cellpadding="4" cellspacing="0" border="1">
<thead>
<tr>
    <th>station id </th>
    <th>station name </th>
    <th>cells </th>
</tr>
</thead>
<tbody>
<?php foreach($list['station'] as $station_id => $r) { 

?>

<tr>
    <td class="cc"><a href="station_edit.php?id=<?php echo $station_id; ?>"><?php echo $station_id; ?></a></td>
    <td class="cc"><?php echo htmlspecialchars(xstation2name($station_id)); ?></td>
    <td class="rr st-cell"><?php 
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
    <span id="c-<?php echo md5($c['key']); ?>" class="c-<?php echo md5($c['key']); ?>" style="background-color:#<?php echo $unique_color; ?>"><b style="background-color:#<?php echo $color; ?>;"></b><?php echo $c['lac']; ?>:<?php echo $c['cid']; ?></span>
<?php
}
?></td>
</tr>


<?php } ?>
</tbody>
</table>


</form>


<script type="text/javascript">
$(document).ready(function(){
    $('.st-cell span').click(function(){
        // select duplicated rows
        var id = this.id.substring(2);

        $('tr').removeClass('hi');
        $('.c-'+id).closest('tr').addClass('hi');
    });
    
});
</script>

</div>

<?php
include 'inc/footer.php';

