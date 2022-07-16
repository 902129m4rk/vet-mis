$(document).ready(function() {
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
    });
});

$('select').change(function() {
    if ($(this).children('option:first-child').is(':selected')) {
        $(this).addClass('placeholder');
    } else {
        $(this).removeClass('placeholder');
    }
});
$(document).ready(function() {
    // Prepare the preview for profile picture
    $("#wizard-picture").change(function() {
        readURL(this);
    });
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(document).ready(function() {


    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.profile-pic').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }


    $(".file-upload").on('change', function() {
        readURL(this);
    });

    $(".upload-button").on('click', function() {
        $(".file-upload").click();
    });
});

//FILE UPLOAD
var dropFileForm = document.getElementById("dropFileForm");
var fileLabelText = document.getElementById("fileLabelText");
var uploadStatus = document.getElementById("uploadStatus");
var fileInput = document.getElementById("fileInput");
var droppedFiles;

function overrideDefault(event) {
    event.preventDefault();
    event.stopPropagation();
}

function fileHover() {
    dropFileForm.classList.add("fileHover");
}

function fileHoverEnd() {
    dropFileForm.classList.remove("fileHover");
}

function addFiles(event) {
    droppedFiles = event.target.files || event.dataTransfer.files;
    showFiles(droppedFiles);
}

function showFiles(files) {
    if (files.length > 1) {
        fileLabelText.innerText = files.length + " files selected";
    } else {
        fileLabelText.innerText = files[0].name;
    }
}

function uploadFiles(event) {
    event.preventDefault();
    changeStatus("Uploading...");

    var formData = new FormData();

    for (var i = 0, file;
        (file = droppedFiles[i]); i++) {
        formData.append(fileInput.name, file, file.name);
    }

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(data) {
        //handle server response and change status of
        //upload process via changeStatus(text)
        console.log(xhr.response);
    };
    xhr.open(dropFileForm.method, dropFileForm.action, true);
    xhr.send(formData);
}

function changeStatus(text) {
    uploadStatus.innerText = text;
}






//Table
// Search Button
$(document).ready(function() {
    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });

    });
});
//Page pagination SEARCH CS EXCEL ETC
$(document).ready(function() {
    var table = $('#example').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'csv', 'pdf']
    });

    table.buttons().container()
        .appendTo('#example_wrapper .col-md-6:eq(0)');
});

// Date Time Picker
$(function() {
    $('#datetimepicker2').datetimepicker({
        locale: 'ru'
    });
});

//OTHER PLS SPECIFY
function OtherSpecies(val) {
    if (val === "others")
        document.getElementById('otherspecies').style.display = 'block';
    else
        document.getElementById('otherspecies').style.display = 'none';
}

function OtherBreed(val) {
    if (val === "others")
        document.getElementById('otherbreed').style.display = 'block';
    else
        document.getElementById('otherbreed').style.display = 'none';
}

//OTHER SPECIES 2
function OtherSpecies2(val) {
    if (val === "others")
        document.getElementById('otherspecies2').style.display = 'block';
    else
        document.getElementById('otherspecies2').style.display = 'none';
}

//select img
function triggerClick(e) {
    document.querySelector('#profileImage').click();
}

function displayImage(e) {
    if (e.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}

//tooltip hover
$(function() {
    $('[p"]').tooltip()
})