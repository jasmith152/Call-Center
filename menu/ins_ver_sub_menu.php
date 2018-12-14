<div class="ins_ver_sub_menu">
<ul>
<li id="IvOne" class=""><a HREF="javascript:void(0);" onClick="IvOne()">Patient Info</a></li>
<li id="IvTwo" class="selected"><a HREF="javascript:void(0);" onClick="IvTwo();">Primary Insurance<? if($lcc_ins_ver_ins_name){echo '&nbsp;<img src="images/checkmark.gif" border="0" />';}?></a></li>
<?php if($lcc_ins_ver_ins_name ==  'SELF PAY' || $lcc_ins_ver_ins_name ==  'LOP' || $lcc_ins_ver_ins_name ==  'Work Comp'){?>
<li id="IvThree" class=""><a HREF="javascript:void(0);" onClick="alert('Disabled due to Insurnace Carrier.');"><font color="#999999">Secondary Insurance</font></a></li>
<?php }else{ ?>
<li id="IvThree" class=""><a HREF="javascript:void(0);" onClick="IvThree();">Secondary Insurance<? if($lcc_ins_ver_sec_ins_name){echo '&nbsp;<img src="images/checkmark.gif" border="0" />';}?></a></li>
<?php }?>
<li id="IvFour" class=""><a HREF="javascript:void(0);" onClick="IvFour();">Verified</a></li>
</ul>
</div>