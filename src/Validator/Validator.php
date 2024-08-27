<?php

namespace Anodio\Validator\Validator;
class Validator
{

    protected const RULES = [
      'required',
      'string'
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
                if (!in_array($rule, self::RULES)) {
                    throw new \Exception('Rule '.$rule.' is not supported. Use Respect\\Validation validator instead');
                }
                if ($rule === 'required' && empty($value)) {
                    throw new \Exception('Field '.$field.' is required', 400);
                }
                if ($rule === 'string' && !is_string($value)) {
                    throw new \Exception('Field '.$field.' must be a string', 400);
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
