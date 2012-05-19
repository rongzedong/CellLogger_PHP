<?php

require_once 'config.php';

include 'inc/header.php';


$page = util_request::get('page', 1);
$page = intval($page);

$limit = 20;
$offset = ( $page - 1 ) * $limit;

$res = dao_record::getInstance()->getList($offset, $limit);
$total_page = ceil( $res['total'] / $limit );
$list = $res['list'];

$station = dao_station::getInstance()->getAllStation();

?>

<style type="text/css">
.stat-new {
    background-color: #7f7;
}
.stat-exist {
    background-color: #77f;
}
.stat-multi {
    background-color: #ff0;
}
</style>

<div>

<form id="frm-batch" name="frm-batch" method="post" action="op.php">
<input type="hidden" name="next" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" />
    <input type="hidden" id="batch-action" name="action" value="" />

<div class="type">
    <a href="?type=new">new</a>
    &nbsp;|&nbsp;
    <a href="?type=approved">approved</a>
    &nbsp;|&nbsp;
    <a href="?type=declined">declined</a>
    &nbsp;|&nbsp;
    <a href="?type=all">all</a>
</div>

<hr />

<div class="buttons">
    <button class="action-delete"  name="r-delete"  type="button">delete selected</button>
    <button class="action-approve" name="r-approve" type="button">approve selected</button>
    <button class="action-decline" name="r-decline" type="button">decline selected</button>
</div>

<?php include 'inc/pager.php'; ?>

<table class="tbl-checkall" width="100%" cellpadding="4" cellspacing="0" border="1">
<thead>
<tr>
    <th><input class="action-checkall" type="checkbox" name="checkall" value="" /></th>
    <th>client </th>
    <th>client index </th>
    <th>network type </th>
    <th>lac </th>
    <th>cid </th>
    <th>station id </th>
    <th>station name </th>
    <th>signal strength </th>
    <th>client time </th>
    <th>upload time </th>
    <th>ap </th>
    <th>status </th>
</tr>
</thead>
<tbody>
<?php foreach($list as $row) { 

    $stat = 'new';
    $x_cell_key = $row['lac'].':'.$row['cid'];
    $x_st_id = $row['station_id'];
    if(isset($station['cell'][$x_cell_key])) {
        if(count($station['cell'][$x_cell_key]) and in_array($x_st_id, $station['cell'][$x_cell_key])) {
            $stat = 'exist';
        } else {
            $stat = 'multi';
        }
    }

?>

<tr>
<td><input type="checkbox" name="checkitem[]" value="<?php echo $row['id']; ?>" /></td>
    <td class="ss"><?php echo $row['client_id'];                        ?></td>
    <td class="rr"><?php echo $row['seq'];                              ?></td>
    <td class="rr"><?php echo $row['network'];                          ?></td>
    <td class="rr"><?php echo $row['lac'];                              ?></td>
    <td class="rr"><?php echo $row['cid'];                              ?></td>
    <td class="rr"><?php echo $row['station_id'];                       ?></td>
    <td class="rr"><?php echo htmlspecialchars(xstation2name($row['station_id'])); ?></td>
    <td class="rr"><?php echo $row['signal_strength'];                  ?></td>
    <td class=""  ><?php echo date('Y-m-d H:i:s', $row['time']);        ?></td>
    <td class=""  ><?php echo date('Y-m-d H:i:s', $row['time_upload']); ?></td>
    <td class="cc approved-<?php echo $row['approved']; ?>"  ><?php echo $row['approved'];                         ?></td>
    <td class="cc stat-<?php echo $stat; ?>"><?php echo $stat; ?></td>
</tr>

<?php } ?>
</tbody>
</table>

<?php include 'inc/pager.php'; ?>

</form>

<script type="text/javascript">
$(document).ready(function(){
    function highlight_row() {
        $("td :checkbox").closest('tr').removeClass('hi');
        $("td :checked").closest('tr').addClass('hi');
    }
    $("table").delegate('td','mouseover mouseleave', function(e) {
        if (e.type == 'mouseover') {
            $(this).parent().addClass("hover");
        }   
        else {
            $(this).parent().removeClass("hover");
        }   
    }); 
    $("td").click(function(e) {
        var chk = $(this).closest("tr").find("input:checkbox").get(0);
        if(chk && e.target != chk){
            chk.checked = !chk.checked;
            highlight_row();
        }   
    }); 
    $('.action-checkall').click(function(e){
        var checked = e.target.checked; 
        $(".tbl-checkall td input:checkbox").attr('checked', checked);
        highlight_row();
    }); 

    $('.buttons button').click(function(e){
        var action = this.name;
        $('#batch-action').val(action);
        $('#frm-batch').submit();
    });
    
});
</script>

</div>

<?php
include 'inc/footer.php';

