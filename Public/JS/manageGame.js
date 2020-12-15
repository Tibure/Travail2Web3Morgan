$(window).on('load', function () {
    Get_all_puzzles();
    Get_all_files();
});

$(document).ready(function () {
    $("#PuzzleSelect").on("change", function () {
        const selected_puzzle = $("#PuzzleSelect option:selected").val();
        if (selected_puzzle != 0)
            Get_puzzle(selected_puzzle);
    });
    $("#selectImage").on("change", function () {
        const selected_image = $("#selectImage option:selected").text();
        if (selected_image != 0)
            Show_image(selected_image);
    });
});
function Get_puzzle(selected_puzzle){
    $.ajax({
        url: "/manageGame/get_puzzle/" + selected_puzzle,
        method: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json"
    }).then((data) => {

        $("#previewImagePuzzle").attr("src",  data[0].image);
        $("#puzzleName").val(data[0].title);
        $("#puzzleQuestion").val(data[0].question);
        $("#puzzleHint").val(data[0].hint);
        $("#puzzleAnswer").val(data[0].answer);
        $("#puzzleActive").attr("checked",data[0].active == 1);
    });
}
function Show_image(selected_image){
    $.ajax({
        url: "/manageGame/show_image",
        method: "POST",
        data: JSON.stringify({
            name: selected_image
        }),
        contentType: "application/json; charset=utf-8",
        dataType: "json"
    }).then((data) => {
        $("previewImagePuzzle").attr("src", data)//a refaire
    });
}

function Get_all_puzzles(){
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
}
function Get_all_files(){
    $.ajax({
        url: "/manageGame/get_all_files",
        method: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json"
    }).then((data) => {
        data.forEach(element => {
            $('#selectImage').append($("<option>", {
                value: element.id_file,
                text: element.name
            }));
        });
    })
};
