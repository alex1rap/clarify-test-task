<?php

namespace App\Service;

use App\Entity\Carrier;
use App\Model\CarrierDelivery;
use InvalidArgumentException;

class DeliveryCostService
{

    public function handle(Carrier $carrier, float $weight): array
    {
        $deliveryRules = $carrier->getDeliveryRules();

        $applicableRule = $this->findApplicableRule($deliveryRules, $weight);

        if ($applicableRule) {
            return [
                'cost' => $this->calculateFormula($applicableRule[CarrierDelivery::RULE_FORMULA], $weight),
                'rule' => $applicableRule
            ];
        }

        return [
            'cost' => 0,
            'rule' => null
        ];
    }

    protected function calculateFormula(string $formula, float $weight): float
    {
        $formula = trim($formula);
        if (is_numeric($formula)) {
            return (float)$formula;
        } elseif (preg_match(
            '/^(?<left>(\d+([.,]\d+)?))\s*(?<operator>([\-*+\/]))\s*(?<right>(\d+([.,]\d+)?))$/uisU',
            str_replace(['weight', 'kg'], $weight, $formula), $matches
        )) {
            $left = $matches['left'];
            $operator = $matches['operator'];
            $right = $matches['right'];

            $left = (float)str_replace(',', '.', $left);
            $right = (float)str_replace(',', '.', $right);

            switch ($operator) {
                case '+':
                    return $left + $right;
                case '-':
                    return $left - $right;
                case '*':
                    return $left * $right;
                case '/':
                    return $left / $right;
            }
        }
        throw new InvalidArgumentException(sprintf(
            'Invalid formula: "%s" (%s)',
            $formula,
            str_replace(['weight', 'kg'], $weight, $formula)
        ), 400);
    }

    protected function findApplicableRule(array $rules, float $weight): ?array
    {
        $applicableRules = [];

        foreach ($rules as $rule) {
            switch ($rule['type']) {
                case 'lt':
                    if ($weight < $rule['value']) {
                        $applicableRules[] = $rule;
                    }
                    break;
                case 'lte':
                    if ($weight <= $rule['value']) {
                        $applicableRules[] = $rule;
                    }
                    break;
                case 'gt':
                    if ($weight > $rule['value']) {
                        $applicableRules[] = $rule;
                    }
                    break;
                case 'gte':
                    if ($weight >= $rule['value']) {
                        $applicableRules[] = $rule;
                    }
                    break;
                case 'eq':
                    if ($weight == $rule['value']) {
                        $applicableRules[] = $rule;
                    }
                    break;
            }
        }

        // Знаходимо найбільше значення ваги серед всіх застосовних правил
        $maxWeight = max(array_column($applicableRules, 'value'));

        // Вибираємо правило з найбільшим значенням ваги
        $applicableRule = null;
        foreach ($applicableRules as $rule) {
            if ($rule['value'] == $maxWeight) {
                $applicableRule = $rule;
                break;
            }
        }

        return $applicableRule;
    }
}
