$(window).on('load', function () {
    Get_all_puzzles();
    Get_all_files();
});

$(document).ready(function () {
    $("#PuzzleSelect").on("change", function () {
        const selected_puzzle = $("#PuzzleSelect option:selected").val();
        $("#puzzleID").val(selected_puzzle);
        if (selected_puzzle != 0)
        {   
            $("#btn_add").attr("disabled", true);
            $("#btn_delete").attr("disabled", false);
            $("#btn_save").attr("disabled", false);
            Get_puzzle(selected_puzzle);
        }
        else
        {
            $("#btn_add").attr("disabled", false);
            $("#btn_delete").attr("disabled", true);
            $("#btn_save").attr("disabled", true);
            $("input.form-control:text").val("");
            $("#selectImage").prop("selectedIndex", 0);
            $("#puzzleActive").prop("checked", 0);
        }     
    });
    $("#selectImage").on("change", function () {
        const selected_image = $("#selectImage option:selected").text();
        if (selected_image != 0)
        {
            Show_image(selected_image);
        }
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
        $("#puzzleActive").prop("checked",data[0].active == 1);
    });
}
function Show_image(selected_image){
    $.ajax({
        url: "/manageGame/show_image",
        method: "POST",
        data: {'name' : selected_image},
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
        $('#selectImage').append($("<option value=\"0\">Aucune image</option>"));

        data.forEach(element => {
            $('#selectImage').append($("<option>", {
                value: element.id_file,
                text: element.name
            }));
        });
    })
};
