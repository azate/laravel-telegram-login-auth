<?php

namespace Azate\LaravelTelegramLoginAuth;

use Azate\LaravelTelegramLoginAuth\Contracts\Telegram\Entity as EntityContract;
use Azate\LaravelTelegramLoginAuth\Contracts\Validation\ValidatorChain as ValidatorChainContract;
use Azate\LaravelTelegramLoginAuth\Telegram\EntityFromRequestFactory;
use Azate\LaravelTelegramLoginAuth\Validation\Rules\ResponseNotOutdatedRule;
use Azate\LaravelTelegramLoginAuth\Validation\Rules\SignatureRule;
use Exception;
use Illuminate\Contracts\Config\Repository as ConfigContract;
use Illuminate\Http\Request;

final class TelegramLoginAuth
{
    public function __construct(
        private ConfigContract $config,
        private ValidatorChainContract $validatorChain,
    ) {
    }

    /**
     * @return EntityContract|false
     */
    public function validate(Request $request)
    {
        try {
            return $this->validateWithError($request);
        } catch (Exception $exception) {
            //
        }

        return false;
    }

    public function validateWithError(Request $request): EntityContract
    {
        $entity = (new EntityFromRequestFactory($request))->create();

        if ($this->config->get('telegram_login_auth.validate.signature')) {
            $this->validatorChain->addRule(new SignatureRule($this->config->get('telegram_login_auth.token')));
        }

        if ($this->config->get('telegram_login_auth.validate.response_outdated')) {
            $this->validatorChain->addRule(new ResponseNotOutdatedRule());
        }

        $this->validatorChain->validate($entity);

        return $entity;
    }
}
