let game_status;
let number_puzzle;
let win_game = false;

$(window).on('load', function(){
    document.getElementById("subtitle").innerHTML = "<h4> En attente du lancement de la partie </h4>";
    get_number_puzzle_active();
    get_game_status();
});

function get_game_status()
{
    $.ajax({
        url: "/game/is_game_started",
        method: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json"
    }).then(function(is_started){
        game_status = is_started;
    })
}

function get_current_level_of_teams()
{
    $.ajax({
        url: "/game/get_current_level_of_teams",
        method: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json"
    }).then(function(data){
        document.getElementById("games").innerHTML = "";
        data.forEach(element => 
        {
            var current_puzzle = element.current_puzzle_order;
            var new_class = "";
            var percent = (current_puzzle/number_puzzle)*100;
            if(percent > 100)
            {
                percent = 100;
                current_puzzle = number_puzzle;
                new_class = "bg-success";
            }
            document.getElementById("subtitle").innerHTML = "<h4> Progression des parties </h4>";
            document.getElementById("games").innerHTML += '<h6>'+element.name+'</h6> <div class="progress">'+
            '<div class="progress-bar '+new_class+'" role="progressbar" style="width: '+percent+'%" aria-valuenow="'+current_puzzle+'" aria-valuemin="0" aria-valuemax="'+number_puzzle+'">' 
            +current_puzzle+'/'+number_puzzle+'</div></div> <br><br>';
        });
    })
}

function get_number_puzzle_active()
{
    $.ajax({
        url: "/game/get_number_puzzle_active",
        method: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json"
    }).then(function(data){
        number_puzzle = data.total;
    })
}

function refreshFunction(){
    setInterval(function(){
        get_game_status();
        if(!game_status)
        {
            document.getElementById("subtitle").innerHTML = "<h4> En attente du lancement de la partie </h4>";
            document.getElementById("games").innerHTML = "";
        }
        else
        {   
            document.getElementById("subtitle").innerHTML = "";
            get_current_level_of_teams();
        }
     }, 10000);
 };

 
 refreshFunction();