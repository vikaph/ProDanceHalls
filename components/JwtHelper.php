<?php

namespace app\components;

use Yii;
use yii\base\Component;

class JwtHelper extends Component
{
    public $key = 'your-secret-key-here';

    /**
     * Создает JWT токен
     */
    public function encode($payload)
    {
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];

        $headerEncoded = $this->base64UrlEncode(json_encode($header));
        $payloadEncoded = $this->base64UrlEncode(json_encode($payload));
        $signature = hash_hmac('sha256', $headerEncoded . '.' . $payloadEncoded, $this->key, true);
        $signatureEncoded = $this->base64UrlEncode($signature);

        return $headerEncoded . '.' . $payloadEncoded . '.' . $signatureEncoded;
    }

    /**
     * Декодирует и проверяет JWT токен
     */
    public function decode($token)
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return null;
        }

        list($headerEncoded, $payloadEncoded, $signatureEncoded) = $parts;

        $signature = $this->base64UrlDecode($signatureEncoded);
        $expectedSignature = hash_hmac('sha256', $headerEncoded . '.' . $payloadEncoded, $this->key, true);

        if (!hash_equals($signature, $expectedSignature)) {
            return null;
        }

        $payload = json_decode($this->base64UrlDecode($payloadEncoded), true);
        
        // Проверка срока действия токена (если есть exp)
        if (isset($payload['exp']) && $payload['exp'] < time()) {
            return null;
        }

        return $payload;
    }

    /**
     * Base64 URL encode
     */
    private function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Base64 URL decode
     */
    private function base64UrlDecode($data)
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }
}

