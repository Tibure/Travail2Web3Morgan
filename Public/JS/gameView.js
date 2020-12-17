$(window).on('load', function(){
    fill_puzzle_info();
});

$(document).ready(function () {

    document.getElementById("btn_answer").addEventListener("click", function (event) {
    event.preventDefault();
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
                $("#gameForm").submit();
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
        document.getElementById("title").innerHTML = data.title;
        document.getElementById("question").innerHTML = "Question : " + data.question;
        $("#image").attr("src", "/game/retrieveFile/"+data.image_id);
    });
}