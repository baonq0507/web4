@extends('user.layouts.app')
@section('title', __('index.deposit'))
@section('css')
<link rel="stylesheet" href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css">
@endsection
@section('content')
<!-- Main Section -->
<main class="max-w-7xl mx-auto py-5 px-2 flex flex-col gap-12 mt-16">
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Deposit Form Card -->
        <section class="flex-1 min-w-0 bg-[#181a1d] rounded-2xl border border-[#232425] p-10 flex flex-col gap-10">
            <div class="flex flex-row justify-between items-center">
                <h1 class="text-2xl font-bold text-white">{{ __('index.projects') }}</h1>
                <button class="cursor-pointer text-white px-4 py-2 rounded-md flex items-center gap-2" onclick="document.getElementById('historyModal').classList.remove('hidden')">
                    <i class="fa-solid fa-history"></i>
                    {{ __('index.invest_history') }}
                </button>
            </div>
            <div class="flex justify-between items-center">
                <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($projects as $project)
                    <div class="bg-[#232425] rounded-lg p-4 w-full">
                        <div class="flex justify-between items-center md:flex-row flex-col">
                            <img src="{{ $project->image }}" alt="{{ $project->name }}" class="w-40 h-40 object-cover rounded-lg mb-4">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-sort-amount-up-alt text-red-500 text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-red-500 mt-2 font-bold text-2xl">
                                    {{rand(1, 100)}}%
                                </p>
                            </div>
                        </div>
                        <h3 class="text-sm font-bold text-white mb-2">{{__('index.project_id')}}: {{ $project->id }}</h3>
                        <h3 class="text-sm font-bold text-white mb-2" title="{{ $project->name }}">
                            <i class="fa-solid fa-project-diagram"></i>
                            {{__('index.project_name')}}: {{ Str::limit($project->name, 20) }}
                        </h3>
                        <h3 class="text-sm font-bold text-white mb-2">
                            <i class="fa-solid fa-money-bill"></i>
                            {{__('index.amount_project')}}: {{ number_format($project->amount, 0, ',', '.') }}
                        </h3>
                        <h3 class="text-sm font-bold text-white mb-2">
                            <i class="fa-solid fa-calendar-days"></i>
                            {{__('index.total_period')}}: {{ $project->total_period }}
                        </h3>
                        <h3 class="text-sm font-bold text-white mb-2">
                            <i class="fa-solid fa-money-bill"></i>
                            {{__('index.min_invest')}}: {{ number_format($project->min_invest, 0, ',', '.') }}
                        </h3>
                        <h3 class="text-sm font-bold text-white mb-2">
                            <i class="fa-solid fa-money-bill"></i>
                            {{__('index.max_invest')}}: {{ number_format($project->max_invest, 0, ',', '.') }}
                        </h3>
                        <h3 class="text-sm font-bold text-white mb-2">
                            <i class="fa-solid fa-calendar-days"></i>
                            {{__('index.interval')}}: {{ $project->interval == 'day' ? __('index.day') : ($project->interval == 'week' ? __('index.week') : ($project->interval == 'month' ? __('index.month') : __('index.year'))) }}
                        </h3>
                        <!-- <p class="text-sm text-white/70 mb-2">
                            @switch(app()->getLocale())
                            @case('vi')
                            {!! $project->description_vi !!}
                            @break
                            @case('en')
                            {!! $project->description_en !!}
                            @break
                            @case('id')
                            {!! $project->description_id !!}
                            @break
                            @case('ja')
                            {!! $project->description_ja !!}
                            @break
                            @case('ko')
                            {!! $project->description_ko !!}
                            @break
                            @case('th')
                            {!! $project->description_th !!}
                            @break
                            @case('zh')
                            {!! $project->description_zh !!}
                            @break
                            @default
                            {!! $project->description_vi !!}
                            @break
                            @endswitch
                        </p> -->
                        <!-- //thêm footer và button đàu tư -->
                        <hr class="my-4 border-white/20">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-white/70 mb-2">
                                {{__('index.project_progress')}}: {{$project->progress }}%
                            </p>
                            @if(auth()->check())
                            <button class="cursor-pointer bg-cyan-500 text-white px-4 py-2 rounded-md" onclick="document.getElementById('investModal-{{ $project->id }}').classList.remove('hidden')">
                                {{__('index.invest')}}
                            </button>
                            @endif
                            <!-- modal invest -->
                            <div id="investModal-{{ $project->id }}" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-opacity-50 backdrop-blur-sm transition-all duration-300">
                                <div class="bg-[#181a1d] rounded-lg shadow-lg w-[500px] overflow-auto">
                                    <div class="flex justify-between items-center p-4 border-b border-white/20">
                                        <h5 class="text-lg font-semibold text-white" id="investModalLabel">{{ __('index.invest') }}</h5>
                                        <button type="button" class="cursor-pointer hover:text-white text-white/70" onclick="document.getElementById('investModal-{{ $project->id }}').classList.add('hidden')">
                                            <span class="sr-only">Close</span>
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                    <div class="p-4">
                                        <!-- hiển thị toàn bộ thong tin project sau đó thêm form input amount và button submit -->
                                        <div class="grid grid-cols-1 gap-4">
                                            <div>
                                                <h3 class="text-sm font-bold text-white mb-2 border-b border-white/20 pb-2">{{__('index.project_id')}}: {{ $project->id }}</h3>
                                                <h3 class="text-sm font-bold text-white mb-2 border-b border-white/20 pb-2" title="{{ $project->name }}">
                                                    {{__('index.project_name')}}: {{ Str::limit($project->name, 20) }}
                                                </h3>
                                                
                                                <h3 class="text-sm font-bold text-white mb-2 border-b border-white/20 pb-2">
                                                    {{__('index.amount_project')}}: {{ number_format($project->amount, 0, ',', '.') }}
                                                </h3>
                                                <h3 class="text-sm font-bold text-white mb-2 border-b border-white/20 pb-2">
                                                    {{__('index.min_invest')}}: {{ number_format($project->min_invest, 0, ',', '.') }}
                                                </h3>
                                                <h3 class="text-sm font-bold text-white mb-2 border-b border-white/20 pb-2">
                                                    {{__('index.max_invest')}}: {{ number_format($project->max_invest, 0, ',', '.') }}
                                                </h3>
                                            </div>
                                            <div>
                                                <h3 class="text-sm font-bold text-white mb-2 border-b border-white/20 pb-2">
                                                    {{__('index.interval')}}: {{ $project->interval == 'day' ? __('index.day') : ($project->interval == 'week' ? __('index.week') : ($project->interval == 'month' ? __('index.month') : __('index.year'))) }}
                                                </h3>
                                                <h3 class="text-sm font-bold text-white mb-2 border-b border-white/20 pb-2">
                                                    {{__('index.total_period')}}: {{ $project->total_period }}
                                                </h3>
                                                <h3 class="text-sm font-bold text-white mb-2 border-b border-white/20 pb-2">
                                                    {{__('index.profit')}}: {{ $project->profit }}%
                                                </h3>
                                                <h3 class="text-sm font-bold text-white mb-2 border-b border-white/20 pb-2">
                                                    {{__('index.payback')}}: {{ $project->payback == 1 ? __('index.yes') : __('index.no') }}
                                                </h3>
                                                <h3 class="text-sm font-bold text-white mb-2 border-b border-white/20 pb-2">
                                                    {{__('index.project_description')}}:
                                                    <br>
                                                    @switch(app()->getLocale())
                                                    @case('vi')
                                                    {!! $project->description_vi !!}
                                                    @break
                                                    @case('en')
                                                    {!! $project->description_en !!}
                                                    @break
                                                    @case('id')
                                                    {!! $project->description_id !!}
                                                    @break
                                                    @case('ja')
                                                    {!! $project->description_ja !!}
                                                    @break
                                                    @case('ko')
                                                    {!! $project->description_ko !!}
                                                    @break
                                                    @case('th')
                                                    {!! $project->description_th !!}
                                                    @break
                                                    @case('zh')
                                                    {!! $project->description_zh !!}
                                                    @break
                                                    @default
                                                    {!! $project->description_vi !!}
                                                    @break
                                                    @endswitch
                                                </h3>
                                            </div>
                                            
                                        </div>
                                        <div class="flex justify-end">
                                            <form action="{{ route('invest') }}" method="post" class="w-full form-invest">
                                                @csrf
                                                <input type="hidden" name="project_id" value="{{ $project->id }}">
                                                <input type="number" name="amount" placeholder="{{ __('index.amount') }}" class=" mb-3 w-full bg-[#1e2124] border border-gray-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500 transition-colors">
                                                <button type="submit" class="w-full cursor-pointer bg-cyan-500 text-white px-4 py-2 rounded-md">{{ __('index.invest') }}</button>
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
<div id="historyModal" class="fixed inset-0 z-50 flex mt-16 justify-center hidden bg-opacity-50 backdrop-blur-sm transition-all duration-300">
    <div class="bg-[#181a1d] rounded-lg shadow-lg max-w-[70%] max-h-[70%] overflow-y-auto w-[90%]">
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
                            <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('index.project_id') }}</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('index.project_name') }}</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('index.amount') }}</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('index.status') }}</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('index.created_at') }}</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-white uppercase tracking-wider">{{ __('index.progress') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($investments as $investment)
                        <tr>
                            <td class="px-4 py-2 text-left text-xs font-medium text-white tracking-wider">{{ $investment->project->id }}</td>
                            <td class="px-4 py-2 text-left text-xs font-medium text-white tracking-wider">{{ $investment->project->name }}</td>
                            <td class="px-4 py-2 text-left text-xs font-medium text-white  tracking-wider">{{ number_format($investment->amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 text-left text-xs font-medium text-white tracking-wider {{ $investment->status == 'pending' ? 'text-yellow-500' : ($investment->status == 'success' ? 'text-green-500' : 'text-red-500') }}">{{ $investment->status == 'pending' ? __('index.investing') : ($investment->status == 'success' ? __('index.success') : __('index.failed')) }}</td>
                            <td class="px-4 py-2 text-left text-xs font-medium text-white  tracking-wider">{{ $investment->created_at }}</td>
                            <td class="px-4 py-2 text-left text-xs font-medium text-white tracking-wider">{{ $investment->project->progress }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="md:hidden">
                <div class="space-y-4">
                    @foreach($investments as $investment)
                    <div class="bg-[#232425] p-4 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-white">{{ __('index.project_id') }}: {{ $investment->project->id }}</span>
                            <span class="text-sm {{ $investment->status == 'pending' ? 'text-yellow-500' : ($investment->status == 'success' ? 'text-green-500' : 'text-red-500') }}">
                                {{ $investment->status == 'pending' ? __('index.investing') : ($investment->status == 'success' ? __('index.success') : __('index.failed')) }}
                            </span>
                        </div>
                        <div class="space-y-1">
                            <p class="text-sm text-white">{{ __('index.project_name') }}: {{ $investment->project->name }}</p>
                            <p class="text-sm text-white">{{ __('index.amount') }}: {{ number_format($investment->amount, 0, ',', '.') }}</p>
                            <p class="text-sm text-white">{{ __('index.created_at') }}: {{ $investment->created_at }}</p>
                            <p class="text-sm text-white">{{ __('index.progress') }}: {{ $investment->project->progress }}%</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<script>
    $(document).ready(function() {
        $('.form-invest').submit(function(e) {
            e.preventDefault();
            const btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true);
            btn.html("<i class='fa-solid fa-spinner fa-spin'></i> {{ __('index.loading') }}");
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        title: "{{ __('index.success') }}",
                        text: response.message,
                        icon: 'success'
                    });
                    //close modal
                    document.getElementById('investModal-{{ $project->id }}').classList.add('hidden');
                },
                error: function(response) {
                    console.log(response);
                    Swal.fire({
                        title: "{{ __('index.error') }}",
                        text: response.responseJSON.message,
                        icon: 'error'
                    });
                },
                complete: function(response) {
                    btn.prop('disabled', false);
                    btn.html("{{ __('index.invest') }}");
                }
            });
        });
    });
</script>
@endsection