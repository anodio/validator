<?php

namespace Anodio\Validator\Validator;

use Anodio\Validator\Exceptions\ValidationException;

class Validator
{

    protected const RULES = [
      'required',
      'string',
        'in',
        'email'
    ];

    /**
     * @param $data
     * @param $rules
     * @return void
     * @deprecated
     */
    public static function validate($data, $rules)
    {
        foreach ($rules as $field=>$ruleSet) {
            $value = self::getArrayValueByKeyDefinedAsDotNotation($field, $data);
            $rulesList = explode('|', $ruleSet);
            foreach ($rulesList as $rule) {
                $ruleExploded = explode(':', $rule);
                if ($ruleExploded>1) {
                    $rule = $ruleExploded[0];
                }
                if (!in_array($rule, self::RULES)) {
                    throw new ValidationException('Rule '.$rule.' is not supported. Use Respect\\Validation validator instead');
                }
                if ($rule === 'required' && empty($value)) {
                    throw new ValidationException('Field '.$field.' is required', 422);
                }
                if ($rule === 'string' && !is_string($value)) {
                    throw new ValidationException('Field '.$field.' must be a string', 422);
                }
                if ($rule==='email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    throw new ValidationException('Field '.$field.' must be a valid email', 422);
                }
                if ($rule === 'in') {
                    $inValues = explode(',', $ruleExploded[1]);
                    if (!in_array($value, $inValues)) {
                        throw new ValidationException('Field '.$field.' must be one of '.implode(',', $inValues), 422);
                    }
                }
            }
        }
    }


    protected static function getArrayValueByKeyDefinedAsDotNotation($key, $array)
    {
        $keys = explode('.', $key);
        $value = $array;
        foreach ($keys as $key) {
            if (isset($value[$key])) {
                $value = $value[$key];
            } else {
                return null;
            }
        }
        return $value;
    }
}
