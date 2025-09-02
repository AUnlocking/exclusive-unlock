@extends('layouts.admin_master')
@section('content')
<form action="{{route('admin.page.insert')}}" method="POST" >
    @csrf
    <div class="add-new-form">
        <div class="add-new-form-content">
            <div class="add-new-form-title">
                <input type="text" name="page_title" id="" placeholder="Enter Page Title....." required >
            </div>
            <div class="add-new-form-article">
                <div class="add-new-form-article-top">
                    <span class="badge-secondery p-tag">p</span>
                    <span class="badge-secondery div-tag">div</span>
                    <span class="badge-secondery span-tag">span</span>
                    <span class="badge-secondery ol-tag">ol</span>
                    <span class="badge-secondery li-tag">li</span>
                    <span class="badge-secondery h2-tag">h2</span>
                    <span class="badge-secondery h3-tag">h3</span>
                    <span class="badge-secondery h4-tag">h4</span>
                    <span class="badge-secondery h5-tag">h5</span>
                    <div class="badge-warning" style="float: right" id="wordCount" >Word: 0</div>
                </div>
                <div>
                    <textarea name="page_article" id="textarea-word"  rows="56" ></textarea>
                </div>
            </div>
        </div>
        <div class="add-new-form-sidebar">
            <div class="form-sidebar-post-btn">
                <button type="submit"><i class="bi bi-pencil-square"></i> Add Now</button>
            </div>
            <div class="form-sidebar-post-element">

                <label for="post_visibility" style="margin: 0 0 10px 0">Visibility <span style="color: red">*</span></label>
                <select name="page_visibility" id="post_visibility" required >
                    <option value="Publish">Publish</option>
                    <option value="Need Improve">Need Improve</option>
                    <option value="Draft">Draft</option>
                </select>

                <label for="post_thumbnail" >Thumbnail URL</label>
                <input type="text" id="page_thumbnail" name="page_thumbnail" placeholder="Thumbnail URL" >

            </div>
            <div style="border-top: 1px solid #e3e0e0"></div>
            <div class="form-sidebar-post-element">

                {{-- Meta Description --}}
                <label for="page_meta_description" style="margin: 0 0 10px 0" >Meta Description <span id="metaCount" class="badge-warning">0 Char</span></label>
                <textarea name="page_meta_description" id="page_meta_description" cols="30" rows="6"></textarea>

                {{-- Keyword 1 --}}
                <label for="page_kw1" >Keyword 1 <span class="badge-warning" id="page_kw1_word_count">0 Word</span></label>
                <input type="text" id="page_kw1" name="page_kw1" placeholder="Keyword 1">

                {{-- Keyword 2 --}}
                <label for="page_kw2" >Keyword 2 <span class="badge-warning" id="page_kw2_word_count">0 Word</span></label>
                <input type="text" id="page_kw2" name="page_kw2" placeholder="Keyword 2">

                {{-- Keyword 3 --}}
                <label for="page_kw3" >Keyword 3 <span class="badge-warning" id="page_kw3_word_count">0 Word</span></label>
                <input type="text" id="page_kw3" name="page_kw3" placeholder="Keyword 3">

                {{-- Keyword 4 --}}
                <label for="page_kw4" >Keyword 4 <span class="badge-warning" id="page_kw4_word_count">0 Word</span></label>
                <input type="text" id="page_kw4" name="page_kw4" placeholder="Keyword 4">

                {{-- Keyword 5 --}}
                <label for="page_kw5" >Keyword 5 <span class="badge-warning" id="page_kw5_word_count">0 Word</span></label>
                <input type="text" id="page_kw5" name="page_kw5" placeholder="Keyword 5">

            </div>
        </div>
    </div>
</form>
@endsection

@section('footer_script')
<script>
    // CONTENT WORD COUNT
    $(document).ready(function() {
        $('#textarea-word').on('input', function() {
            var words = $(this).val().match(/\S+/g); // Use regex to count words
            var wordCount = words ? words.length : 0;
            $('#wordCount').text('Word: ' + wordCount);
            if(wordCount >= 300){
                $('#wordCount').css({"background": "#04AA6D", "color": "white"});
            }
            else{
                $('#wordCount').css({"background": "#ffc107", "color": "#212529"});
            }
        });
    });
    // META DESCRIPTION CHARECTER COUNT
    $(document).ready(function() {
        $('#page_meta_description').on('input', function() {
            var text = $(this).val();
            var charCount = text.length;
            $('#metaCount').text(charCount + ' Char');
            if(charCount >= 105 && charCount <= 140){
            $('#metaCount').css({"background": "#04AA6D", "color": "white"});
            }
            else{
                $('#metaCount').css({"background": "#ffc107", "color": "#212529"});
            }
        });
    });
    // KEYWORD 1 WORD COUNT
    $(document).ready(function() {
        $('#page_kw1').on('input', function() {
            var words = $(this).val().match(/\S+/g); // Use regex to count words
            var wordCount = words ? words.length : 0;
            $('#page_kw1_word_count').text(wordCount + ' Word');
            if(wordCount <= 4 && wordCount >= 1){
                $('#page_kw1_word_count').css({"background": "#04AA6D", "color": "white"});
            }
            else{
                $('#page_kw1_word_count').css({"background": "#ffc107", "color": "#212529"});
            }
        });
    });
    // KEYWORD 2 WORD COUNT
    $(document).ready(function() {
        $('#page_kw2').on('input', function() {
            var words = $(this).val().match(/\S+/g); // Use regex to count words
            var wordCount = words ? words.length : 0;
            $('#page_kw2_word_count').text(wordCount + ' Word');
            if(wordCount <= 4 && wordCount >= 1){
                $('#page_kw2_word_count').css({"background": "#04AA6D", "color": "white"});
            }
            else{
                $('#page_kw2_word_count').css({"background": "#ffc107", "color": "#212529"});
            }
        });
    });
    // KEYWORD 3 WORD COUNT
    $(document).ready(function() {
        $('#page_kw3').on('input', function() {
            var words = $(this).val().match(/\S+/g); // Use regex to count words
            var wordCount = words ? words.length : 0;
            $('#page_kw3_word_count').text(wordCount + ' Word');
            if(wordCount <= 4 && wordCount >= 1){
                $('#page_kw3_word_count').css({"background": "#04AA6D", "color": "white"});
            }
            else{
                $('#page_kw3_word_count').css({"background": "#ffc107", "color": "#212529"});
            }
        });
    });
    // KEYWORD 4 WORD COUNT
    $(document).ready(function() {
        $('#page_kw4').on('input', function() {
            var words = $(this).val().match(/\S+/g); // Use regex to count words
            var wordCount = words ? words.length : 0;
            $('#page_kw4_word_count').text(wordCount + ' Word');
            if(wordCount <= 4 && wordCount >= 1){
                $('#page_kw4_word_count').css({"background": "#04AA6D", "color": "white"});
            }
            else{
                $('#page_kw4_word_count').css({"background": "#ffc107", "color": "#212529"});
            }
        });
    });
    // KEYWORD 5 WORD COUNT
    $(document).ready(function() {
        $('#page_kw5').on('input', function() {
            var words = $(this).val().match(/\S+/g); // Use regex to count words
            var wordCount = words ? words.length : 0;
            $('#page_kw5_word_count').text(wordCount + ' Word');
            if(wordCount <= 4 && wordCount >= 1){
                $('#page_kw5_word_count').css({"background": "#04AA6D", "color": "white"});
            }
            else{
                $('#page_kw5_word_count').css({"background": "#ffc107", "color": "#212529"});
            }
        });
    });

    // Copy Tag Value
    $('.p-tag').on('click', function() {
        navigator.clipboard.writeText('<p></p>');
        // Sweetalert
        const Toast = Swal.mixin({
        toast: true,
        position: "bottom-end",
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
        }
        });
        Toast.fire({
            icon: "success",
            title: "Copied!"
        });
    })
    $('.div-tag').on('click', function() {
        navigator.clipboard.writeText('<div></div>');
        // Sweetalert
        const Toast = Swal.mixin({
        toast: true,
        position: "bottom-end",
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
        }
        });
        Toast.fire({
            icon: "success",
            title: "Copied!"
        });
    })
    $('.span-tag').on('click', function() {
        navigator.clipboard.writeText('<span></span>');
        // Sweetalert
        const Toast = Swal.mixin({
        toast: true,
        position: "bottom-end",
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
        }
        });
        Toast.fire({
            icon: "success",
            title: "Copied!"
        });
    })
    $('.ol-tag').on('click', function() {
        navigator.clipboard.writeText('<ol></ol>');
        // Sweetalert
        const Toast = Swal.mixin({
        toast: true,
        position: "bottom-end",
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
        }
        });
        Toast.fire({
            icon: "success",
            title: "Copied!"
        });
    })
    $('.li-tag').on('click', function() {
        navigator.clipboard.writeText('<li></li>');
        // Sweetalert
        const Toast = Swal.mixin({
        toast: true,
        position: "bottom-end",
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
        }
        });
        Toast.fire({
            icon: "success",
            title: "Copied!"
        });
    })
    $('.h2-tag').on('click', function() {
        navigator.clipboard.writeText('<h2></h2>');
        // Sweetalert
        const Toast = Swal.mixin({
        toast: true,
        position: "bottom-end",
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
        }
        });
        Toast.fire({
            icon: "success",
            title: "Copied!"
        });
    })
    $('.h3-tag').on('click', function() {
        navigator.clipboard.writeText('<h3></h3>');
        // Sweetalert
        const Toast = Swal.mixin({
        toast: true,
        position: "bottom-end",
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
        }
        });
        Toast.fire({
            icon: "success",
            title: "Copied!"
        });
    })
    $('.h4-tag').on('click', function() {
        navigator.clipboard.writeText('<h4></h4>');
        // Sweetalert
        const Toast = Swal.mixin({
        toast: true,
        position: "bottom-end",
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
        }
        });
        Toast.fire({
            icon: "success",
            title: "Copied!"
        });
    })
    $('.h5-tag').on('click', function() {
        navigator.clipboard.writeText('<h5></h5>');
        // Sweetalert
        const Toast = Swal.mixin({
        toast: true,
        position: "bottom-end",
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
        }
        });
        Toast.fire({
            icon: "success",
            title: "Copied!"
        });
    })
</script>
@endsection

