
$(document).ready(function(){

  $(function () {
    //unchecked checkbox when page load
    $('#diff-acc').prop('checked',false);

    //show/hide if the checkbox is check/uncheck
    $(".checkout__input__checkbox").on('click', '#diff-acc', () => {
      showHideDivision($('#diff-acc'),$('#shipping-address-div'));
    })

    $("#placeOrderBtn").click(function(e){
      if(!$('#payment').is(':checked')){
        $('#checkReminder').html("Please check 'Pay by Cash'");
        e.preventDefault();
      }
      else{
        $('#checkReminder').html("");
      }
    })
  });

  function showHideDivision(checkbox,division){
    if($(checkbox).is(":checked")){
      $(division).show();
      $("#diff-address").prop("required",true);
    }
    else{
      $(division).hide();
      $("#diff-address").prop("required",false);
    }
  }
  
}); 
  
