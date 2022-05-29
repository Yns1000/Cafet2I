function affListe(a,b,c) {
    var div = document.getElementById(a);
    var button1 = document.getElementById(b);
    var button2 = document.getElementById(c);


    if (div.style.display === "none" ||  !div.style.display) {
        div.style.display = "block";
        button1.style.display = "none";
        button2.style.display = "block";

    } 
    else{
        div.style.display = "none";
        button1.style.display = "block";
        button2.style.display = "none";

    }

}

function affinfo(a,b,c) {
    var div = document.getElementById(a);
    var reste1 = document.getElementById(b);
    var reste2 = document.getElementById(c);

    if (div.style.display === "none") {
        div.style.display = "block";
        reste1.style.display = "none";
        reste2.style.display = "none";

    }

    }

    function affConex(a,b, c) {
        var div1 = document.getElementById(a);
        var div2 = document.getElementById(b);
        var div3 = document.getElementById(c);
    
  

        if (div1.style.display === "none"){
            div1.style.display = "block";
            div2.style.display = "none";
            div3.style.display = "block";


        }
      }
        function NoUser(a,b, c,d) {
          var div1 = document.getElementById(a);
          var div2 = document.getElementById(b);
          var div3 = document.getElementById(c);
          var div4 = document.getElementById(d);

      
    
  
          if (div1.style.display === "block" ||  div2.style.display === "block"){
              div1.style.display = "none";
              div2.style.display = "none";
              div3.style.display = "none";
              div4.style.display = "block";
  
          }
        
    
        }
