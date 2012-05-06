
<!-- pager -->
<div class="pager">
<div class="pg">
<?php 
echo util_pager::gethtml($page, $total_page);
?>
</div>

<div class="link">
<?php for($i=0;$i<4;$i++) { 
    if(empty($pager_link[$i])){
            continue;
    }
    $item = $pager_link[$i];
?>
    <a target="_blank" href="<?php echo $this->escape($item['url']); ?>"<?php if(!empty($item['color'])) echo ' style="color:#'.$item['color'].'"'; ?>><?php echo $this->escape($item['name']); ?></a>
<?php } ?>
</div>
</div>
<!-- /pager -->

