@extends('layouts.master')

@section('title')
    @lang('nav.itinerary')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">@lang('nav.home')</li>
    @if (auth()->check() && auth()->user()->can('owns', $itinerary))
        <li class="breadcrumb-item">@lang('nav.manage_itineraries')</li>
        <li class="breadcrumb-item">@lang('nav.my_itineraries')</li>
    @else
        <li class="breadcrumb-item">@lang('nav.itineraries')</li>
    @endif
    <li class="breadcrumb-item active">{{ $itinerary->city->name }}</li>
@endsection

@section('scripts')
    @if(auth()->check() && auth()->user()->cannot('owns', $itinerary))
        <script>
            $(document).ready(function () {
                function handleRemoveSaved(buttonElement) {
                    $.ajax({
                        url: '{{ route('favourites.remove') }}',
                        method: 'DELETE',
                        data: {
                            itinerary_id: {{ $itinerary->id }},
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (data) {
                            if (data.deleted === true) {
                                buttonElement.html(`<i class="bi bi-bookmark"></i> Salva`);
                                buttonElement.removeClass('btn-secondary saved');
                                buttonElement.addClass('btn-outline-secondary toSave');
                                buttonElement.off('click');
                                buttonElement.on('click', function () {
                                    handleAddSaved($(this));
                                });

                                favourite = $(`#favouriteNumber`);
                                favourite_number = favourite_number = parseInt(favourite.text(), 10);
                                favourite.text(favourite_number - 1)

                            }
                        }
                    });
                }

                function handleAddSaved(buttonElement) {
                    const itinerary_id = buttonElement.attr('itineraryid');

                    $.ajax({
                        url: '{{ route('favourites.add') }}',
                        method: 'POST',
                        data: {
                            itinerary_id: {{ $itinerary->id }},
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (data) {
                            if (data.created === true) {
                                buttonElement.html(`<i class="bi bi-check-lg"></i> Salvato`);
                                buttonElement.removeClass('btn-outline-secondary toSave');
                                buttonElement.addClass('btn-secondary saved');

                                buttonElement.off('click');
                                buttonElement.on('click', function () {
                                    handleRemoveSaved($(this));
                                });

                                favourite = $(`#favouriteNumber`);
                                favourite_number = parseInt(favourite.text(), 10);
                                favourite.text(favourite_number + 1)

                            }
                        }
                    });
                }

                $('.toSave').on('click', function (e) {
                    handleAddSaved($(this), '{{ route('favourites.add') }}');
                });

                $('.saved').on('click', function (e) {
                    handleRemoveSaved($(this));
                });
            });

        </script>
    @endif
@endsection

@section('body')
    <div class="row g-4 mb-2">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card" style="height:100%">
                <div class="card-body">
                    <h3 class="card-title">{{ $itinerary->title }}</h3>
                    <p>{{$itinerary->city->name}}</p>
                    <p>@lang('itinerary.total_price'): {{ number_format($itinerary->stages->sum('cost'), 2, ',', '.') }} €</p>
                    <p>@lang('itinerary.stages'): {{ $itinerary->stages->count() }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card" style="height:100%">
                <div class="card-body">
                    <h5 class="mb-3">@lang('itinerary.itinerary_detail')</h5>
                    <p><strong>@lang('itinerary.favourites'):</strong> <span
                            id="favouriteNumber">{{ $itinerary->favourites->count()}}</span>
                        <i class="text-danger bi bi-heart-fill"></i>
                    </p>
                    <p><strong>@lang('itinerary.created_by'):</strong> {{ $itinerary->user->name}}</p>
                    <p><strong>@lang('itinerary.visibility'):</strong>
                        @if($itinerary->visibility->value == 'public')
                            @lang('itinerary.public')
                        @else
                            @lang('itinerary.private')
                        @endif
                    </p>

                    <!-- bottoni -->
                    @if (auth()->check())
                        <hr>
                        </hr>
                        @if (auth()->user()->id == $itinerary->user->id)
                            <a href="{{ route('itinerary.edit', ['itinerary' => $itinerary->id]) }}"
                                class="btn btn-primary w-100 mb-2"><i class="bi bi-pencil"></i> @lang('itinerary.edit')</a>
                            <a href="{{ route('itinerary.destroy.confirm', ['itinerary' => $itinerary]) }}"
                                class="btn btn-danger w-100 mb-2"><i class="bi bi-trash"></i> @lang('itinerary.delete')</a>
                        @else
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
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- tappe -->
    <div class="row">
        @if (count($itinerary->stages) > 0)
            <h4>@lang('itinerary.stages')</h4>
            <div class="accordion" id="stagesAccordion">
                @foreach ($itinerary->stages as $stage)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $stage->id }}" aria-expanded="false"
                                aria-controls="collapse{{ $stage->id }}">
                                {{$stage->location}}
                            </button>
                        </h2>
                        <div id="collapse{{ $stage->id }}" class="accordion-collapse collapse" data-bs-parent="#stagesAccordion">
                            <div class="accordion-body">
                                <p><strong>@lang('itinerary.description')</strong><br>
                                    {{ $stage->description }}</p>
                                <p><strong>@lang('itinerary.price')</strong>: {{ $stage->cost }} €</p>
                                <p><strong>@lang('itinerary.duration')</strong>: {{ $stage->duration }} @lang('itinerary.minutes')</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection