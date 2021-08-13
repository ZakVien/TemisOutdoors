function shipping(clicked_id){
    var checkboxValue = document.getElementsByName(clicked_id).getAttribute("checked");
    console.log(checkboxValue);
    $("#firstName").value("WOW")
    $("#lastName").value($("#billLastName"))
    $("#shippingAddr").value($("#billAddr"))
    $("#shippingAddr2").value($("#billAddr2"))
    $("#city").value($("#billCity"))
    $("#state").value($("#billState"))
    $("#zip").value($("#billZip"))
}