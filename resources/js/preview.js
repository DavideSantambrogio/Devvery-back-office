const previewImg = document.getElementById('preview-image');

document.getElementById('cover_image').addEventListener('change', function () {
    const selectedFile = this.files[0];
    if(selectedFile) {
        const reader = new FileReader();
        reader.addEventListener("load", function() {
            previewImg.src = reader.result;
        })
        reader.readAsDataURL(selectedFile);
    }
})
