document.querySelector('.custom-file-input').addEventListener('change', function (e) {
    var fileName = document.getElementById("file").files[0].name;
    var nextSibling = e.target.nextElementSibling
    nextSibling.innerText = fileName
  })

  /*function SelectedImagePuzzle(){
    console.log("selected change");
    newImage = document.getElementById("selectImage").value;
    document.getElementById("previewImagePuzzle").src = "/files/"+newImage+".jpg";
  }
*/
  