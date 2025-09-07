<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use Illuminate\Support\Str;

class NewsPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Bitcoin đạt mức cao mới trong năm 2024',
                'content' => '<p>Bitcoin đã chạm mức cao mới trong năm 2024, vượt qua ngưỡng $100,000. Đây là một dấu hiệu tích cực cho thị trường cryptocurrency sau một thời gian dài biến động.</p><p>Các chuyên gia dự đoán rằng xu hướng tăng này sẽ tiếp tục trong những tháng tới, nhờ vào việc chấp nhận ngày càng rộng rãi của Bitcoin trong các tổ chức tài chính lớn.</p>',
                'excerpt' => 'Bitcoin đã chạm mức cao mới trong năm 2024, vượt qua ngưỡng $100,000. Đây là một dấu hiệu tích cực cho thị trường cryptocurrency.',
                'slug' => 'bitcoin-dat-muc-cao-moi-trong-nam-2024',
                'status' => 'published',
                'image' => null,
                'author' => 'Admin',
                'tags' => ['Bitcoin', 'Cryptocurrency', 'Thị trường'],
                'views' => 1250,
                'is_featured' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Ethereum 2.0: Tương lai của blockchain',
                'content' => '<p>Ethereum 2.0 đã chính thức ra mắt với nhiều cải tiến đáng kể về hiệu suất và bảo mật. Việc chuyển đổi từ Proof of Work sang Proof of Stake đã giúp giảm đáng kể mức tiêu thụ năng lượng.</p><p>Với khả năng xử lý giao dịch nhanh hơn và phí gas thấp hơn, Ethereum 2.0 hứa hẹn sẽ mở ra nhiều cơ hội mới cho các ứng dụng phi tập trung.</p>',
                'excerpt' => 'Ethereum 2.0 đã chính thức ra mắt với nhiều cải tiến đáng kể về hiệu suất và bảo mật.',
                'slug' => 'ethereum-2-0-tuong-lai-cua-blockchain',
                'status' => 'published',
                'image' => null,
                'author' => 'Admin',
                'tags' => ['Ethereum', 'Blockchain', 'Công nghệ'],
                'views' => 980,
                'is_featured' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'DeFi: Xu hướng tài chính phi tập trung',
                'content' => '<p>DeFi (Decentralized Finance) đang trở thành xu hướng chính trong lĩnh vực tài chính. Với tổng giá trị bị khóa (TVL) vượt qua $200 tỷ, DeFi đã chứng minh được tiềm năng to lớn của mình.</p><p>Các ứng dụng DeFi như Uniswap, Compound, và Aave đã tạo ra một hệ sinh thái tài chính hoàn toàn mới, cho phép người dùng giao dịch, cho vay và đi vay mà không cần qua trung gian.</p>',
                'excerpt' => 'DeFi đang trở thành xu hướng chính trong lĩnh vực tài chính với tổng giá trị bị khóa vượt qua $200 tỷ.',
                'slug' => 'defi-xu-huong-tai-chinh-phi-tap-trung',
                'status' => 'published',
                'image' => null,
                'author' => 'Admin',
                'tags' => ['DeFi', 'Tài chính', 'Xu hướng'],
                'views' => 756,
                'is_featured' => false,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'NFT: Nghệ thuật số trong thời đại blockchain',
                'content' => '<p>NFT (Non-Fungible Token) đã tạo ra một cuộc cách mạng trong lĩnh vực nghệ thuật và sưu tầm. Từ những tác phẩm nghệ thuật kỹ thuật số đến các vật phẩm trong game, NFT đã mở ra nhiều cơ hội mới cho các nghệ sĩ và nhà sáng tạo.</p><p>Với khả năng xác thực quyền sở hữu độc đáo và không thể thay thế, NFT đã trở thành một công cụ quan trọng trong việc bảo vệ bản quyền và tạo ra giá trị cho nội dung số.</p>',
                'excerpt' => 'NFT đã tạo ra một cuộc cách mạng trong lĩnh vực nghệ thuật và sưu tầm số.',
                'slug' => 'nft-nghe-thuat-so-trong-thoi-dai-blockchain',
                'status' => 'published',
                'image' => null,
                'author' => 'Admin',
                'tags' => ['NFT', 'Nghệ thuật', 'Blockchain'],
                'views' => 634,
                'is_featured' => false,
                'published_at' => now()->subDays(4),
            ],
            [
                'title' => 'Web3: Internet của tương lai',
                'content' => '<p>Web3 đang được coi là thế hệ tiếp theo của Internet, nơi người dùng có quyền kiểm soát dữ liệu và danh tính của mình. Với sự kết hợp của blockchain, AI và IoT, Web3 hứa hẹn sẽ tạo ra một môi trường Internet phi tập trung và minh bạch hơn.</p><p>Các ứng dụng Web3 như MetaMask, OpenSea và Decentraland đã cho thấy tiềm năng to lớn của công nghệ này trong việc thay đổi cách chúng ta tương tác với Internet.</p>',
                'excerpt' => 'Web3 đang được coi là thế hệ tiếp theo của Internet, nơi người dùng có quyền kiểm soát dữ liệu và danh tính.',
                'slug' => 'web3-internet-cua-tuong-lai',
                'status' => 'published',
                'image' => null,
                'author' => 'Admin',
                'tags' => ['Web3', 'Internet', 'Tương lai'],
                'views' => 892,
                'is_featured' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Stablecoin: Cầu nối giữa fiat và crypto',
                'content' => '<p>Stablecoin đã trở thành một công cụ quan trọng trong hệ sinh thái cryptocurrency, giúp giảm thiểu sự biến động giá và tạo ra sự ổn định cần thiết cho việc giao dịch và thanh toán.</p><p>Với các loại stablecoin phổ biến như USDT, USDC và DAI, người dùng có thể dễ dàng chuyển đổi giữa tiền tệ truyền thống và cryptocurrency mà không lo lắng về sự biến động giá.</p>',
                'excerpt' => 'Stablecoin đã trở thành một công cụ quan trọng trong hệ sinh thái cryptocurrency.',
                'slug' => 'stablecoin-cau-noi-giua-fiat-va-crypto',
                'status' => 'published',
                'image' => null,
                'author' => 'Admin',
                'tags' => ['Stablecoin', 'Fiat', 'Crypto'],
                'views' => 543,
                'is_featured' => false,
                'published_at' => now()->subDays(6),
            ],
        ];

        foreach ($posts as $postData) {
            Post::create($postData);
        }
    }
}