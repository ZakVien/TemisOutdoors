function updateQuant(clicked_id) {
    var setUpdate = false;
    if (clicked_id != null) {
        var idNum = clicked_id.split(/(\d+)/)[1];
        var updateId = "update" + idNum;
        var minusId = "minus" + idNum;
        var addId = "add" + idNum;
        var inputQtyId = "inputQty" + idNum;
        var inputQtyElement = document.getElementById(inputQtyId);
        var removeButton = document.getElementById(updateId);
        removeButton = removeButton.previousElementSibling;
        var productArrayId = removeButton.value;
        removeButton = document.getElementById("prodArrId" + productArrayId);
        //        alert('step 1');
    } else {
        clicked_id = "";
    }
    //    var clickedButton = document.getElementById(clicked_id);
    //    var inputQuant = "";


    document.addEventListener('keypress', function (e) {
        if ((inputQtyElement.value < 1) && (e.keyCode === 13 || e.which === 13)) {
            e.preventDefault();
            return false;
        } else {
            inputQtyElement.style = "";
        }

    });
    if (clicked_id == updateId) {
        var initialVal = parseInt(inputQtyElement.value);
        inputQtyElement.addEventListener("change", function () {
            var newVal = validQuant(inputQtyElement.value, initialVal);
            inputQtyElement.value = newVal;
            if (inputQtyElement.value != initialVal) {
                setUpdate = true;
            }
        });
    }
    //minus button press
    if (clicked_id == minusId) {
        //        alert('step 2');
        inputQtyElement.value = parseInt(inputQtyElement.value) - 1;
        if (parseInt(inputQtyElement.value) < 1) {
            removeButton.click();
        } else {
            setUpdate = true;
        }
        //add button press
    } else if (clicked_id == addId) {
        //        alert('step 2');
        inputQtyElement.value = parseInt(inputQtyElement.value) + 1;
        setUpdate = true;
        //inputbox change/enter pressed
    } else if (clicked_id == inputQtyId) {
        var initialVal = parseInt(inputQtyElement.value);
        inputQtyElement.addEventListener("change", function () {
            if (inputQtyElement.value < 1) {
                inputQtyElement.style = "border: 1px solid red";
            } else {
                inputQtyElement.style = "";
            }
            var newVal = validQuant(inputQtyElement.value, initialVal);
            inputQtyElement.value = newVal;
            if (inputQtyElement.value != initialVal) {
                setUpdate = true;
            }
        });
    }
    if (setUpdate) {
        document.getElementById(updateId).click();
    }
}


function validQuant(input, initial) {
    input = parseInt(input);
    if (input < 1) {
        inputQtyElement.style = "";
        return initial;
    } else {
        return input;
    }
}
