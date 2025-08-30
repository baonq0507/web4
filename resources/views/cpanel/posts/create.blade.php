@extends('cpanel.layouts.app')
@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #007bff;
        border: 1px solid #006fe6;
        color: #fff;
        border-radius: 3px;
        padding: 2px 8px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff;
        margin-right: 5px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: #fff;
        background: rgba(255,255,255,0.2);
    }
    .select2-container {
        width: 100% !important;
    }
</style>
@endpush
@section('content')
<main id="main-container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('index.create_new_post') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('cpanel.posts.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> {{ __('index.back_to_list') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('cpanel.posts.store') }}" method="POST" enctype="multipart/form-data" id="post-form">
                        @csrf
                        <div class="form-group">
                            <label for="title">{{ __('index.title') }}</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">{{ __('index.content') }}</label>
                            <div id="content"></div>
                            <input type="hidden" name="content" id="content-input">
                            @error('content')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">{{ __('index.image') }}</label>
                            <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image">
                            @error('image')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">{{ __('index.status') }}</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>{{ __('index.published') }}</option>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>{{ __('index.draft') }}</option>
                            </select>
                            @error('status')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('index.send_notification') }}</label>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="notification_all" name="notification_type" value="all" class="custom-control-input" {{ old('notification_type') == 'all' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="notification_all">{{ __('index.send_to_all_users') }}</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="notification_selected" name="notification_type" value="selected" class="custom-control-input" {{ old('notification_type') == 'selected' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="notification_selected">{{ __('index.select_users') }}</label>
                            </div>
                        </div>

                        <div class="form-group selected-users" style="display: none;">
                            <label>{{ __('index.select_users') }}</label>
                            <select class="form-control select2" name="selected_users[]" multiple="multiple" data-placeholder="{{ __('index.select_users') }}">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ in_array($user->id, old('selected_users', [])) ? 'selected' : '' }}>
                                    {{ $user->id }}/{{ $user->name }} 
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<!-- jQuery first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Then Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Then Quill -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            theme: 'default',
            width: '100%',
            placeholder: 'Chọn người nhận...',
            allowClear: true,
            language: {
                noResults: function() {
                    return "Không tìm thấy kết quả";
                },
                searching: function() {
                    return "Đang tìm kiếm...";
                }
            }
        });

        // Show/hide selected users based on notification type
        $('input[name="notification_type"]').change(function() {
            if ($(this).val() === 'selected') {
                $('.selected-users').show();
            } else {
                $('.selected-users').hide();
            }
        });

        // Trigger change on page load
        $('input[name="notification_type"]:checked').trigger('change');
    });

    // Initialize Quill for content
    var quill = new Quill('#content', {
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

    // Update hidden input before form submission
    document.getElementById('post-form').addEventListener('submit', function() {
        document.getElementById('content-input').value = quill.root.innerHTML;
    });
</script>

@endpush