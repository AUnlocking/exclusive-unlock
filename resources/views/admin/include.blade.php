{{-- Copy Media to clipboard, show img --}}
<script>
    $('.image-data').on('click', function() {
        let filename = $(this).attr('filename');
        let fileurl = $(this).attr('fileurl');
        let img_width = $(this).attr('img_width');
        let img_height = $(this).attr('img_height');
        let img_size = $(this).attr('img_size');
        document.getElementById('img-width').innerText = `Width: ${img_width}px`;
        document.getElementById('img-height').innerText = `Height: ${img_height}px`;
        document.getElementById('file-url').innerText = `${fileurl}`;
        document.getElementById('file-name').innerText = `${filename}`;
        document.getElementById('img-size').innerText = `Size: ${img_size} KB`;
        $('.preview-img').attr("src",  fileurl);
        navigator.clipboard.writeText(fileurl);
        new Notify ({
            status: 'success',
            title: 'URL Copied!',
            text: $(this).attr('filename'),
            effect: 'fade',
            speed: 300,
            customClass: '',
            customIcon: '',
            showIcon: true,
            showCloseButton: true,
            autoclose: true,
            autotimeout: 3000,
            notificationsGap: null,
            notificationsPadding: null,
            type: 'filled',
            position: 'left bottom',
            customWrapper: '',
        });
    })
</script>



