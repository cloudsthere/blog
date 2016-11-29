@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="row page-title-row">
        <div class="col-md-6">
            <h3 class="pull-left">Uploads</h3>
            <div class="pull-left">
                <ul class="breadcrumb">
                    @foreach ($breadcrumbs as $path => $disp)
                        <li><a href="/admin/upload?folder={{$path}}">{{$disp}}</a></li>
                    @endforeach
                    <li class="active">{{$folderName}}</li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 text-right">
            <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#modal-folder-create">
                <i class="fa fa-plus-circle"></i> New Year
            </button>
            <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-targe="#modal-file-upload">
                <i class="fa fa-upload"></i> Upload
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            @include('admin.partials.errors')
            @include('admin.partials.success')

        </div>
        <table id="uploads-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Type</td>
                    <td>Date</td>
                    <td>Size</td>
                    <td data-sortable="false">Actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($subfolders as $path => $name)
                <tr>
                    <td>
                        <a href="/admin/upload?folder={{$path}}">
                            <i class="fa fa-folder fa-lg fa-fw"></i>
                            {{$name}}
                        </a>
                    </td>
                    <td>Folder</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button type="button" class="btn btn-xs btn-danger" onclick="delete_folder('{{$name}}')">
                            <i class="fa fa-times-circle fa-lg"></i>
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach

                @foreach ($files as $file)
                    <tr>
                        <td>
                            <a href="{{$file['webPath']}}">
                                @if(is_image($file['mimeType']))
                                <i class="fa fa-file-image-o fa-lg fa-fw"></i>
                                @else
                                <i class="fa fa-file-o fa-lg fa-fw"></i>
                                @endif
                                {{$file['name']}}
                            </a>
                        </td>
                        <td>{{$file['mimeType'] or 'Unknown'}}</td>
                        <td>{{$file['modified']->format('j-M-y g:ia')}}</td>
                        <td>{{human_filesize($file['size'])}}</td>
                        <td>
                            <button type="button" class="btn btn-xs btn-danger" onclick="delete_file('{{$file['name']}}')">
                                <i class="fa fa-times-circle fa-lg"></i>
                                Delete
                            </button>
                            @if(is_image($file['mimeType']))
                                <button type="button" class="btn btn-xs btn-success" onclick="preview_image('{{$file['webPath']}}')">
                                    <i class="fa fa-eye fa-lg"></i>
                                    Preview
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('admin.upload._modals')


@endsection

@section('scripts')
<script type="text/javascript">
    function delete_file(name) {
        $('#delete-file-name1').html(name);
        $('#delete-file-name2').val(name);
        $('#modal-file-delete').modal('show');

    }

    function delete_folder(name) {
        $('#delete-folder-name1').html(name);
        $('#delete-folder-name2').val(name);
        $('#modal-folder-delete').modal('show');

    }

    function preview_image(path) {
        $('#preview-image').attr('scr', path)
        $('#modal-image-view').modal('show')
    }

    $(function(){
        $('#uploads-table').DataTable()
    })
</script>
@stop