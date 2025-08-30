@extends('cpanel.layouts.app')
@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

@endpush
@section('content')
<main id="main-container">
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('index.edit_project') }}</h1>
            </div>
        </div>
        <div class="content">
            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <form action="{{ route('cpanel.projects.update', $project->id) }}" method="post" id="form-project" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ __('index.name') }}</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('index.name') }}" required value="{{ $project->name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">{{ __('index.amount_project') }}</label>
                                    <input type="text" class="form-control" id="amount" name="amount" placeholder="{{ __('index.amount_project') }}" value="{{ $project->amount }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="progress">{{ __('index.project_progress') }}</label>
                                    <input type="text" class="form-control" min="0" max="100" id="progress" name="progress" placeholder="{{ __('index.project_progress') }}" value="{{ $project->progress }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="min_invest">{{ __('index.min_invest') }}</label>
                                    <input type="text" class="form-control" id="min_invest" name="min_invest" placeholder="{{ __('index.min_invest') }}" value="{{ $project->min_invest }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="max_invest">{{ __('index.max_invest') }}</label>
                                    <input type="text" class="form-control" id="max_invest" name="max_invest" placeholder="{{ __('index.max_invest') }}" value="{{ $project->max_invest }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="interval">{{ __('index.interval') }}</label>
                                    <!-- <input type="text" class="form-control" id="interval" name="interval" placeholder="{{ __('index.interval') }}"> -->
                                    <select class="form-control" id="interval" name="interval" required>
                                        <option value="m" {{ $project->interval == 'm' ? 'selected' : '' }}>{{ __('index.minute') }}</option>
                                        <option value="h" {{ $project->interval == 'h' ? 'selected' : '' }}>{{ __('index.hour') }}</option>
                                        <option value="d" {{ $project->interval == 'd' ? 'selected' : '' }}>{{ __('index.day') }}</option>
                                        <option value="w" {{ $project->interval == 'w' ? 'selected' : '' }}>{{ __('index.week') }}</option>
                                        <option value="mo" {{ $project->interval == 'mo' ? 'selected' : '' }}>{{ __('index.month') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_period">{{ __('index.total_period') }}</label>
                                    <input type="text" class="form-control" id="total_period" name="total_period" placeholder="{{ __('index.total_period') }}" required value="{{ $project->total_period }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="profit">{{ __('index.profit') }}</label>
                                    <input type="text" class="form-control" id="profit" name="profit" required value="{{ $project->profit }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payback">{{ __('index.payback') }}</label>
                                    <!-- <input type="text" class="form-control" id="payback" name="payback"> -->
                                    <select class="form-control" id="payback" name="payback">
                                        <option value="1" {{ $project->payback == 1 ? 'selected' : '' }}>{{ __('index.yes') }}</option>
                                        <option value="0" {{ $project->payback == 0 ? 'selected' : '' }}>{{ __('index.no') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">{{ __('index.description_vi') }}</label>
                                    <div id="descriptionVi">{!! $project->description_vi !!}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">{{ __('index.description_en') }}</label>
                                    <div id="descriptionEn">{!! $project->description_en !!}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">{{ __('index.description_de') }}</label>
                                    <div id="descriptionDe">{!! $project->description_de !!}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">{{ __('index.description_id') }}</label>
                                    <div id="descriptionId">{!! $project->description_id !!}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">{{ __('index.description_ja') }}</label>
                                    <div id="descriptionJa">{!! $project->description_ja !!}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">{{ __('index.description_ko') }}</label>
                                    <div id="descriptionKo">{!! $project->description_ko !!}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">{{ __('index.description_zh') }}</label>
                                    <div id="descriptionZh">{!! $project->description_zh !!}</div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="image">{{ __('index.image') }}</label>
                                    <input type="file" class="form-control" id="image" name="image" onchange="previewImage(this)">
                                    <div class="mt-2">
                                        <img id="imagePreview" src="{{ asset($project->image) }}" alt="Preview" style="max-width: 200px; display: block;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">{{ __('index.status') }}</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="active" {{ $project->status == 'active' ? 'selected' : '' }}>{{ __('index.active') }}</option>
                                        <option value="inactive" {{ $project->status == 'inactive' ? 'selected' : '' }}>{{ __('index.inactive') }}</option>
                                        <option value="stop" {{ $project->status == 'stop' ? 'selected' : '' }}>{{ __('index.stop') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    function previewImage(input) {
                        const preview = document.getElementById('imagePreview');
                        if (input.files && input.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                preview.src = e.target.result;
                                preview.style.display = 'block';
                            }
                            reader.readAsDataURL(input.files[0]);
                        } else {
                            preview.src = '#';
                            preview.style.display = 'none';
                        }
                    }
                </script>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary w-100">{{ __('index.update') }}</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</main>
@endsection
@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    const quilds = ['descriptionVi', 'descriptionEn', 'descriptionDe', 'descriptionId', 'descriptionJa', 'descriptionKo', 'descriptionZh'];
    quilds.forEach(function(quild) {
        var quill = new Quill('#' + quild, {
            theme: 'snow',
            modules: {
                toolbar: {
                    container: [
                        [{
                            'header': [1, 2, 3, 4, 5, 6, false]
                        }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{
                            'color': []
                        }, {
                            'background': []
                        }],
                        [{
                            'align': []
                        }],
                        ['link', 'image'],
                        ['clean']
                    ],
                    handlers: {
                        image: function() {
                            var input = document.createElement('input');
                            input.setAttribute('type', 'file');
                            input.setAttribute('accept', 'image/*');
                            input.click();

                            input.onchange = function() {
                                var file = input.files[0];
                                if (file) {
                                    var formData = new FormData();
                                    formData.append('file', file);

                                    // Upload image to server
                                    fetch("{{ route('upload') }}", {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                            },
                                            body: formData
                                        })
                                        .then(response => response.json())
                                        .then(result => {
                                            // Insert image into editor
                                            console.log(result.url);
                                            const range = quill.getSelection(true); // true = force focus
                                            if (range) {
                                                quill.insertEmbed(range.index, 'image', result.url);
                                            } else {
                                                quill.insertEmbed(0, 'image', result.url);
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error uploading image:', error);
                                        });
                                }
                            };
                        }
                    }
                }
            }
        });
    });

    function getContent(quillId) {
        const quillEditor = Quill.find(document.getElementById(quillId));
        return quillEditor.root.innerHTML;
    }

    $('#form-project').submit(function(e) {
        e.preventDefault();
        var formData1 = new FormData(this);
        formData1.append('description_vi', getContent('descriptionVi'));
        formData1.append('description_en', getContent('descriptionEn')); 
        formData1.append('description_de', getContent('descriptionDe'));
        formData1.append('description_id', getContent('descriptionId'));
        formData1.append('description_ja', getContent('descriptionJa'));
        formData1.append('description_ko', getContent('descriptionKo'));
        formData1.append('description_zh', getContent('descriptionZh'));
        const file = $('#image')[0].files[0];
        if (file) {
            formData1.append('image', file);
        }
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            processData: false,
            contentType: false,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data: formData1,
            success: function(response) {
                Swal.fire({
                    title: 'Thành công', 
                    text: response.message,
                    icon: 'success'
                }).then(function() {
                    window.location.reload();
                });
            },
            error: function(response) {
                Swal.fire({
                    title: 'Lỗi',
                    text: response.responseJSON.message,
                    icon: 'error'
                });
            }
        });
    });
</script>

@endpush