<?php

require_once 'config.php';

include 'inc/header.php';


$page = util_request::get('page', 1);
$page = intval($page);

$limit = 20;
$offset = ( $page - 1 ) * $limit;

$list = dao_station::getInstance()->getStationList($offset, $limit);

?>

<div>


<?php include 'inc/pager.php'; ?>

<form id="frm-batch" name="frm-batch" method="post" action="op.php">
    <input type="hidden" id="batch-action" name="action" value="" />


<table class="tbl-checkall" width="100%" cellpadding="4" cellspacing="0" border="1">
<thead>
<tr>
    <th><input class="action-checkall" type="checkbox" name="checkall" value="" /></th>
    <th>station id </th>
    <th>station name </th>
    <th>cells </th>
</tr>
</thead>
<tbody>
<?php foreach($list as $row) { ?>

<tr>
<td class="cc"><input type="checkbox" name="checkitem" value="<?php echo $row['station_id']; ?>" /></td>
    <td class="cc"><?php echo $row['station_id']; ?></td>
    <td class="cc"><?php echo htmlspecialchars(xstation2name($row['station_id'])); ?></td>
    <td class="rr"><?php echo $row['cell_count']; ?></td>
</tr>


<?php } ?>
</tbody>
</table>


</form>

<?php include 'inc/pager.php'; ?>

<script type="text/javascript">
$(document).ready(function(){
    
    
});
</script>

</div>

<?php
include 'inc/footer.php';

