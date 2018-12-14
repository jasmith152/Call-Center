<form style="display:none" id="proxy" method="post" action="http://lsicallcenter/ccenter/create/old/" target="_self">
  <?php
  foreach ($_GET as $k => $v)
  {
    ?>
    <input name="<?php echo $k; ?>" value="<?php echo $v; ?>" />
    <?php
  }
  ?>
</form>
<script type="text/javascript">
    document.getElementById('proxy').submit();
</script>