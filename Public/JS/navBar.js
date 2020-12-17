$(window).on('load', function () {
    refresh();
    GetGameStatus();
});


function GetGameStatus(){
    setInterval(function(){
        refresh();
     }, 5000);
}

function refresh()
{
    $.ajax({
        url: "/game/get_time_left",
        method: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json"
    }).then(function(time_left_game){
        var join_game_bar = document.getElementById("join_game");
        var join_game_text = document.getElementById("time_left");
        if(time_left_game < 3600 && time_left_game > 0){
            $(join_game_text).removeClass("not_started").addClass("started");
            join_game_text.innerHTML = "<span>"+new Date(time_left_game * 1000).toISOString().substr(12, 7)+"</span>";
            join_game_bar.innerHTML = "<a id=\"join_game\" class=\"nav-link\" href=\"/game/show\">Rejoindre la partie<span class=\"sr-only\">(current)</span></a>";
            $(join_game_text).css("color", "red");
        }
        else{
            join_game_text.innerHTML = "<span>1:00:00</span>";
            join_game_bar.innerHTML = "";
            $(join_game_text).css("color", "green");
            $(join_game_text).removeClass("started").addClass("not_started");
        }
    })
}