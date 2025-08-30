@extends('user.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-5 px-2 mt-16" >
    <div class="flex justify-center">
        <div class="w-full md:w-2/3">
            <div class="bg-[#181a1d] rounded-2xl border border-[#232425]">
                <div class="flex justify-between items-center p-6 border-b border-[#232425]">
                    <h5 class="text-xl font-semibold text-white">{{ __('index.notifications') }}</h5>
                    <button class="text-white bg-cyan-500 px-4 py-2 rounded-full hover:bg-cyan-600 transition duration-300 ease-in-out text-sm hover:scale-105 btn-mark-all-read">{{ __('index.mark_all_read') }}</button>
                </div>

                <div class="p-6"
                    @if($notifications->isEmpty())
                    <p class="text-center text-gray-400">{{ __('index.no_notifications') }}</p>
                    @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4"  id="notifications-container">
                        @include('notifications.partials.notification-list')
                    </div>
                    @if($notifications->hasMorePages())
                    <div class="text-center mt-6">
                        <button id="load-more" class="text-white bg-cyan-500 px-6 py-2 rounded-full hover:bg-cyan-600 transition duration-300 ease-in-out text-sm hover:scale-105" data-page="1">
                            {{ __('index.load_more') }}
                        </button>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        function markAsRead(id) {
            $.ajax({
                url: `/notifications/${id}/mark-as-read`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                success: function(data) {
                    if (data.success) {
                        // reloadPage('#notifications-container', '#notifications-container');
                        // location.reload();
                    }
                }
            });
        }

        function markAllAsRead() {
            $.ajax({
                url: '/notifications/mark-all-as-read',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                success: function(data) {
                    if (data.success) {
                        // reloadPage('#notifications-container', '#notifications-container');
                        // location.reload();
                    }
                }
            });
        }

        function loadMoreNotifications(page) {
            $.ajax({
                url: '/notifications/load-more',
                method: 'GET',
                data: {
                    page: page
                },
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                success: function(data) {
                    if (data.html) {
                        $('#notifications-container').append(data.html);
                        $('#load-more').data('page', page + 1);

                        if (!data.hasMorePages) {
                            $('#load-more').hide();
                        }
                    }
                }
            });
        }

        $(document).on('click', '.btn-mark-all-read', function() {
            markAllAsRead();
        });

        $(document).on('click', '.btn-mark-as-read', function() {
            markAsRead($(this).data('id'));
        });

        $(document).on('click', '#load-more', function() {
            const page = $(this).data('page');
            loadMoreNotifications(page);
        });

        // Xử lý nút xem chi tiết
        $(document).on('click', '.btn-view-detail', function() {
            const id = $(this).data('id');
            const title = $(this).data('title');
            const content = $(this).data('content');
            const image = $(this).data('image');
            const created = $(this).data('created');

            // Hiển thị modal
            $(`#notification-modal-${id}`).removeClass('hidden');

            // Điền thông tin vào modal
            $(`#modal-title-${id}`).text(title);
            $(`#modal-date-${id}`).text(created);
            $(`#modal-content-${id}`).html(content);

            // Xử lý hình ảnh nếu có
            if (image) {
                $(`#modal-image-${id}`).html(`<img src="${image}" class="rounded-lg max-w-full h-auto">`);
            } else {
                $(`#modal-image-${id}`).empty();
            }

            // Gọi API đánh dấu đã đọc
            $.ajax({
                url: `/notifications/${id}/mark-as-read`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                success: function(data) {
                    if (data.success) {
                        // reloadPage('#notifications-container', '#notifications-container');
                        // location.reload();
                    }
                }
            });
        });

        // Xử lý nút đóng modal
        $('.close-modal').click(function() {
            const modalId = $(this).data('modal-id');
            $(`#notification-modal-${modalId}`).addClass('hidden');
        });

        // Đóng modal khi click bên ngoài
        $(window).click(function(e) {
            if ($(e.target).hasClass('fixed')) {
                $('.fixed').addClass('hidden');
            }
        });
    });
</script>
@endsection