@extends('user.layouts.app')
@section('title', __('index.ky_quy'))
@section('css')
<link rel="stylesheet" href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css">
@endsection
@section('content')
<!-- Main Section -->
<main class="max-w-7xl mx-auto py-5 px-2 flex flex-col gap-12 mt-16" id="kyquy-page">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Deposit Form Card -->
        <section class="flex-1 min-w-0 bg-[#181a1d] rounded-2xl border border-[#232425] p-2 md:p-10 flex flex-col gap-10">
            <div class="flex flex-row justify-between items-center">
                <h1 class="text-2xl font-bold text-white">{{ __('index.ky_quy') }}</h1>
                <button class="cursor-pointer text-white px-4 py-2 rounded-md flex items-center gap-2" onclick="document.getElementById('historyModal').classList.remove('hidden')">
                    <i class="fa-solid fa-history"></i>
                    {{ __('index.invest_history') }}
                </button>
            </div>
            <div class="flex">
                <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
                    @foreach($kyQuies as $kyQuy)
                    <div class="bg-[#232425] rounded-lg px-2 py-4 md:px-4 w-full">
                        <div class="flex flex-row">
                            <img src="{{ asset('images/' . $kyQuy->image) }}" alt="{{ $kyQuy->name }}" class="w-50 h-50 object-cover rounded-lg mb-4 img-kyquy">
                            <div class="flex-1 ml-4">
                                <h3 class="text-xl md:text-xl text-cyan-500 mb-2" style="overflow: hidden;" title="{{ $kyQuy->name }}">
                                    @switch(app()->getLocale())
                                    @case('vi')
                                    {{ $kyQuy->name_vi }}
                                    @break
                                    @case('en')
                                    {{ $kyQuy->name_en }}
                                    @break
                                    @case('id')
                                    {{ $kyQuy->name_id }}
                                    @break
                                    @case('ja')
                                    {{ $kyQuy->name_ja }}
                                    @break
                                    @case('ko')
                                    {{ $kyQuy->name_ko }}
                                    @break
                                    @case('th')
                                    {{ $kyQuy->name_th }}
                                    @break
                                    @case('zh')
                                    {{ $kyQuy->name_zh }}
                                    @break
                                    @default
                                    {{ $kyQuy->name_vi }}
                                    @break
                                    @endswitch
                                </h3>
                                <div class="sm:hidden md:block">
                                    <h3 class="text-sm text-white mb-3" style="overflow: hidden;" title="{{ $kyQuy->description_vi }}">
                                        @switch(app()->getLocale())
                                        @case('vi')
                                        {!! Str::limit($kyQuy->description_vi, 250) !!}
                                        @break
                                        @case('en')
                                        {!! Str::limit($kyQuy->description_en, 200) !!}
                                        @break
                                        @case('id')
                                        {!! Str::limit($kyQuy->description_id, 200) !!}
                                        @break
                                        @case('ja')
                                        {!! Str::limit($kyQuy->description_ja, 200) !!}
                                        @break
                                        @case('ko')
                                        {!! Str::limit($kyQuy->description_ko, 200) !!}
                                        @break
                                        @case('th')
                                        {!! Str::limit($kyQuy->description_th, 200) !!}
                                        @break
                                        @case('zh')
                                        {!! Str::limit($kyQuy->description_zh, 200) !!}
                                        @break
                                        @default
                                        <span class="block md:block">{!! Str::limit($kyQuy->description_vi, 200) !!}</span>
                                        @endswitch
                                    </h3>
                                </div>
                                <div class="sm:block md:hidden">
                                    <h3 class="text-sm text-white mb-3" style="overflow: hidden;" title="{{ $kyQuy->description_vi }}">
                                        @switch(app()->getLocale())
                                        @case('vi')
                                        {!! Str::limit($kyQuy->description_vi, 150) !!}
                                        @break
                                        @case('en')
                                        {!! Str::limit($kyQuy->description_en, 150) !!}
                                        @break
                                        @case('id')
                                        {!! Str::limit($kyQuy->description_id, 150) !!}
                                        @break
                                        @case('ja')
                                        {!! Str::limit($kyQuy->description_ja, 150) !!}
                                        @break
                                        @case('ko')
                                        {!! Str::limit($kyQuy->description_ko, 150) !!}
                                        @break
                                        @case('th')
                                        {!! Str::limit($kyQuy->description_th, 150) !!}
                                        @break
                                        @case('zh')
                                        {!! Str::limit($kyQuy->description_zh, 150) !!}
                                        @break
                                        @default
                                        <span class="block md:block">{!! Str::limit($kyQuy->description_vi, 200) !!}</span>
                                        @endswitch
                                    </h3>
                                </div>

                                @if(auth()->check())
                                <button class="cursor-pointer bg-cyan-500 text-white px-4 py-2 rounded-md" onclick="document.getElementById('investModal-{{ $kyQuy->id }}').classList.remove('hidden')">
                                    {{__('index.open_now')}}
                                </button>
                                @endif
                            </div>
                        </div>
                        <!-- <hr class="my-4 border-white/20"> -->
                        <div class="flex items-center justify-between">

                            <!-- modal invest -->
                            <div id="investModal-{{ $kyQuy->id }}" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-opacity-50 backdrop-blur-sm transition-all duration-300">
                                <div class="bg-[#181a1d] rounded-lg shadow-lg w-[500px] overflow-auto">
                                    <div class="flex justify-between items-center p-4 border-b border-white/20">
                                        <h5 class="text-lg font-semibold text-white" id="investModalLabel">{{ __('index.open_now') }}</h5>
                                        <button type="button" class="cursor-pointer hover:text-white text-white/70" onclick="document.getElementById('investModal-{{ $kyQuy->id }}').classList.add('hidden')">
                                            <span class="sr-only">Close</span>
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <div class="p-4">
                                        <!-- hiển thị toàn bộ thong tin project sau đó thêm form input amount và button submit -->
                                        <div class="grid grid-cols-1 gap-4">
                                            <div>
                                                <h3 class="text-md text-white mb-2 border-b border-white/20 pb-2" title="{{ $kyQuy->name }}">
                                                    @switch(app()->getLocale())
                                                    @case('vi')
                                                    {{ $kyQuy->name_vi }}
                                                    @break
                                                    @case('en')
                                                    {{ $kyQuy->name_en }}
                                                    @break
                                                    @case('id')
                                                    {{ $kyQuy->name_id }}
                                                    @break
                                                    @case('ja')
                                                    {{ $kyQuy->name_ja }}
                                                    @break
                                                    @case('ko')
                                                    {{ $kyQuy->name_ko }}
                                                    @break
                                                    @case('th')
                                                    {{ $kyQuy->name_th }}
                                                    @break
                                                    @case('zh')
                                                    {{ $kyQuy->name_zh }}
                                                    @break
                                                    @default
                                                    {{ $kyQuy->name_vi }}
                                                    @break
                                                    @endswitch
                                                </h3>
                                            </div>
                                            <div>
                                                <h3 class="text-md text-white mb-2 border-b border-white/20 pb-2">
                                                    @switch(app()->getLocale())
                                                    @case('vi')
                                                    {!! $kyQuy->description_vi !!}
                                                    @break
                                                    @case('en')
                                                    {!! $kyQuy->description_en !!}
                                                    @break
                                                    @case('id')
                                                    {!! $kyQuy->description_id !!}
                                                    @break
                                                    @case('ja')
                                                    {!! $kyQuy->description_ja !!}
                                                    @break
                                                    @case('ko')
                                                    {!! $kyQuy->description_ko !!}
                                                    @break
                                                    @case('th')
                                                    {!! $kyQuy->description_th !!}
                                                    @break
                                                    @case('zh')
                                                    {!! $kyQuy->description_zh !!}
                                                    @break
                                                    @default
                                                    {!! $kyQuy->description_vi !!}
                                                    @break
                                                    @endswitch
                                                </h3>
                                            </div>

                                        </div>
                                        <div class="flex justify-end">
                                            <form action="{{ route('open-ky-quy') }}" method="post" class="w-full form-invest">
                                                @csrf
                                                <input type="hidden" name="ky_quy_id" value="{{ $kyQuy->id }}">
                                                <select name="time" class="mb-3 w-full border border-gray-600 text-white rounded-lg px-4 py-2 appearance-none bg-[#1e2124] z-100000">
                                                    @if($kyQuy->time)
                                                    <option value="" disabled selected>{{ __('index.select_time') }}</option>
                                                    @foreach($kyQuy->time as $time)
                                                    <option class="text-white whitespace-nowrap w-full max-w-full bg-[#1e2124]" value="{{ $time['duration'] . '-' . $time['unit'] . '-' . $time['value'] }}">{{ __('index.ky_han') }}: {{ $time['duration'] }} {{ __('index.' . $time['unit']) }} - {{__('index.profit')}} {{ $time['value'] }}%</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <input type="number" name="amount" placeholder="USDT" class=" mb-3 w-full bg-[#1e2124] border border-gray-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 transition-colors">

                                                <button type="submit" class="w-full cursor-pointer bg-cyan-500 text-white px-4 py-2 rounded-md">{{ __('index.open_now') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</main>

<!-- modal history -->
@if(auth()->check())
<div id="historyModal" class="fixed inset-0 z-30 flex mt-16 justify-center hidden bg-opacity-50 backdrop-blur-sm transition-all duration-300">
    <div class="bg-[#181a1d] rounded-lg shadow-lg md:max-w-[70%] md:max-h-[70%] overflow-y-auto w-[90%]">
        <div class="flex justify-between items-center p-4 border-b border-white/20">
            <h5 class="text-lg font-semibold text-white" id="historyModalLabel">{{ __('index.invest_history') }}</h5>
            <button type="button" class="cursor-pointer hover:text-white text-white/70" onclick="document.getElementById('historyModal').classList.add('hidden')">
                <span class="sr-only">Close</span>
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="p-4">
            <div class="hidden md:block">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-md font-medium text-white uppercase tracking-wider">{{ __('index.amount') }}</th>
                            <th class="px-4 py-2 text-left text-md font-medium text-white uppercase tracking-wider">{{ __('index.profit') }}</th>
                            <th class="px-4 py-2 text-left text-md font-medium text-white uppercase tracking-wider">{{ __('index.status') }}</th>
                            <th class="px-4 py-2 text-left text-md font-medium text-white uppercase tracking-wider">{{ __('index.type') }}</th>
                            <th class="px-4 py-2 text-left text-md font-medium text-white uppercase tracking-wider">{{ __('index.time_unit') }}</th>
                            <th class="px-4 py-2 text-left text-md font-medium text-white uppercase tracking-wider">{{ __('index.start_date') }}</th>
                            <th class="px-4 py-2 text-left text-md font-medium text-white uppercase tracking-wider">{{ __('index.end_date') }}</th>
                            <th class="px-4 py-2 text-left text-md font-medium text-white uppercase tracking-wider">{{ __('index.progress') }}</th>
                            <th class="px-4 py-2 text-left text-md font-medium text-white uppercase tracking-wider">{{ __('index.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kyQuyUsers as $kyQuyUser)
                        <tr>
                            <td class="px-4 py-2 text-left text-md font-medium text-white uppercase tracking-wider">{{ $kyQuyUser->balance }} USDT</td>
                            <td class="px-4 py-2 text-left text-md font-medium text-white uppercase tracking-wider">{{ $kyQuyUser->profit }} USDT</td>
                            <td class="px-4 py-2 text-left text-md font-medium {{ $kyQuyUser->status == 'pending' ? 'text-yellow-500' : ($kyQuyUser->status == 'approve' ? 'text-green-500' : ($kyQuyUser->status == 'cancel' ? 'text-red-500' : ($kyQuyUser->status == 'finish' ? 'text-green-500' : ($kyQuyUser->status == 'stop' ? 'text-red-500' : ($kyQuyUser->status == 'failed' ? 'text-red-500' : 'text-gray-500'))))) }} uppercase tracking-wider">
                                {{ $kyQuyUser->status == 'pending' ? __('index.pending') : ($kyQuyUser->status == 'approve' ? __('index.approve') : ($kyQuyUser->status == 'cancel' ? __('index.cancel') : ($kyQuyUser->status == 'finish' ? __('index.finish') : ($kyQuyUser->status == 'stop' ? __('index.stop') : ($kyQuyUser->status == 'failed' ? __('index.failed') : __('index.false')))))) }}
                            </td>
                            <td class="px-4 py-2 text-left text-md font-medium text-white uppercase tracking-wider">{{ $kyQuyUser->kyQuy->loai == 'co_dinh' ? __('index.co_dinh') : __('index.linh_hoat') }}</td>
                            <td class="px-4 py-2 text-left text-md font-medium text-white uppercase tracking-wider">{{ $kyQuyUser->value }} {{ $kyQuyUser->unit == 'mm' ? __('index.minute') : ($kyQuyUser->unit == 'd' ? __('index.day') : ($kyQuyUser->unit == 'm' ? __('index.month') : __('index.year'))) }}</td>
                            <td class="px-4 py-2 text-left text-md font-medium text-white uppercase tracking-wider">{{ $kyQuyUser->start_date }}</td>
                            <td class="px-4 py-2 text-left text-md font-medium text-white uppercase tracking-wider">{{ $kyQuyUser->end_date }}</td>
                            <td class="px-4 py-2 text-left text-md font-medium text-white uppercase tracking-wider">
                                @if($kyQuyUser->status == 'approve')
                                <div class="w-full h-2 bg-gray-200 rounded-full">
                                    <div data-start-time="{{ $kyQuyUser->approve_date }}" data-end-time="{{ $kyQuyUser->end_date }}" class="h-full bg-cyan-500 rounded-full progress-kyquy" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                @else
                                <span class="{{ $kyQuyUser->status == 'pending' ? 'bg-yellow-500 text-white' : ($kyQuyUser->status == 'approve' ? 'bg-green-500 text-white' : ($kyQuyUser->status == 'cancel' ? 'bg-red-500 text-white' : 'bg-gray-500 text-white')) }} px-2 py-1 rounded">
                                    {{ $kyQuyUser->status == 'pending' ? __('index.pending') : ($kyQuyUser->status == 'approve' ? __('index.approve') : ($kyQuyUser->status == 'cancel' ? __('index.cancel') : ($kyQuyUser->status == 'finish' ? __('index.finish') : ($kyQuyUser->status == 'stop' ? __('index.stop') : ($kyQuyUser->status == 'failed' ? __('index.failed') : __('index.false')))))) }}
                                </span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-left text-md font-medium text-white uppercase tracking-wider">
                                @if($kyQuyUser->status == 'approve')
                                <button class="bg-cyan-500 text-white px-4 py-2 rounded-md cskh">{{ __('index.final_settlement') }}</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="block md:hidden">
                @foreach($kyQuyUsers as $kyQuyUser)
                <div class="bg-[#232425] rounded-lg p-4 w-full mb-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-bold text-cyan-500 mb-2">
                            @switch(app()->getLocale())
                            @case('vi')
                            {{ $kyQuyUser->kyQuy->name_vi }}
                            @break
                            @case('en')
                            {{ $kyQuyUser->kyQuy->name_en }}
                            @break
                            @case('id')
                            {{ $kyQuyUser->kyQuy->name_id }}
                            @break
                            @case('ja')
                            {{ $kyQuyUser->kyQuy->name_ja }}
                            @break
                            @case('ko')
                            {{ $kyQuyUser->kyQuy->name_ko }}
                            @break
                            @case('th')
                            {{ $kyQuyUser->kyQuy->name_th }}
                            @break
                            @case('zh')
                            {{ $kyQuyUser->kyQuy->name_zh }}
                            @break
                            @default
                            {{ $kyQuyUser->kyQuy->name_vi }}
                            @break
                            @endswitch
                        </h3>
                        @if($kyQuyUser->status == 'approve')
                        <button class="bg-cyan-500 text-white px-4 py-2 rounded-md cskh">{{ __('index.final_settlement') }}</button>
                        @endif
                    </div>
                    <p class="text-md text-white">{{ __('index.amount') }}: {{ $kyQuyUser->balance }} USDT</p>
                    <p class="text-md  {{ $kyQuyUser->status == 'pending' ? 'text-yellow-500' : ($kyQuyUser->status == 'approve' ? 'text-green-500' : ($kyQuyUser->status == 'cancel' ? 'text-red-500' : ($kyQuyUser->status == 'finish' ? 'text-green-500' : ($kyQuyUser->status == 'stop' ? 'text-red-500' : ($kyQuyUser->status == 'failed' ? 'text-red-500' : 'text-gray-500'))))) }}">{{ __('index.status') }}: {{ $kyQuyUser->status == 'pending' ? __('index.pending') : ($kyQuyUser->status == 'approve' ? __('index.approve') : ($kyQuyUser->status == 'cancel' ? __('index.cancel') : ($kyQuyUser->status == 'finish' ? __('index.finish') : ($kyQuyUser->status == 'stop' ? __('index.stop') : ($kyQuyUser->status == 'failed' ? __('index.failed') : __('index.false')))))) }}</p>
                    <p class="text-md text-white">{{ __('index.type') }}: {{ $kyQuyUser->kyQuy->loai == 'co_dinh' ? __('index.co_dinh') : __('index.linh_hoat') }}</p>
                    <p class="text-md text-white">{{ __('index.time_unit') }}: {{ $kyQuyUser->value }} {{ $kyQuyUser->unit == 'd' ? __('index.day') : ($kyQuyUser->unit == 'm' ? __('index.month') : __('index.year')) }}</p>
                    <p class="text-md text-white">{{ __('index.profit') }}: {{ $kyQuyUser->profit }} USDT</p>
                    <p class="text-md text-white">{{ __('index.start_date') }}: {{ $kyQuyUser->start_date }}</p>
                    <p class="text-md text-white mb-2">{{ __('index.end_date') }}: {{ $kyQuyUser->end_date }}</p>
                    @if($kyQuyUser->status == 'approve')
                    <div class="w-full h-2 bg-gray-200 rounded-full">
                        <div data-start-time="{{ $kyQuyUser->approve_date }}" data-end-time="{{ $kyQuyUser->end_date }}" class="h-full bg-cyan-500 rounded-full progress-kyquy" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<script>
    $(document).ready(function() {
        $('.form-invest').submit(function(e) {
            e.preventDefault();
            const btn = $(this).find('button[type="submit"]');
            const kyQuyId = $(this).find('input[name="ky_quy_id"]').val();
            btn.prop('disabled', true);
            btn.html("<i class='fa-solid fa-spinner fa-spin'></i> {{ __('index.loading') }}");
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    console.log(response);
                    Toastify({
                        text: response.message,
                        duration: 3000,
                        gravity: "top",
                        style: {
                            background: "linear-gradient(to right, #3ddeea, #3ddeea)",
                        }
                    }).showToast();
                    //reload page
                    document.getElementById('investModal-' + kyQuyId).classList.add('hidden');
                    document.getElementById('historyModal').classList.remove('hidden');
                    reloadPage(['.balance-value', '#historyModal', '.ky-quy-users-page'], ['.balance-value', '#historyModal', '.ky-quy-users-page']);
                },
                error: function(response) {
                    console.log(response);
                    Toastify({
                        text: response.responseJSON.message,
                        duration: 3000,
                        gravity: "top",
                        style: {
                            background: "linear-gradient(to right, #3ddeea, #3ddeea)",
                        }
                    }).showToast();
                },
                complete: function(response) {
                    btn.prop('disabled', false);
                    btn.html("{{ __('index.invest') }}");
                }
            });
        });

        $('.btn-final-settlement').click(function() {
            const kyQuyId = $(this).data('ky-quy-id');
            $(this).prop('disabled', true);
            $(this).html("<i class='fa-solid fa-spinner fa-spin'></i> {{ __('index.loading') }}");
            $.ajax({
                url: "{{ route('final-settlement') }}",
                type: 'POST',
                data: {
                    ky_quy_user_id: kyQuyId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    Toastify({
                        text: response.message,
                        duration: 3000,
                        gravity: "top",
                        style: {
                            background: "linear-gradient(to right, #3ddeea, #3ddeea)",
                        }
                    }).showToast();
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                },
                error: function(response) {
                    Toastify({
                        text: response.responseJSON.message,
                        duration: 3000,
                        gravity: "top",
                        style: {
                            background: "linear-gradient(to right, #ff0000, #ff0000)", // màu đỏ
                        }
                    }).showToast();
                },
                complete: function(response) {
                    $(this).prop('disabled', false);
                    $(this).html("{{ __('index.confirm') }}");
                }
            });
        });

        setInterval(function() {
            $('.progress-kyquy').each(function() {
                let start_time = new Date($(this).data('start-time'));
                let end_time = new Date($(this).data('end-time'));
                let now = new Date();
                let total_duration = Math.ceil((end_time - start_time) / (1000 * 60 * 60 * 24)); // Tính tổng thời gian theo ngày
                let elapsed_time = Math.ceil((now - start_time) / (1000 * 60 * 60 * 24)); // Tính thời gian đã trôi qua theo ngày
                let progress = (elapsed_time / total_duration) * 100;
                if (!isFinite(progress) || progress < 0) {
                    progress = 0;
                } else if (progress > 100) {
                    progress = 100;
                }
                console.log(progress);
                $(this).css('width', progress + '%');

                // Thay đổi màu sắc dựa trên tiến độ
                if (progress < 50) {
                    $(this).css('background-color', 'red');
                } else if (progress < 75) {
                    $(this).css('background-color', 'yellow');
                } else {
                    $(this).css('background-color', 'green');
                }
            });
        }, 1000); // Cập nhật mỗi giây
    });
</script>
@endsection