@extends('layouts.main')
@section('container')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" />

    <form action={{ url('updateform') }} method="post" enctype="multipart/form-data">
        @csrf
        <div id="mainbodyaddform">
            <br>

            <div id="carding">
                <div class="card">
                    <div class="card-header">
                        <b>{{ $data->form_id }}</b>
                    </div>
                </div>

                <br>

                {{-- Company Details --}}
                <div class="card">
                    <div class="card-header">
                        Company Details
                    </div>
                    <div class="card-body"
                        style="margin-left: 5px; margin-top: 5px; margin-right: 5px; margin-bottom: 5px;">
                        <div class="row">
                            <input type="hidden" name="id" class="form-control" value="{{ $data->id }}" required>
                            <div class="col">
                                <label for="">Company Name <span style="color: red">*</span></label>
                                <input type="text" name="company_name" class="form-control"
                                    value="{{ $data->company_name }}" placeholder="Company Name" required>
                            </div>

                            <div class="col">
                                <label for="">HQ Office Address <span style="color: red">*</span></label>
                                <input type="text" name="hq" class="form-control"
                                    value="{{ $data->company_hq_office_address }}" placeholder="HQ Office Address" required>
                            </div>

                        </div>
                        <br>
                        <div class="row">

                            <div class="col">
                                <label for="">Company Website <span style="color: red">*</span></label>
                                <input type="text" name="company_website" class="form-control"
                                    value="{{ $data->company_website }}" placeholder="Company Website" required>
                            </div>

                            <div class="col">
                                <label for="">Country of origin <span style="color: red">*</span></label>
                                <select class="form-control js-example-basic-single" name="Country_of_origin" id="country"
                                    required>
                                    <option value="" selected></option>
                                    @foreach ($country as $c)
                                        <option value="{{ $c }}"
                                            {{ $data->company_country_of_origin == $c ? 'selected' : '' }}>
                                            {{ $c }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <br>
                        <div class="row">

                            <div class="col-6">
                                <label for="">Year of establishment <span style="color: red">*</span></label>
                                <input type="number" maxlength="4" min="1900" max="2099" name="year"
                                    value="{{ $data->year_of_establishment }}" class="form-control"
                                    placeholder="Year of establishment" required>
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
                                <input type="text" name="contact_name" class="form-control" placeholder="Name"
                                    value="{{ $data->contact_name }}" required>
                            </div>

                            <div class="col">
                                <label for="">Designation <span style="color: red">*</span></label>
                                <input type="text" name="contact_designation" class="form-control"
                                    value="{{ $data->contact_designation }}" placeholder="Destignation" required>
                            </div>

                        </div>
                        <br>
                        <div class="row">

                            <div class="col">
                                <label for="">Email Address <span style="color: red">*</span></label>
                                <input type="text" name="contact_email" class="form-control"
                                    value="{{ $data->contact_email_address }}" placeholder="Email Address" required>
                            </div>


                            <div class="col">
                                <label for="">Phone Number <span style="color: red">*</span></label>
                                <input type="text" name="contact_phone" class="form-control"
                                    value="{{ $data->contact_phone_number }}" placeholder="Phone Number" required>
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
                                        <option value="{{ $c->id }}"
                                            {{ in_array($c->id, $type) ? 'selected' : '' }}>
                                            {{ $c->description }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <label for="">Care Segment <span style="color: red">*</span></label>
                                <select class="form-control js-example-basic-multiple" multiple id="care"
                                    name="care[]" required>
                                    @foreach ($care_segment as $c)
                                        <option value="{{ $c->id }}"
                                            {{ in_array($c->id, $care) ? 'selected' : '' }}>
                                            {{ $c->description }}</option>
                                    @endforeach
                                </select>
                            </div>


                        </div>
                        <br>
                        <div class="row">

                            <div class="col">
                                <label for="">Main Products <span style="color: red">*</span></label>
                                <textarea name="main_products" class="form-control" placeholder="Main Products" required>{{ $data->main_products }}</textarea>
                            </div>

                            <div class="col">
                                <label for="">Presence of Existing Distributor <span
                                        style="color: red">*</span></label>
                                <select class="form-control js-example-basic-multiple" multiple id="Presence"
                                    name="presence[]" required>
                                    @foreach ($presence as $c)
                                        <option value="{{ $c->id }}"
                                            {{ in_array($c->id, $presence_of_distributor) ? 'selected' : '' }}>
                                            {{ $c->description }}</option>
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
                                        <option value="{{ $c->id }}"
                                            {{ in_array($c->id, $country_of_interest_for_distribution) ? 'selected' : '' }}>
                                            {{ $c->description }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>


                    </div>
                </div>


                <br>

                {{-- Potential Partnetship --}}
                <div class="card">
                    <div class="card-header">
                        Potential Partnership
                    </div>
                    <div class="card-body"
                        style="margin-left: 5px; margin-top: 5px; margin-right: 5px; margin-bottom: 5px;">
                        <b>Note: Select one or more options</b>
                        <br>
                        <br>
                        <div class="row">

                            <div class="col">
                                <label for="">Potential Relationship <span style="color: red">*</span></label>
                                <select class="form-control js-example-basic-multiple" multiple id="Potential_1"
                                    name="potential_1[]" onchange="appendother1();" required>
                                    @foreach ($potential_relationship as $c)
                                        <option value="{{ $c->id }}"
                                            {{ in_array($c->id, $potential1) ? 'selected' : '' }}>{{ $c->description }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <label for="">Potential Service offered by Company <span
                                        style="color: red">*</span></label>
                                <select class="form-control js-example-basic-multiple" multiple id="Potential_2"
                                    name="potential_2[]" onchange="appendother2();" required>
                                    @foreach ($potential_service as $c)
                                        <option value="{{ $c->id }}"
                                            {{ in_array($c->id, $potential2) ? 'selected' : '' }}>{{ $c->description }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                        </div>
                        <div class="row">

                            <div class="col" id="other_1">
                                {{-- <label for="">Other Potential Relationship <span
                                        style="color: red">*</span></label>
                                <input type="text" name="other_1" class="form-control"
                                    placeholder="Other Potential Relationship" required> --}}
                            </div>

                            <div class="col" id="other_2">
                                {{-- <label for="">Other Potential Service offered by Company <span
                                        style="color: red">*</span></label>
                                <input type="text" name="other_2" class="form-control"
                                    placeholder="Other Potential Service offered by Company" required> --}}
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
                                <label for="">Company Profile</label><br><br>
                                <input type="file" name="company_profile[]" class="file" data-max-file-size="5120"
                                    data-preview-file-type="text"
                                    data-allowed-file-extensions='["xlsx","xls","jpg","jpeg","png","gif","bmp","doc","docx","pdf","zip"]'
                                    onchange="handleFileInputChange(this.id);"
                                    accept=".xlsx,.xls,image/*,.doc,.docx,.pdf,.zip" id="file1" multiple>

                                <br>
                                <div id="file-list1"></div>
                                <br>

                                @foreach ($company_profiles as $index => $company_profile)
                                    @if (!empty($company_profile) || $company_profile !== '')
                                        <div id="compa_box_{{ $index }}">

                                            <input id="compa_value_{{ $index }}" type="hidden"
                                                name="company_profile_name" value="{{ $company_profile }}">
                                            <button
                                                onclick="if (confirm('Are you sure you want to delete this item?')) del_compa({{ $index }});"
                                                type="button" class="btn btn-danger  btn-lg"><i
                                                    class="bi bi-trash3-fill"></i></button>

                                            &nbsp;&nbsp;&nbsp;
                                            <a class="btn btn-primary"
                                                href="{{ Storage::url('uploads/company_profile/' . $company_profile) }}"
                                                download="{{ $company_profile }}">Download</a>
                                            <label for=""><b>{{ $company_profile }}</b></label>
                                            <br>
                                            <br>
                                        </div>
                                    @endif
                                @endforeach



                            </div>

                            <div class="col">
                                <label for="">Product Brochure</label><br><br>
                                <input type="file" name="product_brochure[]" class="file" data-max-file-size="5120"
                                    data-preview-file-type="text"
                                    data-allowed-file-extensions='["xlsx","xls","jpg","jpeg","png","gif","bmp","doc","docx","pdf","zip"]'
                                    onchange="handleFileInputChange(this.id);"
                                    accept=".xlsx,.xls,image/*,.doc,.docx,.pdf,.zip" id="file2" multiple>
                                <br>
                                <div id="file-list2"></div>

                                <div id="fileinput2"></div><br>
                                @foreach ($product_brochures as $index => $product_brochure)
                                    @if (!empty($product_brochure) || $product_brochure !== '')
                                        <div id="prod_box_{{ $index }}">
                                            <input id="prod_value_{{ $index }}" type="hidden"
                                                name="product_brochure_name" value="{{ $product_brochure }}">
                                            <button
                                                onclick="if (confirm('Are you sure you want to delete this item?')) del_prod({{ $index }});"
                                                type="button" class="btn btn-danger btn-lg"><i
                                                    class="bi bi-trash3-fill"></i></button>

                                            &nbsp;&nbsp;&nbsp;
                                            <a class="btn btn-primary"
                                                href="{{ Storage::url('uploads/product_brochure/' . $product_brochure) }}"
                                                download="{{ $product_brochure }}">Download</a>
                                            <label for=""><b>{{ $product_brochure }}</b></label>
                                            <br>
                                            <br>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                        </div>
                        <br>
                        <div class="row">

                            <div class="col-6" id="other_card">
                                <label for="">Other relevant Documents</label><br><br>
                                <input type="file" name="other_documents[]" multiple
                                    onchange="handleFileInputChange(this.id);"
                                    accept=".xlsx,.xls,image/*,.doc,.docx,.pdf,.zip" id="file3" class="file"
                                    data-max-file-size="5120" data-preview-file-type="text"
                                    data-allowed-file-extensions='["xlsx","xls","jpg","jpeg","png","gif","bmp","doc","docx","pdf","zip"]'>
                                <br>
                                <div id="file-list3"></div>

                                <div id="fileinput3"></div><br>

                                @foreach ($other_relevant_files as $index => $other_relevant_file)
                                    @if (!empty($other_relevant_file) || $other_relevant_file !== null)
                                        <div id="ot_box_{{ $index }}">
                                            <input id="ot_value_{{ $index }}" type="hidden"
                                                name="other_relevant_files_name" value="{{ $other_relevant_file }}">
                                            <button
                                                onclick="if (confirm('Are you sure you want to delete this item?')) del_ot({{ $index }});"
                                                type="button" class="btn btn-danger btn-lg"><i
                                                    class="bi bi-trash3-fill"></i></button>


                                            &nbsp;&nbsp;&nbsp;
                                            <a class="btn btn-primary"
                                                href="{{ Storage::url('uploads/other_documents/' . $other_relevant_file) }}"
                                                download="{{ $other_relevant_file }}">Download</a>
                                            <label for=""><b>{{ $other_relevant_file }}</b></label>
                                            <br>
                                            <br>
                                        </div>
                                    @endif
                                @endforeach

                            </div>

                        </div>

                        <br>
                        <br>
                        <div class="alert alert-danger" style="max-width: 470px;">
                            Max file size = 5MB | Accepted file type = pdf, xlsx, docx, png, jpeg, zip
                        </div>
                        {{-- <p>Max file size = 5MB | Accepted file type = pdf, xlsx, docx, png, jpeg, zip
                        </p> --}}
                    </div>
                </div>
                <br>
                <br>
                <div class="d-flex justify-content-center">
                    <a href={{ url('/home') }} class="btn btn-danger">Cancel</a>&nbsp;&nbsp;&nbsp;
                    <button id="openmodal" type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#exampleModal">Update</button>
                </div>



                @php
                    $type = json_encode($type); // Convert the PHP array to a JSON string
                    $care = json_encode($care);
                    $presence_of_distributor = json_encode($presence_of_distributor);
                    $country_of_interest_for_distribution = json_encode($country_of_interest_for_distribution);
                @endphp

            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Company Form Edit</h5>
                    </div>
                    <div class="modal-body">
                        Are you sure want to edit this Data?
                        <br>
                        <br>
                        <b>
                            Changed Field:
                        </b>
                        <br>
                        <div id="changedfield"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>


    </form>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(".file").fileinput({
            removeClass: "btn btn-danger",
            removeLabel: "Delete",
            removeIcon: "<i class=\"bi-trash\"></i> ",
            showUpload: false
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#type_products, #care, #Presence, #country_interest, #Potential_1, #Potential_2, .js-example-basic-single')
            .select2();

        appendother1();
        appendother2();
    });
</script>

<script>
    function handleFileInputChange(fileInput) {

        if (fileInput == 'file1') {
            var fileList = document.getElementById('file-list1');
            var filefile = document.getElementById('file1');
        }
        if (fileInput == 'file2') {
            var fileList = document.getElementById('file-list2');
            var filefile = document.getElementById('file2');
        }
        if (fileInput == 'file3') {
            var fileList = document.getElementById('file-list3');
            var filefile = document.getElementById('file3');
        }

        var maxFileSize = 5 * 1024 * 1024; // 5 MB in bytes
        var allcompafile = {!! json_encode($allcompafile) !!};
        var allprodfile = {!! json_encode($allprodfile) !!};
        var allotherfile = {!! json_encode($allotherfile) !!};

        // Clear previous messages
        fileList.innerHTML = '';


        for (var i = 0; i < filefile.files.length; i++) {
            var file = filefile.files[i];
            var fileName = file.name;
            var fileSize = file.size;

            var acceptedExtensions = ['pdf', 'xls', 'xlsx', 'doc', 'docx', 'png', 'jpeg',
                'jpg', 'zip'
            ];
            var fileExtension = fileName.split('.').pop().toLowerCase();

            if (fileInput == 'file1') {
                if (allcompafile.includes(fileName)) {
                    alert('File "' + fileName +
                        '" already exist please rename the file');
                    filefile.value = ''; // Clear the selected files
                    fileList.innerHTML = '';
                    break; // Exit the loop
                }
            }

            if (fileInput == 'file2') {
                if (allprodfile.includes(fileName)) {
                    alert('File "' + fileName +
                        '" already exist please rename the file');
                    filefile.value = ''; // Clear the selected files
                    fileList.innerHTML = '';
                    break; // Exit the loop
                }
            }

            if (fileInput == 'file3') {
                if (allotherfile.includes(fileName)) {
                    alert('File "' + fileName +
                        '" already exist please rename the file');
                    filefile.value = ''; // Clear the selected files
                    fileList.innerHTML = '';
                    break; // Exit the loop
                }
            }

            if (!acceptedExtensions.includes(fileExtension)) {
                alert('File "' + fileName +
                    '" has an invalid extension. Accepted extensions are: ' +
                    acceptedExtensions.join(', '));
                filefile.value = ''; // Clear the selected files
                fileList.innerHTML = '';
                break; // Exit the loop
            } else if (fileSize > maxFileSize) {
                alert('File "' + fileName + '" is too large. Maximum file size is 5 MB.');
                filefile.value = ''; // Clear the selected files
                fileList.innerHTML = '';
                break; // Exit the loop
            } else {
                var listItem = document.createElement('div');
                // listItem.innerHTML = '<b>sdasd</b>';
                listItem.innerHTML =
                    '<div><span class="fa-stack fa-lg"><i class="fa fa-file fa-stack-1x "></i><strong class="fa-stack-1x" style="color:#FFF; font-size:12px; margin-top:2px;">' +
                    (i + 1) + '</strong></span> ' + fileName +
                    '&nbsp;&nbsp;</div>';
                fileList.appendChild(listItem);
            }
        }

    }
</script>


<script>
    function appendother1() {
        var Potential_1 = document.getElementById('Potential_1');
        var other_1 = document.getElementById('other_1');

        var selectedValues = Array.from(Potential_1.selectedOptions).map(option => option.value.toLowerCase());

        other_1.innerHTML = "";

        if (selectedValues.some(value => value.includes("42"))) {
            other_1.innerHTML += `<br> <label for="">Other Potential Relationship <span
            style="color: red">*</span></label>
            <input type="text" name="other_1" class="form-control"
            placeholder="Other Potential Relationship" value="{{ $data->other_potential_relationship }}" required>`;
        }
    }

    function appendother2() {
        var Potential_2 = document.getElementById("Potential_2");
        var other_2 = document.getElementById('other_2');

        var selectedValues = Array.from(Potential_2.selectedOptions).map(option => option.value.toLowerCase());

        other_2.innerHTML = "";

        if (selectedValues.some(value => value.includes("46"))) {
            other_2.innerHTML += `<br> <label for="">Other Potential Service offered by Company <span
                style="color: red">*</span></label>
                <input type="text" name="other_2" class="form-control" value="{{ $data->other_potential_service_offered_by_ids }}"
                                    placeholder="Other Potential Service offered by Company" required>`;
        }
    }
</script>

<script>
    $(document).ready(function() {
        $('#openmodal').on('click', function() {
            var old_company_name = "{{ $data->company_name }}";
            var new_company_name = document.querySelector('input[name="company_name"]').value;
            var old_company_hq_office_address = "{{ $data->company_hq_office_address }}";
            var new_company_hq_office_address = document.querySelector('input[name="hq"]').value;
            var old_company_website = "{{ $data->company_website }}";
            var new_company_website = document.querySelector('input[name="company_website"]').value;
            var old_company_country_of_origin = "{{ $data->company_country_of_origin }}";
            var new_company_country_of_origin = document.querySelector('#country').value;
            var old_year = "{{ $data->year_of_establishment }}";
            var new_year = document.querySelector('input[name="year"]').value;
            var old_contact_name = "{{ $data->contact_name }}";
            var new_contact_name = document.querySelector('input[name="contact_name"]').value;
            var old_contact_designation = "{{ $data->contact_designation }}";
            var new_contact_designation = document.querySelector('input[name="contact_designation"]')
                .value;
            var old_contact_email = "{{ $data->contact_email_address }}";
            var new_contact_email = document.querySelector('input[name="contact_email"]').value;
            var old_contact_phone = "{{ $data->contact_phone_number }}";
            var new_contact_phone = document.querySelector('input[name="contact_phone"]').value;
            var old_main_products = "{{ $data->main_products }}";
            var new_main_products = document.querySelector('textarea[name="main_products"]').value;
            var old_type_products = JSON.parse('{!! addslashes($type) !!}');
            var new_type_products = $('#type_products').val();
            var old_care = JSON.parse('{!! addslashes($care) !!}');
            var new_care = $('#care').val();
            var old_presence = JSON.parse('{!! addslashes($presence_of_distributor) !!}');
            var new_presence = $('#Presence').val();
            var old_country_interest = JSON.parse('{!! addslashes($country_of_interest_for_distribution) !!}');
            var new_country_interest = $('#country_interest').val();
            var file1 = $('#file1').val();
            var file2 = $('#file2').val();
            var file3 = $('#file3').val();

            var conditionMet = false;
            $('#changedfield').html('');

            if (old_company_name !== new_company_name) {
                $('#changedfield').append('Company Name<br>');
                conditionMet = true;
            }
            if (old_company_hq_office_address !== new_company_hq_office_address) {
                $('#changedfield').append('HQ Office Address<br>');
                conditionMet = true;
            }
            if (old_company_website !== new_company_website) {
                $('#changedfield').append('Company Website<br>');
                conditionMet = true;
            }
            if (old_company_country_of_origin !== new_company_country_of_origin) {
                $('#changedfield').append('Company Country of Origin<br>');
                conditionMet = true;
            }
            if (old_year !== new_year) {
                $('#changedfield').append('Year of Establishment<br>');
                conditionMet = true;
            }
            if (old_contact_name !== new_contact_name) {
                $('#changedfield').append('Contact Name<br>');
                conditionMet = true;
            }
            if (old_contact_designation !== new_contact_designation) {
                $('#changedfield').append('Contact Designation<br>');
                conditionMet = true;
            }
            if (old_contact_email !== new_contact_email) {
                $('#changedfield').append('Contact Email<br>');
                conditionMet = true;
            }
            if (old_contact_phone !== new_contact_phone) {
                $('#changedfield').append('Contact Phone Number<br>');
                conditionMet = true;
            }

            if (JSON.stringify(old_type_products) !== JSON.stringify(new_type_products)) {
                $('#changedfield').append('Type of Products<br>');
                conditionMet = true;
            }
            if (JSON.stringify(old_care) !== JSON.stringify(new_care)) {
                $('#changedfield').append('Care Segment<br>');
                conditionMet = true;
            }

            if (JSON.stringify(old_main_products) !== JSON.stringify(new_main_products)) {
                $('#changedfield').append('Main Products<br>');
                conditionMet = true;
            }

            if (JSON.stringify(old_presence) !== JSON.stringify(new_presence)) {
                $('#changedfield').append('Presence of distributor<br>');
                conditionMet = true;
            }
            if (JSON.stringify(old_country_interest) !== JSON.stringify(new_country_interest)) {
                $('#changedfield').append('Country of interest for distribution<br>');
                conditionMet = true;
            }

            if (file1 !== '') {
                $('#changedfield').append('Company Profile<br>');
                conditionMet = true;
            }

            if (file2 !== '') {
                $('#changedfield').append('Product Brochure<br>');
                conditionMet = true;
            }

            if (file3 !== '') {
                $('#changedfield').append('Other relevant Documents<br>');
                conditionMet = true;
            }

            if (!conditionMet) {
                $('#changedfield').append('-');
            }


        });
    });
</script>

<script>
    function del_compa(index) {
        console.log('asd');
        var company_profile_name = document.getElementById('compa_value_' + index).value;
        var compa_box = document.getElementById('compa_box_' + index);
        $.ajax({
            url: "{{ url('deletefiles') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                company_profile_name: company_profile_name
            },
            async: false,
            success: function() {
                compa_box.innerHTML = '';
                // comp_file_check();
                location.reload();
            },
            error: function() {
                alert('Delete failed, if the issue persists contact administrator');
            }
        });
    }

    function del_prod(index) {
        var prod_name = document.getElementById('prod_value_' + index).value;
        var prod_box = document.getElementById('prod_box_' + index);


        $.ajax({
            url: "{{ url('deletefiles') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                product_brochure_name: prod_name
            },
            async: false,
            success: function() {
                prod_box.innerHTML = '';
                // prod_file_check();
                location.reload();
            },
            error: function() {
                alert('Delete failed, if the issue persists contact administrator');
            }
        });
    }

    function del_ot(index) {
        var ot_name = document.getElementById('ot_value_' + index).value;
        var ot_box = document.getElementById('ot_box_' + index);


        $.ajax({
            url: "{{ url('deletefiles') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                other_relevant_files_name: ot_name
            },
            async: false,
            success: function() {
                ot_box.innerHTML = '';

                location.reload();

            },
            error: function() {
                alert('Delete failed, if the issue persists contact administrator');
            }
        });
    }
</script>
