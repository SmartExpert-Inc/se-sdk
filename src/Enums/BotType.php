<?php

namespace SE\SDK\Enums;

use BenSampo\Enum\Enum;

final class BotType extends Enum
{
    const Telegram = 0;
    const Viber = 1;
    const Slack = 2;

    static public function isTelegram(int $value): bool
    {
        return $value == self::Telegram;
    }

    static public function isViber(int $value): bool
    {
        return $value == self::Viber;
    }

    static public function isSlack(int $value): bool
    {
        return $value == self::Slack;
    }
}
