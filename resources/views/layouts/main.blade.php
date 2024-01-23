<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title> Company</title>
        <link rel="stylesheet" href="css/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> --}}



        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

        <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>


        {{-- Bootstrap File Input --}}
        <!-- the fileinput plugin styling CSS file -->
        <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/css/fileinput.min.css" media="all"
            rel="stylesheet" type="text/css" />
        <!-- buffer.min.js and filetype.min.js are necessary in the order listed for advanced mime type parsing and more correct
                         preview. This is a feature available since v5.5.0 and is needed if you want to ensure file mime type is parsed
                         correctly even if the local file's extension is named incorrectly. This will ensure more correct preview of the
                         selected file (note: this will involve a small processing overhead in scanning of file contents locally). If you
                         do not load these scripts then the mime type parsing will largely be derived using the extension in the filename
                         and some basic file content parsing signatures. -->
        <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/buffer.min.js"
            type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/filetype.min.js"
            type="text/javascript"></script>
        <!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you
                        wish to resize images before upload. This must be loaded before fileinput.min.js -->
        <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/piexif.min.js"
            type="text/javascript"></script>

        <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview.
                        This must be loaded before fileinput.min.js -->
        <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/plugins/sortable.min.js"
            type="text/javascript"></script>

        <!-- bootstrap.bundle.min.js below is needed if you wish to zoom and preview file content in a detail modal
                        dialog. bootstrap 5.x or 4.x is supported. You can also use the bootstrap js 3.3.x versions. -->
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
        </script> --}}

        <!-- the main fileinput plugin script JS file -->
        <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.0/js/fileinput.min.js"></script>

    </head>

<body>
    @include('partials.navbar')


    <div class="p-2 mt-2">
        @if (session('status'))
            <div class="d-flex" style="justify-content: center;">
                <div class="alert alert-success" style="width:1320px;">
                    {{ session('status') }}
                </div>
            </div>
        @elseif(session('status-mer'))
            <div class="d-flex" style="justify-content: center;">
                <div class="alert alert-danger" style="width:1320px;">
                    {{ session('status-mer') }}
                </div>
            </div>
        @elseif(session('status-conf.message'))
            <div class="d-flex" style="justify-content: center;">
                <div class="alert alert-danger" style="width:1320px;">
                    <form action="{{ session('status-conf.action') }}" method="POST">
                        @csrf
                        <div class="d-inline">
                            {{ session('status-conf.message') }}
                            <input type="hidden" name="id_restore" value="{{ session('status-conf.id') }}">
                            <button type="submit" class="btn btn-success"><i class="bi bi-check-lg"></i></button>
                            <button class="btn btn-danger" id="removeAlertButton"><i class="bi bi-x-lg"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                const removeAlertButton = document.getElementById('removeAlertButton');
                const alertContainer = removeAlertButton.closest('.alert');

                removeAlertButton.addEventListener('click', function() {
                    alertContainer.remove();
                });
            });
        </script> --}}


        <div class="container mt-4">
            @yield('container')
        </div>
        <div id="overlay">
            <div class="w-100 d-flex justify-content-center align-items-center">
                <div class="spinner"></div>
            </div>
        </div>


</body>

</html>

<script>
    window.onbeforeunload = function() {
        spinner();
    };

    function spinner() {
        document.getElementById("overlay").style.display = "flex";
    }

    function spinneroff() {
        document.getElementById("overlay").style.display = "none";
    }
</script>
