$(window).on('load', function(){
    fill_puzzle_info();
});

$(document).ready(function () {

    document.getElementById("btn_hint").addEventListener("click", function(event){
        show_hints();
    })
    document.getElementById("btn_answer").addEventListener("click", function (event){
        document.getElementById("btn_answer").disabled = true;
        setTimeout(function()
        {
            document.getElementById("btn_answer").disabled = false;
        },5000);
        verify_answer();
    });
});

function verify_answer()
{
    const answer = $("#answer").val();
    $.ajax({
            method: "POST",
            url: "/game/verify_answer",
            dataType: "json",
            data: {
                'answer': answer
            }
        })
        .then(function (response) {
            if(response === true)
            {
                show_button_next();
            }
            else
            {
                alert("C'est une mauvaise réponse !")
                $("#answer").val("");
            }
        });
};

function fill_puzzle_info()
{
    $.ajax({
        method: "GET",
        url: "/game/fill_puzzle_info",
        contentType: "application/json; charset=utf-8",
        dataType: "json"
    }).then(function (data) {
        if(data){
            document.getElementById("title").innerHTML = data.title;
            document.getElementById("question").innerHTML = "Question : " + data.question;
            $("#image").attr("src", "/game/retrieveFile/"+data.image_id);
        }
        else{
            alert("Félicitation vous avez terminé !");
            window.location.href =  "../home/show";
        }

    });
}

function show_button_next(){
   const buttonRealHeight = parseFloat($('#btn_answer').css("height"));
   $("#btn_answer").text("*click*");
   $('#btn_answer').attr("disabled", true);
   $('#btn_next_puzzle').attr("disabled", false);
   $("#btn_answer").animate(
   {
       height: buttonRealHeight-10+"px"
   },
   {   
       duration: 100,
       complete: function(){
           $("#btn_answer").animate(
           {
               height: buttonRealHeight+"px"
           },
           {   
               duration: 600
           })
       }
   });
   
   $('#btn_next_puzzle').animate(
   {
       opacity: '100%'
   }, 1000);
}

function show_hints(){
    $.ajax({
        method: "GET",
        url: "/game/get_all_hints_available",
        contentType: "application/json; charset=utf-8",
        dataType: "json"
    }).then(function (inData) {
        const data = inData;
        var hint_list = document.createElement("ul");
        hint_list.className = "list-group";
        (data).forEach(Element => {
            var node = document.createElement("li");    
            node.className = "list-group-item";
            node.innerText =  "["+Element.puzzle_order + "] "+Element.title + ": "+Element.hint;
            hint_list.appendChild(node);
        });
        var div = document.createElement("div");
        $(div).append(hint_list);
        $("#modalHints .modal-body").empty();
        $("#modalHints .modal-body").append(div);
    });
}
