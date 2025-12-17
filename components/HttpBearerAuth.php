<?php

namespace app\components;

use Yii;
use yii\filters\auth\AuthMethod;
use app\models\Users;

class HttpBearerAuth extends AuthMethod
{
    /**
     * @var string the HTTP authentication realm
     */
    public $realm = 'api';

    /**
     * @var callable a PHP callable that will authenticate the user with the JWT information.
     */
    public $auth;

    /**
     * {@inheritdoc}
     */
    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->getHeaders()->get('Authorization');
        if ($authHeader !== null && preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
            $token = $matches[1];
            $jwtHelper = Yii::$app->jwt;
            $payload = $jwtHelper->decode($token);

            if ($payload !== null && isset($payload['user_id'])) {
                $identity = Users::findIdentity($payload['user_id']);
                if ($identity !== null) {
                    $user->login($identity);
                    return $identity;
                }
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function challenge($response)
    {
        $response->getHeaders()->set('WWW-Authenticate', "Bearer realm=\"{$this->realm}\"");
    }
}

