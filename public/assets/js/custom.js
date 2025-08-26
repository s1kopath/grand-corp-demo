
function fetchFragment(url, sectionId) {
    $.get(url, function (response) {
        $('#' + sectionId).html(response);
    });
}


function previewThumbnail(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var thumbnailPreview = document.getElementById(id);
            if (thumbnailPreview) {
                thumbnailPreview.src = e.target.result;
            }
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function loadModal(url, size = "default") {
    $("#show-modal").find(".modal-dialog").removeClass("modal-lg modal-xl modal-sm").addClass("modal-" + size);

    $("#show-content").html(`<div style="min-height: 200px; display: flex; align-items: center; justify-content: center;"><svg width="24" height="24" stroke="#000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><style>.spinner_V8m1{transform-origin:center;animation:spinner_zKoa 2s linear infinite}.spinner_V8m1 circle{stroke-linecap:round;animation:spinner_YpZS 1.5s ease-in-out infinite}@keyframes spinner_zKoa{100%{transform:rotate(360deg)}}@keyframes spinner_YpZS{0%{stroke-dasharray:0 150;stroke-dashoffset:0}47.5%{stroke-dasharray:42 150;stroke-dashoffset:-16}95%,100%{stroke-dasharray:42 150;stroke-dashoffset:-59}}</style><g class="spinner_V8m1"><circle cx="12" cy="12" r="9.5" fill="none" stroke-width="3"></circle></g></svg></div>`);

    $("#show-modal").modal("show");

    $("#show-content").load(url, function () {
        $(this)
            .find(".select2")
            .each(function () {
                if (!$(this).hasClass("select2-container")) {
                    $(this).select2({
                        dropdownParent: $("#show-modal"),
                        width: "100%",
                    });
                }
            });

        $(this)
            .find(".select2-image")
            .each(function () {
                $(this).select2({
                    dropdownParent: $("#show-modal"),
                    width: "100%",
                });
            });
    });
}