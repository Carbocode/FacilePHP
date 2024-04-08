<?php
trait ExploreJson
{
    public function getParam(array $data, string|int $key, string|int|null $default = null): string|int|bool|array|null
    {
        $segments = explode('.', $key);

        foreach ($segments as $segment) {
            // Verifica se il segmento è numericamente indicizzato.
            if (is_array($data) && is_numeric($segment) && array_key_exists($segment, $data)) {
                $data = $data[$segment];
            } elseif (is_array($data) && array_key_exists($segment, $data)) {
                $data = $data[$segment];
            } else {
                return $default;
            }
        }

        return $data;
    }
}
