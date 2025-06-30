@extends('layouts.master')

@section('title')
@lang('city.city')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">@lang('nav.home')</li>
    <li class="breadcrumb-item">@lang('nav.admin')</li>
    <li class="breadcrumb-item active">@lang('nav.city')</li>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {

            // variabili
            var currentPage;
            var rowsPerPage;
            var $tableRows;
            var totalPages;
            var allCities = [];

            function appendCityToTableBody(city) {
                const CITY_EDIT_BASE_URL = "{{ route('city.edit', ['city' => ':cityId']) }}";
                const CITY_DESTROY_CONFIRM_BASE_URL = "{{ route('city.destroy.confirm', ['city' => ':cityId']) }}";

                const editUrl = CITY_EDIT_BASE_URL.replace(':cityId', city.id);
                const deleteConfirmUrl = CITY_DESTROY_CONFIRM_BASE_URL.replace(':cityId', city.id);

                $('#cityTableBody').append(
                    `<tr><td>${city.name}</td><td>${city.region}</td><td>${city.state}</td><td><a class="btn btn-primary" href="${editUrl}"><i class="bi bi-pencil"></i> @lang('city.modify')</a></td><td><a class="btn btn-danger" href="${deleteConfirmUrl}"><i class="bi bi-trash"></i> @lang('city.delete')</a></td></tr>`
                );
            }

            // paginazione
            function showPage(page) {
                var start = (page - 1) * rowsPerPage;
                var end = start + rowsPerPage;

                $tableRows.hide().slice(start, end).show();
                $(".page-item.pageNumber").remove();
                var startPage = Math.max(1, currentPage - 1);
                var endPage = Math.min(startPage + 2, totalPages);

                for (var i = startPage; i <= endPage; i++) {
                    var $li = $("<li>", { class: "page-item pageNumber" });
                    var $link = $("<a>", { class: "page-link", href: "#", text: i });
                    if (i === currentPage) {
                        $li.addClass("active");
                    }
                    $li.append($link);
                    $li.insertBefore("#nextPage");
                }
            }

            function goToPreviousPage() {
                if (currentPage > 1) {
                    currentPage--;
                    showPage(currentPage);
                }
            }

            function goToNextPage() {
                if (currentPage < totalPages) {
                    currentPage++;
                    showPage(currentPage);
                }
            }

            // event listener
            $('#stateSelect').on('change', function () {
                $('#regionSelect').html('<option id="initialRegionDisabled" value="" disabled selected>@lang('city.select_region')</option>')
                const state = $(this).val();
                $.ajax({
                    url: '{{ route('api.regions.state') }}',
                    data: { state: state },
                    async: true,
                    success: function (data) {
                        $('#initialRegionDisabled').html('@lang('city.select_region')');
                        $('#regionSelect').removeAttr('disabled');

                        data.forEach(region => {
                            $('#regionSelect').append(`<option value="${region}">${region}</option>`);
                        });
                    }
                })
            });

            $('#regionSelect').on('change', function () {
                const state = $('#stateSelect').val();
                const region = $(this).val();

                $.ajax({
                    url: '{{ route('api.city.region') }}',
                    data: {
                        state: state,
                        region: region
                    },
                    async: true,
                    success: function (data) {
                        allCities = [];
                        $('#cityTable').removeClass('d-none');
                        $('#searchBox').removeClass('d-none');
                        $('#paginationNav').removeClass('d-none');
                        $('#cityTableBody').empty();

                        data.forEach(city => {
                            allCities.push(city);
                            appendCityToTableBody(city);
                        });

                        currentPage = 1;
                        rowsPerPage = parseInt($("#rowsPerPage").val());
                        $tableRows = $(".table tbody tr");
                        totalPages = Math.ceil($tableRows.length / rowsPerPage);
                        showPage(currentPage);
                    }
                });
            });

            $('#searchCity').on('input', function () {
                const searchText = $(this).val().toLowerCase();
                const filteredCities = allCities.filter(city =>
                    city.name.toLowerCase().startsWith(searchText)
                );

                $('#cityTableBody').empty();
                filteredCities.forEach(city => {
                    appendCityToTableBody(city);
                })

                if ($(this).val() === '') {
                    rowsPerPage = parseInt($("#rowsPerPage").val());
                    $tableRows = $(".table tbody tr");
                    totalPages = Math.ceil($tableRows.length / rowsPerPage);
                    showPage(currentPage);
                }
            })

            $("#rowsPerPage").on("change", function () {
                rowsPerPage = parseInt($(this).val());
                totalPages = Math.ceil($tableRows.length / rowsPerPage);
                showPage(currentPage);
            });

            $("#previousPage").on("click", goToPreviousPage);
            $("#nextPage").on("click", goToNextPage);

            $(document).on("click", ".pageNumber", function () {
                var page = parseInt($(this).text());
                currentPage = page;
                showPage(currentPage);
            });
        });
    </script>
@endsection

@section('body')
    <div class="row d-flex justify-content-end mb-2">
        <div class="col-4">
            <a class="btn btn-success w-100" href="{{ route('city.create') }}">
                <i class="bi bi-database-add"></i>
                @lang('city.add_city')
            </a>
        </div>
    </div>

    <h2>@lang('city.search_city')</h2>
    <div class="row g-2 mb-2">
        <div class="col-6">
            <div class="d-flex align-items-center">
                <label for="stateSelect" class="p-2 text-secondary">@lang('city.state')</label>
                <select name="state" id="stateSelect" class="form-control">
                    <option value="" disabled selected>@lang('city.select_state')</option>
                    @foreach ($states as $state)
                        <option value="{{ $state }}">{{ $state }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="d-flex">
                <label for="regionSelect" class="p-2 text-secondary">@lang('city.region')</label>
                <select name="state" id="regionSelect" class="form-control" disabled>
                    <option id="initialRegionDisabled" value="" disabled selected>@lang('city.select_state')</option>
                </select>
            </div>
        </div>
        <div class="col-12">
            <div class="form-floating d-none" id="searchBox">
                <input type="text" id="searchCity" class="form-control" placeholder="@lang('city.search')">
                <label for="searchCity">@lang('city.search')</label>
            </div>
        </div>
    </div>
    <nav id="paginationNav" class="d-none">
        <ul class="pagination justify-content-center">
            <li class="page-item" id="previousPage"><a class="page-link" href="#">&lsaquo;</a></li>
            <!-- Numeri di pagina -->
            <li class="page-item" id="nextPage"><a class="page-link" href="#">&rsaquo;</a></li>
            <li>
                <select id="rowsPerPage" class="form-control justify-content-end">
                    @php
                        $values = [5, 10, 15, 20];
                        $selected = $values[1];
                    @endphp
                    @foreach($values as $val)
                        @if($val == $selected)
                            <option $ue="{{ $val }}" selected>{{ $val }} @lang('city.city_per_page')</option>
                        @else
                            <option $ue="{{ $val }}">{{ $val }} @lang('city.city_per_page')</option>
                        @endif
                    @endforeach
                </select>
            </li>
        </ul>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover d-none" id="cityTable">
                <col width='30%'>
                <col width='20%'>
                <col width='20%'>
                <col width='15%'>
                <col width='15%'>
                <thead>
                    <tr>
                        <th>@lang('city.name')</th>
                        <th>@lang('city.region')</th>
                        <th>@lang('city.state')</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody id="cityTableBody">
                </tbody>
            </table>
        </div>
    </div>
@endsection