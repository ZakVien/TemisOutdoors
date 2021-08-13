$(document).ready(function () {
    $(function () {
        var defaultMin;
        var defaultMax;
        var highestPrice;
        var updateButton = document.getElementById("updateButton");
        var isDisabled = false;
        
        highestPrice = parseInt(document.getElementById("maximumValue").value);
        lowestPrice = parseInt(document.getElementById("minimumValue").value);
        if(lowestPrice == highestPrice){
            lowestPrice = lowestPrice - 1;
        }
        $("#amount").css("color", "gray");
        
        defaultMin = $("#minPrice").val();
        defaultMax = $("#maxPrice").val();
        
        $("#slider-range").slider({
            range: true,
            min: lowestPrice,
            max: highestPrice,
            values: [defaultMin, defaultMax],
            slide: function (event, ui) {
                $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                $("#minPrice").val(ui.values[0]);
                $("#maxPrice").val(ui.values[1]);
                
                if(($("#maxPrice").val() == highestPrice) && ($("#minPrice").val() == lowestPrice)){
                    $("#amount").css("color", "gray");
                }else{
                    $("#amount").css("color", "orange");
                }
                
                if($("#maxPrice").val() == $("#minPrice").val()){
                    updateButton.setAttribute("disabled", "disabled");
                    $("#amount").css("color", "red");
                }else{
                    updateButton.removeAttribute("disabled");
                }
            }
            
        });
        $("#amount").val("$" + $("#slider-range").slider("values", 0) +
            " - $" + $("#slider-range").slider("values", 1));
        
    });
})
