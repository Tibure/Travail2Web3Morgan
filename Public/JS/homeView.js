let game_status;
let number_puzzle;

$(window).on('load', function(){
    document.getElementById("subtitle").innerHTML = "<h4> En attente du lancement de la partie </h4>";
    get_number_puzzle_active();
    get_game_status();
});

function get_game_status()
{
    $.ajax({
        url: "/home/is_game_started",
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
        data.forEach(element => {
            const current_puzzle = element.current_puzzle_order;
            document.getElementById("subtitle").innerHTML = "<h4> Progression des parties </h4>";
            document.getElementById("games").innerHTML += '<h6>'+element.name+'</h6> <div class="progress">'+
            '<div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="'+current_puzzle+'" aria-valuemin="0"aria-valuemax="'+number_puzzle+'">' 
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

 var refreshFunction = () =>{
     setInterval(function(){
        get_game_status();
        if(!game_status)
        {
            document.getElementById("subtitle").innerHTML = "<h4> En attente du lancement de la partie </h4>";
            $("#join_game").attr("href", "");
        }
        else
        {
            $("#join_game").attr("href", "/game/show");
            document.getElementById("subtitle").innerHTML = "";
            get_current_level_of_teams();
        }
     }, 5000);
 };

 
 refreshFunction();