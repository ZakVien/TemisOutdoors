function changePaymentMethod(clicked_id) {
    var button = document.getElementById(clicked_id);
    if (clicked_id.includes("cash")) {
        //hide other divs
        $("#bitcoinDiv").addClass('d-none');
        $("#creditDiv").addClass('d-none');
        $("#bitcoinDiv").removeClass('d-block');
        $("#creditDiv").removeClass('d-block');
        document.getElementById("ccNumInput").removeAttribute("required");
        document.getElementById("ccMonthInput").removeAttribute("required");
        document.getElementById("ccYearInput").removeAttribute("required");
        document.getElementById("cvcInput").removeAttribute("required");
        document.getElementById("bitcoinAddressInput").removeAttribute("required");
        
    } else if (clicked_id.includes('credit')) {
        //show this div
        $("#creditDiv").addClass('d-block');
        $("#creditDiv").removeClass('d-none');
        document.getElementById("ccNumInput").setAttribute("required", "");
        document.getElementById("ccMonthInput").setAttribute("required", "");
        document.getElementById("ccYearInput").setAttribute("required", "");
        document.getElementById("cvcInput").setAttribute("required", "");
        
        //hide other divs
        $("#bitcoinDiv").addClass('d-none');
        $("#bitcoinDiv").removeClass('d-block');
        document.getElementById("bitcoinAddressInput").removeAttribute("required");
        
    } else if (clicked_id.includes('bitcoin')) {
        //show this div
        $("#bitcoinDiv").removeClass('d-none');
        $("#bitcoinDiv").addClass('d-block');
        document.getElementById("bitcoinAddressInput").setAttribute("required", "");
        
        //hide other divs
        $("#creditDiv").addClass('d-none');
        $("#creditDiv").removeClass('d-block');
        document.getElementById("ccNumInput").removeAttribute("required");
        document.getElementById("ccMonthInput").removeAttribute("required");
        document.getElementById("ccYearInput").removeAttribute("required");
        document.getElementById("cvcInput").removeAttribute("required");
        
    }
    $("#paymentMethod").val(clicked_id);
    $(".btn.btn-success.d-none").removeClass('d-none');
}

function shipping(clicked_id){
    if(document.getElementById(clicked_id).getAttribute("checked") == null){
        document.getElementById(clicked_id).setAttribute("checked", "checked");
        $("#shippingFirstName").val($("#billFirstName").val());
        $("#shippingLastName").val($("#billLastName").val());
        $("#shippingAddr").val($("#billAddr").val());
        $("#shippingAddr2").val($("#billAddr2").val());
        $("#shippingcity").val($("#billCity").val());
        $("#shippingstate").val($("#billState").val());
        $("#shippingzip").val($("#billZip").val());
    }else{
        document.getElementById(clicked_id).removeAttribute("checked");
        $("#shippingFirstName").val("");
        $("#shippingLastName").val("");
        $("#shippingAddr").val("");
        $("#shippingAddr2").val("");
        $("#shippingcity").val("");
        $("#shippingstate").val("");
        $("#shippingzip").val("");
    }
}