<?php

namespace Azate\LaravelTelegramLoginAuth;

use Azate\LaravelTelegramLoginAuth\Contracts\Telegram\Entity as EntityContract;
use Azate\LaravelTelegramLoginAuth\Contracts\Validation\ValidatorChain as ValidatorChainContract;
use Azate\LaravelTelegramLoginAuth\Telegram\EntityFromRequestFactory;
use Azate\LaravelTelegramLoginAuth\Validation\Rules\ResponseNotOutdatedRule;
use Azate\LaravelTelegramLoginAuth\Validation\Rules\SignatureRule;
use Illuminate\Contracts\Config\Repository as ConfigContract;
use Illuminate\Http\Request;
use Exception;

final class TelegramLoginAuth
{
    /**
     * @var ConfigContract
     */
    private $config;

    /**
     * @var ValidatorChainContract
     */
    private $validatorChain;

    public function __construct(ConfigContract $config, ValidatorChainContract $validatorChain)
    {
        $this->config = $config;
        $this->validatorChain = $validatorChain;
    }

    /**
     * @param Request $request
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
