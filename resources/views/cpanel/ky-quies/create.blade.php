@extends('cpanel.layouts.app')
@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush
@section('content')
<main id="main-container" class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('index.create_new_ky_quy') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('cpanel.ky-quies.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> {{ __('index.back_to_list') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('cpanel.ky-quies.store') }}" method="POST" enctype="multipart/form-data" id="ky-quy-form">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name_vi">{{ __('index.name_vi') }}</label>
                                <input type="text" class="form-control @error('name_vi') is-invalid @enderror" id="name_vi" name="name_vi" value="{{ old('name_vi') }}">
                                @error('name_vi')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name_en">{{ __('index.name_en') }}</label>
                                <input type="text" class="form-control @error('name_en') is-invalid @enderror" id="name_en" name="name_en" value="{{ old('name_en') }}">
                                @error('name_en')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name_de">{{ __('index.name_de') }}</label>
                                <input type="text" class="form-control @error('name_de') is-invalid @enderror" id="name_de" name="name_de" value="{{ old('name_de') }}">
                                @error('name_de')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name_id">{{ __('index.name_id') }}</label>
                                <input type="text" class="form-control @error('name_id') is-invalid @enderror" id="name_id" name="name_id" value="{{ old('name_id') }}">
                                @error('name_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name_ja">{{ __('index.name_ja') }}</label>
                                <input type="text" class="form-control @error('name_ja') is-invalid @enderror" id="name_ja" name="name_ja" value="{{ old('name_ja') }}">
                                @error('name_ja')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name_ko">{{ __('index.name_ko') }}</label>
                                <input type="text" class="form-control @error('name_ko') is-invalid @enderror" id="name_ko" name="name_ko" value="{{ old('name_ko') }}">
                                @error('name_ko')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name_th">{{ __('index.name_th') }}</label>
                                <input type="text" class="form-control @error('name_th') is-invalid @enderror" id="name_th" name="name_th" value="{{ old('name_th') }}">
                                @error('name_th')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name_zh">{{ __('index.name_zh') }}</label>
                                <input type="text" class="form-control @error('name_zh') is-invalid @enderror" id="name_zh" name="name_zh" value="{{ old('name_zh') }}">
                                @error('name_zh')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description_vi">{{ __('index.description_vi') }}</label>
                            <div id="description_vi"></div>
                            <input type="hidden" name="description_vi" id="description_vi-input">
                            @error('description_vi')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description_en">{{ __('index.description_en') }}</label>
                            <div id="description_en"></div>
                            <input type="hidden" name="description_en" id="description_en-input">
                            @error('description_en')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description_de">{{ __('index.description_de') }}</label>
                            <div id="description_de"></div>
                            <input type="hidden" name="description_de" id="description_de-input">
                            @error('description_de')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description_id">{{ __('index.description_id') }}</label>
                            <div id="description_id"></div>
                            <input type="hidden" name="description_id" id="description_id-input">
                            @error('description_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description_ja">{{ __('index.description_ja') }}</label>
                            <div id="description_ja"></div>
                            <input type="hidden" name="description_ja" id="description_ja-input">
                            @error('description_ja')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description_ko">{{ __('index.description_ko') }}</label>
                            <div id="description_ko"></div>
                            <input type="hidden" name="description_ko" id="description_ko-input">
                            @error('description_ko')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description_th">{{ __('index.description_th') }}</label>
                            <div id="description_th"></div>
                            <input type="hidden" name="description_th" id="description_th-input">
                            @error('description_th')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description_zh">{{ __('index.description_zh') }}</label>
                            <div id="description_zh"></div>
                            <input type="hidden" name="description_zh" id="description_zh-input">
                            @error('description_zh')
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
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="status">{{ __('index.status') }}</label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="show" {{ old('status') == 'show' ? 'selected' : '' }}>{{ __('index.show') }}</option>
                                    <option value="hide" {{ old('status') == 'hide' ? 'selected' : '' }}>{{ __('index.hide') }}</option>
                                </select>
                                @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="loai">{{ __('index.type') }}</label>
                                <select class="form-control @error('loai') is-invalid @enderror" id="loai" name="loai" required>
                                    <option value="co_dinh" {{ old('loai') == 'co_dinh' ? 'selected' : '' }}>{{ __('index.co_dinh') }}</option>
                                    <option value="linh_hoat" {{ old('loai') == 'linh_hoat' ? 'selected' : '' }}>{{ __('index.linh_hoat') }}</option>
                                </select>
                                @error('loai')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="min_balance">{{ __('index.min_balance') }}</label>
                                <input type="number" class="form-control @error('min_balance') is-invalid @enderror" id="min_balance" name="min_balance" value="{{ old('min_balance') }}">
                                @error('min_balance')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div id="time-container">
                                <div class="row align-items-center time-row">
                                    <div class="col-md-3 mb-2">
                                        <label for="time">{{ __('index.time') }}</label>
                                        <input type="text" class="form-control" name="time[0][duration]" placeholder="6">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="unit">{{ __('index.unit') }}</label>
                                        <select class="form-control" name="time[0][unit]" required>
                                            <option value="mm">{{ __('index.minute') }}</option>
                                            <option value="d">{{ __('index.day') }}</option>
                                            <option value="m">{{ __('index.month') }}</option>
                                            <option value="y">{{ __('index.year') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label for="value">{{ __('index.value') }}</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="time[0][value]" placeholder="10" min="0" max="100">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <div class="input-group-append mt-4">
                                            <button class="btn btn-outline-secondary add-time" type="button"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary">{{ __('index.create_ky_quy') }}</button>
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
        // Initialize Quill for description
        function initQuill(selector) {
            return new Quill(selector, {
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
                                let input = document.createElement('input');
                                input.type = 'file';
                                input.accept = 'image/*';
                                input.click();
                                input.onchange = () => {
                                    let file = input.files[0];
                                    if (file) {
                                        let formData = new FormData();
                                        formData.append('file', file);
                                        fetch("{{ route('upload') }}", {
                                                method: 'POST',
                                                headers: {
                                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                                },
                                                body: formData
                                            })
                                            .then(res => res.json())
                                            .then(result => {
                                                let range = quill.getSelection(true);
                                                quill.insertEmbed(range ? range.index : 0, 'image', result.url);
                                            })
                                            .catch(err => console.error('Error uploading image:', err));
                                    }
                                };
                            }
                        }
                    }
                }
            });
        }

        var quill_vi = initQuill('#description_vi');
        var quill_en = initQuill('#description_en');
        var quill_de = initQuill('#description_de');
        var quill_id = initQuill('#description_id');
        var quill_ja = initQuill('#description_ja');
        var quill_ko = initQuill('#description_ko');
        var quill_th = initQuill('#description_th');
        var quill_zh = initQuill('#description_zh');

        // Update hidden input before form submission
        document.getElementById('ky-quy-form').addEventListener('submit', function() {
            document.getElementById('description_vi-input').value = quill_vi.root.innerHTML;
            document.getElementById('description_en-input').value = quill_en.root.innerHTML;
            document.getElementById('description_de-input').value = quill_de.root.innerHTML;
            document.getElementById('description_id-input').value = quill_id.root.innerHTML;
            document.getElementById('description_ja-input').value = quill_ja.root.innerHTML;
            document.getElementById('description_ko-input').value = quill_ko.root.innerHTML;
            document.getElementById('description_th-input').value = quill_th.root.innerHTML;
            document.getElementById('description_zh-input').value = quill_zh.root.innerHTML;
        });
        let timeIndex = 1; // Bắt đầu từ 1 vì phần tử đầu đã là [0]

        // Add new time input fields
        $(document).on('click', '.add-time', function() {
            const newTimeInput = `
            <div class="row time-row">
                <div class="col-md-3 mb-2">
                    <label for="time">{{ __('index.time') }}</label>
                    <input type="text" class="form-control" name="time[${timeIndex}][duration]" placeholder="6">
                </div>
                <div class="col-md-3 mb-2">
                    <label for="unit">{{ __('index.unit') }}</label>
                    <select class="form-control" name="time[${timeIndex}][unit]" required>
                        <option value="mm">{{ __('index.minute') }}</option>
                        <option value="d">{{ __('index.day') }}</option>
                        <option value="m">{{ __('index.month') }}</option>
                        <option value="y">{{ __('index.year') }}</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <label for="value">{{ __('index.value') }}</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="time[${timeIndex}][value]" placeholder="10" min="0" max="100">
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <div class="input-group-append mt-4">
                        <button class="btn btn-outline-secondary remove-time" type="button"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
        `;
            $('#time-container').append(newTimeInput);
            timeIndex++;
        });


        // Remove time input fields
        $(document).on('click', '.remove-time', function() {
            $(this).closest('.row').remove();
        });
    });
</script>

@endpush