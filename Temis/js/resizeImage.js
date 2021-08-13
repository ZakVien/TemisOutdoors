$(document).ready(function () {
    var image = $(".card-img-top");
    image.onload = function () {
        image.each(function (index) {
            console.log("Width: " + image.naturalWidth)
            console.log("Height: " + image.naturalHeight)
        })
    }
})
