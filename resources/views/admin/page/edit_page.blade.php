@extends('layouts.admin_master')
@section('content')
<form action="{{route('admin.page.update')}}" method="POST" >
    @csrf
    <div class="add-new-form">
        <div class="add-new-form-content">
            <div class="add-new-form-title">
                <input type="text" name="page_title" id="" placeholder="Enter Page Title....." value="{{$page_data->page_title}}" required >
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
                    @if (str_word_count($page_data->page_article) >= 300)
                    <div class="badge-success" style="float: right" id="wordCount" >{{'Word: '.str_word_count($page_data->page_article)}}</div>
                    @else
                    <div class="badge-warning" style="float: right" id="wordCount" >{{'Word: '.str_word_count($page_data->page_article)}}</div>
                    @endif
                </div>
                <div>
                    <textarea name="page_article" id="textarea-word"  rows="56" >{{$page_data->page_article}}</textarea>
                </div>
            </div>
        </div>
        <div class="add-new-form-sidebar">
            <div class="form-sidebar-post-btn">
                <button type="submit"><i class="bi bi-pencil-square"></i> Update</button>
            </div>
            <div class="form-sidebar-post-element">

                <label for="post_visibility" style="margin: 0 0 10px 0">Visibility <span style="color: red">*</span></label>
                <select name="page_visibility" id="post_visibility" required >
                    <option {{($page_data->page_visibility == 'Publish' ?'selected':'' )}} value="Publish">Publish</option>
                    <option {{($page_data->page_visibility == 'Need Improve' ?'selected':'' )}} value="Need Improve">Need Improve</option>
                    <option {{($page_data->page_visibility == 'Draft' ?'selected':'' )}} value="Draft">Draft</option>
                </select>

                <label for="page_slug" >Page Slug <span style="color: red">*</span></label>
                <input type="text" id="page_slug" name="page_slug" placeholder="Page Slug" value="{{$page_data->page_slug}}" required>

                <label for="post_thumbnail" >Thumbnail URL</label>
                <input type="text" id="page_thumbnail" name="page_thumbnail" placeholder="Thumbnail URL" value="{{$page_data->page_thumbnail}}" >

            </div>
            <div style="border-top: 1px solid #e3e0e0"></div>
            <div class="form-sidebar-post-element">

                {{-- Meta Description --}}
                @if (strlen($page_data->page_meta_description) >= 105 && strlen($page_data->page_meta_description) <= 140)
                <label for="page_meta_description" style="margin: 0 0 10px 0" >Meta Description <span id="metaCount" class="badge-success">{{strlen($page_data->page_meta_description)}} Char</span></label>
                @else
                <label for="page_meta_description" style="margin: 0 0 10px 0" >Meta Description <span id="metaCount" class="badge-warning">{{strlen($page_data->page_meta_description)}} Char</span></label>
                @endif
                <textarea name="page_meta_description" id="page_meta_description" cols="30" rows="6">{{$page_data->page_meta_description}}</textarea>

                {{-- Keyword 1 --}}
                @if (str_word_count($page_data->page_kw1) <= 4 && str_word_count($page_data->page_kw1) >= 1)
                <label for="page_kw1" >Keyword 1 <span class="badge-success" id="page_kw1_word_count">{{str_word_count($page_data->page_kw1).' Word'}}</span></label>
                @else
                <label for="page_kw1" >Keyword 1 <span class="badge-warning" id="page_kw1_word_count">{{str_word_count($page_data->page_kw1).' Word'}}</span></label>
                @endif
                <input type="text" id="page_kw1" name="page_kw1" placeholder="Keyword 1" value="{{$page_data->page_kw1}}" >

                {{-- Keyword 2 --}}
                @if (str_word_count($page_data->page_kw2) <= 4 && str_word_count($page_data->page_kw2) >= 1)
                <label for="page_kw2" >Keyword 2 <span class="badge-success" id="page_kw2_word_count">{{str_word_count($page_data->page_kw2).' Word'}}</span></label>
                @else
                <label for="page_kw2" >Keyword 2 <span class="badge-warning" id="page_kw2_word_count">{{str_word_count($page_data->page_kw2).' Word'}}</span></label>
                @endif
                <input type="text" id="page_kw2" name="page_kw2" placeholder="Keyword 2" value="{{$page_data->page_kw2}}" >

                {{-- Keyword 3 --}}
                @if (str_word_count($page_data->page_kw3) <= 4 && str_word_count($page_data->page_kw3) >= 1)
                <label for="page_kw3" >Keyword 3 <span class="badge-success" id="page_kw3_word_count">{{str_word_count($page_data->page_kw3).' Word'}}</span></label>
                @else
                <label for="page_kw3" >Keyword 3 <span class="badge-warning" id="page_kw3_word_count">{{str_word_count($page_data->page_kw3).' Word'}}</span></label>
                @endif
                <input type="text" id="page_kw3" name="page_kw3" placeholder="Keyword 3" value="{{$page_data->page_kw3}}" >

                {{-- Keyword 4 --}}
                @if (str_word_count($page_data->page_kw4) <= 4 && str_word_count($page_data->page_kw4) >= 1)
                <label for="page_kw4" >Keyword 4 <span class="badge-success" id="page_kw4_word_count">{{str_word_count($page_data->page_kw4).' Word'}}</span></label>
                @else
                <label for="page_kw4" >Keyword 4 <span class="badge-warning" id="page_kw4_word_count">{{str_word_count($page_data->page_kw4).' Word'}}</span></label>
                @endif
                <input type="text" id="page_kw4" name="page_kw4" placeholder="Keyword 4" value="{{$page_data->page_kw4}}" >

                {{-- Keyword 5 --}}
                @if (str_word_count($page_data->page_kw5) <= 4 && str_word_count($page_data->page_kw5) >= 1)
                <label for="page_kw5" >Keyword 5 <span class="badge-success" id="page_kw5_word_count">{{str_word_count($page_data->page_kw5).' Word'}}</span></label>
                @else
                <label for="page_kw5" >Keyword 5 <span class="badge-warning" id="page_kw5_word_count">{{str_word_count($page_data->page_kw5).' Word'}}</span></label>
                @endif
                <input type="text" id="page_kw5" name="page_kw5" placeholder="Keyword 5" value="{{$page_data->page_kw5}}" >

            </div>
        </div>
        <input type="hidden" name="id" id="" value="{{$page_data->id}}">
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

