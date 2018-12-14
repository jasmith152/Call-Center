// QUERY STRING
jQuery.query = function(s){
  // http://stackoverflow.com/questions/1162791/jquery-query-string-traversal
  var r = {};
  if(s){
    if(s.indexOf('?') >= 0){
      s = s.substring(s.indexOf('?') + 1); // remove everything up to the ?
    }
    if(s.indexOf('#') >= 0){
      s = s.substring(0, s.indexOf('#')); // get everything before hash
    }
    s = s.replace(/\&amp;/, '&'); // fix amps
    s = s.replace(/\&$/, ''); // remove the trailing &
    jQuery.each(s.split('&'), function(){
      var splitted = this.split('=');
      if(splitted.length === 2){
        var key = splitted[0];
        var val = splitted[1];
        // convert numbers
        if(/^[0-9.]+$/.test(val)){
          val = parseFloat(val);
        }
        // convert booleans
        if(val == 'true'){
          val = true;
        }
        if(val == 'false'){
          val = false;
        }
        // ignore empty values
        if(typeof val == 'number' || typeof val == 'boolean' || val.length > 0){
          r[key] = val;
        }
      }else if(splitted.length === 1){
        r[splitted[0]] = '';
      }
    });
  }
  return r;
};

function checkPphone(){
  var value = $('#lcc_pphone1').val()+$('#lcc_pphone2').val()+$('#lcc_pphone3').val();
  if(value.length==10){
    $.ajax({
      type:'GET',
      url:'/ccenter/ajax/request/duplicate/http.php?check=lcc_contact_phone&value='+value,
      cache:false,
      success:function(data){
        if(data.call_center !== null || data.pre_qual !== null || data.recycled !== null){
          $('#duplicate_fields').show();
          $('#lcc_pphone1,#lcc_pphone2,#lcc_pphone3').css('border-color','red');
          //Call Center Pphone
          if(data.call_center !== null){
            $('#call_center_duplicates').show();
            $('#call_center_duplicates tr:not(:first)').remove();
            var call_center_html = '';
            $.each(data.call_center, function(i,row){
              var rowColor = (i%2)?'#E0ECF8':'#F2F2F2';
              call_center_html += '<tr bgcolor='+rowColor+'>';
              //call_center_html += '<td align="right" style="width:1px">'+row.id+'</td>';
              call_center_html += '<td>'+row.fname+' '+row.lname+'</td>';
              call_center_html += '<td style="width:1px;cursor:pointer;" title="Open in Call Center" onclick="window.location=\'../update.php?cad_call='+row.id+'\'"><img src="/ccenter/images/icons/fatcow/16x16/telephone_go.png" /></td>';
              call_center_html += '</tr>';
            });
            $('#call_center_duplicates_tr').after(call_center_html);
          }
          else
          {
            $('#call_center_duplicates').hide();
            $('#call_center_duplicates tr:not(:first)').remove();
          }
          //END Call Center Pphone
          //Prequal Pphone
          if(data.pre_qual !== null){
            $('#pre_qual_duplicates').show();
            $('#pre_qual_duplicates tr:not(:first)').remove();
            var pre_qual_html = '';
            $.each(data.pre_qual, function(i,row){
              var rowColor = (i%2)?'#E0ECF8':'#F2F2F2';
              pre_qual_html += '<tr bgcolor='+rowColor+'>';
              //pre_qual__html += '<td align="right" style="width:1px">'+row.id+'</td>';
              pre_qual_html += '<td>'+row.fname+' '+row.lname+'</td>';
              pre_qual_html += '<td style="width:1px;cursor:pointer;" title="Add to Call Center"><img src="/ccenter/images/icons/fatcow/16x16/telephone_add.png" /></td>';
              pre_qual_html += '</tr>';
            });
            $('#pre_qual_duplicates_tr').after(pre_qual_html);
          }
          else
          {
            $('#pre_qual_duplicates').hide();
            $('#pre_qual_duplicates tr:not(:first)').remove();
          }
          //END Prequal Pphone
          //Recycled Pphone
          if(data.recycled !== null){
            $('#recycled_duplicates').show();
            $('#recycled_duplicates tr:not(:first)').remove();
            var recycled_html = '';
            $.each(data.recycled, function(i,row){
              var rowColor = (i%2)?'#E0ECF8':'#F2F2F2';
              recycled_html += '<tr bgcolor='+rowColor+'>';
              //recycled__html += '<td align="right" style="width:1px">'+row.id+'</td>';
              recycled_html += '<td>'+row.fname+' '+row.lname+'</td>';
              recycled_html += '<td style="width:1px;cursor:pointer;" title="Add to Call Center"><img src="/ccenter/images/icons/fatcow/16x16/telephone_add.png" /></td>';
              recycled_html += '</tr>';
            });
            $('#recycled_duplicates_tr').after(recycled_html);
          }
          else
          {
            $('#recycled_duplicates').hide();
            $('#recycled_duplicates tr:not(:first)').remove();
          }
        //END Recycled Pphone
        }
        else
        {
          $('#duplicate_fields').hide();
          $('#call_center_duplicates').hide();
          $('#call_center_duplicates tr:not(:first)').remove();
          $('#pre_qual_duplicates').hide();
          $('#pre_qual_duplicates tr:not(:first)').remove();
          $('#recycled_duplicates').hide();
          $('#recycled_duplicates tr:not(:first)').remove();
          $('#lcc_pphone1,#lcc_pphone2,#lcc_pphone3').css('border-color','#00FF00');
        }
      },
      error:function (xhr, ajaxOptions, thrownError){
        alert(xhr.status);
        alert(thrownError);
      }
    });
  }
}

function checkCellPhone(){
  var value = $('#lcc_aphone1').val()+$('#lcc_aphone2').val()+$('#lcc_aphone3').val();
  if(value.length==10){
    $.ajax({
      type:'GET',
      url:'/ccenter/ajax/request/duplicate/http.php?check=lcc_contact_phone&value='+value,
      cache:false,
      success:function(data){
        if(data.call_center !== null || data.pre_qual !== null || data.recycled !== null){
          $('#duplicate_cell_fields').show();
          $('#lcc_aphone1,#lcc_aphone2,#lcc_aphone3').css('border-color','red');
          //Call Center Pphone
          if(data.call_center !== null){
            $('#call_center_duplicates_cell').show();
            $('#call_center_duplicates_cell tr:not(:first)').remove();
            var call_center_html = '';
            $.each(data.call_center, function(i,row){
              var rowColor = (i%2)?'#E0ECF8':'#F2F2F2';
              call_center_html += '<tr bgcolor='+rowColor+'>';
              //call_center_html += '<td align="right" style="width:1px">'+row.id+'</td>';
              call_center_html += '<td>'+row.fname+' '+row.lname+'</td>';
              call_center_html += '<td style="width:1px;cursor:pointer;" title="Open in Call Center" onclick="window.location=\'../update.php?cad_call='+row.id+'\'"><img src="/ccenter/images/icons/fatcow/16x16/telephone_go.png" /></td>';
              call_center_html += '</tr>';
            });
            $('#call_center_duplicates_cell_tr').after(call_center_html);
          }
          else
          {
            $('#call_center_duplicates_cell').hide();
            $('#call_center_duplicates_cell tr:not(:first)').remove();
          }
          //END Call Center Pphone
          //Prequal Pphone
          if(data.pre_qual !== null){
            $('#pre_qual_duplicates_cell').show();
            $('#pre_qual_duplicates_cell tr:not(:first)').remove();
            var pre_qual_html = '';
            $.each(data.pre_qual, function(i,row){
              var rowColor = (i%2)?'#E0ECF8':'#F2F2F2';
              pre_qual_html += '<tr bgcolor='+rowColor+'>';
              //pre_qual__html += '<td align="right" style="width:1px">'+row.id+'</td>';
              pre_qual_html += '<td>'+row.fname+' '+row.lname+'</td>';
              pre_qual_html += '<td style="width:1px;cursor:pointer;" title="Add to Call Center"><img src="/ccenter/images/icons/fatcow/16x16/telephone_add.png" /></td>';
              pre_qual_html += '</tr>';
            });
            $('#pre_qual_duplicates_cell_tr').after(pre_qual_html);
          }
          else
          {
            $('#pre_qual_duplicates_cell').hide();
            $('#pre_qual_duplicates_cell tr:not(:first)').remove();
          }
          //END Prequal Pphone
          //Recycled Pphone
          if(data.recycled !== null){
            $('#recycled_duplicates_cell').show();
            $('#recycled_duplicates_cell tr:not(:first)').remove();
            var recycled_html = '';
            $.each(data.recycled, function(i,row){
              var rowColor = (i%2)?'#E0ECF8':'#F2F2F2';
              recycled_html += '<tr bgcolor='+rowColor+'>';
              //recycled__html += '<td align="right" style="width:1px">'+row.id+'</td>';
              recycled_html += '<td>'+row.fname+' '+row.lname+'</td>';
              recycled_html += '<td style="width:1px;cursor:pointer;" title="Add to Call Center"><img src="/ccenter/images/icons/fatcow/16x16/telephone_add.png" /></td>';
              recycled_html += '</tr>';
            });
            $('#recycled_duplicates_cell_tr').after(recycled_html);
          }
          else
          {
            $('#recycled_duplicates_cell').hide();
            $('#recycled_duplicates_cell tr:not(:first)').remove();
          }
        //END Recycled Pphone
        }
        else
        {
          $('#duplicate_cell_fields').hide();
          $('#call_center_duplicates_cell').hide();
          $('#call_center_duplicates_cell tr:not(:first)').remove();
          $('#pre_qual_duplicates_cell').hide();
          $('#pre_qual_duplicates_cell tr:not(:first)').remove();
          $('#recycled_duplicates_cell').hide();
          $('#recycled_duplicates_cell tr:not(:first)').remove();
          $('#lcc_aphone1,#lcc_aphone2,#lcc_aphone3').css('border-color','#00FF00');
        }
      },
      error:function (xhr, ajaxOptions, thrownError){
        alert(xhr.status);
        alert(thrownError);
      }
    });
  }
}
function validateEmail(elementValue){
  var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
  return emailPattern.test(elementValue);
}
function doSubmit(user,home){
  var data = $('#new_patient').serialize();
  data = data.push({'user':user});
  $.ajax({
    url:'submit/',
    type:'POST',
    data:data,
    success:function(data){
      alert(data)
    }
  })
}
function validateCreateForm(){
  var data = $('#new_patient').serialize();
  var form = $.query(data);
  var pphone = $('#lcc_pphone1').val()+$('#lcc_pphone2').val()+$('#lcc_pphone3').val();
  var aphone = $('#lcc_aphone1').val()+$('#lcc_aphone2').val()+$('#lcc_aphone3').val();
  var email = $('#lcc_contact_email').val();
  if(form.assign_status == undefined)
  {
    alert('Please Select assigned or unassigned');
  }
  else if(form.lcc_contact_fname == undefined || form.lcc_contact_lname == undefined){
    alert('Full Name is required.');
  }
  else if(form.lcc_contact_source_one == undefined){
    alert('A source is required.');
  }
  else if(form.lcc_contact_source_one == 'Physician+Referral' && form.lcc_contact_source_two == undefined){
    alert('Please select a physician.');
  }
  else if(form.lcc_contact_source_one == 'Social+Media' && form.lcc_contact_source_two == undefined){
    alert('Please select a the website.');
  }
  else if(form.lcc_contact_source_one == 'Patient+Referral' && form.lcc_contact_source_two == undefined){
    alert('Please enter the patient\'s name.');
  }
  else if(form.lcc_contact_source_one == 'Other' && form.lcc_contact_source_two == undefined){
    alert('Source other requires additional information.');
  }
  else if(pphone.length == 0 && form.lcc_contact_email == undefined){
    alert('A preferred phone number or email address is required.');
  }
  else if(pphone.length !== 0 && pphone.length < 10){
    alert('Preferred phone is invalid.');
  }
  else if(aphone.length !== 0 && aphone.length < 10){
    alert('Cell phone is invalid.');
  }
  else if(email !== '' && !validateEmail(email))
  {
    alert('Email is invalid.');
  }
  else if(form.call_log_note == 1 && form.call_log_note_text == undefined){
    alert('Enter a call log note.')
  }
  else if(form.add_seminar == 1 && (form.seminar_id == undefined || form.lcc_seminar_attending == undefined)){
    alert('Seminar and Atendees are required.')
  }
  else
  {
    if(form.assign_status == 0){
      $('#jquery_dialog').dialog({
        modal: true,
        resizable: false,
        draggable: false,
        autoOpen:true,
        height: 'auto',
        width:350,
        position: ['center','center'],
        title: 'Unassigned Patient',
        buttons:{
          'Add Patient':function(){
            var user = $('#ua_add_user').val();
            var home = $('#ua_add_user_home').is(':checked');
            $('#assign_user').val(user);
            $('#ajax_load').css('display',null);
            $('#jquery_dialog').dialog('close');
            doSubmit(user,home);
          },
          'Cancel':function(){
            $('#jquery_dialog').dialog('close');
          }
        },
        open:function(){
          $.ajax({
            type:'GET',
            url:'dialog/',
            data:{
              type:'unassigned'
            },
            success:function(data){
              $('#jquery_dialog').html(data);
            },
            error:function (xhr, ajaxOptions, thrownError){
              alert(xhr.status);
              alert(thrownError);
            }
          })
        },
        close:function(){
          $('#jquery_dialog').dialog('destroy');
        }
      })
    }
    else
    {
      alert('assigned');
    }
  }
}

