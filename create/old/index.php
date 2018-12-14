<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/ccenter/lists/functions/index.php';
include $_SERVER['DOCUMENT_ROOT'] . '/modules/functions/database/index.php';
include $_SERVER['DOCUMENT_ROOT'] . '/modules/functions/helper/index.php';
$helper = new miscHelpers();
$carrier = new lccPayClassCarrier(1);
?>
<html>
  <head>
    <title>LSI Call Center Create</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <style type="text/css">@import'/ccenter/css/update.css';</style>
    <script type="text/javascript" src="/ccenter/lib/jquery/latest/jquery.js"></script>
    <script type="text/javascript" src="/ccenter/lib/jquery/latest/custom.js"></script>
    <script type="text/javascript" src="/ccenter/lib/jquery/latest/cookie.js"></script>
    <?php
    if (isset($_SESSION['session_registered'])){
      if ($_GET['client_id'] > 0){
        $seminarContactExists = FALSE;
        $sql = "SELECT * FROM `sem_leads_raw` WHERE `web_id` = " . $_GET['client_id'] . " LIMIT 1";
        $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
        while ($r = mysql_fetch_array($result, MYSQL_ASSOC))
        {
          $seminarContactUser = $r["user"];
          $seminarContactExists = $r["ID"];
          $data[] = $r;
        }
        if (strlen(trim($seminarContactUser)) < 1){
          $sql = "UPDATE `sem_leads_raw` SET `user` = '" . $_SESSION['write_user'] . "' WHERE `web_id` = " . $_GET['client_id'] . " LIMIT 1";
          $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
        }
        $data = $data[0];
        if (!$seminarContactExists){
          ?>
          <script type="text/javascript">
            alert('It appears that this seminar was entered by another user, redirecting to home screen.');
            window.location = '/';
          </script>
          <?php
        }else if (strlen(trim($seminarContactUser)) > 0 && $seminarContactUser <> $_SESSION['write_user']){
          ?>
          <script type="text/javascript">
            alert('This patient is currently, or was previously, loaded by <?php echo $seminarContactUser; ?>, <?php echo $seminarContactUser; ?> user must complete the entry.');
            window.location = '/';
          </script>
          <?php
        }else{
          foreach ($data as $key => $value) {
            $$key = $value;
          }
          $PrivateCompanyInsuranceType = ($PrivateCompanyInsuranceType == "Other") ? $PrivateCompanyInsuranceTypeOther : $PrivateCompanyInsuranceType;
        }
      }else if (isset($_POST['livechatid'])){
        $EmailName = (isset($_POST['email'])) ? strtoupper($_POST['email']) : '';
        $FirstName = (isset($_POST['fname'])) ? strtoupper($_POST['fname']) : '';
        $LastName = (isset($_POST['lname'])) ? strtoupper($_POST['lname']) : '';
        $HadMri = (isset($_POST['mri']) && $_POST['mri'] == 'Yes') ? 1 : 0;
        $primPhone = (isset($_POST['phone'])) ? $_POST['phone'] : '';
        $zip = (isset($_POST['zip'])) ? $_POST['zip'] : '';
      }
      include 'includes/js.php';
    }else{
      ?>
      <script type="text/javascript">
        window.location = '/'
      </script>
      <?php
    }
    ?>
  </head>
  <body>
    <div id="secondary" class="ui-widget ui-widget-header ui-corner-top" style="font-size:110%;padding:3px;margin-bottom: 10px;"><button class="save-sheet">Create New Contact</button>
      <button tabindex="-1" class="to-homepage" style="float:right">Home</button>
      <div class="ui-helper-clearfix"></div>
    </div>
    <div id="container">
      <div id="general">
        <form id="cc_main" name="cc_main" method="post" action="">
          <div class="old-wrapped">
            <div id="personal_up" class="ui-widget-content ui-corner-all" style="top:0px; height:205px"><?php include $_SERVER['DOCUMENT_ROOT'] . '/ccenter/php/create/php/general/personal_info.php'; ?></div>
            <div id="personal_b" style="top:127px"><?php include $_SERVER['DOCUMENT_ROOT'] . '/ccenter/php/create/php/general/personal_info_hear.php'; ?></div>
            <div id="personal_c" class="ui-widget-content ui-corner-all" style="top:210px"><?php include $_SERVER['DOCUMENT_ROOT'] . '/ccenter/php/create/php/general/personal_info_pay.php'; ?></div>
          </div>
          <div id="personal_referral" class="ui-widget ui-widget-content ui-corner-all">
            <h4 style="margin:2px auto 3px 5px">Other</h4>
            <div style="width:200px; margin: 5px;">
              Physician Referred
              <div class="is-referral-set" style="display: inline-block">
                <input id="is_referral_1" type="radio" name="is_referral" value="1" /><label for="is_referral_1">Yes</label>
                <input id="is_referral_2" type="radio" name="is_referral" value="0" checked="checked"/><label for="is_referral_2">No</label>
              </div>
            </div>
          </div>
          <div class="old-wrapped">
            <div id="personal_d" class="ui-widget-content ui-corner-all" style="top:271px; padding-top:5px;"><?php include $_SERVER['DOCUMENT_ROOT'] . '/ccenter/php/create/php/general/personal_info_eval.php'; ?></div>
            <div id="personal_e_new" class="ui-widget-content ui-corner-all" style="top:336px;height:150px"><?php include $_SERVER['DOCUMENT_ROOT'] . '/ccenter/php/create/php/general/personal_info_tier_questions.php'; ?></div>
            <div id="personal_h" class="ui-widget-content ui-corner-all" style="top:336px;height:150px"><?php include $_SERVER['DOCUMENT_ROOT'] . '/ccenter/php/create/php/general/personal_info_seminar.php'; ?></div>
            <div id="tasks_new" class="ui-widget-content ui-corner-all" style="top:0px"><?php include $_SERVER['DOCUMENT_ROOT'] . '/ccenter/php/create/php/tasks/tasks.php'; ?></div>
            <div id="create_note" class="ui-widget-content ui-corner-all">
              <label class="no_float"><b>Add Call Log Note</b>&nbsp;<input class="no_float" type="checkbox"  id="add_call_log_note" name="add_call_log_note"  value="1" /></label><br />
              <textarea class="shadow" name="lcc_contact_log_notes" onKeyDown="document.getElementById('add_call_log_note').checked = 'true';" style="width:97%; height:180px"></textarea>
            </div>
            <input name="lcc_contact_date_created" type="TEXT" size="11" value="<?php echo ($datereceived) ? date('Y-m-d', strtotime($datereceived)) : date('Y-m-d'); ?>" />
            <input id="client_id" name="sem_leads_raw_web_id" type="hidden" value="<?php echo $_GET['client_id']; ?>" />
          </div>
        </form> 
        <div id="dupe_panel" class="ui-widget ui-widget-content ui-corner-all">
          <strong>Call Center<br /></strong>
          <?php include $_SERVER['DOCUMENT_ROOT'] . '/ccenter/form_helpers/dupe_checks/dupe_loaders.php'; ?>
        </div>
        <div id="dupe_panel_nlr" class="ui-widget ui-widget-content ui-corner-all">
          <strong>Held Tank<br /></strong>
          <?php include $_SERVER['DOCUMENT_ROOT'] . '/ccenter/form_helpers/dupe_checks/dupe_loaders_nlr.php'; ?>
        </div>
        <div id="dupe_panel_rcy" class="ui-widget ui-widget-content ui-corner-all">
          <strong>Recycled Tank<br /></strong>
          <?php include $_SERVER['DOCUMENT_ROOT'] . '/ccenter/form_helpers/dupe_checks/dupe_loaders_recycled.php'; ?>
        </div>
      </div>
    </div>
    <div id="homeDialog"></div>
    <script>
      ajaxCall('p');
      ajaxCall('a');
      ajaxCall('e');
      if (jQuery('#lcc_contact_postal').val().length >= 5) {
        var url = 'http://api.laserspineinstitute.com/zip.json?code=' + jQuery('#lcc_contact_postal').val();
        jQuery.ajax({
          url: url,
          dataType: 'jsonp',
          jsonp: 'jsonp_callback',
          success: function(data) {
            var city = data[0].City.toUpperCase();
            jQuery('#lcc_contact_city').val(city)
            jQuery('#lcc_contact_state_prov').val(data[0].State.toUpperCase())
            jQuery('.referrer-dialog-form .modal-setup').removeClass('modal-child');
            if (parseInt(data[0].ZipCode.length) == 5) {
              jQuery('#lcc_contact_country').val('USA')
            }
            else if (parseInt(data[0].ZipCode.length) == 6) {
              jQuery('#lcc_contact_country').val('CAN')
            }
            else
            {
              jQuery('#lcc_contact_country').val('')
            }
          }
        });
      }
    </script>
    <?php
    if ($_GET['client_id']){
      ?>
      <script>
        jQuery(function() {
          jQuery('.pay-class-changer').trigger('change');
        });
      </script>
      <?php
    }
    ?>
  </body>
</html>