// hàm xử lý ảnh khi update book lưu lại các id ảnh và sẽ đưa lên input hidden 
// xử lý ảnh bên bookController
//áp dụng với file sửa
function removeGalleryImg(el, galleryId = 0) {
    $(el).parent().parent().remove();
    if (galleryId != 0) {
        let removeIds = $(`[name="removeGalleryIds"]`).val();
        removeIds += `${galleryId}|`
        $(`[name="removeGalleryIds"]`).val(removeIds);
    }
}
//hàm dùng để upload ảnh lên sẽ hiện thì ảnh ngay dưới dạng base64
//hàm này áp dụng vào file sửa
function loadFiles(event, el_rowId) {
    var reader = new FileReader();
    var output = document.querySelector(`img[row_id="${el_rowId}"]`);
    reader.onload = function() {
        output.src = reader.result;
    };
    if (event.target.files[0] == undefined) {
        output.src = "";
        return false;
    } else {
        reader.readAsDataURL(event.target.files[0]);
    }
};

//hàm dùng để upload ảnh lên sẽ hiện thì ảnh ngay dưới dạng base64
//hàm này áp dụng vào file add
function loadFile(event) {
    var reader = new FileReader();
    var output = document.getElementById('images');
    reader.onload = function() {
        output.src = reader.result;
    };
    if (event.target.files[0] == undefined) {
        output.src = "";
    } else {
        reader.readAsDataURL(event.target.files[0]);
    }

};
//hàm dùng để xóa ảnh upload lên 
//áp dụng với file add
function removeImg(el) {
    $(el).parent().parent().remove();
}
//hàm dùng để xóa dữ liệu của 1 bảng bằng ajax
//áp dụng với file index
function deleteData(id) {
    var urlData = window.location;
    if (confirm('Bạn có chắc chắn muốn xóa mục này ?')) {
        $.ajax({
            url: urlData + '/xoa/' + id,
            type: 'DELETE',
            data: {
                _token: $("input[name=_token]").val()
            },
            success: function(data) {
                $('div.alert-success').text(data.success);
                $('div.alert-success').css('display', 'block');
                $('#' + id).remove();
            },
        });
    }
}