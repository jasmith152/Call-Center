<script type="text/javascript">

  function ucwords(str) {
    return (str + '').replace(/^([a-z])|\s+([a-z])/g, function($1) {
      return $1.toUpperCase();
    });
  }



  function ajaxCall(type) {
    var data = jQuery('#cc_main').serialize();
    jQuery.ajax({
      type: 'GET',
      url: '/ccenter/form_helpers/dupe_checks/?type=' + type,
      data: data,
      dataType: 'json',
      success: function(data) {

        if (parseInt(data.nlr) > 0) {
          if (type == 'p') {
            jQuery('.nl_dupe_button_p').attr('data', data.nlr).removeClass('hide');
            jQuery('.p_error input').addClass('ui-state-error-secondary');
          }
          if (type == 'a') {
            jQuery('.nl_dupe_button_a').attr('data', data.nlr).removeClass('hide');
            jQuery('.a_error input').addClass('ui-state-error-secondary');
          }
          if (type == 'e') {
            jQuery('.nl_dupe_button_e').attr('data', data.nlr).removeClass('hide');
            jQuery('.e_error input').addClass('ui-state-error-secondary');
          }
        }
        else
        {
          if (type == 'p') {
            jQuery('.nl_dupe_button_p').attr('data', '').addClass('hide');
            jQuery('.p_error input').removeClass('ui-state-error-secondary');
          }
          if (type == 'a') {
            jQuery('.nl_dupe_button_a').attr('data', '').addClass('hide');
            jQuery('.a_error input').removeClass('ui-state-error-secondary');
          }
          if (type == 'e') {
            jQuery('.nl_dupe_button_e').attr('data', '').addClass('hide');
            jQuery('.e_error input').removeClass('ui-state-error-secondary');
          }
        }

        if (parseInt(data.cc) > 0) {
          if (type == 'p') {
            jQuery('.cc_dupe_button_p').attr('data', data.cc).removeClass('hide');
            jQuery('.p_error input').addClass('ui-state-error');
          }
          if (type == 'a') {
            jQuery('.cc_dupe_button_a').attr('data', data.cc).removeClass('hide');
            jQuery('.a_error input').addClass('ui-state-error');
          }
          if (type == 'e') {
            jQuery('.cc_dupe_button_e').attr('data', data.cc).removeClass('hide');
            jQuery('.e_error input').addClass('ui-state-error');
          }
        }
        else
        {
          if (type == 'p') {
            jQuery('.cc_dupe_button_p').attr('data', '').addClass('hide');
            jQuery('.p_error input').removeClass('ui-state-error');
          }
          if (type == 'a') {
            jQuery('.cc_dupe_button_a').attr('data', '').addClass('hide');
            jQuery('.a_error input').removeClass('ui-state-error');
          }
          if (type == 'e') {
            jQuery('.cc_dupe_button_e').attr('data', '').addClass('hide');
            jQuery('.e_error input').removeClass('ui-state-error');
          }
        }
      }
    });
  }

  jQuery(function() {
    var seminar_id = parseInt('<?php echo $sem_id; ?>');
    jQuery('.seminar-selected-option').val(seminar_id);
    var currentYear = (new Date).getFullYear();
    jQuery(".date-one").datepicker({
      dateFormat: 'yy-mm-dd',
      changeMonth: true,
      changeYear: true,
      yearRange: '1900:' + currentYear
    });
    jQuery(".is-referral-set").buttonset();
  jQuery('.save-sheet').button({
    icons: {
      primary: 'ui-icon-disk'
    }
  }).bind('click', function() {
    if (jQuery('[name=lcc_contact_fname]').val() == "")
    {
      alert("Enter a First Name");
    }
    else if (jQuery('[name=lcc_contact_lname]').val() == "")
    {
      alert("Enter a Last Name");
    }
    else if ((jQuery('[name=lcc_contact_prim_phone_two]').val() || jQuery('[name=lcc_contact_prim_phone_three]').val() || jQuery('[name=lcc_contact_prim_phone_four]').val()) == "" && jQuery('[name=lcc_contact_email]').val() == "")
    {
      alert("You must enter either a Primary Phone or an Email Address");
    }
    else if (jQuery('[name=lcc_contact_source_one]').val() == "")
    {
      alert("Atleast one Source is Required");
    }
    else if (jQuery('[name=lcc_contact_pay_type_comments]').val() == "") {
      alert('An insurance carrier is required.');
    }
    else if (!jQuery('[name="lcc_contact_had_mri"]').is(':checked')) {
      alert('Please select Yes/No qualifier: "Had MRI/CT Scan in last 5 years."');
    }
    else if ((jQuery('[name=lcc_contact_source_one]').val() == "Patient Referral") && jQuery('[name=lcc_contact_source_two]').val() == "")
    {
      alert("Name is required for referrer.");
    }
    else if (jQuery('[name="lcc_contact_lop_wc_status"]:checked').val() == 'Yes' && jQuery('[name="lcc_contact_work_related"]:checked').val() == 'No' && jQuery('[name="lcc_contact_legal_counsel"]:checked').val() == 'No') {
      alert('You must select "Work Related" or "Other" when "Open Claim" is Yes.');
    }
    else
    {
      if (confirm('Are you sure you wish to add this record?')) {
        document.cc_main.action = '/ccenter/form_helpers/contact_sheet/new/';
        document.getElementById('cc_main').submit();
      }
    }
    return false;
  });
  jQuery('.to-homepage').button({
    icons: {
      primary: 'ui-icon-home'
    }
  }).bind('click', function() {
    window.location = "/"
    return false;
  });
  jQuery('#lcc_contact_postal').bind('blur', function() {
    var url = 'http://api.laserspineinstitute.com/zip.json?code=' + jQuery(this).val();
    jQuery.ajax({
      url: url,
      dataType: 'jsonp',
      jsonp: 'jsonp_callback',
      success: function(data) {
        var city = data[0].City.toLowerCase();
        city = ucwords(city);
        jQuery('#lcc_contact_city').val(city)
        jQuery('#lcc_contact_state_prov').val(data[0].State)
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
  });
  jQuery('.phone_c').bind('blur', function() {
    if (jQuery(this).val().length >= 4) {
      ajaxCall('p');
    }
  });
  jQuery('.fax_c').bind('blur', function() {
    if (jQuery(this).val().length >= 4) {
      ajaxCall('a');
    }
  });
  jQuery('#lcc_contact_email').bind('blur', function() {
    if (jQuery(this).val().length > 5) {
      ajaxCall('e');
    }
  });
  jQuery('.cc_dupe_button').button({
    icons: {
      primary: 'ui-icon-alert'
    }
  }).bind('click', function() {
    var cc_id = jQuery(this).attr('data');
    window.location = '/ccenter/update.php?cad_call=' + cc_id
    return false;
  });
  jQuery('.nl_dupe_button').button({
    icons: {
      primary: 'ui-icon-alert'
    }
  }).bind('click', function() {
    var id = jQuery(this).attr('data');
    window.location = '/ccenter/new_leads/scrub/dupe/?nlr=1&new_lead=' + id
    return false;
  });
  jQuery('.recy_dupe_button').button({
    icons: {
      primary: 'ui-icon-alert'
    }
  }).bind('click', function() {
    return false;
  });
  jQuery('[name="lcc_contact_lop_wc_status"]').bind('click', function() {
    if (jQuery(this).val() == 'No') {
      jQuery('#lcc_contact_work_related_no').attr('checked', 'checked');
      jQuery('#lcc_contact_legal_counsel_no').attr('checked', 'checked');
    }
  });
  jQuery('[name="lcc_contact_work_related"]').bind('click', function() {
    if (jQuery('[name="lcc_contact_lop_wc_status"]:checked').val() == 'No') {
      jQuery('#lcc_contact_work_related_no').attr('checked', 'checked');
      jQuery('#lcc_contact_legal_counsel_no').attr('checked', 'checked');
      alert('Open Claim must be "Yes" to make this selection.');
      jQuery(this).blur();
    }
    else
    {
      if (jQuery(this).val() == 'Yes') {
        jQuery('#lcc_contact_legal_counsel_no').attr('checked', 'checked');
      }
      else
      {
        jQuery('#lcc_contact_legal_counsel_yes').attr('checked', 'checked');
      }

    }
  });
  jQuery('[name="lcc_contact_legal_counsel"]').bind('click', function() {
    if (jQuery('[name="lcc_contact_lop_wc_status"]:checked').val() == 'No') {
      jQuery('#lcc_contact_work_related_no').attr('checked', 'checked');
      jQuery('#lcc_contact_legal_counsel_no').attr('checked', 'checked');
      alert('Open Claim must be "Yes" to make this selection.');
      jQuery(this).blur();
    }
    else
    {
      if (jQuery(this).val() == 'Yes') {
        jQuery('#lcc_contact_work_related_no').attr('checked', 'checked');
      }
      else
      {
        jQuery('#lcc_contact_work_related_yes').attr('checked', 'checked');
      }
    }
  });
  jQuery('.pay-class-changer').bind('change', function() {
    var value = jQuery(this).val();
    if (value.length > 0)
    {
      jQuery.ajax({
        type: 'post',
        url: '/ccenter/create/old/proxy/pay_class.php',
        data: {
          carrier: value
        },
        success: function(data) {
          jQuery('.pay-class-change').html(data).css('color', 'blue')
        }
      })
    }
    else
    {
      jQuery('.pay-class-change').html('Select Carrier').css('color', 'red')
    }
  });
  });
</script>