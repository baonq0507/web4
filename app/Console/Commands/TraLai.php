<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Symbol;
use Illuminate\Support\Facades\Http;

class TraLai extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-symbol';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cập nhật dữ liệu symbol';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $symbols = Symbol::all();
        foreach ($symbols as $symbol) {
            $response = Http::get('https://api.twelvedata.com/quote?symbol=' . $symbol->symbol . '&apikey=' . env('TWELVEDATA_API_KEY'));
            $data = $response->json();
            dd($data);

            // Phân biệt loại symbol: forex, crypto, usa
            $type = null;
            $symbolStr = strtoupper($symbol->symbol);

            // Forex: thường có ký hiệu dạng EUR/USD, GBP/USD, USD/JPY, v.v.
            if (preg_match('/^[A-Z]{3}\/[A-Z]{3}$/', $symbolStr)) {
                $type = 'forex';
            }
            // Crypto: thường có ký hiệu dạng BTC/USD, ETH/USDT, v.v. hoặc nằm trong danh sách crypto phổ biến
            elseif (
                preg_match('/^(BTC|ETH|BNB|USDT|SOL|XRP|DOGE|ADA|MATIC|SHIB|DOT|TRX|LTC|AVAX|BCH|LINK|UNI|XLM|ATOM|ETC|FIL|ICP|APT|ARB|OP|SUI|PEPE|WBTC|DAI|TUSD|FDUSD|RNDR|NEAR|LDO|INJ|STETH|IMX|GRT|AAVE|MKR|QNT|EGLD|CRV|SAND|AXS|MANA|FTM|RPL|SNX|CAKE|GMX|KAVA|XMR|ALGO|XTZ|EOS|CRO|CHZ|ENJ|ZEC|BAT|1INCH|COMP|YFI|ZRX|BAL|KNC|SRM|BNT|OMG|LRC|REN|NMR|OCEAN|ANKR|BAND|RUNE|CVC|STMX|DGB|DENT|CELR|HOT|WRX|REEF|SXP|CTSI|DOCK|PERL|TOMO|LIT|POLS|ALPHA|BUSD|USDC|USDP|GUSD|PAX|UST|LUNA|LUNC|FLOKI|MEME|BONK|ORDI|JUP|PYTH|TIA|WIF|JTO|MANTA|AEVO|STRK|ALT|ZK|ETHFI|NOT|ZRO|ENA|BIGTIME|PIXEL|PORTAL|TURBO|DOG|DEGEN|MOG|PEOPLE|AIDOGE|TOSHI|FET|AGIX|GROK|SATS|NMT|MAGA|TURT|POPCAT|BOOK|BOME|MOTHER|GME|TRUMP|HARAMBE|WEN|TOSHI|MOG|FLOKI|LADYS|BITCOIN|ETHEREUM|SOLANA|DOGECOIN|SHIBA|PEPE|BONK|ORDI|JUP|PYTH|TIA|WIF|JTO|MANTA|AEVO|STRK|ALT|ZK|ETHFI|NOT|ZRO|ENA|BIGTIME|PIXEL|PORTAL|TURBO|DOG|DEGEN|MOG|PEOPLE|AIDOGE|TOSHI|FET|AGIX|GROK|SATS|NMT|MAGA|TURT|POPCAT|BOOK|BOME|MOTHER|GME|TRUMP|HARAMBE|WEN|TOSHI|MOG|FLOKI|LADYS)[\/\-]/i', $symbolStr)
            ) {
                $type = 'crypto';
            }
            // USA: mã chứng khoán Mỹ, thường là 1 chuỗi chữ cái (AAPL, TSLA, MSFT, v.v.)
            elseif (preg_match('/^[A-Z]{1,5}$/', $symbolStr)) {
                $type = 'usa';
            } else {
                $type = 'unknown';
            }

            if (isset($data['status']) && $data['status'] == 'ok') {
                $symbol->update([
                    'name' => $data['name'] ?? $symbol->name,
                    'symbol' => $data['symbol'] ?? $symbol->symbol,
                    'image' => $data['image'] ?? $symbol->image,
                    'type' => $type,
                ]);
            } else {
                // Nếu không lấy được dữ liệu, vẫn cập nhật type nếu chưa có
                if ($symbol->type !== $type) {
                    $symbol->update([
                        'type' => $type,
                    ]);
                }
            }
        }
    }
}
