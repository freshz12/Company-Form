@extends('layouts.main')
@section('container')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" />



    <form action={{ url('storeform') }} method="post" enctype="multipart/form-data" onsubmit="disableSubmitButton(event)">
        @csrf

        <div id="mainbodyaddform">

            <br>

            <div id="carding">
                <p><b>Note:</b> Please fill out the form to submit. Required fields are marked with "*".</p>

                {{-- Company Details --}}

                <div class="card">
                    <div class="card-header">
                        Company Details
                    </div>
                    <div class="card-body"
                        style="margin-left: 5px; margin-top: 5px; margin-right: 5px; margin-bottom: 5px;">
                        <div class="row">

                            <div class="col">
                                <label for="">Company Name <span style="color: red">*</span></label>
                                <input type="text" name="company_name" class="form-control" placeholder="Company Name"
                                    required>
                            </div>

                            <div class="col">
                                <label for="">HQ Office Address <span style="color: red">*</span></label>
                                <input type="text" name="hq" class="form-control" placeholder="HQ Office Address"
                                    required>
                            </div>

                        </div>
                        <br>
                        <div class="row">

                            <div class="col">
                                <label for="">Company Website <span style="color: red">*</span></label>
                                <input type="text" name="company_website" class="form-control"
                                    placeholder="Company Website" required>
                            </div>

                            <div class="col">
                                <label for="">Country of origin <span style="color: red">*</span></label>
                                <select class="form-control js-example-basic-single" name="Country_of_origin" required>
                                    <option value="" selected disabled></option>
                                    @foreach ($country as $c)
                                        <option value="{{ $c }}">{{ $c }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <br>
                        <div class="row">

                            <div class="col-6">
                                <label for="">Year of establishment <span style="color: red">*</span></label>
                                <input type="number" maxlength="4" min="1900" max="2099" name="year"
                                    class="form-control" placeholder="Year of establishment" required>
                            </div>
                        </div>
                    </div>
                </div>
                <br>





                {{-- Contact Person --}}
                <div class="card">
                    <div class="card-header">
                        Contact Person
                    </div>
                    <div class="card-body"
                        style="margin-left: 5px; margin-top: 5px; margin-right: 5px; margin-bottom: 5px;">
                        <div class="row">

                            <div class="col">
                                <label for="">Name <span style="color: red">*</span></label>
                                <input type="text" name="contact_name" class="form-control" placeholder="Name" required>
                            </div>

                            <div class="col">
                                <label for="">Designation <span style="color: red">*</span></label>
                                <input type="text" name="contact_designation" class="form-control"
                                    placeholder="Designation" required>
                            </div>

                        </div>
                        <br>
                        <div class="row">

                            <div class="col">
                                <label for="">Email Address <span style="color: red">*</span></label>
                                <input type="email" name="contact_email" class="form-control" placeholder="Email Address"
                                    required>
                            </div>


                            <div class="col">
                                <label for="">Phone Number <span style="color: red">*</span></label>
                                <input type="text" name="contact_phone" class="form-control" placeholder="Phone Number"
                                    required>
                            </div>

                        </div>

                    </div>
                </div>

                <br>






                {{-- Products Offering --}}
                <div class="card">
                    <div class="card-header">
                        Products Offering
                    </div>
                    <div class="card-body"
                        style="margin-left: 5px; margin-top: 5px; margin-right: 5px; margin-bottom: 5px;">
                        <b>Note: Select one or more options</b>
                        <br>
                        <br>
                        <div class="row">

                            <div class="col">
                                <label for="">Type of Products <span style="color: red">*</span></label>
                                <select class="form-control js-example-basic-multiple" multiple id="type_products"
                                    name="type_products[]" required>
                                    @foreach ($product_type as $c)
                                        <option value="{{ $c->id }}">{{ $c->description }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <label for="">Care Segment <span style="color: red">*</span></label>
                                <select class="form-control js-example-basic-multiple" multiple id="care"
                                    name="care[]" required>
                                    @foreach ($care_segment as $c)
                                        <option value="{{ $c->id }}">{{ $c->description }}</option>
                                    @endforeach
                                </select>
                            </div>


                        </div>
                        <br>
                        <div class="row">

                            <div class="col">
                                <label for="">Main Products <span style="color: red">*</span></label>
                                <textarea name="main_products" class="form-control" placeholder="Main Products" required></textarea>
                            </div>

                            <div class="col">
                                <label for="">Presence of Existing Distributor <span
                                        style="color: red">*</span></label>
                                <select class="form-control js-example-basic-multiple" multiple id="Presence"
                                    name="presence[]" required>
                                    @foreach ($presence as $c)
                                        <option value="{{ $c->id }}">{{ $c->description }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <br>
                        <div class="row">

                            <div class="col-6">
                                <label for="">Country of interest for distribution <span
                                        style="color: red">*</span></label>
                                <select class="form-control js-example-basic-multiple" multiple id="country_interest"
                                    name="country_interest[]" required>
                                    @foreach ($presence as $c)
                                        <option value="{{ $c->id }}">{{ $c->description }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>
                </div>

                <br>


                {{-- Documents File --}}
                <div class="card">
                    <div class="card-header">
                        Documents Files
                    </div>
                    <div class="card-body"
                        style="margin-left: 5px; margin-top: 5px; margin-right: 5px; margin-bottom: 5px;">
                        <div class="row">

                            <div class="col">
                                <label for="">Company Profile <span style="color: red">*</span></label>
                                <input type="file" name="company_profile[]"
                                    accept=".xlsx,.xls,image/*,.doc,.docx,.pdf,.zip" id="file1" multiple
                                    data-allowed-file-extensions='["xlsx","xls","jpg","jpeg","png","gif","bmp","doc","docx","pdf","zip"]'
                                    class="file" data-preview-file-type="text" required>
                                <br>
                                <div id="file-list1"></div>
                            </div>


                            <div class="col">
                                <label for="">Product Brochure <span style="color: red">*</span></label>
                                <input type="file" name="product_brochure[]" class="file"
                                    data-preview-file-type="text" accept=".xlsx,.xls,image/*,.doc,.docx,.pdf,.zip"
                                    data-allowed-file-extensions='["xlsx","xls","jpg","jpeg","png","gif","bmp","doc","docx","pdf","zip"]'
                                    id="file2" multiple required>
                                <br>
                                <div id="file-list2"></div>
                            </div>
                            {{-- <div class="col">
                                <label for="">Product Brochure <span style="color: red">*</span></label>
                                <br>
                                <label class="custom-file-input" ondrop="handleDrop(event);"
                                    ondragover="handleDragOver(event);">
                                    <input type="file" name="product_brochure[]" class="form-control file-input"
                                        accept=".xlsx,.xls,image/*,.doc,.docx,.pdf,.zip" id="file2" multiple required>
                                    Drag and drop files here, or <span
                                        style="color: blue; text-decoration: underline; cursor: pointer;">click to
                                        browse</span>.
                                </label>
                                <br>
                                <div id="file-list2"></div>
                            </div> --}}

                        </div>
                        <br>
                        <div class="row">
                            <div class="col-6">
                                <label for="">Other relevant Documents</label>
                                <input type="file" name="other_documents[]" multiple
                                    accept=".xlsx,.xls,image/*,.doc,.docx,.pdf,.zip" id="file3" class="file"
                                    data-max-file-size="5120" data-preview-file-type="text"
                                    data-allowed-file-extensions='["xlsx","xls","jpg","jpeg","png","gif","bmp","doc","docx","pdf","zip"]'>
                                <br>
                                <div id="file-list3"></div>
                            </div>
                        </div>

                        <br>
                        <br>
                        <div class="alert alert-danger" style="max-width: 470px;">
                            Max file size = 5MB | Accepted file type = pdf, xlsx, docx, png, jpeg, zip
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="d-flex justify-content-center">
                    {{-- <a href="/" class="btn btn-danger">Cancel</a>&nbsp;&nbsp;&nbsp; --}}
                    <button id="submit-butt" class="btn btn-primary" type="submit">Submit</button>
                </div>
            </div>



        </div>
    @endsection

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#type_products, #care, #Presence, #country_interest, #Potential_1, #Potential_2, .js-example-basic-single')
                .select2();

            $(".file").fileinput({
                removeClass: "btn btn-danger",
                removeLabel: "Delete",
                removeIcon: "<i class=\"bi-trash\"></i> ",
                showUpload: false
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            function handleFileInputChange(inputId, fileListId) {
                var fileInput = document.getElementById(inputId);
                var fileList = document.getElementById(fileListId);
                var allcompafile = {!! json_encode($allcompafile) !!};
                var allprodfile = {!! json_encode($allprodfile) !!};
                var allotherfile = {!! json_encode($allotherfile) !!};

                fileInput.addEventListener('change', function() {
                    // var maxFiles = 3; // Maximum number of files allowed
                    var maxFileSize = 5 * 1024 * 1024; // 5 MB in bytes

                    // Clear previous messages
                    // fileList.innerHTML = '';

                    // if (fileInput.files.length > maxFiles) {
                    //     alert('You can only upload a maximum of ' + maxFiles + ' files.');
                    //     fileInput.value = ''; // Clear the selected files
                    // } 
                    if (fileInput) {
                        for (var i = 0; i < fileInput.files.length; i++) {
                            var file = fileInput.files[i];
                            var fileName = file.name;
                            var fileSize = file.size;

                            var acceptedExtensions = ['pdf', 'xls', 'xlsx', 'doc', 'docx', 'png', 'jpeg',
                                'jpg', 'zip'
                            ];
                            var fileExtension = fileName.split('.').pop().toLowerCase();

                            if (fileInput.id == 'file1') {
                                if (allcompafile.includes(fileName)) {
                                    alert('File "' + fileName +
                                        '" already exist please rename the file');
                                    fileInput.value = ''; // Clear the selected files
                                    // fileList.innerHTML = '';
                                    break; // Exit the loop
                                }
                            }

                            if (fileInput.id == 'file2') {
                                if (allprodfile.includes(fileName)) {
                                    alert('File "' + fileName +
                                        '" already exist please rename the file');
                                    fileInput.value = ''; // Clear the selected files
                                    // fileList.innerHTML = '';
                                    break; // Exit the loop
                                }
                            }

                            if (fileInput.id == 'file3') {
                                if (allotherfile.includes(fileName)) {
                                    alert('File "' + fileName +
                                        '" already exist please rename the file');
                                    fileInput.value = ''; // Clear the selected files
                                    // fileList.innerHTML = '';
                                    break; // Exit the loop
                                }
                            }

                            if (!acceptedExtensions.includes(fileExtension)) {
                                alert('File "' + fileName +
                                    '" has an invalid extension. Accepted extensions are: ' +
                                    acceptedExtensions.join(', '));
                                fileInput.value = ''; // Clear the selected files
                                // fileList.innerHTML = '';
                                break; // Exit the loop
                            } else if (fileSize > maxFileSize) {
                                alert('File "' + fileName + '" is too large. Maximum file size is 5 MB.');
                                fileInput.value = ''; // Clear the selected files
                                // fileList.innerHTML = '';
                                break; // Exit the loop
                            }
                            // else {
                            //     var listItem = document.createElement('div');
                            //     // listItem.textContent = fileName;
                            //     listItem.innerHTML =
                            //         '<div><span class="fa-stack fa-lg"><i class="fa fa-file fa-stack-1x "></i><strong class="fa-stack-1x" style="color:#FFF; font-size:12px; margin-top:2px;">' +
                            //         (i + 1) + '</strong></span> ' + fileName +
                            //         '&nbsp;&nbsp;</div>';
                            //     fileList.appendChild(listItem);
                            // }
                        }
                    }
                });
            }

            handleFileInputChange('file1', 'file-list1');
            handleFileInputChange('file2', 'file-list2');
            handleFileInputChange('file3', 'file-list3');
        });
    </script>
