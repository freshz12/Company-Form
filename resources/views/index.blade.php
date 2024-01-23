@extends('layouts.main')
@section('container')
    {{-- @can('Opportunity View') --}}
    {{-- @php
        $gg = Auth::user();
        $roles = $gg->getRoleNames();
    @endphp
    @foreach ($roles as $role)
        {{ $role }} <br>
    @endforeach --}}

    {{-- <div class="content-wrapper">
        <div>
            <a href="/form" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add New Form</a>
        </div>
    </div> --}}
    <div>
        <table id="header" class="table table-responsive table-bordered table-hover table-striped optab"
            style="width: max-content">
            <thead>
                <tr>
                    <th>No</th>
                    <th class="text-center">#</th>
                    <th>Form ID</th>
                    <th>Company Name</th>
                    <th>HQ Office Address</th>
                    <th>Company website</th>
                    <th>Country of origin</th>
                    <th>Year of establishment</th>
                    <th>Contact Name</th>
                    <th>Contact Designation</th>
                    <th>Contact Email address</th>
                    <th>Contact Phone number</th>
                    <th>Type of Products</th>
                    <th>Care Segment</th>
                    <th>Main Products</th>
                    <th>Presence of Distributor</th>
                    <th>Country of Interest for Distribution</th>
                    <th>Potential Relationship</th>
                    <th>Other Potential Relationship</th>
                    <th>Potential Service offered by Company</th>
                    <th>Other Potential Service Offered by Company</th>
                    {{-- <th>Company Profile</th>
                    <th>Product Brochure</th>
                    <th>Other Relevant File</th> --}}
                    <th style="width: 200px">Created Date</th>
                    <th style="width: 200px">Updated Date</th>
                    {{-- <th>Updated By</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($form as $b)
                    <tr>
                        <td>
                            {{ ($form->currentpage() - 1) * $form->perpage() + $loop->index + 1 }}
                        </td>
                        <td>
                            <form action={{ url('formedit') }} method="post" style="all: unset">
                                @csrf
                                <input type="hidden" name="id" class="form-control" value="{{ $b->id }}">
                                <button type="submit" class="btn btn-link">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                            </form>
                        </td>
                        <td>{{ $b->form_id }}</td>
                        <td>{{ $b->company_name }}</td>
                        <td>{{ $b->company_hq_office_address }}</td>
                        <td>{{ $b->company_website }}</td>
                        <td>{{ $b->company_country_of_origin }}</td>
                        <td>{{ $b->year_of_establishment }}</td>
                        <td>{{ $b->contact_name }}</td>
                        <td>{{ $b->contact_designation }}</td>
                        <td>{{ $b->contact_email_address }}</td>
                        <td>{{ $b->contact_phone_number }}</td>

                        <td>{{ $b->type_of_products }}</td>
                        <td>{{ $b->care_segment }}</td>
                        <td>{{ $b->main_products }}</td>
                        <td>{{ $b->presence_of_distributor }}</td>
                        <td>{{ $b->country_of_interest_for_distribution }}</td>

                        <td>{{ $b->potential_relationship }}</td>
                        <td>{{ $b->other_potential_relationship ?? '' }}</td>
                        <td>{{ $b->potential_service_offered_by_ids }}</td>
                        <td>{{ $b->other_potential_service_offered_by_ids ?? '' }}</td>
                        {{-- <td>{{ $b->company_profile_name }}</td>
                        <td>{{ $b->product_brochure_name }}</td>
                        <td>{{ $b->other_relevant_file_name }}</td> --}}
                        <td>{{ $b->created_at }}</td>
                        <td>{{ $b->updated_at }}</td>
                        {{-- <td>{{ $b->updated_by }}</td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>




    <br>
    <div class="d-flex justify-content-end">
        {{ $form->links() }}
    </div>
    {{-- @else
        <div style="display: flex;justify-content: center;align-items: center;height: 100vh;">
            <h1>Access Denied</h1>
        </div>
    @endcan --}}
@endsection
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script>
    $(document).ready(function() {
        $('#header thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#header thead');

        var headerClasses = [];

        var table = $('#header').DataTable({
            orderCellsTop: true,
            autoWidth: false,
            dom: 'fBrtlip',
            buttons: [
                // {
                //     text: `<a><i class="bi bi-plus-lg"></i> Add New Form</a>`,
                //     className: 'btn btn-primary',
                //     action: function(e, dt, node, config) {
                //         window.location.href = "/form";
                //     }
                // },
                {
                    text: `<a><i class="bi bi-file-excel"></i> Export Excel</a>`,
                    className: 'btn btn-success',
                    extend: 'excel',
                    exportOptions: {
                        columns: 'th:not(:nth-child(2))',
                        format: {
                            header: function(data, columnIdx) {
                                switch (columnIdx) {
                                    case 0:
                                        return 'No	';
                                        break;
                                    case 2:
                                        return 'Form ID	';
                                        break;
                                    case 3:
                                        return 'Company Name';
                                        break;
                                    case 4:
                                        return 'HQ Office Address	';
                                        break;
                                    case 5:
                                        return 'Company website	';
                                        break;
                                    case 6:
                                        return 'Country of origin	';
                                        break;
                                    case 7:
                                        return 'Year of establishment	';
                                        break;
                                    case 8:
                                        return 'Contact Name	';
                                        break;
                                    case 9:
                                        return 'Contact Designation	';
                                        break;
                                    case 10:
                                        return 'Contact Email address	';
                                        break;
                                    case 11:
                                        return 'Contact Phone number	';
                                        break;
                                    case 12:
                                        return 'Type of Products	';
                                        break;
                                    case 13:
                                        return 'Care Segment	';
                                        break;
                                    case 14:
                                        return 'Main Products	';
                                        break;
                                    case 15:
                                        return 'Presence of Distributor	';
                                        break;
                                    case 16:
                                        return 'Country of Interest for Distribution	';
                                        break;
                                    case 17:
                                        return 'Potential Relationship	';
                                        break;
                                    case 18:
                                        return 'Other Potential Relationship	';
                                        break;
                                    case 19:
                                        return 'Potential Service offered by Company	';
                                        break;
                                    case 20:
                                        return 'Other Potential Service Offered by Company	';
                                        break;
                                    case 21:
                                        return 'Created Date';
                                        break;
                                    case 22:
                                        return 'Updated At	';
                                        break;
                                        // case 23:
                                        //     return 'Other Relevant File	';
                                        //     break;
                                        // case 24:
                                        //     return 'Created Date	';
                                        //     break;
                                        // case 25:
                                        //     return 'Updated At	';
                                        //     break;
                                        // case 26:
                                        //     return 'Updated By';
                                        //     break;
                                    default:
                                        // Do nothing for other columns (maintain their original data)
                                        return data;
                                        break;
                                }
                            }
                        }
                    }
                },
            ],
            select: true,
            scrollX: true,
            initComplete: function() {
                var api = this.api();

                api.columns().eq(0).each(function(colIdx) {
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(api.column(colIdx).header()).addClass(headerClasses[colIdx]);
                    if ($(cell).index() !== 0 && $(cell).index() !== 1) {
                        $(cell).html(
                            '<input type="text" class="form-control" placeholder="' +
                            title +
                            '" style="width: 100%;" />');
                    } else {
                        $(cell).html('<div style="font-size: 17px;">#</div>');
                    }

                    $('input', $('.filters th').eq($(api.column(colIdx).header()).index()))
                        .off('keyup change')
                        .on('change', function(e) {
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr =
                                '({search})'; //$(this).parents('th').find('select').val();

                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != '' ?
                                    regexr.replace('{search}', '(((' + this.value +
                                        ')))') :
                                    '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
                        })
                        .on('keyup', function(e) {
                            e.stopPropagation();

                            $(this).trigger('change');
                            $(this)
                                .focus()[0]
                                .setSelectionRange(cursorPosition, cursorPosition);
                        });
                });

            },
        });

        table.columns.adjust().draw();
    });
</script>
