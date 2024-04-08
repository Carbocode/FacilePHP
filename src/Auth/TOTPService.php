<?php

namespace FacilePHP\Auth;

/**
 * TOTPService handles generating or validating Time-based One-Time Passwords (TOTPs).
 */
final class TOTPService
{
    /**
     * Generates a time slot identifier for the current "time slot".
     * 
     * Explanation:
     * Dividing the Unix TimeStamp (seconds since 1 January 1970) with the duration, 
     * gives us how many times this "time slot" is passed since 1 January 1970, 
     * giving us a counter (our identifier)
     *
     * @param int $duration The duration of the "time slot" in seconds.
     *
     * @return float The "time slot" identifier.
     */
    private function getTimeSlot($duration): float
    {
        return floor(time() / $duration);
    }

    /**
     * Creates a Time-based One-Time Password using the HOTP algorithm.
     *
     * @param string $secret The secret used to generate the OTP.
     * @param int $duration The validity duration of the OTP in seconds.
     * @param float|null $timeSlot The specific time slot for which to generate the TOTP.
     *
     * @return string The generated TOTP.
     */
    public function create(#[\SensitiveParameter] $secret, $duration, $timeSlot = null): string
    {
        $timeSlot = $timeSlot ?? $this->getTimeSlot($duration);

        // Genero il codice a 6 cifre
        $hash = hash_hmac('sha1', strval($timeSlot), $secret, true);
        $otp  = substr(bin2hex($hash), -6); // Estrai un codice a 6 cifre
        return $otp;
    }

    /**
     * Validates the provided OTP code.
     *
     * @param string $inputOtp The OTP code to validate.
     * @param string $secret The secret used to generate the OTP.
     * @param int $duration The validity duration of the OTP in seconds.
     *
     * @return bool The validity of the OTP code.
     */
    public function verify($inputOtp, #[\SensitiveParameter] $secret, $duration): bool
    {
        $isValid = false;

        $currentSlot = $this->getTimeSlot($duration); // Ottengo lo slot temporale attuale

        /*
          Verify the TOTP for the current time slot and the previous
        */
        for ($i = $currentSlot; $i >= $currentSlot - 1; $i--) {
            $otp = $this->create($secret, $duration, $i);

            if ($inputOtp === $otp) {
                $isValid = true;
                break;
            }
        }

        return $isValid;
    }
}
