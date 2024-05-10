<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class TransactionTest extends Seeder
{
    private $totalTime = 0;
    private $desIv = '12345678';

     public function run(): void
    {
        $simulate = 100; // angka simulasi

        for ($i = 0; $i < $simulate; $i++) {
            $transactionHeaderId = $this->insertTransactionHeader();
            $this->insertTransactionDetail($transactionHeaderId);
        }

        $average = $this->totalTime / $simulate;
        Log::info('Average encryption time: ' . $average * 1000); // in milliseconds
    }

    private function insertTransactionHeader(): int
    {
        // Uncomment kalo pake DES
        // $start = microtime(true);
        // $this->desIv = $this->generateRandomIV();
        // $end = microtime(true);
        // $this->totalTime += ($end - $start);

        $card = $this->getCard('DES'); // AES DES RC4

        $transactionHeaderId = DB::table('transaction_headers')->insertGetId([
            'payment_method_id' => 2,
            'cashier_id' => 1,
            'card_number' => $card,
            'iv' => $this->desIv,
            'transaction_date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $transactionHeaderId;
    }

    private function insertTransactionDetail(int $transactionHeaderId): void
    {
        DB::table('transaction_details')->insert([
            'transaction_header_id' => $transactionHeaderId,
            'product_id' => 1, // Adjust product_id as needed
            'quantity' => 3,
            'price' => 45000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function getCard(string $encryptionMethod): string
    {
        $card = $this->generateRandomCardNumber();

        $start = microtime(true);
        if ($encryptionMethod == "AES") {
            $encrypted = Crypt::encrypt($card);
        } 

        if($encryptionMethod == "DES") {
            $this->desIv = $this->generateRandomIV();
            $encrypted = $this->threeDESEncryption($card, env('APP_KEY'), $this->desIv);
        } 

        if($encryptionMethod == "RC4") {
            $encrypted = $this->rc4_encode($card, env('APP_KEY'));
        }
        $end = microtime(true);
        $this->totalTime += ($end - $start);

        return $encrypted;
    }

    function generateRandomCardNumber() {
        $number = '';
        for ($i = 0; $i < 16; $i++) {
            $digit = mt_rand(0, 9);
            $number .= $digit;

            if (($i + 1) % 4 === 0 && $i !== 15) {
                $number .= ' ';
            }
        }
        return $number;
    }

    function generateRandomIV() {
        $randomBytes = random_bytes(4);
        $iv = bin2hex($randomBytes);
        
        return $iv;
    }

    function threeDESEncryption($data, $secret, $iv)
    {
        $key = $secret;
        $data2 = $data;
        $key .= substr($key, 0, 8);
        $encData = openssl_encrypt($data2, 'des-ede3-cbc', $key, OPENSSL_RAW_DATA, $iv);

        return urlencode(base64_encode($encData));
    }

    private function rc4_encode(string $string, string $key): string
    {
        $res = $this->rc4($string, $key);
        return bin2hex($res);
    }

    private function rc4(string $str, string $key): string
    {
        // Initialize the state array
        $s = range(0, 255);
        $j = 0;

        // Key scheduling algorithm (KSA)
        $keyLength = strlen($key);
        for ($i = 0; $i < 256; $i++) {
            $j = ($j + $s[$i] + ord($key[$i % $keyLength])) % 256;
            // Swap s[$i] and s[$j]
            [$s[$i], $s[$j]] = [$s[$j], $s[$i]];
        }

        // Pseudo-random generation algorithm (PRGA)
        $i = 0;
        $j = 0;
        $output = '';

        for ($y = 0; $y < strlen($str); $y++) {
            $i = ($i + 1) % 256;
            $j = ($j + $s[$i]) % 256;

            // Swap s[$i] and s[$j]
            [$s[$i], $s[$j]] = [$s[$j], $s[$i]];

            // Calculate the key stream and XOR with the input string
            $keyStream = chr($s[($s[$i] + $s[$j]) % 256]);
            $output .= $str[$y] ^ $keyStream;
        }

        return $output;
    }
}
