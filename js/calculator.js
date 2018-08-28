//Calculando a soma dos valores das fantasias selecionadas
jQuery(document).ready(function(){

   jQuery(".fantasy").click(function(event){
        var result = 42;
        jQuery(".fantasy:checked").each(function(){
            result += parseInt(jQuery(this).val());
        });

        if (result == 0) {
            jQuery('#result').text('');
            jQuery('#result').removeAttr('name');
        }else{
            jQuery('#result').text('R$ ' + result + ',00');
            jQuery('#result').attr('name', result + '00');
        }
   });
});
