// Data Picker Initialization
$(document).ready(function(){
    var date_input=$('input[name="date"]'); //our date input has the name "date"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    var options={
      format: 'dd/mm/yyyy',
      container: container,
      todayHighlight: true,
      autoclose: true,
    };
    date_input.datepicker(options);
})

alternar_prazo = () => {
    recor = $("#prazo-recorrente").is(':checked');
    lim = $("#data-limite").is(':checked');
    if (recor) {
        $("#data-limite-div").attr("hidden",true);
        $("#prazo-recorrente-div").removeAttr('hidden');
    }
    if (lim) {
        $("#data-limite-div").removeAttr('hidden');
        $("#prazo-recorrente-div").attr("hidden",true);
    }
}