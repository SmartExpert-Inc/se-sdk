<?php

namespace SE\SDK\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @SWG\Definition(
 *     definition="UserGroupTypeInCompetencyAssessment",
 *     required={"Evaluated": 0, "Subordinate": 1, "Leader": 2, "Colleague": 3},
 *     title="User Group in Competency Assessment",
 *     type="array",
 *     @SWG\Items(
 *         type="integer",
 *         title="UserGroupTypeInCompetencyAssessment ID",
 *         default=0,
 *     ),
 * )
 */
final class UserGroupTypeInCompetencyAssessment extends Enum implements LocalizedEnum
{
    const Evaluated = 0;
    const Subordinate = 1;
    const Leader = 2;
    const Colleague = 3;

    public static function isEvaluated(int $value): bool
    {
        return $value == self::Evaluated;
    }

    public static function isSubordinate(int $value): bool
    {
        return $value == self::Subordinate;
    }

    public static function isLeader(int $value): bool
    {
        return $value == self::Leader;
    }

    public static function isColleague(int $value): bool
    {
        return $value == self::Colleague;
    }
}
