 $(document).ready(function(){
     var navItems = ["archery", "clothing", "fishing", "gardening", "hunting", "clearance"];
     $.each(navItems, function(index, value){
         if (window.location.href.indexOf(value) != -1){
             $("#" + value).addClass("activeNavLink");
         }
     })
});
