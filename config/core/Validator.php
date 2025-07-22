<?php

namespace App\Core;
use App\App;
// class Validator
// {
//     private static array $errors = [];

//     public static array $fields = [
//         'nom' => 'Le nom est obligatoire.',
//         'prenom' => 'Le prénom est obligatoire.',
//         'login' => 'Le login est obligatoire.',
//         'password' => 'Le mot de passe est obligatoire.',
//         'adresse' => 'L\'adresse est obligatoire.',
//         'numeroCarteidentite' => 'Le numéro de carte d\'identité est obligatoire.',
//         'numerotel' => 'Le numéro de téléphone est obligatoire.',
//         'photorecto' => 'La photo recto est obligatoire.',
//         'photoverso' => 'La photo verso est obligatoire.',
//         'auth' => 'Identifiants incorrects',
//         'system' => 'Une erreur est survenue lors de la connexion',
//         'success_client' => 'Connexion réussie ! Bienvenue sur votre espace client.',
//         'success_vendeur' => 'Connexion réussie ! Bienvenue sur votre espace vendeur.',
//         'success_default' => 'Connexion réussie !',
//         'numerotel_invalide' => 'Le numéro de téléphone n\'est pas valide.',
//         'numerotel_existe' => 'Ce numéro de téléphone existe déjà.',
//         'numeroCarteidentite_invalide' => 'Le numéro de CNI n\'est pas valide (13 chiffres).',
//         'numeroCarteidentite_existe' => 'Ce numéro de CNI existe déjà.',
//         'solde_negatif' => 'Le solde doit être positif.',
//         'solde_insuffisant' => 'Solde principal insuffisant'
//     ];

//     private static array $rules = [
//         'nom' => ['required'],
//         'prenom' => ['required'],
//         'login' => ['required'],
//         'password' => ['required'],
//         'adresse' => ['required'],
//         'numeroCarteidentite' => ['required', 'cni'],
//         'numerotel' => ['required', 'phone'],
//         'photorecto' => ['photo'],
//         'photoverso' => ['photo'],
//         'solde' => ['solde'],
//     ];

//     public static function getErrors(): array
//     {
//         return self::$errors;
//     }

//     public static function addError(string $field, string $message): void
//     {
//         self::$errors[$field][] = $message;
//     }

//     public static function isValid(): bool
//     {
//         return empty(self::$errors);
//     }

//     public static function resetErrors(): void
//     {
//         self::$errors = [];
//     }


//     private static function required($field, $value)
//     {
//         if (self::isEmpty($value)) {
//             self::addError($field, self::$fields[$field]);
//         }
//     }

//       public static function isEmpty(string $value): bool
//     {
//         return trim($value) === '';
//     }

//     private static function phone($field, $value, $compteService = null)
//     {
//         if (!self::isValidPhone($value)) {
//             self::addError($field, self::$fields['numerotel_invalide']);
//         } elseif ($compteService && !$compteService->isPhoneUnique($value)) {
//             self::addError($field, self::$fields['numerotel_existe']);
//         }
//     }

//     private static function cni($field, $value, $compteService = null)
//     {
//         if (!self::isValidCni($value)) {
//             self::addError($field, self::$fields['numeroCarteidentite_invalide']);
//         } elseif ($compteService && !$compteService->isCniUnique($value)) {
//             self::addError($field, self::$fields['numeroCarteidentite_existe']);
//         }
//     }

//     private static function solde($field, $value)
//     {
//         if ($value !== '' && floatval($value) < 0) {
//             self::addError($field, self::$fields['solde_negatif']);
//         }
//     }

//     private static function photo($field, $value, $files = [])
//     {
//         if (empty($files[$field]['name'] ?? '')) {
//             self::addError($field, self::$fields[$field]);
//         }
//     }

//     public static function isEmail(string $email): bool
//     {
//         return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
//     }

  

//     public static function isValidPhone(string $phone): bool
//     {
//         return preg_match('/^(77|78|76|70|75)[0-9]{7}$/', $phone);
//     }

//     public static function isValidCni(string $cni): bool
//     {
//         return preg_match('/^[0-9]{13}$/', $cni);
//     }

//     public static function validate(array $data, array $files = [], $compteService = null): void
//     {
//         self::resetErrors();
//         foreach (self::$rules as $field => $validators) {
//             $value = $data[$field] ?? '';
//             foreach ($validators as $validator) {
//                 if (method_exists(__CLASS__, $validator)) {
//                     if ($validator === 'phone' || $validator === 'cni') {
//                         self::$validator($field, $value, $compteService);
//                     } elseif ($validator === 'photo') {
//                         self::$validator($field, $value, $files);
//                     } else {
//                         self::$validator($field, $value);
//                     }
//                 }
//             }
//         }
//     }

//     public static function validateLoginFields(string $login, string $password): void
//     {
//         self::resetErrors();
//         if (self::isEmpty($login)) {
//             self::addError('login', self::$fields['login']);
//         }
//         if (self::isEmpty($password)) {
//             self::addError('password', self::$fields['password']);
//         }
//     }
// }



class Validator
{
    private static array $errors = [];
    private static $instance = null;

    private static array $rules;

    public function __construct()
    {
        self::$errors = [];
        self::$rules = [
            "required" => function ($key, $value, $message = "Champ obligatoire") {
                if (empty($value)) {
                    self::addError($key, $message);
                }
            },
            "minLength" => function ($key, $value, $minLength, $message = "Trop court") {
                if (strlen($value) < $minLength) {
                    self::addError($key, $message);
                }
            },
            "isMail" => function ($key, $value, $message = "Email invalide") {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    self::addError($key, $message);
                }
            },
            "isPassword" => function ($key, $value, $message = "Mot de passe invalide") {
                if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/', $value)) {
                    self::addError($key, $message);
                }
            },
            "isSenegalPhone" => function ($key, $value, $message = "Numéro de téléphone invalide") {
                $value = preg_replace('/\D/', '', $value);
                $prefixes = ['70', '75', '76', '77', '78'];
                if (!(strlen($value) === 9 && in_array(substr($value, 0, 2), $prefixes))) {
                    self::addError($key, $message);
                }
            },
            "isCNI" => function ($key, $value, $message = "Numéro de CNI invalide") {
                $value = preg_replace('/\D/', '', $value);
                if (!preg_match('/^1\d{12}$/', $value)) {
                    self::addError($key, $message);
                }
            },
        ];
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Validator();
        }
        return self::$instance;
    }

    public function validate(array $data, array $rules): bool
    {
        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? null;

            foreach ($fieldRules as $rule) {
                if (is_string($rule)) {
                    $callback = self::$rules[$rule] ?? null;
                    if ($callback) {
                        $callback($field, $value);
                    }
                }
                elseif (is_array($rule)) {
                    $ruleName = $rule[0];
                    $params = array_slice($rule, 1);
                    $callback = self::$rules[$ruleName] ?? null;

                    if ($callback) {
                        $callback($field, $value, ...$params);
                    }
                }
            }
        }

        return empty(self::$errors);
    }

    public static function addError(string $field, string $message)
    {
        self::$errors[$field][] = $message;
    }

    public static function getErrors()
    {
        return self::$errors;
    }

    
}