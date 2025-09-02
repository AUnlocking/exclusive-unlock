@extends('layouts.admin_master')
@section('content')

<div class="admin-breadcrumb">
    <p><a href="{{route('admin')}}"><i class="bi bi-speedometer2"></i> Dashboard</a> > Page List</p>
    <a href="{{route('admin.page.add.new')}}" style="margin-left: auto"><button><i class="bi bi-plus-circle"></i> Add Page</button></a>
</div>

<div class="content-section">

    <div class="content-section-title">
        <div><i class="bi bi-postcard"></i> Page List</div>
        <div>Total: {{$page_count}}</div>
    </div>

    <table id="table">
        <tr style="background: white">
            <th><i class="bi bi-box-arrow-up-right"></i></th>
            <th>Thumbnail</th>
            <th>Page Name</th>
            <th>Author</th>
            <th>Visibility</th>
            <th>Views</th>
            <th>Action (Edit & Del)</th>
        </tr>
        @forelse ($page_list as $page_lists)
            <tr>
                <td>
                    <a href="{{route('page', $page_lists->page_slug)}}" target="_blank"><i class="bi bi-box-arrow-up-right"></i></a>
                </td>
                <td>
                    @if ($page_lists->page_thumbnail)
                        <img src="{{$page_lists->page_thumbnail}}" alt="" height="50" width="75" style="border-radius: 4px; border: 1px solid #e3e0e0">
                    @else
                        <img src="{{asset('resource/default-thumb.png')}}" alt="" height="50" width="75" style="border-radius: 4px; border: 1px solid #e3e0e0">
                    @endif
                </td>
                <td>
                    {{$page_lists->page_title}}
                </td>
                <td>
                    {{App\Models\User::find($page_lists->page_author)->name}}
                </td>
                <td>
                    @if ($page_lists->page_visibility == 'Publish')
                    <span class="badge-success" style="display:inline-block; width:98px; text-align:center">{{$page_lists->page_visibility}}</span>
                    @elseif ($page_lists->page_visibility == 'Need Improve')
                    <span class="badge-warning" style="display:inline-block; width:98px; text-align:center">{{$page_lists->page_visibility}}</span>
                    @else
                    <span class="badge-danger" style="display:inline-block; width:98px; text-align:center">{{$page_lists->page_visibility}}</span>
                    @endif
                </td>
                <td>
                    <span class="badge-light">{{$page_lists->page_views}}</span>
                </td>
                <td>
                    <div class="action-btn">
                        <a href="{{route('admin.page.edit', $page_lists->id)}}">
                            <button class="table-edit-btn">
                                Edit
                            </button>
                        </a>
                        <button
                            delete-data="{{route('admin.page.delete', $page_lists->id)}}"
                            sub-title="{{'Delete => '.$page_lists->page_title}}"
                            class="table-delete-btn"
                        > Delete</button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td>---</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforelse
    </table>

</div>
@endsection

@section('footer_script')
    <script>
        // For Sweet Alert
        $('.table-delete-btn').click(function(){
            Swal.fire({
            title: 'Are you sure?',
            text: $(this).attr('sub-title'),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Delete!'
            }).then((result) => {
            if (result.isConfirmed) {
                var link = $(this).attr('delete-data');
                window.location.href = link;
            }
            })
        })
    </script>
@endsection
