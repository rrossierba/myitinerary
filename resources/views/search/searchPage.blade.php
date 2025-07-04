@extends('layouts.master')

@section('title')
    @lang('nav.search_itinerary')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">@lang('nav.home')</li>
    <li class="breadcrumb-item active">@lang('nav.search_itinerary')</li>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {

            @if (sizeof($history) > 0)
                $('.history-search').on('click', function () {
                    const form = $('form[name=search]')[0];

                    const history = document.createElement('input');
                    history.type = 'hidden';
                    history.name = 'history';
                    history.value = true;
                    form.appendChild(history);

                    $('input[name=query]').val($(this).text().trim());
                    form.submit();
                });
            @endif
            
            $('#searchBox').on('input', function(){
                if($(this).val()!=='')
                    $('#searchSubmit').removeAttr('disabled');
                else
                    $('#searchSubmit').attr('disabled', true);
            });

        });
    </script>
@endsection

@section('body')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-12">

                <!-- titolo -->
                <h4 class="mb-3 text-center">
                    <i class="bi bi-search me-2 text-success"></i>
                    @lang('nav.search_message')
                </h4>

                <!-- form ricerca -->
                <form action="{{ route('search.store') }}" method="POST" name="search">
                    @csrf
                    <div class="form-floating mb-3">
                        <input id="searchBox" type="text" name="query" class="form-control"
                            placeholder="@lang('nav.search_itinerary_box')" autocomplete="off" required>
                        <label for="searchBox">@lang('nav.search_itinerary_box')</label>
                    </div>

                    <div class="d-grid">
                        <button id="searchSubmit" class="btn btn-success" type="submit" disabled>
                            <i class="bi bi-search"></i> @lang('nav.search')
                        </button>
                    </div>
                </form>

                <!-- ricerche recenti -->
                @if (sizeof($history) > 0)
                    <hr class="my-4">

                    <div class="mb-2 text-muted">
                        <i class="bi bi-clock-history me-1"></i> @lang('nav.recent_search')
                    </div>

                    <div class="list-group">
                        @foreach ($history as $recent)
                            <div class="list-group-item align-items-center clickable history-search">
                                {{ $recent->query_string }}
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection