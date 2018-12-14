<div class="shadetabs">
<ul>
<li><a HREF="javascript:void(0);" onClick="return showLayer('general');"><? if($lcc_flagged == '1') {echo "<img src=\"images/flagged.gif\" border=\"0\" onMouseOver=\"showTip('flag_hover');\" onMouseOut=\"hideTip('flag_hover');\" onMouseMove=\"positionElement('flag_hover');\">";}?><img src="images/icons/group.png" title="Demographics" border="0" /></a></li>
<li class="selected"><a HREF="javascript:void(0);" onClick="return showLayer('log');"><img src="images/icons/log.png" title="Call Log" border="0" /></a></li>
<li><a HREF="javascript:void(0);" onClick="return showLayer('seminar');"><img src="images/icons/seminar.png" title="Seminar" border="0" /><? if($seminarcount >= 1){echo "&nbsp;<img src=\"images/checkmark.gif\" border=\"0\">";}?></a></li>
<li><a HREF="javascript:void(0);" onClick="return showLayer('films_mri');">Films/MRI<? if($film_recd == 1){echo "&nbsp;<img src=\"images/checkmark.gif\" border=\"0\">";}?></a></li>
<li><a HREF="javascript:void(0);" onClick="return showLayer('eval_sht');">Eval. Sht.<? if($lcc_eval_sht_id){echo "&nbsp;<img src=\"images/checkmark.gif\" border=\"0\">";}?></a></li>
<li><a HREF="javascript:void(0);" onClick="return showLayer('mri_cons');">MRI/Consult<? if($mriconscount >= 1){echo "&nbsp;<img src=\"images/checkmark.gif\" border=\"0\">";}?></a></li>
<li><a HREF="javascript:void(0);" onClick="return showLayer('ins_ver');"><? if($insvercount >= 1){if($lcc_ins_ver_risk == 2 || !$lcc_ins_ver_id){echo "<font color=\"red\">";}else {echo "<font color=\"green\">";}} else {echo "<font color=\"black\">";} ?>Ins. Verify</font><? if($insvercount >= 1){echo "&nbsp;<img src=\"images/checkmark.gif\" border=\"0\">";}if($insvercount >= 1 && $lcc_ins_ver_warning >= 61){echo '<img src="images/warn.png" border="0" onmouseover="showTip(\'ins_ver_warn\')" onmousemove="positionElement(\'ins_ver_warn\')" onmouseout="hideTip(\'ins_ver_warn\')">';}?></a></li>
<li><a HREF="javascript:void(0);" onClick="return showLayer('new_pt_sht');"><img src="images/icons/patient-icon.png" title="Patient Sheet" border="0" height="13" width="13" /></a></li>
<li><a HREF="javascript:void(0);" onClick="return showLayer('sx');"><img src="images/icons/calendar.png" title="Scheduling" border="0" height="13" width="13" /></a></li>
<li><a HREF="javascript:void(0);" onClick="return showLayer('finance');"><img src="images/icons/finance.png" title="Finance" border="0" /><? if($fin_stat){echo " ".$fin_stat_menu;} ?></a></li>
<li><a HREF="javascript:void(0);" onClick="return showLayer('pt_test');"><img src="images/icons/feedback.png" title="Patient Testimonials" border="0" /></a></li>
<!--<li><a HREF="javascript:void(0);" onClick="return showLayer('wc_lop');"><img src="images/icons/wc_lop.png" title="Work Comp" border="0" /></a></li>-->
<li><a HREF="javascript:void(0);" onClick="return showLayer('file_upload');"><img src="images/icons/file.png" title="File Upload" border="0" /></a></li>
</ul>
</div>
