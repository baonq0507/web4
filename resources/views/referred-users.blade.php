@extends('user.layouts.app')
@section('title', __('index.referral_users'))
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
    <div class="flex justify-center shadow-lg">
        <div class="w-full">
            <div class="bg-[#181a1d] rounded-lg border border-[#232425] overflow-hidden shadow-md border-2 border-gray-700" >
                <div class="px-4 py-5 border-b border-[#232425]">
                    <h3 class="text-lg font-medium text-white">{{ __('index.referral_users') }}</h3>
                </div>

                <div class="p-4">
                    @if($referredUsers->count() > 0)
                        <div class="overflow-x-auto">
                                <table class=" min-w-full divide-y divide-[#232425]">
                                    <thead>
                                        <tr>
                                            <th class="px-2 py-3 text-left text-xs font-medium text-white uppercase tracking-wider whitespace-nowrap">{{ __('index.fullname') }}</th>
                                            <th class="px-2 py-3 text-left text-xs font-medium text-white uppercase tracking-wider whitespace-nowrap">{{ __('index.phone') }}</th>
                                            <th class="px-2 py-3 text-left text-xs font-medium text-white uppercase tracking-wider whitespace-nowrap">{{ __('index.created_at') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-[#232425]" id="referred-users-table">
                                        @foreach($referredUsers as $user)
                                            @include('user.partials.referred-user-row', ['user' => $user])
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        @if($referredUsers->hasMorePages())
                            <div class="flex justify-center mt-4">
                                <button id="load-more-btn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    {{ __('Load More') }}
                                </button>
                            </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let currentPage = 1;
    const loadMoreBtn = document.getElementById('load-more-btn');
    const tableBody = document.getElementById('referred-users-table');
    const isMobile = window.innerWidth < 768;

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            currentPage++;
            fetch(`/load-more-referred-users?page=${currentPage}&is_mobile=${isMobile}`)
                .then(response => response.json())
                .then(data => {
                    if (data.html) {
                        if (isMobile) {
                            document.querySelector('.grid').insertAdjacentHTML('beforeend', data.html);
                        } else {
                            tableBody.insertAdjacentHTML('beforeend', data.html);
                        }
                    }
                    if (!data.hasMorePages) {
                        loadMoreBtn.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error loading more users:', error);
                });
        });
    }
</script>
@endpush
@endsection 