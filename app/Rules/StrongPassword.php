<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StrongPassword implements Rule
{
    protected $userName;
    protected $email;
    protected $phone;
    protected $firstName;
    protected $lastName;

    public function __construct($userName, $email, $phone, $firstName, $lastName)
    {
        $this->userName = strtolower($userName);  // Normalize inputs to lowercase
        $this->email = strtolower($email);        // Normalize inputs to lowercase
        $this->phone = $phone;
        $this->firstName = strtolower($firstName);
        $this->lastName = strtolower($lastName);
    }

    public function passes($attribute, $value)
    {
        $password = strtolower($value);  // Normalize password to lowercase for comparison

        // Check if the password contains user-related information
        if (
            (isset($this->userName) && str_contains($password, $this->userName)) ||
            (isset($this->email) && str_contains($password, explode('@', $this->email)[0])) || // Check the local part of the email
            (isset($this->phone) && str_contains($password, $this->phone)) ||
            (isset($this->firstName) && str_contains($password, $this->firstName)) ||
            (isset($this->lastName) && str_contains($password, $this->lastName))
        ) {
            return false;
        }

        // Check for more than two consecutive identical characters
        if (preg_match('/(.)\\1{2,}/', $value)) { // 3 or more consecutive identical chars
            return false;
        }

        // Ensure the password isn't fully alphabetic or fully numeric
        if (ctype_alpha($value) || ctype_digit($value)) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'The password cannot contain personal information, consecutive identical characters, or be entirely alphabetic or numeric.';
    }
}
