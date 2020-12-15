var dragging, draggedOver;

$(window).on('load', function () {
    Get_all_puzzles();
    Get_all_files();
});

$(document).ready(function () {
    $("#PuzzleSelect").on("change", function () {
        const selected_puzzle = $("#PuzzleSelect option:selected").val();
        $("#puzzleID").val(selected_puzzle);
        if (selected_puzzle != 0)
            Get_puzzle(selected_puzzle);
    });
    $("#selectImage").on("change", function () {
        const selected_image = $("#selectImage option:selected").text();
        if (selected_image != 0)
            Show_image(selected_image);
    });

    $("#managerOrder").on("click", function() {
        var list = document.createElement("ul");
        list.id = "orderList";
        $.ajax({
            url: "/manageGame/get_all_puzzle",
            method: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json"
        }).then((data) => {
            data.forEach(element => {
                if(element.active){
                    var node = document.createElement("li");    
                    node.draggable = true;
                    node.addEventListener('drag', setDragging); 
                    node.addEventListener('dragover', setDraggedOver);
                    node.addEventListener('drop', compare);
                    node.value = element.puzzle_ID;
                    node.innerText = element.title;
                    list.appendChild(node)
                }
               
            });
        })

        var div = document.createElement("div");
        $(div).append(list);
        $("#modalOrder .modal-body").empty()
        $("#modalOrder .modal-body").append(div);

    })

    $("#saveOrder").on("click", function(){
        let i = 0;
        const puzzleArray = []
        const li = $("#orderList li");
        for(i = 0; i< li.length; i++){
          puzzleArray.push({
            puzzle_ID : $(li[i]).val(),
            puzzle_order: i+1
          })  
        }
        $.ajax({       
            method:"POST",   
            url: "/manageGame/modify_puzzle_order",
            dataType: "json",
            data: {'puzzlesOrder': puzzleArray}
        })
        .then(function(isValid){
            if(isValid){
                alert("L'ordre a été sauvegarder correctement");
            }else{
                alert("L'ordre n'a pas pu sauvegarder correcterment, réessayez.");
            }
        });
    })
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

const compare = (e) =>{
    const _draggedOver = draggedOver;
    const _dragging  = dragging;
    if($(dragging).index() > $(draggedOver).index())
    $(dragging).insertBefore(draggedOver);
    else{
        $(dragging).insertBefore(draggedOver);
        $(draggedOver).insertBefore(dragging);
    }
   
}
  
  const setDraggedOver = (e) => {
    e.preventDefault();
    draggedOver = $(e.target);
  }
  
  const setDragging = (e) =>{
    dragging = $(e.target);
  }
