
$(document).ready(function(){

  $(function () {
    //unchecked checkbox when page load
    $('#acc').prop('checked',false);
    $('#diff-acc').prop('checked',false);


    $(".checkout__input__checkbox").on('click', '#acc', () => {
      showHideDivision($('#acc'),$('#passwordDiv'));
    })

    $(".checkout__input__checkbox").on('click', '#diff-acc', () => {
      showHideDivision($('#diff-acc'),$('#shipping-address-div'));
    })
    
  });

  function showHideDivision(checkbox,division){
    if($(checkbox).is(":checked")){
      $(division).show();
    }
    else{
      $(division).hide();
    }
  }
  
}); 
  
