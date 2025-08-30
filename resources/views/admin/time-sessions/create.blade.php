@extends('cpanel.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('index.create_time_session') }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('cpanel.time-sessions.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="time">{{ __('index.time') }}</label>
                            <input type="number" class="form-control @error('time') is-invalid @enderror" 
                                id="time" name="time" value="{{ old('time') }}" required>
                            @error('time')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="unit">{{ __('index.unit') }}</label>
                            <select class="form-control @error('unit') is-invalid @enderror" id="unit" name="unit" required>
                                <option value="">{{ __('index.select_unit') }}</option>
                                <option value="m" {{ old('unit') == 'm' ? 'selected' : '' }}>{{ __('index.minutes') }}</option>
                                <option value="h" {{ old('unit') == 'h' ? 'selected' : '' }}>{{ __('index.hours') }}</option>
                                <option value="d" {{ old('unit') == 'd' ? 'selected' : '' }}>{{ __('index.days') }}</option>
                            </select>
                            @error('unit')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="win_rate">{{ __('index.win_rate') }}</label>
                            <input type="number" class="form-control @error('win_rate') is-invalid @enderror" 
                                id="win_rate" name="win_rate" value="{{ old('win_rate') }}" min="0" max="100" required>
                            @error('win_rate')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="lose_rate">{{ __('index.lose_rate') }}</label>
                            <input type="number" class="form-control @error('lose_rate') is-invalid @enderror" 
                                id="lose_rate" name="lose_rate" value="{{ old('lose_rate') }}" min="0" max="100" required>
                            @error('lose_rate')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">{{ __('index.status') }}</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>{{ __('index.active') }}</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>{{ __('index.inactive') }}</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ __('index.create') }}</button>
                            <a href="{{ route('cpanel.time-sessions.index') }}" class="btn btn-secondary">{{ __('index.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 