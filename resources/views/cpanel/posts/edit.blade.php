@extends('cpanel.layouts.app')
@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush
@section('content')
<main id="main-container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Post</h3>
                    <div class="card-tools">
                        <a href="{{ route('cpanel.posts.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('cpanel.posts.update', $post) }}" method="POST" enctype="multipart/form-data" id="post-form">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $post->title) }}" required>
                            @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">Content</label>
                            <div id="content"></div>
                            <input type="hidden" name="content" id="content-input">
                            @error('content')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            @if($post->image)
                            <div class="mb-2">
                                <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" style="max-width: 200px;">
                            </div>
                            @endif
                            <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image">
                            @error('image')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>{{ __('index.draft') }}</option>
                                <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>{{ __('index.published') }}</option>
                            </select>
                            @error('status')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
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

    // Set initial content
    quill.root.innerHTML = {!! json_encode($post->content) !!};

    // Update hidden input before form submission
    document.getElementById('post-form').addEventListener('submit', function() {
        document.getElementById('content-input').value = quill.root.innerHTML;
    });
</script>

@endpush