$.getJSON("https://api.openweathermap.org/data/2.5/weather?q=la%20verne&units=imperial&appid=689d3bd03d9f7dab20870a5f4da956ee", function(data){
    var temp = Math.floor(data.main.temp);
    var iconId = data.weather[0].icon;
    var iconUrl = "http://openweathermap.org/img/w/" + iconId + ".png";
    $(".temp").append(temp + "º");
    $(".icon").attr("src", iconUrl);
    
    $(".weather").css({"position": "absolute", "top":"5%", "left":"5%", "background-color":"rgba(202,202,202,0.3)", "display":"flex", "flex-direction":"row", "align-content":"center", "border-radius":"40px"});
    $(".temp").css({"display":"inline", "margin": "auto"});
    $(".icon").css({"display":"inline", "margin": "auto"});
    
    function responsive(maxWidth) {
      if (maxWidth.matches) {
          $(".weather").css({"top":"0", "left":"0"});
      } else {
          $(".weather").css({"top":"5%", "left":"5%"});

      }
    }
    
     var maxWidth = window.matchMedia("(max-width: 750px)");
     responsive(maxWidth);
     maxWidth.addListener(responsive);
});

