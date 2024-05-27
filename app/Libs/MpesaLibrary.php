<?php

declare(strict_types=1);

namespace App\Libs;

use App\Exceptions\MpesaAccessTokenException;
use App\Models\Payment\MpesaReversal;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MpesaLibrary
{
    public function RegisterURLs($type): JsonResponse
    {
        $url = 'https://api.safaricom.co.ke/mpesa/paybill/v1/registerurl';
        if ($type == 'till') {
            $access_token = $this->GenerateAuthToken('till');
            $data = [
                'ShortCode' => config('payments.mpesa.till.short_code'),
                'ResponseType' => 'Completed',
                'ConfirmationURL' => config('payments.mpesa.till.register.confirmationURL'),
                'ValidationURL' => config('payments.mpesa.till.register.validationURL'),
            ];
        } else {
            $access_token = $this->GenerateAuthToken('paybill');
            $data = [
                'ShortCode' => config('payments.mpesa.paybill.short_code'),
                'ResponseType' => 'Completed',
                'ConfirmationURL' => config('payments.mpesa.paybill.register.confirmationURL'),
                'ValidationURL' => config('payments.mpesa.paybill.register.validationURL'),
            ];
        }

        $data_string = json_encode($data);

        return Http::withHeaders([
            'Authorization' => "Bearer $access_token",
            'Content-Type' => 'application/json',
        ])->post($url, $data_string)->json();

    }

    public function generateAuthToken($type): ?string
    {
        if ($type == 'till') {
            $consumer_key = config('payments.mpesa.till.consumer_key');
            $consumer_secret = config('payments.mpesa.till.consumer_secret');
        } else {
            $consumer_key = config('payments.mpesa.paybill.consumer_key');
            $consumer_secret = config('payments.mpesa.paybill.consumer_secret');
        }
        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $credentials = base64_encode($consumer_key.':'.$consumer_secret);
        $response = Http::withHeaders([
            'Authorization' => "Basic $credentials",
            'Content-Type' => 'application/json',
        ])->get($url);
        $res = $response->json();
        $access_token = $res['access_token'];
        if (!$access_token) {
            throw new MpesaAccessTokenException();
        }

        return $access_token;

    }

    /**
     * @throws MpesaAccessTokenException
     */
    public function MpesaSTKPush(string $payer, int|string $amount, string $payee, string $type): JsonResponse
    {
        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        if ($type == 'till') {
            $access_token = $this->GenerateAuthToken('till');
        } else {
            $access_token = $this->GenerateAuthToken('paybill');
        }
        $timestamp = '20'.date('ymdhis');
        //        $curl_post_data = [
        //            'BusinessShortCode' => $type == 'till' ?
        //                config('payments.mpesa.till.short_code') :
        //                config('payments.mpesa.paybill.short_code'),
        //            'Password' => $this->Password($timestamp, $type),
        //            'Timestamp' => $timestamp,
        //            'TransactionType' => $type == 'till' ? 'CustomerBuyGoodsOnline' : 'CustomerPayBillOnline',
        //            'Amount' => $amount,
        //            'PartyA' => $payer,
        //            'PartyB' => $type == 'till' ?
        //                config('payments.mpesa.till.store_number') :
        //                config('payments.mpesa.paybill.store_number'),
        //            'PhoneNumber' => $payer,
        //            'CallBackURL' => $type == 'till' ?
        //                config('payments.mpesa.till.callBackURL') :
        //                'https://rr.com',
        //            'AccountReference' => $payee,
        //            'TransactionDesc' => 'STK push',
        //        ];
        $curl_post_data = [
            'BusinessShortCode' => $type == 'till' ?
                config('payments.mpesa.till.short_code') :
                config('payments.mpesa.paybill.short_code'),
            'Password' => 'MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMTgwODE0MDg1NjIw',
            'Timestamp' => '20180814085620',
            'TransactionType' => $type == 'till' ? 'CustomerBuyGoodsOnline' : 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $payer,
            'PartyB' => $type == 'till' ?
                config('payments.mpesa.till.store_number') :
                config('payments.mpesa.paybill.store_number'),
            'PhoneNumber' => $payer,
            'CallBackURL' => $type == 'till' ?
                config('payments.mpesa.till.callBackURL') :
                'https://7a7d-41-80-116-2.ngrok-free.app',
            'AccountReference' => $payee,
            'TransactionDesc' => 'STK push',
        ];

        $response = Http::withHeaders([
            'Authorization' => "Bearer $access_token",
        ])->post($url, $curl_post_data);
        logger(json_encode([$payer, $amount, $payee, $response]));
        //        logDataToFile(
        //            [$payer, $amount, $payee],
        //            'logs/mpesa/' . $type . '/daily/StkPushes/' . Carbon::now('Africa/Nairobi')->format('Y-m-d') . '.log',
        //            'MpesaLogs'
        //        );

        return response()->json([
            'response' => $response,
        ]);
    }

    public function dynamicQR(int|string $amount, string $ref, string $type)
    {
        $url = 'https://api.safaricom.co.ke/mpesa/paybill/v1/registerurl';
        if ($type == 'till') {
            $access_token = $this->GenerateAuthToken('till');
            $data = [
                'MerchantName' => config('payments.mpesa.till.merchant_name'),
                'RefNo' => $ref,
                'Amount' => $amount,
                'TrxCode' => 'BG',
                'CPI' => config('payments.mpesa.till.short_code'),
            ];
        } else {
            $access_token = $this->GenerateAuthToken('paybill');
            $data = [
                'MerchantName' => config('payments.mpesa.paybill.merchant_name'),
                'RefNo' => $ref,
                'Amount' => $amount,
                'TrxCode' => 'PB',
                'CPI' => config('payments.mpesa.paybill.short_code'),
            ];
        }

        $data_string = json_encode($data);

        return Http::withHeaders([
            'Authorization' => "Bearer $access_token",
            'Content-Type' => 'application/json',
        ])->post($url, $data_string)->json();
    }

    public function MpesaSTKPushRequestVerify(string $checkOutRequestId, $type): JsonResponse
    {
        $url = 'https://api.safaricom.co.ke/mpesa/stkpushquery/v1/query';
        $timestamp = Carbon::now('Africa/Nairobi')->format('Ymdhis');
        if ($type == 'till') {
            $access_token = $this->GenerateAuthToken('till');
            $data = [
                'BusinessShortCode' => config('payments.mpesa.till.shortcode'),
                'Password' => $this->Password($timestamp, 'till'),
                'Timestamp' => $timestamp,
                'CheckoutRequestID' => $checkOutRequestId,
            ];
        } else {
            $access_token = $this->GenerateAuthToken('paybill');
            $data = [
                'BusinessShortCode' => config('payments.mpesa.paybill.shortcode'),
                'Password' => $this->Password($timestamp, 'till'),
                'Timestamp' => $timestamp,
                'CheckoutRequestID' => $checkOutRequestId,
            ];
        }

        $data_string = json_encode($data);
        $response = Http::withHeaders([
            'Authorization' => "Bearer $access_token",
            'Content-Type' => 'application/json',
        ])->post($url, $data_string)->json();

        return response()->json([
            'response' => $response,
        ], 200);

    }

    /**
     * Private method to generate the password for the apps
     *
     * @return string password
     */
    private function Password($timestamp, $type): string
    {
        if ($type == 'till') {
            $short_code = config('payments.mpesa.till.store_number');
            $passkey = config('payments.mpesa.till.passkey');
        } else {
            $short_code = config('payments.mpesa.paybill.shortcode');
            $passkey = config('payments.mpesa.paybill.passkey');
        }

        return base64_encode($short_code.$passkey.$timestamp);
    }

    public function MpesaC2B(int|string $amount, string $phone, string $ref, string $type): JsonResponse
    {
        $url = 'https://api.safaricom.co.ke/mpesa/paybill/v1/simulate';
        if ($type == 'till') {
            $access_token = $this->GenerateAuthToken('till');
            $data = [
                'ShortCode' => config('payments.mpesa.till.shortcode'),
                'CommandID' => 'CustomerPayBillOnline',
                'Amount' => $amount,
                'Msisdn' => $phone,
                'BillRefNumber' => $ref,
            ];
        } else {
            $access_token = $this->GenerateAuthToken('paybill');
            $data = [
                'ShortCode' => config('payments.mpesa.paybill.shortcode'),
                'CommandID' => 'CustomerPayBillOnline',
                'Amount' => $amount,
                'Msisdn' => $phone,
                'BillRefNumber' => $ref,
            ];
        }

        $data_string = json_encode($data);
        $response = Http::withHeaders([
            'Authorization' => "Bearer $access_token",
            'Content-Type' => 'application/json',
        ])->post($url, $data_string)->json();

        return response()->json([
            'response' => $response,
        ], 200);

    }

    public function MpesaB2C($phone, $amount, $type): JsonResponse
    {
        $url = 'https://api.safaricom.co.ke/mpesa/till/v1/paymentrequest';

        if ($type == 'till') {
            $access_token = $this->GenerateAuthToken('till');
            $data = [
                'InitiatorName' => config('payments.mpesa.till.initiator'),
                'SecurityCredential' => config('payments.mpesa.till.securitycred'),
                'CommandID' => 'BusinessPayment',
                'Amount' => $amount,
                'PartyA' => config('payments.mpesa.till.paybill'),
                'PartyB' => '254'.substr($phone, -9),
                'Remarks' => 'till',
                'QueueTimeOutURL' => route('tillTimeOut'),
                'ResultURL' => route('tillResult'),
                'Occasion' => '',
            ];
        } else {
            $access_token = $this->GenerateAuthToken('paybill');
            $data = [
                'InitiatorName' => config('payments.mpesa.paybill.initiator'),
                'SecurityCredential' => config('payments.mpesa.paybill.securitycred'),
                'CommandID' => 'BusinessPayment',
                'Amount' => $amount,
                'PartyA' => config('payments.mpesa.paybill.paybill'),
                'PartyB' => '254'.substr($phone, -9),
                'Remarks' => 'till',
                'QueueTimeOutURL' => route('tillTimeOut'),
                'ResultURL' => route('tillResult'),
                'Occasion' => '',
            ];
        }

        $data_string = json_encode($data);
        $response = Http::withHeaders([
            'Authorization' => "Bearer $access_token",
            'Content-Type' => 'application/json',
        ])->post($url, $data_string)->json();

        return response()->json([
            'response' => $response,
        ], 200);

    }

    public function AccountBalance($type): JsonResponse
    {
        $url = 'https://api.safaricom.co.ke/mpesa/accountbalance/v1/query';

        if ($type == 'till') {
            $access_token = $this->GenerateAuthToken('till');
            $data = [
                'Initiator' => config('payments.mpesa.till.initiator'),
                'SecurityCredential' => config('payments.mpesa.till.securitycred'),
                'CommandID' => 'AccountBalance',
                'PartyA' => config('payments.mpesa.till.paybill'),
                'IdentifierType' => '4',
                'Remarks' => 'Account balance',
                'QueueTimeOutURL' => route('tillBalTimeOut'),
                'ResultURL' => route('tillBalResult'),
            ];
        } else {
            $access_token = $this->GenerateAuthToken('paybill');
            $data = [
                'Initiator' => config('payments.mpesa.paybill.initiator'),
                'SecurityCredential' => config('payments.mpesa.paybill.securitycred'),
                'CommandID' => 'AccountBalance',
                'PartyA' => config('payments.mpesa.paybill.paybill'),
                'IdentifierType' => '4',
                'Remarks' => 'Account balance',
                'QueueTimeOutURL' => route('tillBalTimeOut'),
                'ResultURL' => route('tillBalResult'),
            ];
        }

        $data_string = json_encode($data);

        return Http::withHeaders([
            'Authorization' => "Bearer $access_token",
            'Content-Type' => 'application/json',
        ])->post($url, $data_string)->json();
    }

    public function TransactionStatus($transactionId, $amount, $type): JsonResponse
    {
        $url = 'https://api.safaricom.co.ke/mpesa/transactionstatus/v1/query';
        if ($type == 'till') {
            $access_token = $this->GenerateAuthToken('till');
            $data = [
                'Initiator' => config('payments.mpesa.till.initiator'),
                'SecurityCredential' => $this->getEncryptedPassword(config('payments.mpesa.till.password')),
                'CommandID' => 'TransactionReversal',
                'TransactionID' => $transactionId,
                'PartyA' => config('payments.mpesa.till.shortcode'),
                'IdentifierType' => '1',
                'ResultURL' => config('payments.mpesa.till.resultURL'),
                'QueueTimeOutURL' => config('payments.mpesa.till.transactionTimeOutURL'),
                'Remarks' => 'Get transaction status',
                'Occasion' => ' ',
            ];
        } else {
            $access_token = $this->GenerateAuthToken('paybill');
            $data = [
                'Initiator' => config('payments.mpesa.paybill.initiator'),
                'SecurityCredential' => $this->getEncryptedPassword(config('payments.mpesa.paybill.password')),
                'CommandID' => 'TransactionReversal',
                'TransactionID' => $transactionId,
                'PartyA' => config('payments.mpesa.paybill.shortcode'),
                'IdentifierType' => '1',
                'ResultURL' => config('payments.mpesa.paybill.resultURL'),
                'QueueTimeOutURL' => config('payments.mpesa.paybill.transactionTimeOutURL'),
                'Remarks' => 'Get transaction status',
                'Occasion' => ' ',
            ];
        }

        $data_string = json_encode($data);

        return Http::withHeaders([
            'Authorization' => "Bearer $access_token",
            'Content-Type' => 'application/json',
        ])->post($url, $data_string)->json();
    }

    public function getEncryptedPassword($plaintext): string
    {
        $public_key = file_get_contents(public_path('cert.cer'));
        openssl_public_encrypt($plaintext, $encrypted, $public_key, OPENSSL_PKCS1_PADDING);

        return base64_encode($encrypted);
    }

    public function ReverseTransaction(string $receiver, string $transactionId, int|string $amount, string $type)
    {
        $url = 'https://api.safaricom.co.ke/mpesa/reversal/v1/request';

        if ($type == 'till') {
            $access_token = $this->GenerateAuthToken('till');
            $data = [
                'Initiator' => config('payments.mpesa.till.initiator'),
                'SecurityCredential' => $this->getEncryptedPassword(config('payments.mpesa.till.password')),
                'CommandID' => 'TransactionReversal',
                'TransactionID' => $transactionId,
                'Amount' => (int) $amount,
                'ReceiverParty' => config('payments.mpesa.till.shortcode'),
                'RecieverIdentifierType' => '11',
                'ResultURL' => config('payments.mpesa.till.reversalURL'),
                'QueueTimeOutURL' => config('payments.mpesa.till.reversalTimeoutURL'),
                'Remarks' => 'remarks',
                'Occasion' => 'mine',
            ];
        } else {
            $access_token = $this->GenerateAuthToken('paybill');
            $data = [
                'Initiator' => config('payments.mpesa.paybill.initiator'),
                'SecurityCredential' => $this->getEncryptedPassword(config('payments.mpesa.paybill.password')),
                'CommandID' => 'TransactionReversal',
                'TransactionID' => $transactionId,
                'Amount' => (int) $amount,
                'ReceiverParty' => config('payments.mpesa.paybill.shortcode'),
                'RecieverIdentifierType' => '11',
                'ResultURL' => config('payments.mpesa.paybill.reversalURL'),
                'QueueTimeOutURL' => config('payments.mpesa.paybill.reversalTimeoutURL'),
                'Remarks' => 'remarks',
                'Occasion' => 'mine',
            ];
        }

        $data_string = json_encode($data);
        $response = Http::withHeaders([
            'Authorization' => "Bearer $access_token",
            'Content-Type' => 'application/json',
        ])->post($url, $data_string)->json();

        $reversal = MpesaReversal::where('TransID', $transactionId)
            ->where('TransAmount', $amount)
            ->first();
        if (!$reversal) {
            $payment = new MpesaReversal();
            $payment->TransID = $transactionId;
            $payment->TransAmount = $amount;
            $payment->MSISDN = $receiver;
            $payment->type = $type;
            $payment->save();
        }

        return $response;

    }

    public function validation(Request $request): void
    {
        $job = new MpesaValidation($request->post());
        dispatch($job);
        echo '{"ResultCode":0, "ResultDesc":"Success", "ThirdPartyTransID": 0}';

    }

    public function confirmation(Request $request): void
    {
        dispatch(new MpesaConfirmation($request->post()));
    }

}
