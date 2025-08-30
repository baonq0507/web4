@foreach($notifications as $notification)
<div class="bg-[#232425] rounded-lg p-4 {{ $notification->read_at ? '' : 'bg-opacity-50' }}">
    <div class="flex justify-between items-start">
        <h6 class="text-white font-medium">{{ $notification->data['title'] ?? __('index.new_post_published') }}</h6>
        <small class="text-gray-400">{{ $notification->created_at->diffForHumans() }}</small>
    </div>
    @if(isset($notification->data['image']) )
    <div class="mt-2">
        <img src="{{ $notification->data['image'] }}" class="rounded-lg max-w-full h-auto">
    </div>
    @endif
    <p class="text-gray-300 mt-2">
        {!! Str::limit($notification->data['content'] ?? '', 100) !!}
    </p>
    <div class="mt-3 flex gap-2">
        @if(!$notification->read_at)
        <button class="text-cyan-500 border border-cyan-500 px-4 py-2 rounded-full hover:bg-cyan-500 hover:text-white transition duration-300 ease-in-out text-sm btn-mark-as-read" data-id="{{ $notification->id }}">
            {{ __('index.mark_as_read') }}
        </button>
        @endif
        <button class="text-white bg-cyan-500 px-4 py-2 rounded-full hover:bg-cyan-600 transition duration-300 ease-in-out text-sm hover:scale-105 btn-view-detail" 
                data-id="{{ $notification->id }}"
                data-title="{{ $notification->data['title'] ?? __('index.new_post_published') }}"
                data-content="{{ $notification->data['content'] ?? '' }}"
                data-image="{{ $notification->data['image'] ?? '' }}"
                data-created="{{ $notification->created_at->format('d/m/Y H:i') }}">
            {{ __('index.view_detail') }}
        </button>
    </div>
</div>

<!-- Modal chi tiết thông báo -->
<div id="notification-modal-{{ $notification->id }}" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden overflow-y-auto max-w-7xl mx-auto">
    <div class="flex items-center justify-center min-h-screen p-4 backdrop-blur-sm">
        <div class="bg-[#232425] rounded-lg max-w-2xl w-full lg:w-1/2 mx-auto">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-xl font-semibold text-white" id="modal-title-{{ $notification->id }}"></h3>
                    <button class="text-gray-400 hover:text-white close-modal" data-modal-id="{{ $notification->id }}">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="text-gray-400 text-sm mb-4" id="modal-date-{{ $notification->id }}"></div>
                <div id="modal-image-{{ $notification->id }}" class="mb-4"></div>
                <div class="text-gray-300" id="modal-content-{{ $notification->id }}"></div>
            </div>
        </div>
    </div>
</div>
@endforeach
