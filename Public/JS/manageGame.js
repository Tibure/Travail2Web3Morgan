$(window).on('load', function () {
    $.ajax({
        url: "/manageGame/get_all_puzzle",
        method: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json"
    }).then((data) => {
        $('#PuzzleSelect').append($("<option value=\"0\">Ajouter une nouvelle énigme</option>"));

        data.forEach(element => {
            $('#PuzzleSelect').append($("<option>", {
                value: element.puzzle_ID,
                text: element.title
            }));
        });
    })

});


$(document).ready(function () {
    $("#PuzzleSelect").on("change", function () {
        const selectedPuzzle = $("#PuzzleSelect option:selected").val();
        if (selectedPuzzle != 0)
            $.ajax({
                url: "/manageGame/get_puzzle/" + selectedPuzzle,
                method: "GET",
                contentType: "application/json; charset=utf-8",
                dataType: "json"
            }).then((data) => {

            
                $("#previewImagePuzzle").attr("src",  data.image);
                $("#puzzleName").val(data.title);


            });
    });
});