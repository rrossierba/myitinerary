@extends('layouts.master')

@section('title', 'Città')

@section('breadcrumb')
    <li class="breadcrumb-item">Home</li>
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item active">Città</li>
@endsection

@section('body')
    <div class="row d-flex justify-content-end mb-2">
        <div class="col-4">
            <a class="btn btn-success w-100" href="{{ route('city.create') }}">
                <i class="bi bi-database-add"></i>
                Aggiungi città
            </a>
        </div>
    </div>
    <h2>Cerca città</h2>
    <div class="row g-2 mb-2">
        <div class="col-6">
            <div class="d-flex align-items-center">
                <label for="stateSelect" class="p-2">Stato</label>
                <select name="state" id="stateSelect" class="form-control">
                    <option value="" disabled selected>Seleziona uno stato</option>
                    @foreach ($states as $state)
                        <option value="{{ $state }}">{{ $state }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="d-flex align-items-center">
                <label for="regionSelect" class="p-2">Regione</label>
                <select name="state" id="regionSelect" class="form-control" disabled>
                    <option id="initialRegionDisabled" value="" disabled selected>Seleziona uno stato</option>
                </select>
            </div>
        </div>
        <div class="col-12">
            <div class="d-flex align-items-center d-none" id="searchBox">
                <label for="searchCity" class="p-2">Cerca</label>
                <input type="text" id="searchCity" class="form-control">
            </div>
        </div>

    </div>
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
                        <th>Nome</th>
                        <th>Regione</th>
                        <th>Stato</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody id="cityTableBody">
                </tbody>
            </table>
        </div>
    </div>

    <script>
        var allCities = [];

        function appendCityToTableBody(city) {
            const CITY_EDIT_BASE_URL = "{{ route('city.edit', ['city' => ':cityId']) }}";
            const CITY_DESTROY_CONFIRM_BASE_URL = "{{ route('city.destroy.confirm', ['city' => ':cityId']) }}";

            const editUrl = CITY_EDIT_BASE_URL.replace(':cityId', city.id);
            const deleteConfirmUrl = CITY_DESTROY_CONFIRM_BASE_URL.replace(':cityId', city.id);

            $('#cityTableBody').append(
                `<tr>
                                <td>${city.name}</td>
                                <td>${city.region}</td>
                                <td>${city.state}</td>
                                <td>
                                    <a class="btn btn-primary" href="${editUrl}">
                                        <i class="bi bi-pencil-square"></i> Modifca
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-danger" href="${deleteConfirmUrl}">
                                        <i class="bi bi-trash"></i> Elimina
                                    </a>
                                </td>
                            </tr>`
            );
        }

        $('#stateSelect').on('change', function () {
            $('#regionSelect').html('<option id="initialRegionDisabled" value="" disabled selected>Seleziona uno stato</option>')
            const state = $(this).val();
            $.ajax({
                url: '{{ route('api.regions.state') }}',
                data: { state: state },
                async:true,
                success: function (data) {
                    $('#initialRegionDisabled').html('Seleziona una regione');
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
                async:true,
                success: function (data) {
                    allCities = [];
                    $('#cityTable').removeClass('d-none');
                    $('#searchBox').removeClass('d-none');
                    $('#cityTableBody').empty();

                    data.forEach(city => {
                        allCities.push(city);
                        appendCityToTableBody(city);
                    });
                    console.log(allCities)
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
        })

    </script>
@endsection