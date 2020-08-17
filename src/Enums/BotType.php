<?php

namespace SE\SDK\Enums;

use BenSampo\Enum\Enum;

final class BotType extends Enum
{
    const Telegram = 0;
    const Viber = 1;
    const Facebook = 2;
    const Slack = 3;

    static public function isTelegram(int $value): bool
    {
        return $value == self::Telegram;
    }

    static public function isViber(int $value): bool
    {
        return $value == self::Viber;
    }

    static public function isFacebook(int $value): bool
    {
        return $value == self::Facebook;
    }

    static public function isSlack(int $value): bool
    {
        return $value == self::Slack;
    }
}
