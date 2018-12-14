<?php
session_start();
if(!$_SESSION['session_registered'])
{
  header("location:/login/login.php");
}
else
{
  include $_SERVER['DOCUMENT_ROOT'].'/ccenter/lists/functions/index.php';
  include $_SERVER['DOCUMENT_ROOT'].'/ccenter/images/functions/index.php';
  $source = getSourceOptions();
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <title>Create New Patient</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="title" content="LSI Lead Statistics" />
    <meta name="description" content="Laser Spine Institute Lead Generation Resources" />
    <meta name="keywords" content="" />
    <meta name="language" content="en" />
    <meta name="robots" content="noindex, nofollow" />
    <link type="text/css" href="/ccenter/css/home.css" rel="stylesheet" />
    <link type="text/css" href="/ccenter/css/create/main.css" rel="stylesheet" />
    <link type="text/css" href="/ccenter/css/login/main.css" rel="stylesheet" />
    <script type="text/javascript" src="/ccenter/lib/jquery/jquery-1.4.1.min.js"></script>
    <script type="text/javascript" src="/ccenter/lib/jquery/jquery-ui-1.8rc1.custom.min.js"></script>
    <script type="text/javascript" src="/ccenter/lib/jquery/jquery.cookie.js"></script>
    <script type="text/javascript" src="/ccenter/lib/jquery/jquery.autotab.js"></script>
    <script type="text/javascript" src="/ccenter/ajax/request/duplicate/js/jquery.create.js"></script>
    <script type="text/javascript" src="/ccenter/lib/jquery/create/main.js"></script>
  </head>
  <body>
    <div id="create_wrapper" style="display:none">
        <?php include $_SERVER['DOCUMENT_ROOT'].'/login/header/index.php';?>
      <div id="content_wrapper">
        <div id="content" class="ui-widget-content ui-corner-all">
          <form id="new_patient" name="new_patient" action="">
            <table border="0" width="100%" cellpadding="0" cellspacing="0">
              <tr valign="top" class="ui-widget-header ui-corner-top">
                <td>
                  <div  id="assigned_status">
                    <input type="radio" id="assign_status_yes" name="assign_status" value="1" /><label for="assign_status_yes">Assigned</label>
                    <input type="radio" id="assign_status_no" name="assign_status" value="0" checked="checked" /><label for="assign_status_no">Unassigned</label>
                  </div>
                </td>
                <td align="right" class="menu-bar">
                  <div class="icon"><?php echo iconHelper(null, 'icons', 'moment', '32','home',null,'20','20','Home') ;?></div>
                  <div class="icon" onclick="validateCreateForm()"><?php echo iconhelper(null, 'icons', 'fatcow', '32x32','user_add',null,'20','20','Add Patient') ;?></div>
                </td>
                <td>&nbsp;</td>
              </tr>
              <tr valign="top">
                <td style="width:100px">
                  <fieldset class="ui-widget-content ui-corner-all">
                    <legend class="ui-corner-all ui-widget-header">General</legend>
                    <table width="100%" cellpadding="4" border="0">
                      <tr>
                        <td>
                          <label class="first">Prefix</label>
                        </td>
                        <td>
                          <select id="lcc_contact_prefix" name="lcc_contact_prefix">
                            <option value="">-</option>
                            <option value="Miss">Miss</option>
                            <option value="Mr">Mr</option>
                            <option value="Mrs">Mrs</option>
                            <option value="Ms">Ms</option>
                            <option value="Dr">Dr</option>
                            <option value="Rev">Rev</option>
                          </select>
                        </td>
                        <td>
                          <label class="required">Name</label>
                        </td>
                        <td>
                          <input type="text" id="lcc_contact_fname" name="lcc_contact_fname" />
                        </td>
                        <td>
                          <label class="required">Last Name</label>
                        </td>
                        <td>
                          <input type="text" id="lcc_contact_lname" name="lcc_contact_lname" />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label>Alias</label>
                        </td>
                        <td>
                          <input type="text" id="lcc_contact_alias" name="lcc_contact_alias" />
                        </td>
                        <td>
                          <label>Birth Date</label>
                        </td>
                        <td>
                          <input type="text" tabindex="-1" id="lcc_contact_dob" name="lcc_contact_dob" style="text-align:center" readonly="readonly" />
                        </td>
                        <td>
                          <label>Gender</label>
                        </td>
                        <td>
                          <select id="lcc_contact_gender" name="lcc_contact_gender">
                            <option value="">Select</option>
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label class="first">Address</label>
                        </td>
                        <td colspan="5">
                          <input type="text" id="lcc_contact_address" name="lcc_contact_address" />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label>Postal</label>
                        </td>
                        <td>
                          <input type="text" id="lcc_contact_postal" name="lcc_contact_postal" />
                        </td>
                        <td>
                          <label>City</label>
                        </td>
                        <td>
                          <input tabindex="-1" type="text" id="lcc_contact_city" name="lcc_contact_city" />
                        </td>
                        <td>
                          <label>State</label>
                        </td>
                        <td>
                          <select tabindex="-1" id="lcc_contact_state_prov" name="lcc_contact_state_prov" >
                            <option value="">Select</option>
                              <?php echo getStateOptionList() ;?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label>Country</label>
                        </td>
                        <td>
                          <select tabindex="-1" id="lcc_contact_country" name="lcc_contact_country" >
                            <option value="">Select</option>
                              <?php echo getCountryOptionList() ;?>
                          </select>
                        </td>
                        <td>
                          <label>Source</label>
                        </td>
                        <td colspan="3">
                          <select class="source" id="lcc_contact_source_one" name="lcc_contact_source_one">
                            <option value="">Select</option>
                              <?php
                              echo $source[0]
                              ?>
                          </select>
                          <select class="source source_select" id="" name="" style="display: none">
                            <option value="">Select</option>
                              <?php
                              echo $source[1]
                              ?>
                          </select>
                          <input class="source_text" id="" name="" type="text" style="display: none" value="" />
                        </td>
                      </tr>
                    </table>
                  </fieldset>
                  <fieldset class="ui-widget-content ui-corner-all">
                    <legend class="ui-corner-all ui-widget-header">Contact</legend>
                    <fieldset class="ui-widget-content ui-corner-all">
                      <legend class="ui-corner-all ui-widget-header ui-state-hover">Phone</legend>
                      <table width="100%" cellpadding="4" border="0">
                        <tr>
                          <td>
                            <label class="first">Pref.</label>
                          </td>
                          <td width="30%">
                            <input type="text" class="three_digit" id="lcc_pphone1" name="lcc_pphone1" maxlength="3" />
                            <input type="text" class="three_digit" id="lcc_pphone2" name="lcc_pphone2" maxlength="3" />
                            <input type="text" class="four_digit" id="lcc_pphone3" name="lcc_pphone3"  maxlength="4" />
                          </td>
                          <td>
                            <label class="first">Cell</label>
                          </td>
                          <td width="30%">
                            <input type="text" class="three_digit" id="lcc_aphone1" name="lcc_aphone1" maxlength="3" />
                            <input type="text" class="three_digit" id="lcc_aphone2" name="lcc_aphone2" maxlength="3" />
                            <input type="text" class="four_digit" id="lcc_aphone3" name="lcc_aphone3" maxlength="4" />
                          </td>
                          <td>
                            <label class="first">Work</label>
                          </td>
                          <td title="Currently unavailable" width="30%">
                            <input type="text" title="Currently unavailable" class="three_digit dis" id="lcc_wphone1" name="lcc_wphone1" maxlength="3" disabled="disabled" />
                            <input type="text" title="Currently unavailable" class="three_digit dis" id="lcc_wphone2" name="lcc_wphone2" maxlength="3" disabled="disabled" />
                            <input type="text" title="Currently unavailable" class="four_digit dis" id="lcc_wphone3" name="lcc_wphone3" maxlength="4" disabled="disabled" />
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label class="first">Ext.</label>
                          </td>
                          <td width="30%">
                            <input type="text" tabindex="-1" id="lcc_contact_prim_phone_ext" name="lcc_contact_prim_phone_ext" maxlength="3" />
                          </td>
                          <td>
                            <label class="first">Ext.</label>
                          </td>
                          <td width="30%">
                            <input type="text" tabindex="-1" class="" id="lcc_contact_alt_phone_ext" name="lcc_contact_alt_phone_ext" />
                          </td>
                          <td>
                            <label class="first">Ext.</label>
                          </td>
                          <td title="Currently unavailable" width="30%">
                            <input type="text" tabindex="-1" title="Currently unavailable" class="dis" id="lcc_contact_work_phone_ext" name="lcc_contact_work_phone_ext" disabled="disabled" />
                          </td>
                        </tr>
                      </table>
                    </fieldset>
                    <table width="100%" cellpadding="4" border="0">
                      <tr>
                        <td>
                          <label class="first">Email</label>
                        </td>
                        <td width="60%">
                          <input type="text" id="lcc_contact_email" name="lcc_contact_email" />
                        </td>
                        <td>
                          <select id="lcc_contact_best_time_id" name="lcc_contact_best_time_id">
                            <option value="">Best Time to Contact</option>
                              <?php echo getBestTimeOptions(); ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label class="first">Notes</label>
                        </td>
                        <td>
                          <input type="text" id="lcc_reminder_note" name="lcc_reminder_note" maxlength="255" />
                        </td>
                        <td>
                          <select id="lcc_contact_timezone" name="lcc_contact_timezone">
                            <option value="">Select Timezone</option>
                              <?php echo getTimezoneOptions(); ?>
                          </select>
                        </td>
                      </tr>
                    </table>
                  </fieldset>
                  <fieldset class="ui-widget-content ui-corner-all">
                    <legend class="ui-corner-all ui-widget-header">Insurance</legend>
                    <table width="100%" cellpadding="4" border="0">
                      <tr>
                        <td>
                          <label class="first">Class</label>
                        </td>
                        <td>
                          <select id="lcc_contact_payment_type_id" name="lcc_contact_payment_type_id">
                            <option value="">Select</option>
                              <?php
                              echo  getPayClassOptions();
                              ?>
                          </select>
                        </td>
                        <td>
                          <label class="first">Carrier</label>
                        </td>
                        <td colspan="2">
                          <input type="text" id="lcc_contact_pay_type_comments" name="lcc_contact_pay_type_comments" />
                          <select id="lcc_contact_payment_type_two" name="lcc_contact_payment_type_two" style="width:70px">
                            <option value="">Type</option>
                            <option value="HMO">HMO</option>
                            <option value="PPO">PPO</option>
                          </select>
                        </td>
                      </tr>
                    </table>
                  </fieldset>
                  <fieldset class="ui-widget-content ui-corner-all">
                    <legend class="ui-corner-all ui-widget-header">Add Log Note</legend>
                    <table width="100%" cellpadding="4" border="0" class="no_float">
                      <tr>
                        <td colspan="2">
                          <div  id="call_log" style="display:inline">
                            <input type="radio" id="call_log_note_yes" name="call_log_note" value="1" /><label for="call_log_note_yes">Yes</label>
                            <input type="radio" id="call_log_note_no" name="call_log_note" value="0" checked="checked" /><label for="call_log_note_no">No</label>
                          </div>
                        </td>
                      </tr>
                      <tr class="call_log_note_hide" style="display:none">
                        <td>
                          <textarea id="call_log_note_text" name="call_log_note_text" cols="" rows="" style="width:98%; height:50px;"></textarea>
                        </td>
                      </tr>
                    </table>
                  </fieldset>
                </td>
                <!--/ ########################################## START CENTER COLUMN ########################################## /-->
                <td style="width:3px">
                  <fieldset class="ui-widget-content ui-corner-all">
                    <legend class="ui-corner-all ui-widget-header">Candidacy</legend>
                    <table width="100%" cellpadding="4" border="0" class="no_float">
                      <tr>
                        <td width="1%">
                          <label class="first">Select area of pain.</label>
                        </td>
                        <td align="right">
                          <div  id="eval_buttons">
                            <input type="checkbox" id="lcc_contact_eval_area" name="lcc_contact_eval_area" value="CS" /><label for="lcc_contact_eval_area">CS</label>
                            <input type="checkbox" id="lcc_contact_eval_areaa" name="lcc_contact_eval_areaa" value="TS" /><label for="lcc_contact_eval_areaa">TS</label>
                            <input type="checkbox" id="lcc_contact_eval_areab" name="lcc_contact_eval_areab" value="LS" /><label for="lcc_contact_eval_areab">LS</label>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label class="first">Has been in pain for 6 Months.</label>
                        </td>
                        <td align="right">
                          <div  id="pain_time">
                            <input type="radio" id="lcc_contact_pain_time_yes" name="lcc_contact_pain_time" value="1" /><label class="slider_set" for="lcc_contact_pain_time_yes">Yes</label>
                            <input type="radio" id="lcc_contact_pain_time_no" name="lcc_contact_pain_time" value="0" checked="checked" /><label class="slider_set" for="lcc_contact_pain_time_no">No</label>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label class="first">Has tried pain management.</label>
                        </td>
                        <td align="right">
                          <div  id="pain_manage">
                            <input type="radio" id="lcc_contact_pain_management_yes" name="lcc_contact_pain_management" value="1" /><label class="slider_set" for="lcc_contact_pain_management_yes">Yes</label>
                            <input type="radio" id="lcc_contact_pain_management_no" name="lcc_contact_pain_management" value="0" checked="checked" /><label class="slider_set" for="lcc_contact_pain_management_no">No</label>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <label class="first">Had MRI/CT scan in last 2 years.</label>
                        </td>
                        <td align="right">
                          <div  id="had_mri">
                            <input type="radio" id="lcc_contact_had_mri_yes" name="lcc_contact_had_mri" value="1" /><label class="slider_set" for="lcc_contact_had_mri_yes">Yes</label>
                            <input type="radio" id="lcc_contact_had_mri_no" name="lcc_contact_had_mri" value="0" checked="checked" /><label class="slider_set" for="lcc_contact_had_mri_no">No</label>
                          </div>
                        </td>
                      </tr>
                      <tr style="display:none">
                        <td align="center" colspan="2" class="ui-widget-content">
                          <div class="ui-widget-header ui-corner-top ui-state-hover" style="padding:2px">Quality Score </div>
                          <div id="quality_score" style="margin:10px 10px"></div>
                        </td>
                      </tr>
                    </table>
                  </fieldset>
                  <fieldset class="ui-widget-content ui-corner-all">
                    <legend class="ui-corner-all ui-widget-header">Legal</legend>
                    <table width="100%" cellpadding="4" border="0" class="no_float">
                      <tr>
                        <td>
                          <label class="first">Injury was due to an accident.</label>
                        </td>
                        <td align="right">
                          <div  id="wc_status">
                            <input type="radio" id="lcc_contact_lop_wc_status_yes" name="lcc_contact_lop_wc_status" value="1" /><label for="lcc_contact_lop_wc_status_yes">Yes</label>
                            <input type="radio" id="lcc_contact_lop_wc_status_no" name="lcc_contact_lop_wc_status" value="0" checked="checked" /><label for="lcc_contact_lop_wc_status_no">No</label>
                          </div>
                        </td>
                      </tr>
                      <tr class="legal_question_hide" style="display:none">
                        <td>
                          <label class="first"> <img class="rotate_img_180" alt="" src="/ccenter/images/icons/fatcow/16x16/arrow_turn_left.png" />Was it work related.</label>
                        </td>
                        <td align="right">
                          <div  id="work_related">
                            <input type="radio" id="lcc_contact_work_related_yes" name="lcc_contact_work_related" value="1" /><label for="lcc_contact_work_related_yes">Yes</label>
                            <input type="radio" id="lcc_contact_work_related_no" name="lcc_contact_work_related" value="0" checked="checked" /><label for="lcc_contact_work_related_no">No</label>
                          </div>
                        </td>
                      </tr>
                      <tr class="legal_question_hide" style="display:none">
                        <td>
                          <label class="first"> <img class="rotate_img_180" alt="" src="/ccenter/images/icons/fatcow/16x16/arrow_turn_left.png" />Considering legal counsel.</label>
                        </td>
                        <td align="right">
                          <div  id="legal_counsel">
                            <input type="radio" id="lcc_contact_legal_counsel_yes" name="lcc_contact_legal_counsel" value="1" /><label for="lcc_contact_legal_counsel_yes">Yes</label>
                            <input type="radio" id="lcc_contact_legal_counsel_no" name="lcc_contact_legal_counsel" value="0" checked="checked" /><label for="lcc_contact_legal_counsel_no">No</label>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </fieldset>
                  <fieldset class="ui-widget-content ui-corner-all">
                    <legend class="ui-corner-all ui-widget-header">Add a Seminar</legend>
                    <table width="100%" cellpadding="4" border="0" class="no_float">
                      <tr>
                        <td align="right" colspan="2">
                          <div  id="seminar_add" style="display:inline">
                            <input type="radio" id="add_seminar_yes" name="add_seminar" value="1" /><label for="add_seminar_yes">Yes</label>
                            <input type="radio" id="add_seminar_no" name="add_seminar" value="0" checked="checked" /><label for="add_seminar_no">No</label>
                          </div>
                        </td>
                      </tr>
                      <tr class="add_seminar_hide" style="display:none">
                        <td colspan="2" align="center">
                          <select id="seminar_id" name="seminar_id">
                            <option value="">Select Seminar</option>
                              <?php
                              echo getAvailableSeminarsOptions()
                              ?>
                          </select>
                        </td>
                      </tr>
                      <tr class="add_seminar_hide" style="display:none">
                        <td>
                          <label class="first">Number of attendees.</label>
                        </td>
                        <td>
                          <input type="text" id="lcc_seminar_attending" name="lcc_seminar_attending" value="1"/>
                        </td>
                      </tr>
                      <tr class="add_seminar_hide" style="display:none">
                        <td>
                          <label class="first">Will bring MRI/CT Scan</label>
                        </td>
                        <td align="right">
                          <div  id="seminar_consult" style="display:inline">
                            <input type="radio" id="lcc_seminar_consult_yes" name="lcc_seminar_consult" value="1" /><label for="lcc_seminar_consult_yes">Yes</label>
                            <input type="radio" id="lcc_seminar_consult_no" name="lcc_seminar_consult" value="0" checked="checked" /><label for="lcc_seminar_consult_no">No</label>
                          </div>
                        </td>
                      </tr>
                      <tr class="add_seminar_hide" style="display:none">
                        <td colspan="2" align="center">
                          <select id="lcc_seminar_topic" name="lcc_seminar_topic">
                            <option value="">Select most interesting seminar topic</option>
                            <option value="Insurance Coverage">Insurance Coverage</option>
                            <option value="LSI General Information">LSI General Information</option>
                            <option value="Spine Education">Spine Education</option>
                            <option value="Physician Consultation">Physician Consultation</option>
                          </select>
                        </td>
                      </tr>
                    </table>
                  </fieldset>
                </td>
                <td>
                  <fieldset class="ui-widget-content ui-corner-all ui-state-error" id="duplicate_fields" style="display:none">
                    <legend class="ui-corner-all ui-widget-header ui-state-error">Duplicates (Pref.)</legend>
                    <table id="call_center_duplicates" class="ui-widget-content ui-corner-all" width="100%" cellpadding="2" border="0" style="display:none">
                      <tr id="call_center_duplicates_tr">
                        <td class="ui-widget-header ui-corner-top" colspan="2">Call Center</td>
                      </tr>
                    </table>
                    <table id="pre_qual_duplicates" class="ui-widget-content ui-corner-all" width="100%" cellpadding="2" border="0" style="display:none">
                      <tr id="pre_qual_duplicates_tr">
                        <td class="ui-widget-header ui-corner-top" colspan="2">Pre Qualify</td>
                      </tr>
                    </table>
                    <table id="recycled_duplicates" class="ui-widget-content ui-corner-all" width="100%" cellpadding="2" border="0" style="display:none">
                      <tr id="recycled_duplicates_tr">
                        <td class="ui-widget-header ui-corner-top" colspan="2">Recycled</td>
                      </tr>
                    </table>
                  </fieldset>
                  <fieldset class="ui-widget-content ui-corner-all ui-state-error" id="duplicate_cell_fields" style="display:none">
                    <legend class="ui-corner-all ui-widget-header ui-state-error">Duplicates (Cell)</legend>
                    <table id="call_center_duplicates_cell" class="ui-widget-content ui-corner-all" width="100%" cellpadding="2" border="0" style="display:none">
                      <tr id="call_center_duplicates_cell_tr">
                        <td class="ui-widget-header ui-corner-top" colspan="2">Call Center</td>
                      </tr>
                    </table>
                    <table id="pre_qual_duplicates_cell" class="ui-widget-content ui-corner-all" width="100%" cellpadding="2" border="0" style="display:none">
                      <tr id="pre_qual_duplicates_cell_tr">
                        <td class="ui-widget-header ui-corner-top" colspan="2">Pre Qualify</td>
                      </tr>
                    </table>
                    <table id="recycled_duplicates_cell" class="ui-widget-content ui-corner-all" width="100%" cellpadding="2" border="0" style="display:none">
                      <tr id="recycled_duplicates_cell_tr">
                        <td class="ui-widget-header ui-corner-top" colspan="2">Recycled</td>
                      </tr>
                    </table>
                  </fieldset>
                </td>
              </tr>
            </table>
            <input type="hidden" id="assign_user" name="assign_user" />
          </form>
        </div>
      </div>
    </div>
    <div id="jquery_dialog" style="display:none"></div>
    <div id="ajax_load" class="ui-widget-overlay" align="center" style="display:none"><img style="position: absolute;top:50%;bottom:50%;margin-left:-50px;margin-top:-50px" src="/ccenter/images/ajax-loader.gif" alt="" /></div>
  </body>
</html>
  <?php
}
?>