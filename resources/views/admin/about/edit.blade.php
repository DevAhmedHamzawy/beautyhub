@extends('admin.layouts.master')

@section('title')
    {{ trans('about.update_about') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">

            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">{{ trans('dashboard.dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ trans('about.update_about') }}</li>
                </ol>
            </nav>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-body">

                    <h4 class="mb-4">
                        {{ trans('about.update_about') }}
                    </h4>

                    <form action="{{ route('admin.about.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="bg-light p-4 rounded">

                            {{-- ================= MAIN TRANSLATIONS ================= --}}
                            @foreach (['ar', 'en'] as $locale)
                                <h5 class="mt-4">{{ strtoupper($locale) }}</h5>

                                {{-- TITLE --}}
                                <div class="form-group">
                                    <label>{{ trans("about.$locale.title") }}</label>

                                    <input type="text" name="translations[{{ $locale }}][title]"
                                        class="form-control @error("translations.$locale.title") is-invalid @enderror"
                                        value="{{ old("translations.$locale.title", optional($about->translate($locale))->title) }}">

                                    @error("translations.$locale.title")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- CONTENT --}}
                                <div class="form-group">
                                    <label>{{ trans("about.$locale.content") }}</label>

                                    <textarea name="translations[{{ $locale }}][content]"
                                        class="form-control textarea @error("translations.$locale.content") is-invalid @enderror" rows="6">{{ old("translations.$locale.content", optional($about->translate($locale))->content) }}</textarea>

                                    @error("translations.$locale.content")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach

                            <hr class="my-4">

                            {{-- ================= ABOUT LISTS ================= --}}
                            <h4 class="mb-3">{{ trans('about.list') }}</h4>

                            <div id="lists-wrapper">

                                @foreach ($about->lists as $list)
                                    <input type="hidden" name="lists[{{ $list->id }}][place]"
                                        value="{{ $list->place }}">
                                    <div class="list-item border p-3 mb-3" data-id="{{ $list->id }}">

                                        <div class="d-flex justify-content-between mb-2">
                                            <strong>{{ trans('about.' . $list->place) }}</strong>
                                            <button type="button" class="btn btn-sm btn-danger remove-list">X</button>
                                        </div>

                                        {{-- ICON --}}
                                        @if ($list->place == 'column')
                                            <div class="form-group">
                                                <label>Icon</label>
                                                <input type="text" name="lists[{{ $list->id }}][icon]"
                                                    class="form-control @error("lists.$list->id.icon") is-invalid @enderror"
                                                    value="{{ old("lists.$list->id.icon", $list->icon) }}">

                                                @error("lists.$list->id.icon")
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                                <small class="text-muted">مثال: fa-solid fa-star</small>
                                            </div>

                                            @foreach (['ar', 'en'] as $locale)
                                                <div class="form-group">
                                                    <label>{{ strtoupper($locale) }}
                                                        {{ trans("about.$locale.title") }}</label>

                                                    <input type="text"
                                                        name="lists[{{ $list->id }}][{{ $locale }}][title]"
                                                        class="form-control @error("lists.$list->id.$locale.title") is-invalid @enderror"
                                                        value="{{ old("lists.$list->id.$locale.title", optional($list->translate($locale))->title) }}">

                                                    @error("lists.$list->id.$locale.title")
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            @endforeach
                                        @endif

                                        {{-- CONTENT --}}
                                        @foreach (['ar', 'en'] as $locale)
                                            <div class="form-group">
                                                <label>{{ strtoupper($locale) }}
                                                    {{ trans("about.$locale.content") }}</label>

                                                <input type="text"
                                                    name="lists[{{ $list->id }}][{{ $locale }}][content]"
                                                    class="form-control @error("lists.$list->id.$locale.content") is-invalid @enderror"
                                                    value="{{ old("lists.$list->id.$locale.content", optional($list->translate($locale))->content) }}">

                                                @error("lists.$list->id.$locale.content")
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endforeach

                                    </div>
                                @endforeach

                            </div>

                            {{-- ADD BUTTON --}}
                            <button type="button" id="add-list" class="btn btn-outline-primary btn-sm">
                                + {{ trans('about.add_list') }}
                            </button>

                            <button type="button" id="add-column" class="btn btn-outline-success btn-sm">
                                + {{ trans('about.add_column') }}
                            </button>

                            <hr class="my-4">

                            <button class="btn btn-primary btn-block">
                                {{ trans('dashboard.edit') }}
                            </button>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const translations = {
            list: "{{ trans('about.list') }}",
            column: "{{ trans('about.column') }}",
            remove: "{{ trans('about.remove') }}"
        };

        let tempId = 1000;

        // GENERATOR FUNCTION
        function generateItem(type, label) {
            tempId++;


            // icon field يظهر بس لو column
            let iconField = '';
            if (type === 'column') {
                iconField = `


        <div class="form-group">
            <label>Icon</label>
            <input type="text" name="new_lists[${tempId}][icon]" class="form-control">
            <small class="text-muted">مثال: fa-solid fa-star</small>
        </div>

         <div class="form-group">
            <label>AR {{ trans('about.ar.title') }}</label>
            <input type="text" name="new_lists[${tempId}][ar][title]" class="form-control">
        </div>

        <div class="form-group">
            <label>EN {{ trans('about.en.title') }}</label>
            <input type="text" name="new_lists[${tempId}][en][title]" class="form-control">
        </div>


        `;


            }

            return `
    <div class="list-item border p-3 mb-3">
        <div class="d-flex justify-content-between mb-2">
            <strong>${type === 'column' ? translations.column : translations.list}</strong>
            <button type="button" class="btn btn-sm btn-danger remove-list">X</button>
        </div>

        ${iconField}

        <input type="hidden" name="new_lists[${tempId}][place]" value="${type}">



        <div class="form-group">
            <label>AR {{ trans('about.ar.content') }}</label>
            <input type="text" name="new_lists[${tempId}][ar][content]" class="form-control">
        </div>

        <div class="form-group">
            <label>EN {{ trans('about.en.content') }}</label>
            <input type="text" name="new_lists[${tempId}][en][content]" class="form-control">
        </div>


    </div>


    `;
        }


        // ADD LIST
        $('#add-list').click(function() {
            $('#lists-wrapper').append(generateItem('list', 'List'));
        });

        // ADD COLUMN
        $('#add-column').click(function() {
            $('#lists-wrapper').append(generateItem('column', 'Column'));
        });

        $(document).on('click', '.remove-list', function() {
            let item = $(this).closest('.list-item');

            let id = item.data('id');

            if (id) {
                item.append(`<input type="hidden" name="deleted_lists[]" value="${id}">`);
                item.hide();
            } else {
                item.remove();
            }
        });
    </script>
@endsection
