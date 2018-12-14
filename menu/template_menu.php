<?php
function menuTabSelect($selector, $seminarcount, $film_recd = NULL, $lcc_eval_sht_id = NULL, $mriconscount, $insvercount, $lcc_ins_ver_risk = NULL, $lcc_ins_ver_id, $lcc_ins_ver_warning = NULL, $lcc_ins_ver_date_completed = NULL, $valids)
{
  ?>
  <div class="shadetabs">
    <ul>
      <li class="<?php echo ($selector == 'general') ? 'selected' : ''; ?>"><a HREF="javascript:void(0);" onClick="return showLayer('general');">
          <img src="images/icons/group.png" title="Patient Contact Information" border="0" /></a></li>
      <li class="<?php echo ($selector == 'log') ? 'selected' : ''; ?>">
        <a id="trigger_menu_log" HREF="javascript:void(0);" onClick="return showLayer('log');">
          <img src="images/icons/log.png" title="Call Log" border="0" />
        </a>
      </li>
      <li class="<?php echo ($selector == 'seminar') ? 'selected' : ''; ?>">
        <a id="trigger_menu_seminar" HREF="javascript:void(0);" onClick="return showLayer('seminar');">
          <img src="images/icons/seminar.png" title="Seminar" border="0" />
          <?
          if ($seminarcount >= 1)
          {
            echo "&#x2713;";
          }
          ?>
        </a>
      </li>
      <li class="<?php echo ($selector == 'films') ? 'selected' : ''; ?>">
        <a id="trigger_menu_films_mri" HREF="javascript:void(0);" onClick="return showLayer('films_mri');">
          <img src="images/icons/film.png" title="Films/MRI" border="0" />
          <?
          if ($film_recd == 1)
          {
            echo "&#x2713;";
          }
          ?>
        </a>
      </li>
      <li class="<?php echo ($selector == 'eval') ? 'selected' : ''; ?>">
        <a id="trigger_menu_eval_sht" HREF="javascript:void(0);" onClick="return showLayer('eval_sht');">
          <img src="images/icons/eval-sheet.png" title="Films/MRI Evaluation Sheet" border="0" />
          <?
          if ($lcc_eval_sht_id)
          {
            echo "&#x2713;";
          }
          ?>
        </a>
      </li>
      <li class="<?php echo ($selector == 'mri') ? 'selected' : ''; ?>">
        <a id="trigger_menu_mri_cons" HREF="javascript:void(0);" onClick="return showLayer('mri_cons');">
          <img src="images/icons/mri-cons.png" title="Films/MRI Consult Log" border="0" />
          <?
          if ($mriconscount >= 1)
          {
            echo "&#x2713;";
          }
          ?>
        </a>
      </li>
      <li class="<?php echo ($selector == 'ins') ? 'selected' : ''; ?>">
        <a id="trigger_menu_ins_ver" HREF="javascript:void(0);" onClick="return showLayer('ins_ver')">
          <?
          if ($insvercount >= 1)
          {
            if ($lcc_ins_ver_risk == 2 || !$lcc_ins_ver_id || $lcc_ins_ver_warning >= 61)
            {
              echo '<img src="images/icons/ins-alert.png" title="Insurance Verification Worksheet (Risk Factor Red)" border="0" />';
            }
            else
            {
              echo '<img src="images/icons/ins-ok.png" title="Insurance Verification Worksheet (Risk Factor Green)" border="0" />';
            }
          }
          else
          {
            echo '<img src="images/icons/ins.png" title="Insurance Verification Worksheet" border="0" />';
          }
          ?>
          <?
          if ($lcc_ins_ver_date_completed && $insvercount >= 1 && date("Y", strtotime($lcc_ins_ver_date_completed)) < date("Y"))
          {
            echo " <font title='Verification was in previous year' color='6699cc'><strong>!</strong></font> ";
          }
          ?>
          <?
          if ($insvercount >= 1 && $lcc_ins_ver_warning >= 61)
          {
            echo '<img src="images/warn.png" border="0" title="Verification was completed over 60 days ago" onmousemove="positionElement(\'ins_ver_warn\')" onmouseout="hideTip(\'ins_ver_warn\')">';
          }
          else if ($insvercount >= 1)
          {
            echo "&#x2713;";
          }
          ?>
        </a>
      </li>
      
      <li class="<?php echo ($selector == 'sht') ? 'selected' : ''; ?>">
        <a id="trigger_menu_new_pt_sht" HREF="javascript:void(0);" onClick="return showLayer('new_pt_sht');">
          <img src="images/icons/patient-icon.png" title="Patient Sheet" border="0" />
        </a>
      </li>

      <li class="<?php echo ($selector == 'sx') ? 'selected' : ''; ?>">
        <a id="trigger_menu_sx" HREF="javascript:void(0);" onClick="return showLayer('sx');">
          <img src="images/icons/fugue/16/calendar-property.png" title="EMR Appointment List" border="0" />
        </a>
      </li>

    <!-- <li class="<?php //echo ($selector == 'finance')?'selected':'';     ?>"><a HREF="javascript:void(0);" onClick="return showLayer('finance');"><img src="images/icons/finance.png" title="Finance" border="0" /><? //if($fin_stat){echo " ".$fin_statmenu_tab_;}                       ?></a></li>-->

      <li class="<?php echo ($selector == 'story') ? 'selected' : ''; ?>">
        <a id="trigger_menu_story" HREF="javascript:void(0);" onClick="return showLayer('story');">
          <img src="images/icons/moment/16/bookmarks-edit.png" title="Patient Story" border="0" />
        </a>
      </li>
      
      <li class="<?php echo ($selector == 'test') ? 'selected' : ''; ?>">
        <a id="trigger_menu_pt_test" HREF="javascript:void(0);" onClick="return showLayer('pt_test');">
          <img src="images/icons/feedback.png" title="Patient Testimonials" border="0" />
        </a>
      </li>

      <li class="load-wc-lop-tab <?php echo ($selector == 'wc_lop') ? 'selected' : ''; ?>">
        <a id="trigger_menu_wc_lop" HREF="javascript:void(0);" onClick="return showLayer('wc_lop');">
          <img src="images/icons/wc_lop.png" title="Attorney Relations" border="0" />
          <img class="module-server-down hide" src="images/warn.png" border="0" title="" />
        </a>
      </li>

      <li class="load-work-comp-tab <?php echo ($selector == 'work_comp') ? 'selected' : ''; ?>">
        <a id="trigger_menu_work_comp" HREF="javascript:void(0);" onClick="return showLayer('work_comp');">
          <img class="ls-img-person-worker" src="/images/img_trans.gif" title="Worker's Compensation" border="0" />
          <img class="module-server-down hide" src="images/warn.png" border="0" title="" />
        </a>
      </li>

      <li class="<?php echo ($selector == 'file') ? 'selected' : ''; ?>">
        <a id="trigger_menu_file_upload" HREF="javascript:void(0);" onClick="return showLayer('file_upload');">
          <img class="ls-img-paperclip" src="/images/img_trans.gif" title="Attach Files" border="0" />
          <img class="module-server-down hide" src="images/warn.png" border="0" title="" />
        </a>
      </li>

    </ul>
  </div>
  <?php
}
?>