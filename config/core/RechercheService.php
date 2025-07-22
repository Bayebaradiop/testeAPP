<?php

class RechercheService
{
    public static function filtrer(array $transactions, ?string $date = null, ?string $type = null): array
    {
        if ($date) {
            $transactions = array_filter($transactions, function ($transaction) use ($date) {
                return strpos($transaction['date'], $date) !== false;
            });
        }

        if ($type) {
            $transactions = array_filter($transactions, function ($transaction) use ($type) {
                return $transaction['type'] === $type;
            });
        }

        return $transactions;
    }
}