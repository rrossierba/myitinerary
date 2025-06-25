@extends('layouts.master')

@section('scripts')
    <script>
        $(document).ready(function () {
            @if (auth()->check())

                // rimozione dei preferiti
                function handleRemoveSaved(buttonElement) {
                    const itinerary_id = buttonElement.attr('itineraryid');

                    $.ajax({
                        url: '{{ route('favourites.remove') }}',
                        method: 'DELETE',
                        data: {
                            itinerary_id: itinerary_id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (data) {
                            if (data.deleted === true) {
                                buttonElement.html(`<i class="bi bi-bookmark"></i> @lang('itinerary.save')`);
                                buttonElement.removeClass('btn-secondary saved');
                                buttonElement.addClass('btn-outline-secondary toSave');

                                buttonElement.off('click');
                                buttonElement.on('click', function () {
                                    handleAddSaved($(this));
                                });

                                favourite = $(`#favourite${itinerary_id}`);
                                favourite_number = favourite_number = parseInt(favourite.text(), 10);
                                favourite.text(favourite_number - 1)

                            }
                        },
                    });
                }

                // aggiunta ai preferiti
                function handleAddSaved(buttonElement) {
                    const itinerary_id = buttonElement.attr('itineraryid');

                    $.ajax({
                        url: '{{ route('favourites.add') }}',
                        method: 'POST',
                        data: {
                            itinerary_id: itinerary_id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (data) {
                            if (data.created === true) {
                                buttonElement.html(`<i class="bi bi-check-lg"></i> @lang('itinerary.saved')`);
                                buttonElement.removeClass('btn-outline-secondary toSave');
                                buttonElement.addClass('btn-secondary saved');

                                buttonElement.off('click');
                                buttonElement.on('click', function () {
                                    handleRemoveSaved($(this));
                                });

                                favourite = $(`#favourite${itinerary_id}`);
                                favourite_number = parseInt(favourite.text(), 10);
                                favourite.text(favourite_number + 1)

                            }
                        }
                    });
                }

                $('.toSave').on('click', function (e) {
                    handleAddSaved($(this));
                });

                $('.saved').on('click', function (e) {
                    handleRemoveSaved($(this));
                });
            @endif
            @if(!isset($search))
                $('#searchItinerary').on('input', function () {
                    var value = $(this).val().toLowerCase();
                    $(".itinerary-container").each(function () {
                        var title = $(this).attr('title').toLowerCase();
                        var city = $(this).attr('city').toLowerCase();
                        if (title.startsWith(value) || city.startsWith(value))
                            $(this).show();
                        else
                            $(this).hide();
                    });
                });
            @endif
                    });
    </script>
@endsection

@section('body')
    @if(isset($search))
        {{ $itineraries->links('pagination.custom-bootstrap-5') }}
    @endif

    @if(count($itineraries) > 0)
        @if (!isset($search))
            <div class="row">
                <div class="input-group mb-3">
                    <div class="form-floating" id="searchBox">
                        <input type="text" id="searchItinerary" class="form-control" placeholder="@lang('nav.search')">
                        <label for="searchItinerary">@lang('nav.search')</label>
                    </div>
                </div>
            </div>
        @endif

        @foreach ($itineraries as $itinerary)
            <div class="itinerary-container" title="{{ $itinerary->title }}" city="{{ $itinerary->city->name }}">
                <div class="card mb-2 shadow-sm rounded p-3 mb-3">
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-lg-10 col-8">
                                <h5 class="card-title">
                                    <a href="{{ route('itinerary.show', ['itinerary' => $itinerary]) }}"
                                        class="link-underline-opacity-0 link-dark itinerary_title">{{ $itinerary->title }}</a>
                                </h5>
                            </div>

                            @if (auth()->check())
                                @if(auth()->user()->can('owns', $itinerary))
                                    <div class="col-lg-1 col-2">
                                        <a href="{{ route('itinerary.destroy.confirm', ['itinerary' => $itinerary]) }}"
                                            class="btn btn-outline-danger w-100 mb-2">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                    <div class="col-lg-1 col-2">
                                        <a href="{{ route('itinerary.edit', ['itinerary' => $itinerary]) }}"
                                            class="btn btn-outline-secondary w-100 mb-2">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                @else
                                    <div class="col-lg-2 col-4">
                                        @if ($itinerary->isFavouriteByUser(auth()->id()))
                                            <button class="btn btn-secondary w-100 mb-2 saved" itineraryid="{{ $itinerary->id }}">
                                                <i class="bi bi-check-lg"></i>
                                                @lang('itinerary.saved')
                                            </button>
                                        @else
                                            <button class="btn btn-outline-secondary w-100 mb-2 toSave" itineraryid="{{ $itinerary->id }}">
                                                <i class="bi bi-bookmark"></i>
                                                @lang('itinerary.save')
                                            </button>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        </div>

                        <div class="row g-2">
                            <div class="col-lg-10 col-8">
                                <div class="badge bg-secondary fs-6 mb-2">
                                    <i class="bi bi-globe-europe-africa"></i>
                                    <span class="city_name">{{ $itinerary->city->name }}</span>
                                </div>
                                <div class="badge bg-primary fs-6 mb-2">
                                    <i class="bi bi-currency-euro"></i>
                                    {{ number_format($itinerary->stages->sum('cost'), 2, ',', '.') }}
                                </div>
                                <div class="badge bg-success fs-6 mb-2">
                                    <i class="bi bi-person-fill"></i>
                                    {{ $itinerary->user->name }}
                                </div>
                                <div class="badge bg-light fs-6 mb-2 text-dark">
                                    <i class="bi bi-eye"></i>
                                    @if($itinerary->visibility->value == 'public')
                                        @lang('itinerary.public')
                                    @else
                                        @lang('itinerary.private')
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-2 col-4">
                                <div class="badge bg-danger fs-6 mb-2 w-100">
                                    <i class="bi bi-heart-fill"></i>
                                    <span id="favourite{{ $itinerary->id }}">
                                        {{ $itinerary->favourites->count() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p class="text-center">@lang('itinerary.no_itinerary_to_show').</p>
    @endif
@endsection